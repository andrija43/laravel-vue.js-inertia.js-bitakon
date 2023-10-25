<template>
  <div
    class="tab-pane fade show active"
    id="home4"
    role="tabpanel"
    aria-labelledby="home-tab4"
  >
    <form
      method="POST"
      @submit.prevent="
        updatePrimaryData(primary_data, {
          theme_path: theme_path
        })
      "
      class="ajaxform"
      enctype="multipart/form-data"
    >
      <div class="form-group">
        <label>{{ trans("Site Logo - Light Color") }}</label>
        <input
          type="file"
          @input="(e) => (primary_data.logo = e.target.files[0])"
          accept="image/*"
          name="logo"
          class="form-control"
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Site Logo - Dark color") }}</label>
        <input
          type="file"
          accept="image/*"
          name="footer_logo"
          @input="(e) => (primary_data.logo_dark = e.target.files[0])"
          class="form-control"
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Favicon") }}</label>
        <input
          type="file"
          accept="image/*"
          name="favicon"
          @input="(e) => (primary_data.favicon = e.target.files[0])"
          class="form-control"
        />
      </div>

      <div class="form-group">
        <label>{{ trans("Contact Email address") }}</label>
        <input
          type="email"
          name="contact_email"
          v-model="primary_data.contact_email"
          class="form-control"
          required
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Contact Phone") }}</label>
        <input
          type="number"
          name="contact_phone"
          class="form-control"
          required
          v-model="primary_data.contact_phone"
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Office Location") }}</label>
        <input
          type="text"
          name="address"
          class="form-control"
          required=""
          v-model="primary_data.address"
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Announcements") }}</label>
        <input
          type="text"
          name="address"
          class="form-control"
          placeholder="use comma as a separator"
          required
          v-model="primary_data.marquee"
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Footer Description") }}</label>
        <textarea
          class="form-control"
          required
          v-model="primary_data.footer_description"
        ></textarea>
      </div>

      <div class="form-group">
        <label>{{ trans("Facebook Profile Link") }}</label>
        <input
          type="url"
          name="socials[facebook]"
          class="form-control"
          v-model="primary_data.socials.facebook"
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Youtube Profile Link") }}</label>
        <input
          type="url"
          name="socials[youtube]"
          class="form-control"
          v-model="primary_data.socials.youtube"
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Twitter Profile Link") }}</label>
        <input
          type="url"
          name="socials[twitter]"
          class="form-control"
          v-model="primary_data.socials.twitter"
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Instagram Profile Link") }}</label>
        <input
          type="url"
          name="socials[instagram]"
          class="form-control"
          v-model="primary_data.socials.instagram"
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Linkedin Profile Link") }}</label>
        <input
          type="url"
          name="socials[linkedin]"
          class="form-control"
          v-model="primary_data.socials.linkedin"
        />
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
const props = defineProps(["primary_data"])
const updatePrimaryData = (...data) => {
  const primary_data = Object.assign({}, ...data)

  const fileProperties = ["logo", "favicon", "footer_logo"]
  fileProperties.forEach((property) => {
    if (!(primary_data[property] instanceof File)) {
      primary_data[property] = null
    }
  })

  router.post(
    route("admin.page-settings.update", "primary_data"),
    {
      _method: "PUT",
      primary_data: primary_data
    },
    {
      onSuccess: () => {
        createToast({
          title: "Updated",
          description: "Primary Data Updated successfully"
        })
      }
    }
  )
}
</script>
