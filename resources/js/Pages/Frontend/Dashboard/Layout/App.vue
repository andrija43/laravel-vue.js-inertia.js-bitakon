<script setup>
"use strict";
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue"
import Announcement from "@/Pages/Frontend/Home/Partials/Announcement.vue"
import sharedComposable from "@/composables/sharedComposable"
import { ref } from "vue"
import { router } from "@inertiajs/vue3"
import { createToast } from "mosha-vue-toastify"
defineOptions({ layout: FrontendLayout })

const { currentRoute, authUser } = sharedComposable()
const form = ref({
  avatar: "",
  cover_image: ""
})
const changeAvatar = (e) => {
  form.value.avatar = e.target.files[0]
  router.post(
    route("user.info.update", authUser.value.id),
    {
      _method: "PATCH",
      avatar: form.value.avatar
    },
    {
      onSuccess: () => {
        createToast({
          title: "Updated",
          description: "Avatar Updated Successfully"
        })
      }
    }
  )
}
const changeCover = (e) => {
  form.value.cover_image = e.target.files[0]
  router.post(
    route("user.info.update", authUser.value.id),
    {
      _method: "PATCH",
      cover_image: form.value.cover_image
    },
    {
      onSuccess: () => {
        createToast({
          title: "Updated",
          description: "Cover Updated Successfully"
        })
      }
    }
  )
}
</script>

<template>
  <section class="edit__profile pb-120">
    <div class="edit__profile">
      <div class="container-fluid fix p-0">
        <div class="row">
          <div class="col-xxl-12">
            <div class="profile__cover-wrapper p-relative">
              <div class="profile__cover w-img tp-img-cover">
                <img
                  :src="
                    authUser.cover_image
                      ? authUser.cover_image
                      : `/assets/img/creator/creator-bg.jpg`
                  "
                  alt="cover"
                />
              </div>
              <div class="profile__cover-edit">
                <input
                  @input="changeCover"
                  id="profile-cover-input"
                  class="cover-img-popup"
                  type="file"
                />
                <label for="profile-cover-input"
                  ><i class="fa-regular fa-pen-to-square"></i
                ></label>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xxl-12">
            <div class="profile__thumb-wrapper text-center">
              <div
                class="profile__thumb text-center tp-img-profile d-inline-block p-relative"
              >
                <img
                  :src="
                    authUser.avatar
                      ? authUser.avatar
                      : `https://ui-avatars.com/api/?name=${authUser.name}`
                  "
                  alt="avatar"
                />
                <div class="profile__thumb-edit">
                  <input
                    @input="changeAvatar"
                    id="profile-thumb-input"
                    class="profile-img-popup"
                    type="file"
                  />
                  <label for="profile-thumb-input"
                    ><i class="fa-regular fa-camera"></i
                  ></label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-xxl-4 col-lg-4">
          <div class="profile__tab mr-40">
            <nav>
              <div
                class="nav nav-tabs flex-column"
                id="profile-tab"
                role="tablist"
              >
                <Link
                  href="/dashboard/info"
                  :class="{
                    active: currentRoute('Frontend/Dashboard/Info/Edit')
                  }"
                  class="nav-link"
                >
                  <i class="fa-regular fa-user-pen"></i>
                  {{ trans("Profile Information") }}
                </Link>
                <Link
                  v-if="
                    authUser.provider === null && authUser.provider_id === null
                  "
                  href="/dashboard/change-password"
                  class="nav-link"
                  :class="{
                    active: currentRoute('Frontend/Dashboard/Password/Edit')
                  }"
                >
                  <i class="fa-regular fa-lock"></i>
                  {{ trans("Change Password") }}
                </Link>
                <Link
                  href="/dashboard/orders"
                  class="nav-link"
                  :class="{
                    active: currentRoute('Frontend/Dashboard/Order/Index')
                  }"
                >
                  <i class="fa-regular fa-ticket"></i> {{ trans("Order") }}
                </Link>
                <Link
                  href="/dashboard/credit-logs"
                  class="nav-link"
                  :class="{
                    active: currentRoute('Frontend/Dashboard/Credit/Index')
                  }"
                >
                  <i class="fa-regular fa-wallet"></i>
                  {{ trans("Credit Purchase Log") }}
                </Link>
                <Link
                  href="/dashboard/notifications"
                  class="nav-link"
                  :class="{
                    active: currentRoute(
                      'Frontend/Dashboard/Notification/Index'
                    )
                  }"
                >
                  <i class="fa-regular fa-bell"></i>
                  {{ trans("Notifications") }}
                </Link>
              </div>
            </nav>
          </div>
        </div>
        <div class="col-xxl-8 col-lg-8">
          <div class="profile__tab-content">
            <div class="tab-content" id="profile-tabContent">
              <!-- Page content -->
              <slot />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <Announcement />
</template>
