<script setup>
"use strict";
import PromptPreview from "@/Pages/Frontend/Account/Prompt/Partials/PromptPreview.vue"
import PromptType from "@/Pages/Frontend/Account/Prompt/Partials/PromptType.vue"
import StepProgress from "@/Pages/Frontend/Account/Prompt/Partials/StepProgress.vue"
import Announcement from "@/Pages/Frontend/Home/Partials/Announcement.vue"
import sharedComposable from "@/composables/sharedComposable"
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue"
import { required, requiredIf } from "@vuelidate/validators"
import inputError from "@/components/InputErrors.vue"
import { Head, router } from "@inertiajs/vue3"
import { useVuelidate } from "@vuelidate/core"
import { createToast } from "mosha-vue-toastify"
import { ref, computed, watchEffect } from "vue"
import axios from "axios"

defineOptions({ layout: FrontendLayout })
const props = defineProps([
  "promptmodel",
  "promptGroups",
  "promptCategory",
  "collections"
])

const { pickBy } = sharedComposable()
const isProcessing = ref(false)
const form = ref({
  promptmodel_id: null,
  title: "",
  price: "",
  meta: {
    description: ""
  },
  promptcategory_id: "",
  collection_id: null,
  preview: "",
  submodels: [],
  layout_type: "Tab"
})
const firstFormRules = computed(() => ({
  promptmodel_id: { required },
  promptcategory_id: { required },
  title: { required },
  price: { required },
  meta: { description: { required } },
  submodels: {
    requiredIf: requiredIf(findPromptModel.value?.has_submodel === 1)
  }
}))
const promptDetailsForm = ref({
  prompt: null,
  prompt_instruction: null,
  image_height: null,
  image_width: null,
  cfg_scale: null,
  steps: null,
  negative_prompt: null,
  profile_link: null,
  seed: null,
  gallery: []
})
const activeStep = ref(2)

const previewImages = (event) => {
  const images = []
  for (const image of event.target.files) {
    if (
      image.type === "image/jpeg" ||
      image.type === "image/png" ||
      image.type === "image/webp"
    ) {
      images.push(image)
    }
  }
  const maxGallerySize = 9
  const oldImagesCount = Math.max(
    promptDetailsForm.value.gallery.length + images.length - maxGallerySize,
    0
  )

  const newImages = images.slice(0, maxGallerySize - oldImagesCount)
  const updatedGallery = promptDetailsForm.value.gallery
    .slice(oldImagesCount)
    .concat(newImages)

  promptDetailsForm.value.gallery = updatedGallery
}

const setImageURL = (value) => {
  return URL.createObjectURL(value)
}
const clearImage = (i) => {
  const listImages = Array.from(promptDetailsForm.value.gallery)
  listImages.splice(i, 1)
  promptDetailsForm.value.gallery = listImages
}

const findPromptModel = computed(() => {
  return props.promptmodel.find(
    (model) => model.id === form.value.promptmodel_id
  )
})

const validateFirstForm$ = useVuelidate(firstFormRules, form.value)

const promptmodelGuide = ref("")
const promptInstruction = ref({
  example_promptfile: null,
  example_promptfile_instruction: null,
  image_upload_instruction: null,
  profile_instruction: null
})
watchEffect(() => {
  if (findPromptModel.value) {
    promptmodelGuide.value = findPromptModel.value.guide
    const { meta } = findPromptModel.value
    promptInstruction.value.example_promptfile = meta?.example_promptfile
    promptInstruction.value.example_promptfile_instruction =
      meta?.example_promptfile_instruction
    promptInstruction.value.image_upload_instruction =
      meta?.image_upload_instruction
    promptInstruction.value.profile_instruction = meta?.profile_instruction
  }
  if (props.promptGroups.length > 0) {
    form.value.submodels = []
    props.promptGroups.forEach((model, i) => {
      if (model.submodels[0].guide) {
        promptmodelGuide.value = model.submodels[0].guide
      }
      form.value.submodels[i] = model.submodels[0].id
    })
  }
})

