<template>
  <HeaderSegment
    title="Create a blog"
    :segments="segments"
    :buttons="buttons"
  />
  <div class="container-fluid mt--6">
    <form
      class="ajaxform_instant_reload"
      method="post"
      @submit.prevent="createPost"
    >
      <div class="row justify-content-center">
        <div class="col-lg-11">
          <div class="card">
            <div class="card-body">
              <div class="from-group row">
                <label class="col-lg-12">{{ trans("Blog Title") }}</label>
                <div class="col-lg-12">
                  <input
                    v-model="form.title"
                    type="text"
                    name="title"
                    required=""
                    class="form-control"
                  />
                </div>
              </div>

              <div class="from-group row mt-2">
                <label class="col-lg-12">{{
                  trans("Blog Image (Preview)")
                }}</label>
                <div class="col-lg-12">
                  <input
                    @input="previewFile"
                    type="file"
                    class="form-control"
                    required
                    name="preview"
                    accept="image/*"
                  />
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{
                  trans("Short Description")
                }}</label>
                <div class="col-lg-12">
                  <textarea
                    v-model="form.short_description"
                    name="short_description"
                    required
                    class="form-control"
                    maxlength="500"
                  ></textarea>
                </div>
              </div>
              <div class="from-group row mt-3">
                <label class="col-lg-12">{{ trans("Main Description") }}</label>
                <div class="col-lg-12">
                  <cke
                    tag-name="textarea"
                    :editor="ClassicEditor"
                    v-model="form.main_description"
                  />
                </div>
              </div>
              <div class="from-group row mt-3">
                <label class="col-lg-12">{{ trans("Select Category") }}</label>
                <div class="col-lg-12">
                  <Multiselect
                    v-model="form.categories"
                    mode="tags"
                    :options="categories"
                    :searchable="true"
                    placeholder="Select Main Category"
                    :classes="{
                      optionSelected: 'bg-gray-200',
                      optionPointed: 'bg-gray-300',
                      optionSelectedPointed: 'bg-gray-200'
                    }"
                  />
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{ trans("Select Tags") }}</label>
                <div class="col-lg-12">
                  <Multiselect
                    v-model="form.tags"
                    mode="tags"
                    :options="tags"
                    :searchable="true"
                    placeholder="Select Tags"
                    :classes="{
                      optionSelected: 'bg-gray-200',
                      optionPointed: 'bg-gray-300',
                      optionSelectedPointed: 'bg-gray-200'
                    }"
                  />
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
                      :key="language"
                      :value="key"
                    >
                      {{ language }}
                    </option>
                  </select>
                </div>
              </div>

              <hr />

              <div class="from-group row mt-3">
                <label class="col-lg-12">{{ trans("SEO Meta Title") }}</label>
                <div class="col-lg-12">
                  <input
                    v-model="form.meta_title"
                    type="text"
                    name="meta_title"
                    required
                    class="form-control"
                  />
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{ trans("SEO Meta Image") }}</label>
                <div class="col-lg-12">
                  <input
                    @input="metaFile"
                    type="file"
                    class="form-control"
                    name="meta_image"
                    required
                    accept="image/*"
                  />
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{
                  trans("SEO Meta Description")
                }}</label>
                <div class="col-lg-12">
                  <textarea
                    v-model="form.meta_description"
                    name="meta_description"
                    required
                    class="form-control h-100"
                  ></textarea>
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{ trans("SEO Meta Tags") }}</label>
                <div class="col-lg-12">
                  <input
                    v-model="form.meta_tags"
                    type="text"
                    name="meta_tags"
                    required
                    class="form-control"
                  />
                </div>
              </div>

              <div class="from-group row mt-3">
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
                      v-model="form.status"
                      type="checkbox"
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
              </div>

              <div class="from-group row mt-3">
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
import { useForm } from "@inertiajs/vue3"
import Multiselect from "@vueform/multiselect"
import { createToast } from "mosha-vue-toastify"
defineOptions({ layout: AdminLayout })
import CKEditor from "@ckeditor/ckeditor5-vue"
import ClassicEditor from "@ckeditor/ckeditor5-build-classic"
const cke = CKEditor.component
ClassicEditor.defaultConfig = {
  toolbar: {
    items: [
      "heading",
      "|",
      "bold",
      "italic",
      "|",
      "link",
      "bulletedList",
      "numberedList",
      "|",
      "insertTable",
      "|",
      "mediaEmbed",
      "|",
      "undo",
      "redo"
    ]
  },
  table: {
    contentToolbar: ["tableColumn", "tableRow", "mergeTableCells"]
  },
  language: "en"
}
const form = useForm({
  title: "",
  short_description: "",
  main_description: "",
  categories: [],
  tags: [],
  language: "",
  featured: false,
  status: false,
  meta_title: "",
  meta_description: "",
  meta_tags: "",
  meta_image: "",
  preview: ""
})
const props = defineProps([
  "segments",
  "buttons",
  "categories",
  "languages",
  "tags"
])
const previewFile = (event) => {
  form.preview = event.target.files[0]
}
const metaFile = (event) => {
  form.meta_image = event.target.files[0]
}
const createPost = () => {
  form.post(route("admin.blog.store"), {
    onSuccess: () => {
      createToast(
        {
          title: "Created",
          description: "Post Created successfully"
        },
        {
          transition: "slide",
          position: "top-right"
        }
      )
    }
  })
}
</script>

<style>
@import "@vueform/multiselect/themes/default.css";
</style>
