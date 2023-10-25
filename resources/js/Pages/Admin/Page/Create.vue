<template>
  <HeaderSegment title="Create Page" :segments="segments" :buttons="buttons" />
  <div class="container-fluid mt--6">
    <form
      class="ajaxform_instant_reload"
      method="post"
      @submit.prevent="createPage"
    >
      <div class="row justify-content-center">
        <div class="col-lg-10 card-wrapper">
          <ValidationErrors />
          <!-- Alerts -->
          <div class="card">
            <div class="card-header">
              <h3 class="mb-0">{{ trans("Create Custom Page") }}</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label>{{ trans("Page Title") }}</label>
                <input
                  type="text"
                  name="title"
                  v-model="form.title"
                  required
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label>{{ trans("Page Description") }}</label>

                <cke
                  tag-name="textarea"
                  :editor="ClassicEditor"
                  v-model="form.description"
                />
              </div>

              <div class="from-group row">
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
              <div class="from-group row mt-3">
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
              <div class="d-flex mt-2">
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
import ValidationErrors from "@/components/ValidationErrors.vue"
import { useForm } from "@inertiajs/vue3"
import { createToast } from "mosha-vue-toastify"
import CKEditor from "@ckeditor/ckeditor5-vue"
import ClassicEditor from "@ckeditor/ckeditor5-build-classic"
const cke = CKEditor.component
defineOptions({ layout: AdminLayout })

const props = defineProps(["buttons", "segments"])
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
  description: "",
  meta_title: "",
  meta_description: "",
  meta_tags: "",
  status: false
})
const createPage = () => {
  form.post(route("admin.page.store"), {
    onSuccess: () => {
      form.reset()
      createToast(
        {
          title: "Created",
          description: "Page Created successfully"
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
