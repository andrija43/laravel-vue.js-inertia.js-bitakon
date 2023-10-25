<template>
  <div
    class="tab-pane fade"
    id="home-page"
    role="tabpanel"
    aria-labelledby="profile-tab4"
  >
    <form
      method="POST"
      @submit.prevent="updateHomePage"
      enctype="multipart/form-data"
    >
      <div class="form-group">
        <label>{{ trans("Call to action area title") }}</label>
        <input
          type="text"
          name="data[cta][title]"
          class="form-control"
          v-model="homeForm.cta.title"
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Call to action area subtitle") }}</label>
        <input
          type="text"
          name="data[cta][subtitle]"
          class="form-control"
          v-model="homeForm.cta.subtitle"
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Call to action area logo") }}</label>
        <input
          type="file"
          @input="(e) => (homeForm.cta_logo = e.target.files[0])"
          accept="image/*"
          name="cta_logo"
          class="form-control"
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Call to action area thumbnail") }}</label>
        <input
          type="file"
          @input="(e) => (homeForm.cta_thumbnail = e.target.files[0])"
          accept="image/*"
          name="cta_thumbnail"
          class="form-control"
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Call to action area link") }}</label>
        <input
          type="text"
          name="data[cta][link]"
          class="form-control"
          v-model="homeForm.cta.link"
        />
      </div>
      <hr />
      <div class="form-group">
        <label>{{ trans("App Area Title") }}</label>
        <input
          type="text"
          name="data[about][title]"
          class="form-control"
          v-model="homeForm.about.title"
        />
      </div>

      <div class="form-group">
        <label>{{ trans("Action IOS Link") }}</label>
        <input
          type="text"
          name="data[about][action_ios_link]"
          class="form-control"
          v-model="homeForm.about.action_ios_link"
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Action IOS Text") }}</label>
        <input
          type="text"
          name="data[about][action_ios_text]"
          class="form-control"
          v-model="homeForm.about.action_ios_text"
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Action IOS Icon Name") }}</label>
        <input
          type="text"
          name="data[about][action_ios_icon_name]"
          class="form-control"
          v-model="homeForm.about.action_ios_icon_name"
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Action Android Link") }}</label>
        <input
          type="text"
          name="data[about][action_android_link]"
          class="form-control"
          v-model="homeForm.about.action_android_link"
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Action Android Text") }}</label>
        <input
          type="text"
          name="data[about][action_android_text]"
          class="form-control"
          v-model="homeForm.about.action_android_text"
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Action Android Icon Name") }}</label>
        <input
          type="text"
          name="data[about][action_android_icon_name]"
          class="form-control"
          v-model="homeForm.about.action_android_icon_name"
        />
      </div>
      <div class="form-group">
        <label>{{ trans("QR Code image") }}</label>
        <input
          type="file"
          @input="(e) => (homeForm.about.qr_code = e.target.files[0])"
          accept="image/*"
          name="qr_code"
          class="form-control"
        />
      </div>

      <hr />

      <div class="form-group">
        <label>{{ trans("Footer Call To Action Area Title") }}</label>
        <input
          type="text"
          name="data[calltoaction][title]"
          class="form-control"
          v-model="homeForm.calltoaction.title"
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Footer Call To Action Button Title") }}</label>
        <input
          type="text"
          name="data[calltoaction][button_title]"
          class="form-control"
          v-model="homeForm.calltoaction.button_title"
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Footer Call To Action Button Link") }}</label>
        <input
          type="text"
          name="data[calltoaction][button_link]"
          class="form-control"
          v-model="homeForm.calltoaction.button_link"
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
import { ref, onBeforeMount } from "vue"
const props = defineProps({
  home: {
    type: [Object, Array],
    default: () => ({})
  }
})
const homeForm = ref({ ...props.home })
onBeforeMount(() => {
  if (!homeForm.value.cta) {
    homeForm.value.cta = {}
  }

  if (!homeForm.value.about) {
    homeForm.value.about = {}
  }

  if (!homeForm.value.calltoaction) {
    homeForm.value.calltoaction = {}
  }
})
const updateHomePage = () => {
  const fileProperties = ["cta_logo", "cta_thumbnail", "qr_code"]
  fileProperties.forEach((property) => {
    if (!(homeForm.value[property] instanceof File)) {
      homeForm.value[property] = null
    }
  })

  router.post(
    route("admin.page-settings.update", "home-page"),
    {
      _method: "PUT",
      home: homeForm.value
    },
    {
      onSuccess: () => {
        createToast({
          title: "Updated",
          description: "Home Page Updated successfully"
        })
      }
    }
  )
}
</script>
