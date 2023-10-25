<script setup>
"use strict";
import PromptPreview from "@/Pages/Frontend/Account/Prompt/Partials/PromptPreview.vue"
import StepProgress from "@/Pages/Frontend/Account/Prompt/Partials/StepProgress.vue"
import Announcement from "@/Pages/Frontend/Home/Partials/Announcement.vue"
import sharedComposable from "@/composables/sharedComposable"
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue"
import { required, requiredIf, integer, helpers } from "@vuelidate/validators"
import inputError from "@/components/InputErrors.vue"
import { Head, router } from "@inertiajs/vue3"
import { useVuelidate } from "@vuelidate/core"
import { createToast } from "mosha-vue-toastify"
import { ref, computed, onMounted } from "vue"
import axios from "axios"
import moment from "moment"

defineOptions({ layout: FrontendLayout })
const props = defineProps([
  "prompt",
  "promptmodel",
  "promptGroups",
  "promptCategory",
  "promptFiles",
  "promptcategoryimages",
  "promptModelRelation",
  "collections"
])
const isProcessing = ref(false)
const promptmodelGuide = ref("")
const { pickBy } = sharedComposable()
const form = ref({
  submodels: []
})
const promptInstruction = ref({
  example_promptfile: null,
  example_promptfile_instruction: null,
  image_upload_instruction: null,
  profile_instruction: null
})
const discount = ref({
  percentage: props.prompt.discount?.percentage,
  will_expire: props.prompt.discount?.will_expire,
  remove: false
})
const promptMeta = ref(JSON.parse(props.prompt.meta))
const promptForm = computed(() =>
  Object.assign(props.prompt, form.value, promptMeta.value)
)
onMounted(() => {
  promptmodelGuide.value = props.promptmodel.guide
  const { meta } = props.promptmodel
  promptInstruction.value.example_promptfile = meta?.example_promptfile
  promptInstruction.value.example_promptfile_instruction =
    meta?.example_promptfile_instruction
  promptInstruction.value.image_upload_instruction =
    meta?.image_upload_instruction
  promptInstruction.value.profile_instruction = meta?.profile_instruction

  if (props.promptModelRelation.length > 0) {
    form.value.submodels = props.promptModelRelation
  } else if (props.promptGroups.length > 0) {
    props.promptGroups.forEach((model, i) => {
      if (model.submodels[0].guide) {
        promptmodelGuide.value = model.submodels[0].guide
      }
      form.value.submodels[i] = model.submodels[0].id
    })
  }
})
const promptFormRules = computed(() => ({
  promptmodel_id: { required },
  promptcategory_id: { required },
  title: { required },
  price: { required },
  description: { required },
  submodels: {
    requiredIf: requiredIf(props.promptmodel.has_submodel === 1)
  }
}))
const checkExpireDate = (value) => {
  const currentDate = moment()
  const selectedDate = moment(value)

  return !helpers.req(value) || selectedDate.isAfter(currentDate, "day")
}

const discountFormRules = computed(() => ({
  percentage: {
    integer,
    requiredIf: requiredIf(computed(() => discount.value.will_expire))
  },
  will_expire: {
    checkExpireDate: helpers.withMessage(
      "Expire Date should be greater than today",
      checkExpireDate
    ),
    requiredIf: requiredIf(computed(() => discount.value.percentage))
  }
}))
const validateDiscountForm$ = useVuelidate(
  discountFormRules.value,
  discount.value
)
const promptDetailsForm = ref(
  Object.assign(JSON.parse(props.promptFiles.files), {
    gallery: JSON.parse(props.prompt.gallery),
    deleteImgs: []
  })
)
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
  if (value instanceof File) {
    return URL.createObjectURL(value)
  } else {
    return value
  }
}
const clearImage = (i, img) => {
  const listImages = Array.from(promptDetailsForm.value.gallery)
  listImages.splice(i, 1)
  promptDetailsForm.value.gallery = listImages
  if (typeof img === "string") {
    promptDetailsForm.value.deleteImgs.push(img)
  }
}

