<template>
  <HeaderSegment title="Edit a blog" :segments="segments" :buttons="buttons" />

  <div class="container-fluid mt--6">
    <form
      class="ajaxform_instant_reload"
      method="post"
      @submit.prevent="infoUpdate"
    >
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="card">
            <div class="card-body">
              <div class="from-group row">
                <label class="col-lg-12">{{ trans("Blog Title") }}</label>
                <div class="col-lg-12">
                  <input
                    type="text"
                    name="title"
                    required
                    v-model="editForm.title"
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
                    type="file"
                    @input="(e) => (editForm.preview = e.target.files[0])"
                    class="form-control"
                    name="preview"
                    accept="image/*"
                  />
                </div>
              </div>
              <div class="from-group row mt-3">
                <label class="col-lg-12">{{
                  trans("Short Description")
                }}</label>
                <div class="col-lg-12">
                  <textarea
                    name="short_description"
                    required
                    class="form-control h-100"
                    v-model="editForm.short_description"
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
                    v-model="editForm.main_description"
                  />
                </div>
              </div>
              <div class="from-group row mt-3">
                <label class="col-lg-12">{{ trans("Select Language") }}</label>
                <div class="col-lg-12">
                  <select
                    v-model="editForm.language"
                    name="language"
                    class="form-control"
                  >
                    <template
                      v-for="(language, languagesKey) in languages"
                      :key="language"
                    >
                      <option
                        :value="languagesKey"
                        :selected="languagesKey == info.lang"
                      >
                        {{ language }}
                      </option>
                    </template>
                  </select>
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{ trans("Select Category") }}</label>
                <div class="col-lg-12">
                  <Multiselect
                    v-model="editForm.categories"
                    label="title"
                    valueProp="id"
                    mode="tags"
                    :options="categories"
                    :searchable="true"
                    placeholder="Select Category"
                  />
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{ trans("Select Tags") }}</label>
                <div class="col-lg-12">
                  <Multiselect
                    v-model="editForm.tags"
                    label="title"
                    valueProp="id"
                    mode="tags"
                    :options="tags"
                    :searchable="true"
                    placeholder="Select Tags"
                  />
                </div>
              </div>
              <hr />
              <div class="from-group row mt-3">
                <label class="col-lg-12">{{ trans("SEO Meta Title") }}</label>
                <div class="col-lg-12">
                  <input
                    type="text"
                    name="meta_title"
                    required
                    v-model="editForm.meta_title"
                    class="form-control"
                  />
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{ trans("SEO Meta Image") }}</label>
                <div class="col-lg-12">
                  <input
                    type="file"
                    @input="(e) => (editForm.meta_image = e.target.files[0])"
                    class="form-control"
                    name="meta_image"
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
                    name="meta_description"
                    required
                    class="form-control h-100"
                    v-model="editForm.meta_description"
                  ></textarea>
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{ trans("SEO Meta Tags") }}</label>
                <div class="col-lg-12">
                  <input
                    type="text"
                    name="meta_tags"
                    required
                    class="form-control"
                    v-model="editForm.meta_tags"
                  />
                </div>
              </div>
              <div class="from-group row mt-3">
                <div class="col-lg-12 d-flex">
                  <label class="custom-toggle custom-toggle-primary">
                    <input
                      v-model="editForm.featured"
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
                  <label class="mt-1 ml-1" for="plain-text-with-featured">
                    <h4>{{ trans("Make it featured?") }}</h4>
                  </label>
                </div>
                <div class="col-lg-12 d-flex">
                  <label class="custom-toggle custom-toggle-primary">
                    <input
                      v-model="editForm.status"
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
                  <label class="mt-1 ml-1" for="plain-text-with-button">
                    <h4>{{ trans("Make it publish?") }}</h4>
                  </label>
                </div>
              </div>
              <div class="from-group row mt-3">
                <div class="col-lg-12">
                  <button type="submit" class="btn btn-neutral submit-button">
                    {{ trans("Update") }}
                  </button>
                </div>
              </div>
              <ValidationErrors />
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
import { router } from "@inertiajs/vue3"
import CKEditor from "@ckeditor/ckeditor5-vue"
import ClassicEditor from "@ckeditor/ckeditor5-build-classic"
import Multiselect from "@vueform/multiselect"
import { createToast } from "mosha-vue-toastify"
import { onMounted, reactive } from "vue"
import ValidationErrors from "@/components/ValidationErrors.vue"
defineOptions({ layout: AdminLayout })
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
const editForm = reactive({
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
  meta_image: null,
  preview: null
})
const props = defineProps([
  "info",
  "tags",
  "categories",
  "cats",
  "seo",
  "languages",
  "buttons",
  "segments",
  "tagsArr"
])

onMounted(() => {
  editForm.title = props.info.title
  editForm.short_description = props.info.short_description.value
  editForm.main_description = props.info.long_description.value
  editForm.categories = props.cats
  editForm.tags = props.tagsArr
  editForm.meta_title = props.seo.title
  editForm.meta_description = props.seo.description
  editForm.meta_tags = props.seo.tags
  editForm.language = props.info.lang
  editForm.featured = props.info.featured == 1 ? true : false
  editForm.status = props.info.status == 1 ? true : false
})
const infoUpdate = () => {
  router.post(
    route("admin.blog.update", props.info.id),
    {
      _method: "patch",
      blog: editForm
    },
    {
      onSuccess: () => {
        createToast({
          title: "Updated",
          description: "Blog Updated successfully"
        })
      }
    }
  )
}
</script>

<style>
@import "@vueform/multiselect/themes/default.css";
</style>
