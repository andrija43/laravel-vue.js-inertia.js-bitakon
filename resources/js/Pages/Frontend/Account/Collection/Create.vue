<script setup>
"use strict";
import Announcement from "@/Pages/Frontend/Home/Partials/Announcement.vue"
import sharedComposable from "@/composables/sharedComposable"
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue"
import { required } from "@vuelidate/validators"
import inputError from "@/components/InputErrors.vue"
import { Head, useForm } from "@inertiajs/vue3"
import { useVuelidate } from "@vuelidate/core"
import { createToast } from "mosha-vue-toastify"
import { computed } from "vue"

defineOptions({ layout: FrontendLayout })

const { authUser, textExcerpt } = sharedComposable()
const form = useForm({
  name: "",
  preview: ""
})
const formRules = computed(() => ({
  name: { required },
  preview: { required }
}))

const setImageURL = (value) => {
  return URL.createObjectURL(value)
}

const validateForm$ = useVuelidate(formRules, form)

const store = () => {
  validateForm$.value.$validate()
  if (validateForm$.value.$error) return
  form.post(route("user.collection.store"), {
    onSuccess: () => {
      createToast({
        title: "Congratulations",
        description: "Collection Created Successfully"
      })
    }
  })
}
</script>

<template>
  <Head title="Create Collection" />
  <!-- create page section -->

  <div
    class="creator__banner include-bg"
    data-background="/assets/img/create/create-bg.jpg"
  />
  <section class="creator__area">
    <div class="creator__border"></div>
    <div class="container">
      <div class="row mt-10">
        <!-- preview -->
        <div class="col-xxl-4 col-xl-4 col-lg-4">
          <div class="collection__item text-center mb-30 theme-bg-dark">
            <div class="collection__item-inner">
              <div class="collection__thumb-wrapper">
                <div class="row gx-2">
                  <div class="col-xxl-12">
                    <div class="collection__thumb mb-10 m-img">
                      <a href="javascript:void(0)">
                        <img
                          v-if="form.preview"
                          :src="setImageURL(form.preview)"
                          alt="preview"
                        />
                        <img
                          v-else
                          src="/assets/img/collection/collection-big-1.jpg"
                          alt="preview"
                        />
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="collection__content">
                <div class="collection__profile">
                  <a href="javascript:void(0)">
                    <img
                      :src="
                        authUser.avatar
                          ? authUser.avatar
                          : `https://ui-avatars.com/api/?name=${authUser.name}`
                      "
                      alt="avatar"
                    />
                  </a>
                </div>
                <h3 class="collection__title">
                  <a href="javascript:void(0)">{{
                    form.name ? textExcerpt(form.name, 30) : "Name"
                  }}</a>
                </h3>
                <p>{{ trans("10 Prompts") }}</p>
              </div>
            </div>
          </div>
        </div>
        <!-- 4th steps -->
        <template v-if="form.wasSuccessful">
          <div class="col-xxl-8 col-xl-8 col-lg-8 mt-20">
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
                {{ trans("Congratulations Collection Created Successfully") }}
              </p>
              <small class="base-text">{{
                trans("We will review your collection request before publish.")
              }}</small>
            </div>
          </div>
        </template>
        <div v-else class="col-xxl-8 col-xl-8 col-lg-8">
          <div class="create__form pt-20 pb-120">
            <div class="row align-items-center">
              <div class="col-xxl-12">
                <div class="create__input-box">
                  <h4>{{ trans("Name") }} <span>*</span></h4>
                  <p>
                    {{ trans("Choose a unique name") }}
                  </p>
                  <div class="create__input">
                    <input
                      v-model="form.name"
                      type="text"
                      placeholder="Enter name"
                    />
                    <inputError :errors="validateForm$.name.$errors" />
                  </div>
                </div>
              </div>

              <div class="col-xxl-12">
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
                      accept="image/*"
                    />
                  </div>
                  <inputError :errors="validateForm$.preview.$errors" />
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
              <!-- price -->
              <div class="col-xxl-12 mt-20">
                <div class="create__btn">
                  <button
                    :disabled="form.processing"
                    type="button"
                    @click="store"
                    class="tp-btn-3"
                  >
                    {{
                      form.processing ? trans("Processing...") : trans("Submit")
                    }}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- marque text area start -->
  <Announcement />
</template>
