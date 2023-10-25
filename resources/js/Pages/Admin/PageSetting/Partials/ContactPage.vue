<template>
  <div
    class="tab-pane fade"
    id="contact-page"
    role="tabpanel"
    aria-labelledby="profile-tab4"
  >
    <form
      method="POST"
      @submit.prevent="updateContactPage(contact_page)"
      class="ajaxform"
      enctype="multipart/form-data"
    >
      <div class="form-group">
        <label>{{ trans("Office Address") }}</label>
        <input
          type="text"
          name="data[address]"
          class="form-control"
          v-model="contact_page.address"
          required
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Country Name") }}</label>
        <input
          type="text"
          name="data[country]"
          class="form-control"
          v-model="contact_page.country"
          required
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Google Map Link") }}</label>
        <input
          type="text"
          name="data[map_link]"
          class="form-control"
          v-model="contact_page.map_link"
          required
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Contact Number 1") }}</label>
        <input
          type="text"
          name="data[contact1]"
          class="form-control"
          v-model="contact_page.contact1"
          required
        />
      </div>
      <div class="form-group">
        <label>{{ trans("Contact Number 2") }}</label>
        <input
          type="text"
          name="data[contact2]"
          class="form-control"
          v-model="contact_page.contact2"
          required
        />
      </div>

      <div class="form-group">
        <label>{{ trans("Contact Email 1") }}</label>
        <input
          type="email"
          name="data[email1]"
          class="form-control"
          v-model="contact_page.email1"
          required
        />
      </div>

      <div class="form-group">
        <label>{{ trans("Contact Email 2") }}</label>
        <input
          type="email"
          name="data[email2]"
          class="form-control"
          v-model="contact_page.email2"
          required
        />
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-neutral submit-button">
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
const props = defineProps(["contact_page"])

const updateContactPage = (...data) => {
  const contact_page = Object.assign({}, ...data)

  router.put(
    route("admin.page-settings.update", "contact-page"),
    {
      contact_page
    },
    {
      onSuccess: () => {
        createToast({
          title: "Updated",
          description: "Contact Page Updated successfully"
        })
      }
    }
  )
}
</script>