const validatePromptForm$ = useVuelidate(
  promptFormRules.value,
  promptForm.value
)

const promptDetailsRules = computed(() => ({
  prompt: { required },
  prompt_instruction: { required },
  image_width: {
    requiredIf: requiredIf(
      props.promptmodel.accept_image_size_measurement === 1
    )
  },
  image_height: {
    requiredIf: requiredIf(
      props.promptmodel.accept_image_size_measurement === 1
    )
  },
  cfg_scale: {
    requiredIf: requiredIf(
      props.promptmodel.accept_image_size_measurement === 1
    )
  },
  steps: {
    requiredIf: requiredIf(
      props.promptmodel.accept_image_size_measurement === 1
    )
  },
  seed: {
    requiredIf: requiredIf(props.promptmodel.accept_seed === 1)
  },
  profile_link: {
    requiredIf: requiredIf(props.promptmodel.accept_profile_link === 1)
  },
  negative_prompt: {
    requiredIf: requiredIf(props.promptmodel.accept_negative_prompt === 1)
  },
  gallery: {
    requiredIf: requiredIf(props.promptmodel.accept_image === 1)
  }
}))
const validatePromptDetailsForm$ = useVuelidate(
  promptDetailsRules.value,
  promptDetailsForm.value
)
const store = () => {
  isProcessing.value = true
  promptForm.value.meta = promptMeta.value
  if (props.promptmodel.accept_image === 1) {
    const images = []
    for (const image of promptDetailsForm.value.gallery) {
      if (image instanceof File) {
        images.push(image)
      }
    }
    promptForm.value.gallery = images
    promptDetailsForm.value.gallery = null
  }

  router.post(
    route("user.prompt.update", props.prompt.id),
    {
      _method: "PATCH",
      prompt: promptForm.value,
      prompt_details: pickBy(promptDetailsForm.value),
      discount: discount.value
    },
    {
      onSuccess: () => {
        createToast({
          title: "Congratulations",
          description: "Prompt Edited Successfully"
        })
        activeStep.value = 5
      },
      onFinish: () => (isProcessing.value = false)
    }
  )
}
const thirdStep = () => {
  validatePromptForm$.value.$validate()
  if (validatePromptForm$.value.$error) return
  activeStep.value = 3
}
const forthStep = () => {
  validateDiscountForm$.value.$validate()
  if (validateDiscountForm$.value.$error) return
  activeStep.value = 4
}
const fifthStep = () => {
  validatePromptDetailsForm$.value.$validate()
  if (validatePromptDetailsForm$.value.$error) return
  store()
}

const prevStep = () => {
  if (activeStep.value === 2 || activeStep.value === 5) {
    router.get(route("user.prompt.index"))
    return
  }
  if (activeStep.value > 2) {
    activeStep.value--
  }
}
const categoryImages = ref(props.promptcategoryimages)
const categoryImageQuery = ref(null)
const filteredCategoryImages = computed(() => {
  if (props.prompt.promptcategory_id && !categoryImageQuery.value) {
    return categoryImages.value
  }
  if (props.prompt.promptcategory_id && categoryImageQuery.value) {
    return categoryImages.value.filter((image) =>
      image.name.includes(categoryImageQuery.value)
    )
  }
})
const getCategoryImages = (id) => {
  props.prompt.promptcategory_id = id
  axios
    .get(route("api-prompt.category.images", { category_id: id }))
    .then((res) => {
      categoryImages.value = res.data
    })
}

