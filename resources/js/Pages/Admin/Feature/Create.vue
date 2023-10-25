<template>
  <Head title="Create Feature" />
  <HeaderSegment
    :title="trans('Create Feature')"
    :segments="segments"
    :buttons="buttons"
  />
  <div class="container-fluid mt--6">
    <form
      @submit.prevent="create"
      class="ajaxform_instant_reload"
      enctype="multipart/form-data"
    >
      <div class="row">
        <div class="col-lg-5">
          <strong>{{ trans("Create a Step") }}</strong>
          <p>
            {{
              trans(
                "Add your step details and necessary information from here"
              )
            }}
          </p>
        </div>

        <div class="col-lg-7">
          <div class="card">
            <div class="card-body">
              <div class="from-group row">
                <label class="col-lg-12">{{ trans("Step Title") }}</label>
                <div class="col-lg-12">
                  <input
                    type="text"
                    v-model="form.title"
                    name="title"
                    required=""
                    class="form-control"
                  />
                  <div
                    class="invalid-feedback text-danger d-block"
                    v-if="form.errors.title"
                  >
                    {{ form.errors.title }}
                  </div>
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{ trans("Preview Image") }}</label>
                <div class="col-lg-12">
                  <input
                    @input="(e) => (form.preview_image = e.target.files[0])"
                    type="file"
                    class="form-control"
                    required
                    name="preview_image"
                    accept="image/*"
                  />
                  <div
                    class="invalid-feedback text-danger d-block"
                    v-if="form.errors.preview_image"
                  >
                    {{ form.errors.preview_image }}
                  </div>
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{
                  trans("Preview Image Dark")
                }}</label>
                <div class="col-lg-12">
                  <input
                    @input="
                      (e) => (form.preview_image_dark = e.target.files[0])
                    "
                    type="file"
                    class="form-control"
                    required
                    name="preview_image_dark"
                    accept="image/*"
                  />
                  <div
                    class="invalid-feedback text-danger d-block"
                    v-if="form.errors.preview_image_dark"
                  >
                    {{ form.errors.preview_image_dark }}
                  </div>
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{
                  trans("Short Description")
                }}</label>
                <div class="col-lg-12">
                  <textarea
                    v-model="form.description"
                    name="description"
                    required=""
                    class="form-control h-100"
                    maxlength="500"
                  ></textarea>
                  <div
                    class="invalid-feedback text-danger d-block"
                    v-if="form.errors.description"
                  >
                    {{ form.errors.description }}
                  </div>
                </div>
              </div>
              <div class="from-group row mt-3">
                <label class="col-lg-12">{{ trans("Main Description") }}</label>
                <div class="col-lg-12">
                  <textarea
                    v-model="form.main_description"
                    name="main_description"
                    required=""
                    class="h-200 form-control"
                  ></textarea>
                  <div
                    class="invalid-feedback text-danger d-block"
                    v-if="form.errors.main_description"
                  >
                    {{ form.errors.main_description }}
                  </div>
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{ trans("Select Language") }}</label>
                <div class="col-lg-12">
                  <select
                    v-model="form.language"
                    name="language"
                    class="form-control"
                  >
                    <option
                      v-for="(language, key) in languages"
                      :key="key"
                      :value="key"
                    >
                      {{ language }}
                    </option>
                  </select>
                  <div
                    class="invalid-feedback text-danger d-block"
                    v-if="form.errors.language"
                  >
                    {{ form.errors.language }}
                  </div>
                </div>
              </div>
              <div class="from-group row mt-2">
                <div class="col-lg-12 d-flex">
                  <label class="custom-toggle custom-toggle-primary">
                    <input
                      v-model="form.featured"
                      type="checkbox"
                      name="featured"
                      value="1"
                      id="plain-text-with-featured"
                      data-target=".plain-title-with-featured"
                      class="save-template"
                    />
                    <span
                      class="custom-toggle-slider rounded-circle"
                      data-label-off="No"
                      data-label-on="Yes"
                    ></span>
                  </label>
                  <label class="mt-1 ml-1" for="plain-text-with-featured"
                    ><h4>{{ trans("Make it featured?") }}</h4></label
                  >
                </div>
                <div class="col-lg-12 d-flex">
                  <label class="custom-toggle custom-toggle-primary">
                    <input
                      type="checkbox"
                      v-model="form.status"
                      name="status"
                      value="1"
                      id="plain-text-with-button"
                      data-target=".plain-title-with-button"
                      class="save-template"
                    />
                    <span
                      class="custom-toggle-slider rounded-circle"
                      data-label-off="No"
                      data-label-on="Yes"
                    ></span>
                  </label>
                  <label class="mt-1 ml-1" for="plain-text-with-button"
                    ><h4>{{ trans("Make it publish?") }}</h4></label
                  >
                </div>
                <div class="col-lg-12">
                  <button class="btn btn-neutral submit-button">
                    {{ trans("Submit") }}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script setup>
"use strict";
import AdminLayout from "@/Pages/Admin/Layout/App.vue"
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue"
import sharedComposable from "@/composables/sharedComposable"
import { Head, useForm } from "@inertiajs/vue3"
defineOptions({ layout: AdminLayout })
const props = defineProps(["languages", "segments", "buttons"])
const { ToastAlert } = sharedComposable()
const form = useForm({
  title: "",
  preview_image: "",
  preview_image_dark: "",
  banner_image: "",
  description: "",
  main_description: "",
  language: "",
  featured: false,
  status: false
})

const create = () => {
  form.post(route("admin.features.store"), {
    onSuccess: () => {
      ToastAlert("Created", "Created Successfully")
    }
  })
}
</script>
