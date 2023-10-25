<template>
  <Head title="Change Password" />

  <div class="profile__password">
    <form @submit.prevent="updatePassword">
      <div class="row">
        <div class="col-xxl-12">
          <div class="profile__input-box">
            <h4>{{ trans("Old Password") }}</h4>
            <div class="profile__input">
              <input
                type="password"
                v-model="form.oldpassword"
                placeholder="Enter old password"
              />
              <inputError :errors="validateForm$.oldpassword.$errors" />
            </div>
          </div>
        </div>
        <div class="col-xxl-6 col-md-6">
          <div class="profile__input-box">
            <h4>{{ trans("New Password") }}</h4>
            <div class="profile__input">
              <input
                type="password"
                v-model="form.password"
                placeholder="Enter new password"
              />
              <inputError :errors="validateForm$.password.$errors" />
            </div>
          </div>
        </div>
        <div class="col-xxl-6 col-md-6">
          <div class="profile__input-box">
            <h4>{{ trans("Confirm Password") }}</h4>
            <div class="profile__input">
              <input
                type="password"
                v-model="form.password_confirmation"
                placeholder="Enter confirm password"
              />
              <inputError
                :errors="validateForm$.password_confirmation.$errors"
              />
            </div>
          </div>
        </div>
        <div class="col-xxl-6 col-md-6">
          <div class="profile__btn">
            <button :disabled="form.processing" type="submit" class="tp-btn-3">
              {{ form.processing ? trans("Processing...") : trans("Update") }}
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script setup>
"use strict";
import { Head, useForm } from "@inertiajs/vue3"
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue"
import DashboardLayout from "@/Pages/Frontend/Dashboard/Layout/App.vue"
import { createToast } from "mosha-vue-toastify"
import { useVuelidate } from "@vuelidate/core"
import { required, sameAs } from "@vuelidate/validators"
import inputError from "@/components/InputErrors.vue"
import { computed } from "vue"
const props = defineProps(["user"])
defineOptions({ layout: [FrontendLayout, DashboardLayout] })

const form = useForm({
  oldpassword: null,
  password: "",
  password_confirmation: ""
})
const formRules = computed(() => ({
  oldpassword: { required },
  password: { required },
  password_confirmation: {
    required,
    sameAs: sameAs(computed(() => form.password))
  }
}))
const validateForm$ = useVuelidate(formRules.value, form)
const updatePassword = () => {
  validateForm$.value.$validate()
  if (validateForm$.value.$error) return
  form.patch(route("user.change-password.update", props.user.id), {
    onSuccess: () => {
      form.reset()
      validateForm$.value.$reset()
      createToast({
        title: "Updated",
        description: "Password Updated Successfully"
      })
    }
  })
}
</script>
