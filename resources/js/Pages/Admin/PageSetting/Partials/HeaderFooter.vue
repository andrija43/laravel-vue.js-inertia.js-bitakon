<template>
  <div
    class="tab-pane fade"
    id="header-footer"
    role="tabpanel"
    aria-labelledby="contact-tab4"
  >
    <form
      method="POST"
      @submit.prevent="updateHeaderFooter(headerFooter)"
      class="ajaxform"
      enctype="multipart/form-data"
    >
      <div class="form-group" v-if="headerFooter?.footer">
        <label>{{ trans("Footer Description") }}</label>
        <input
          type="text"
          name="footer[description]"
          class="form-control"
          v-model="headerFooter.footer.description"
          required
        />
      </div>

      <div class="form-row">
        <div class="col-sm-6">
          <div class="form-group">
            <label>{{ trans("Footer Certificate Image") }}</label>
            <input
              @input="
                (e) => (headerFooter.certificate_image = e.target.files[0])
              "
              type="file"
              accept="image/*"
              name="certificate_image"
              class="form-control"
            />
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label>{{ trans("Footer Certificate Image Dark") }}</label>
            <input
              @input="
                (e) => (headerFooter.certificate_image_dark = e.target.files[0])
              "
              type="file"
              accept="image/*"
              name="certificate_image_dark"
              class="form-control"
            />
          </div>
        </div>
      </div>

      <div class="form-group">
        <button class="btn btn-neutral submit-button">
          {{ trans("Update") }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
"use strict";

import { router } from "@inertiajs/vue3"
import { createToast } from "mosha-vue-toastify"
const props = defineProps(["headerFooter"])

const updateHeaderFooter = (...data) => {
  const header_footer = Object.assign({}, ...data)

  const fileProperties = ["certificate_image", "certificate_image_dark"]
  fileProperties.forEach((property) => {
    if (!(header_footer[property] instanceof File)) {
      header_footer[property] = null
    }
  })

  router.post(
    route("admin.page-settings.update", "header_footer"),
    {
      _method: "PUT",
      header_footer: header_footer
    },
    {
      onSuccess: () => {
        createToast({
          title: "Updated",
          description: "Header Footer Updated successfully"
        })
      }
    }
  )
}
</script>