const setSubmodelData = (modelIndex, submodel) => {
  const { meta } = submodel
  promptForm.value.submodels[modelIndex] = submodel.id
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
  <Head title="Prompt Edit" />
  <!-- create page section -->

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
          :accept_image="promptmodel.accept_image"
          :preview_image="promptForm.preview || promptMeta.preview"
          :title="promptForm.title"
          :price="promptForm.price"
          :model-title="promptmodel.title"
          :yt-url="promptmodelGuide"
        />

        <div class="col-xxl-8 col-xl-8 col-lg-8">
          <!-- progress -->
          <StepProgress
            @prev-step="prevStep"
            :multiply="20"
            :max-step="5"
            :step="activeStep"
          />
          <!--2nd steps -->
          <div v-show="activeStep === 2" class="create__form pt-55 pb-120">
            <div class="row align-items-center">
              <div class="col-xxl-12">
                <div class="create__input-box">
                  <h4>{{ trans("Name") }} <span>*</span></h4>
                  <p>
                    {{ trans("Choose a unique name for your Prompt") }}
                  </p>
                  <div class="create__input">
                    <input
                      v-model="promptForm.title"
                      type="text"
                      placeholder="Enter name"
                    />
                    <inputError :errors="validatePromptForm$.title.$errors" />
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
                      v-model="promptMeta.description"
                      placeholder="Enter the Prompt's Description"
                    ></textarea>
                    <inputError
                      :errors="validatePromptForm$.description.$errors"
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
                          <span class="current">
                            {{
                              group.submodels.find((sub) =>
                                form.submodels.includes(sub.id)
                              )?.title || group.submodels[0].title
                            }}
                          </span>
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
                <inputError :errors="validatePromptForm$.submodels.$errors" />
              </template>
              <template v-if="promptCategory.length > 0">
                <div class="col-xxl-12">
                  <div class="create__input-box">
                    <h4 class="pb-10">
                      {{ trans("Category") }}
                      <span>*</span>
                    </h4>

                    <div class="create__input">
                      <div class="nice-select" tabindex="0">
                        <span class="current">
                          {{
                            promptCategory.find(
                              (c) => c.id === prompt.promptcategory_id
                            ).name
                          }}
                        </span>

                        <ul class="list">
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
                        :errors="validatePromptForm$.promptcategory_id.$errors"
                      />
                    </div>
                  </div>
                </div>
              </template>
              <template v-else>
                <inputError
                  :errors="validatePromptForm$.promptcategory_id.$errors"
                />
              </template>
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
                          {{
                            collections.find(
                              (c) => c.id == promptForm.collection_id
                            )?.name || trans("Select Collection")
                          }}</span
                        >

                        <ul class="list">
                          <template
                            v-for="collection in collections"
                            :key="collection.id"
                          >
                            <li
                              @click="promptForm.collection_id = collection.id"
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
                      <span class="current"> {{ promptForm.layout_type }}</span>

                      <ul class="list">
                        <template
                          v-for="layout in ['Tab', 'Grid']"
                          :key="layout"
                        >
                          <li
                            @click="promptForm.layout_type = layout"
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
                      v-model="promptForm.price"
                      type="number"
                      step="1.11"
                      placeholder="Enter Price"
                      :disabled="props.prompt.discount ? true : false"
                    />
                    <inputError :errors="validatePromptForm$.price.$errors" />
                  </div>
                </div>
              </div>

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
            <div class="col-xxl-12">
              <div class="create__input-box">
                <h4>{{ trans("Discount ( % )") }} <span>*</span></h4>

                <div class="create__input mt-10">
                  <input
                    v-model="discount.percentage"
                    type="number"
                    placeholder="Enter Discount (%)"
                  />
                  <inputError
                    :errors="validateDiscountForm$.percentage.$errors"
                  />
                </div>
              </div>
            </div>
            <div class="col-xxl-12">
              <div class="create__input-box">
                <h4>{{ trans("Expire Date") }} <span>*</span></h4>

                <div class="create__input mt-10">
                  <input
                    v-model="discount.will_expire"
                    type="date"
                    placeholder="Enter Expire Date"
                  />
                  <inputError
                    :errors="validateDiscountForm$.will_expire.$errors"
                  />
                </div>
              </div>
            </div>
            <div v-if="prompt.discount" class="col-xxl-12">
              <div class="create__input-check d-flex align-items-center mb-40">
                <div class="create__input-check-item d-flex align-items-center">
                  <input
                    class="m-check-input"
                    type="checkbox"
                    v-model="discount.remove"
                    id="discount"
                  />
                  <label class="m-check-label" for="discount"
                    >Remove Discount</label
                  >
                </div>
              </div>
            </div>
            <div class="col-xxl-12">
              <div class="create__btn">
                <button type="button" @click="forthStep" class="tp-btn-3">
                  {{ trans("Next") }}
                </button>
              </div>
            </div>
          </div>
          <!-- 4rd steps-->
          <div v-show="activeStep === 4" class="create__form pt-55 pb-120">
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

              <template v-if="promptmodel.accept_image_size_measurement">
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
                      :errors="validatePromptDetailsForm$.image_height.$errors"
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
              <div v-if="promptmodel.accept_seed" class="col-xxl-12">
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
              <div v-if="promptmodel.accept_negative_prompt" class="col-xxl-12">
                <div class="create__input-box">
                  <h4>
                    {{ trans("Negative Prompt") }}
                    <span>*</span>
                  </h4>
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
              <template v-if="promptmodel.accept_image">
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
                            @click="clearImage(i, image)"
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
              <template
                v-if="
                  promptmodel.accept_image && promptcategoryimages?.length > 0
                "
              >
                <div class="col-xxl-12">
                  <div class="create__input-box">
                    <h4 class="pb-10">
                      {{ trans("Find Image") }}
                    </h4>
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
                          @click="promptMeta.preview = image.url"
                          class="col-xxl-2 mr-10 mb-10"
                          v-for="(image, i) in filteredCategoryImages"
                          :key="i"
                          :class="{
                            'border border-primary':
                              promptMeta.preview == image.url
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
                      <p class="text-danger">No image found</p>
                    </template>
                  </div>
                </div>
              </template>
              <!-- preview add section -->

              <div class="col-xxl-12" v-if="promptmodel.accept_image">
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
                          prompt.preview = e.target.files[0]
                        }
                      "
                      id="input-preview"
                      type="file"
                    />
                  </div>
                  <section v-if="prompt.preview">
                    <button
                      @click="prompt.preview = null"
                      type="button"
                      class="position-absolute btn btn-danger btn-sm"
                    >
                      <i class="fa fa-times" aria-hidden="true"></i>
                    </button>

                    <img
                      class="col-xxl-2"
                      :src="setImageURL(prompt.preview)"
                      alt="preview"
                    />
                  </section>
                </div>
              </div>

              <!-- Instructions -->
              <div v-if="promptmodel.accept_profile_link" class="col-xxl-12">
                <div class="create__input-box">
                  <h4>
                    {{ promptmodel.title }}
                    {{ trans("Instructions") }}
                  </h4>
                  <p class="mt-10" v-if="promptInstruction.profile_instruction">
                    {{ promptInstruction.profile_instruction }}
                  </p>
                  <div class="create__input">
                    <input
                      type="text"
                      v-model="promptDetailsForm.profile_link"
                      placeholder="Enter Instructions"
                    />
                    <inputError
                      :errors="validatePromptDetailsForm$.profile_link.$errors"
                    />
                  </div>
                </div>
              </div>
              <div class="col-xxl-12 mt-100">
                <div class="create__btn">
                  <button type="button" @click="fifthStep" class="tp-btn-3">
                    {{ isProcessing ? trans("Processing...") : trans("Next") }}
                  </button>
                </div>
              </div>
            </div>
          </div>
          <!-- 5th steps -->
          <template v-if="activeStep === 5">
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
                  {{ trans("Congratulations Prompt Edited Successfully") }}
                </p>
              </div>
            </div>
          </template>
        </div>
      </div>
    </div>
  </section>

  <!-- marque text area start -->
  <Announcement />
</template>