const promptDetailsRules = computed(() => ({
  prompt: { required },
  prompt_instruction: { required },
  image_width: {
    requiredIf: requiredIf(
      findPromptModel.value?.accept_image_size_measurement === 1
    )
  },
  image_height: {
    requiredIf: requiredIf(
      findPromptModel.value?.accept_image_size_measurement === 1
    )
  },
  cfg_scale: {
    requiredIf: requiredIf(
      findPromptModel.value?.accept_image_size_measurement === 1
    )
  },
  steps: {
    requiredIf: requiredIf(
      findPromptModel.value?.accept_image_size_measurement === 1
    )
  },
  seed: {
    requiredIf: requiredIf(findPromptModel.value?.accept_seed === 1)
  },
  profile_link: {
    requiredIf: requiredIf(findPromptModel.value?.accept_profile_link === 1)
  },
  negative_prompt: {
    requiredIf: requiredIf(findPromptModel.value?.accept_negative_prompt === 1)
  },
  gallery: {
    requiredIf: requiredIf(findPromptModel.value?.accept_image === 1)
  }
}))
const validatePromptDetailsForm$ = useVuelidate(
  promptDetailsRules,
  promptDetailsForm.value
)
const store = () => {
  isProcessing.value = true
  form.value.gallery = promptDetailsForm.value.gallery
  promptDetailsForm.value.gallery = null
  router.post(
    route("user.prompt.store"),
    {
      prompt: form.value,
      prompt_details: pickBy(promptDetailsForm.value)
    },
    {
      onSuccess: () => {
        activeStep.value = 4
        createToast({
          title: "Congratulations",
          description: "Prompt Created Successfully"
        })
      },
      onFinish: () => (isProcessing.value = false)
    }
  )
}

const thirdStep = () => {
  validateFirstForm$.value.$validate()
  if (validateFirstForm$.value.$error) return
  activeStep.value = 3
}
const forthStep = () => {
  validatePromptDetailsForm$.value.$validate()
  if (validatePromptDetailsForm$.value.$error) return
  store()
}

const prevStep = () => {
  if (activeStep.value === 2 || activeStep.value === 4) {
    router.get(route("user.prompt.create"))
    return
  }
  if (activeStep.value > 2) {
    activeStep.value--
  }
}
const categoryImages = ref([])
const categoryImageQuery = ref(null)
const filteredCategoryImages = computed(() => {
  if (form.value.promptcategory_id && !categoryImageQuery.value) {
    return categoryImages.value
  }
  if (form.value.promptcategory_id && categoryImageQuery.value) {
    return categoryImages.value.filter((image) =>
      image.name.includes(categoryImageQuery.value)
    )
  }
})
const getCategoryImages = (id) => {
  form.value.promptcategory_id = id
  axios
    .get(route("api-prompt.category.images", { category_id: id }))
    .then((res) => {
      categoryImages.value = res.data
    })
}

const setSubmodelData = (modelIndex, submodel) => {
  const { meta } = submodel
  form.value.submodels[modelIndex] = submodel.id
  if (submodel.guide) {
    promptmodelGuide.value = submodel.guide
  }
  if (meta?.hasOwnProperty("example_promptfile")) {
    promptInstruction.value.example_promptfile = meta.example_promptfile
  }
  if (meta?.hasOwnProperty("example_promptfile_instruction")) {
    promptInstruction.value.example_promptfile_instruction =
      meta.example_promptfile_instruction
  }
  if (meta?.hasOwnProperty("image_upload_instruction")) {
    promptInstruction.value.image_upload_instruction =
      meta.image_upload_instruction
  }
  if (meta?.hasOwnProperty("profile_instruction")) {
    promptInstruction.value.profile_instruction = meta.profile_instruction
  }
}
</script>

