<template>
  <Head title="Edit Information" />
  <div class="profile__info">
    <h3 class="profile__info-title">{{ trans("Welcome ") }}</h3>
    <div class="profile__info-content">
      <form @submit.prevent="update">
        <div class="row">
          <div class="col-xxl-12 col-md-6">
            <div class="profile__input-box">
              <h4>{{ trans("Name") }}</h4>
              <div class="profile__input">
                <input
                  type="text"
                  placeholder="Enter name"
                  v-model="user.name"
                />
                <i class="fa-light fa-user"></i>
              </div>
            </div>
          </div>
          <div class="col-xxl-12">
            <div class="profile__input-box">
              <h4>{{ trans('Email') }}</h4>
              <div class="profile__input">
                <input
                  :disabled="
                    user.provider !== null && user.provider_id !== null
                  "
                  type="email"
                  placeholder="Enter your email"
                  v-model="user.email"
                />
                <i class="fa-light fa-envelope"></i>
              </div>
            </div>
          </div>
          <div class="col-xxl-6 col-md-6">
            <div class="profile__input-box">
              <h4>{{ trans("Facebook") }}</h4>
              <div class="profile__input">
                <input
                  v-model="form.socials.facebook"
                  type="url"
                  placeholder="Enter Url"
                />
                <i class="fa-brands fa-facebook-f"></i>
              </div>
            </div>
          </div>
          <div class="col-xxl-6 col-md-6">
            <div class="profile__input-box">
              <h4>{{ trans("Linkedin") }}</h4>
              <div class="profile__input">
                <input
                  type="url"
                  v-model="form.socials.linkedin"
                  placeholder="Enter Url"
                />
                <i class="fa-brands fa-linkedin"></i>
              </div>
            </div>
          </div>
          <div class="col-xxl-6 col-md-6">
            <div class="profile__input-box">
              <h4>{{ trans("Twitter") }}</h4>
              <div class="profile__input">
                <input
                  type="url"
                  v-model="form.socials.twitter"
                  placeholder="Enter Url"
                />
                <i class="fa-brands fa-twitter"></i>
              </div>
            </div>
          </div>
          <div class="col-xxl-6 col-md-6">
            <div class="profile__input-box">
              <h4>{{ trans("Dribbble") }}</h4>
              <div class="profile__input">
                <input
                  type="url"
                  v-model="form.socials.dribbble"
                  placeholder="Enter Url"
                />
                <i class="fa-brands fa-dribbble"></i>
              </div>
            </div>
          </div>
          <div class="col-xxl-12 col-md-6">
            <div class="profile__input-box">
              <h4>{{ trans("Phone") }}</h4>
              <div class="profile__input">
                <input
                  type="tel"
                  placeholder="Enter your number"
                  v-model="user.phone"
                />
                <i class="fa-light fa-phone"></i>
              </div>
            </div>
          </div>
          <div class="col-xxl-12">
            <div class="profile__input-box">
              <h4>{{ trans("Address") }}</h4>
              <div class="profile__input">
                <textarea
                  v-model="form.address"
                  placeholder="Enter your address for billing"
                ></textarea>
              </div>
            </div>
          </div>
          <div class="col-xxl-12">
            <div class="create__input-box">
              <h4 class="pb-10">
                {{ trans("Select Country") }}
              </h4>

              <div class="create__input custom-select">
                <div class="nice-select" tabindex="0">
                  <span class="current">
                    {{ user.country ? user.country : trans("Select Country") }}
                  </span>

                  <ul class="list">
                    <template v-for="country in countries" :key="country">
                      <li
                        @click="user.country = country.name"
                        class="option"
                        :class="{
                          'selected focus': user.country === country.name
                        }"
                      >
                        {{ country.name }}
                      </li>
                    </template>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-12">
            <div class="profile__input-box">
              <h4>{{ trans("Your Bio") }}</h4>
              <div class="profile__input">
                <textarea
                  v-model="form.bio"
                  placeholder="Enter your bio"
                ></textarea>
              </div>
            </div>
          </div>
          <div class="col-xxl-12">
            <div class="profile__btn">
              <button :disabled="isProcessing" type="submit" class="tp-btn-3">
                {{ isProcessing ? trans("Processing...") : trans("Update") }}
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
"use strict";
import { Head } from "@inertiajs/vue3"
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue"
import DashboardLayout from "@/Pages/Frontend/Dashboard/Layout/App.vue"
import { router } from "@inertiajs/vue3"
import { createToast } from "mosha-vue-toastify"
import { onMounted, ref } from "vue"
const props = defineProps(["user", "socials", "countries"])
defineOptions({ layout: [FrontendLayout, DashboardLayout] })
const isProcessing = ref(false)
const form = ref({
  socials: {
    facebook: "",
    twitter: "",
    linkedin: "",
    dribbble: ""
  },
  bio: "",
  address: ""
})
onMounted(() => {
  if (props.socials) form.value = props.socials
})
const update = () => {
  isProcessing.value = true
  props.user.meta = form.value
  router.patch(route("user.info.update", props.user.id), props.user, {
    onSuccess: () => {
      createToast({
        title: "Updated",
        description: "Info Updated Successfully"
      })
    },
    onFinish: () => (isProcessing.value = false)
  })
}
</script>