<template>
  <Head title="Prompt Create" />
  <template v-if="!form.promptmodel_id">
    <PromptType :promptmodel="promptmodel" v-model="form.promptmodel_id" />
  </template>
  <!-- create page section -->
  <template v-else>
    <div
      class="creator__banner include-bg"
      data-background="/assets/img/create/create-bg.jpg"
    />
    <section class="creator__area">
      <div class="creator__border"></div>
      <div class="container">
        <div class="row">
          <!-- preview -->
          <PromptPreview
            :accept_image="findPromptModel.accept_image"
            :preview_image="
              findPromptModel.accept_image ? form.preview : form.meta.preview
            "
            :title="form.title"
            :price="form.price"
            :model-title="findPromptModel.title"
            :yt-url="promptmodelGuide"
          />

          <div class="col-xxl-8 col-xl-8 col-lg-8">
            <!-- progress -->
            <StepProgress @prev-step="prevStep" :step="activeStep" />
            <!--2nd steps -->
            <div v-show="activeStep === 2" class="create__form pt-55 pb-120">
              <div class="row align-items-center">
                <div class="col-xxl-12">
                  <div class="create__input-box">
                    <h4>{{ trans("Name") }} <span>*</span></h4>
                    <p>
                      {{ trans("Enter a unique name for your Prompt") }}
                    </p>
                    <div class="create__input">
                      <input
                        v-model="form.title"
                        type="text"
                        placeholder="Enter name"
                      />
                      <inputError :errors="validateFirstForm$.title.$errors" />
                    </div>
                  </div>
                </div>
                <div class="col-xxl-12">
                  <div class="create__input-box">
                    <h4>{{ trans("Description") }}</h4>
                    <p>
                      {{
                        trans(`Describe your Prompt, help other users understand
                          what's unique about it`)
                      }}
                    </p>
                    <div class="create__input">
                      <textarea
                        v-model="form.meta.description"
                        placeholder="Enter the Prompt's Description"
                      ></textarea>
                      <inputError
                        :errors="validateFirstForm$.meta.description.$errors"
                      />
                    </div>
                  </div>
                </div>
                <template v-if="promptGroups.length > 0">
                  <template
                    v-for="(group, index) in promptGroups"
                    :key="group.id"
                  >
                    <div class="col-xxl-12">
                      <div class="create__input-box">
                        <h4>
                          {{ trans(group.title) }}
                          <span>*</span>
                        </h4>
                        <p>{{ group.slug }}</p>
                        <div class="create__input mt-10">
                          <div class="nice-select" tabindex="0">
                            <span class="current">{{
                              group.submodels[0].title
                            }}</span>
                            <ul class="list">
                              <li
                                @click="setSubmodelData(index, sub)"
                                v-for="sub in group.submodels"
                                :key="sub.id"
                                class="option"
                              >
                                {{ sub.title }}
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </template>
                  <inputError :errors="validateFirstForm$.submodels.$errors" />
                </template>
                <template v-if="promptCategory.length > 0">
                  <div class="col-xxl-12">
                    <div class="create__input-box">
                      <h4 class="pb-10">
                        {{ trans("Category") }} <span>*</span>
                      </h4>

                      <div class="create__input">
                        <div class="nice-select" tabindex="0">
                          <span class="current">
                            {{ trans("Select a Category") }}</span
                          >

                          <ul class="list">
                            <li
                              data-value="Select a Category"
                              class="option"
                              @click="form.promptcategory_id = ''"
                            >
                              {{ trans("Select a Category") }}
                            </li>
                            <template
                              v-for="category in promptCategory"
                              :key="category.id"
                            >
                              <li
                                @click="getCategoryImages(category.id)"
                                class="option"
                              >
                                {{ trans(category.name) }}
                              </li>
                            </template>
                          </ul>
                        </div>
                        <inputError
                          :errors="validateFirstForm$.promptcategory_id.$errors"
                        />
                      </div>
                    </div>
                  </div>
                </template>

                <template v-else>
                  <inputError
                    :errors="validateFirstForm$.promptcategory_id.$errors"
                  />
                </template>
                <div class="col-xxl-12">
                  <div class="create__input-box">
                    <h4>{{ trans("Price") }} <span>*</span></h4>
                    <p>
                      {{
                        trans(
                          "What do you think the price of this prompt should be?"
                        )
                      }}
                    </p>
                    <div class="create__input">
                      <input
                        v-model="form.price"
                        type="number"
                        step="1.11"
                        placeholder="Enter Price"
                      />
                      <inputError :errors="validateFirstForm$.price.$errors" />
                    </div>
                  </div>
                </div>
                <!-- collections -->
                <template v-if="collections.length > 0">
                  <div class="col-xxl-12">
                    <div class="create__input-box">
                      <h4 class="pb-10">
                        {{ trans("Collection") }}
                      </h4>

                      <div class="create__input">
                        <div class="nice-select" tabindex="0">
                          <span class="current">
                            {{ trans("Select Collection") }}</span
                          >

                          <ul class="list">
                            <li
                              class="option"
                              @click="form.collection_id = null"
                            >
                              {{ trans("Select Collection") }}
                            </li>
                            <template
                              v-for="collection in collections"
                              :key="collection.id"
                            >
                              <li
                                @click="form.collection_id = collection.id"
                                class="option"
                              >
                                {{ trans(collection.name) }}
                              </li>
                            </template>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </template>
                <!-- layout type -->

                <div class="col-xxl-12">
                  <div class="create__input-box">
                    <h4 class="pb-10">
                      {{ trans("Image Layout Type") }}
                    </h4>

                    <div class="create__input">
                      <div class="nice-select" tabindex="0">
                        <span class="current"> {{ trans("Tab") }}</span>

                        <ul class="list">
                          <template
                            v-for="layout in ['Tab', 'Grid']"
                            :key="layout"
                          >
                            <li
                              @click="form.layout_type = layout"
                              class="option"
                            >
                              {{ layout }}
                            </li>
                          </template>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- price -->
                <div class="col-xxl-12">
                  <div class="create__btn">
                    <button type="button" @click="thirdStep" class="tp-btn-3">
                      {{ trans("Next") }}
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- 3rd steps-->

            <div v-show="activeStep === 3" class="create__form pt-55 pb-120">
              <div class="row align-items-center">
                <div class="col-xxl-12">
                  <div class="create__input-box">
                    <h4>{{ trans("Prompt") }}</h4>
                    <p>
                      {{
                        promptInstruction.example_promptfile ||
                        "Describe your Prompt, help other users understand."
                      }}
                    </p>
                    <div class="create__input">
                      <textarea
                        v-model="promptDetailsForm.prompt"
                        placeholder="Describe your Prompt"
                      ></textarea>
                      <inputError
                        :errors="validatePromptDetailsForm$.prompt.$errors"
                      />
                    </div>
                  </div>
                </div>

                <div class="col-xxl-12">
                  <div class="create__input-box">
                    <h4>{{ trans("Prompt Instructions") }}</h4>
                    <p>
                      {{
                        promptInstruction.example_promptfile_instruction ||
                        "Prompt Instructions"
                      }}
                    </p>
                    <div class="create__input">
                      <textarea
                        v-model="promptDetailsForm.prompt_instruction"
                        placeholder="Enter Description"
                      ></textarea>
                      <inputError
                        :errors="
                          validatePromptDetailsForm$.prompt_instruction.$errors
                        "
                      />
                    </div>
                  </div>
                </div>

                <template v-if="findPromptModel.accept_image_size_measurement">
                  <div class="col-xxl-12">
                    <div class="create__input-box">
                      <h4>{{ trans("Image Width") }}</h4>

                      <div class="create__input d-flex align-items-center">
                        <input
                          v-model="promptDetailsForm.image_width"
                          type="range"
                          step="64"
                          min="512"
                          max="1024"
                        />

                        <p class="pl-10">
                          {{ promptDetailsForm.image_width ?? "512" }}px
                        </p>
                      </div>
                    </div>
                    <inputError
                      :errors="validatePromptDetailsForm$.image_width.$errors"
                    />
                  </div>
                  <div class="col-xxl-12">
                    <div class="create__input-box">
                      <h4>{{ trans("Height") }}</h4>

                      <div class="create__input d-flex align-items-center">
                        <input
                          v-model="promptDetailsForm.image_height"
                          type="range"
                          step="64"
                          min="512"
                          max="1024"
                        />

                        <p class="pl-10">
                          {{ promptDetailsForm.image_height ?? "512" }}px
                        </p>
                      </div>
                      <inputError
                        :errors="
                          validatePromptDetailsForm$.image_height.$errors
                        "
                      />
                    </div>
                  </div>
                  <div class="col-xxl-12">
                    <div class="create__input-box">
                      <h4>{{ trans("Cfg Scale") }}</h4>

                      <div class="create__input d-flex align-items-center">
                        <input
                          v-model="promptDetailsForm.cfg_scale"
                          type="range"
                          step="0.5"
                          min="0"
                          max="20"
                        />

                        <p class="pl-10">
                          {{ promptDetailsForm.cfg_scale ?? "0.0" }}
                        </p>
                      </div>
                      <inputError
                        :errors="validatePromptDetailsForm$.cfg_scale.$errors"
                      />
                    </div>
                  </div>
                  <div class="col-xxl-12">
                    <div class="create__input-box">
                      <h4>{{ trans("Steps") }}</h4>

                      <div class="create__input d-flex align-items-center">
                        <input
                          v-model="promptDetailsForm.steps"
                          type="range"
                          step="10"
                          min="10"
                          max="150"
                        />

                        <p class="pl-10">
                          {{ promptDetailsForm.steps ?? "10" }}
                        </p>
                      </div>
                      <inputError
                        :errors="validatePromptDetailsForm$.steps.$errors"
                      />
                    </div>
                  </div>
                </template>
                <!-- seed -->
                <div v-if="findPromptModel.accept_seed" class="col-xxl-12">
                  <div class="create__input-box">
                    <h4>{{ trans("Seed") }}</h4>

                    <div class="create__input mt-10">
                      <input
                        v-model="promptDetailsForm.seed"
                        type="text"
                        placeholder="Seed"
                      />
                      <inputError
                        :errors="validatePromptDetailsForm$.seed.$errors"
                      />
                    </div>
                  </div>
                </div>
                <div
                  v-if="findPromptModel.accept_negative_prompt"
                  class="col-xxl-12"
                >
                  <div class="create__input-box">
                    <h4>{{ trans("Negative Prompt") }} <span>*</span></h4>
                    <div class="create__input mt-10">
                      <textarea
                        v-model="promptDetailsForm.negative_prompt"
                        class="form-control"
                        cols="30"
                        rows="10"
                        placeholder="Negative Prompt"
                      ></textarea>
                      <inputError
                        :errors="
                          validatePromptDetailsForm$.negative_prompt.$errors
                        "
                      />
                    </div>
                  </div>
                </div>
                <!-- images add section -->
                <template v-if="findPromptModel.accept_image">
                  <div class="col-xxl-12">
                    <div class="create__input-box">
                      <h4 class="pb-10">
                        *{{
                          trans(
                            "Upload 9 example images generated by this prompt"
                          )
                        }}
                      </h4>
                      <p v-if="promptInstruction.image_upload_instruction">
                        {{ promptInstruction.image_upload_instruction }}
                      </p>
                      <div class="create__upload text-center">
                        <p>
                          {{ trans("JPG, PNG.") }}
                        </p>
                        <label for="input-file">
                          {{ trans("Select a file") }}
                        </label>
                        <input
                          multiple
                          id="input-file"
                          @change="previewImages"
                          type="file"
                          maxlength="9"
                        />
                      </div>

                      <inputError
                        :errors="validatePromptDetailsForm$.gallery.$errors"
                      />
                      <template v-if="promptDetailsForm.gallery?.length > 0">
                        <div class="d-flex flex-wrap">
                          <section
                            class="col-xxl-2 mr-10 mb-10"
                            v-for="(image, i) in promptDetailsForm.gallery"
                            :key="i"
                          >
                            <button
                              @click="clearImage(i)"
                              type="button"
                              class="position-absolute btn btn-danger btn-sm"
                            >
                              <i class="fa fa-times" aria-hidden="true"></i>
                            </button>

                            <img
                              ref="previewImages"
                              :src="setImageURL(image)"
                              class="img-thumbnail"
                              alt="img"
                            />
                          </section>
                        </div>
                      </template>
                    </div>
                  </div>
                </template>
                <!-- product image add section -->
                <template v-else>
                  <div class="col-xxl-12">
                    <div class="create__input-box">
                      <h4 class="pb-10">{{ trans("Find Image") }}</h4>
                      <div class="create__input text-center">
                        <input
                          v-model="categoryImageQuery"
                          type="text"
                          placeholder="Query"
                        />
                      </div>

                      <template v-if="filteredCategoryImages?.length > 0">
                        <div class="d-flex flex-wrap">
                          <section
                            @click="form.meta.preview = image.url"
                            class="col-xxl-2 mr-10 mb-10"
                            v-for="(image, i) in filteredCategoryImages"
                            :key="i"
                            :class="{
                              'border border-primary':
                                form.meta.preview == image.url
                            }"
                          >
                            <img
                              ref="previewImages"
                              :src="image.url"
                              class="img-thumbnail"
                              alt="img"
                            />
                          </section>
                        </div>
                      </template>
                      <template v-else>
                        <p class="text-danger">{{ trans("No image found") }}</p>
                      </template>
                    </div>
                  </div>
                </template>
                <!-- preview add section -->

                <div class="col-xxl-12" v-if="findPromptModel.accept_image">
                  <div class="create__input-box">
                    <h4 class="pb-10">* {{ trans("Preview") }}</h4>

                    <div class="create__upload text-center">
                      <p>{{ trans("JPG, PNG.") }}</p>
                      <label for="input-preview">
                        {{ trans("Select a file") }}
                      </label>
                      <input
                        @input="
                          (e) => {
                            form.preview = e.target.files[0]
                          }
                        "
                        id="input-preview"
                        type="file"
                      />
                    </div>
                    <section v-if="form.preview">
                      <button
                        @click="form.preview = null"
                        type="button"
                        class="position-absolute btn btn-danger btn-sm"
                      >
                        <i class="fa fa-times" aria-hidden="true"></i>
                      </button>
                      <img
                        class="col-xxl-2"
                        :src="setImageURL(form.preview)"
                        alt="preview"
                      />
                    </section>
                  </div>
                </div>

                <!-- Instructions -->
                <div
                  v-if="findPromptModel.accept_profile_link"
                  class="col-xxl-12"
                >
                  <div class="create__input-box">
                    <h4>
                      {{ findPromptModel.title }} {{ trans("Instructions") }}
                    </h4>
                    <p
                      class="mt-10"
                      v-if="promptInstruction.profile_instruction"
                    >
                      {{ promptInstruction.profile_instruction }}
                    </p>
                    <div class="create__input">
                      <input
                        type="text"
                        v-model="promptDetailsForm.profile_link"
                        placeholder="Enter Instructions"
                      />
                      <inputError
                        :errors="
                          validatePromptDetailsForm$.profile_link.$errors
                        "
                      />
                    </div>
                  </div>
                </div>
                <div class="col-xxl-12 mt-10">
                  <div class="create__btn">
                    <button
                      :disabled="isProcessing"
                      type="button"
                      @click="forthStep"
                      class="tp-btn-3"
                    >
                      {{
                        isProcessing ? trans("Processing...") : trans("Next")
                      }}
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- 4th steps -->
            <template v-if="activeStep === 4">
              <div class="create__form pt-55 pb-120">
                <div class="create__upload text-center confetti">
                  <img
                    class="light w-25"
                    src="/assets/img/confetti.gif"
                    alt="congratulations"
                  />
                  <img
                    class="dark w-25"
                    src="/assets/img/dark-confetti.gif"
                    alt="congratulations"
                  />
                  <p class="base-text">
                    {{ trans("Congratulations Prompt Created Successfully") }}
                  </p>
                  <small class="base-text">
                    {{
                      trans(
                        "We will review your prompt request before publish to the market"
                      )
                    }}
                  </small>
                </div>
              </div>
            </template>
          </div>
        </div>
      </div>
    </section>
  </template>
  <!-- marque text area start -->
  <Announcement />
</template>
