<script setup>
"use strict";
import { router } from "@inertiajs/vue3"
import { computed, ref } from "vue"
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue"
import Slider from "@/Pages/Frontend/Home/Partials/Slider.vue"
import Seller from "@/Pages/Frontend/Home/Partials/Seller.vue"
import HotSeller from "@/Pages/Frontend/Home/Partials/HotSeller.vue"
import Explore from "@/Pages/Frontend/Home/Partials/Explore.vue"
import Collection from "@/Pages/Frontend/Home/Partials/Collection.vue"
import Feature from "@/Pages/Frontend/Home/Partials/Feature.vue"
import sharedComposable from "@/composables/sharedComposable"

defineProps(["home","seo"])
defineOptions({ layout: FrontendLayout })
const { ToastAlert } = sharedComposable()
const email = ref("")
const subscribe = () => {
  if (email.value) {
    router.post(
      route("newsletter.subscribe"),
      { email: email.value },
      {
        preserveScroll: true,
        onSuccess: () => {
          email.value = ""
          ToastAlert("success", "Subscribed successfully")
        }
      }
    )
  }
}
const NEWSLETTER_API = computed(() => import.meta.env.VITE_NEWSLETTER_API_KEY)
</script>

<template>
  <Seo :metaData="seo" />

  <img
    class="breadcrumb__shape-1"
    src="/assets/img/breadcrumb/breadcrumb-shape-1.png"
    alt="shape"
  />

  <!-- slider -->
  <Slider />
  <!-- seller -->
  <Seller />
  <!-- hot -->
  <HotSeller />
  <!-- explore -->
  <Explore />
  <!-- Collection -->
  <Collection />
  <!-- Feature -->
  <Feature />
  <!-- cta area start -->
  <section class="cta__area pt-45 pb-30" v-if="home">
    <div class="container tp-container">
      <div class="row gx-3">
        <div class="col-xxl-5 col-xl-5">
          <div
            v-if="NEWSLETTER_API"
            class="subscribe__wrapper p-relative mr-40"
          >
            <div class="subscribe__inner theme-bg-dark p-relative">
              <div class="subscribe__shape">
                <img
                  class="subscribe__shape-1"
                  src="assets/img/cta/cta-shape-1.png"
                  alt=""
                />
              </div>
              <h3>{{ trans("Get the latest Prompt updates") }}</h3>
              <form @submit.prevent="subscribe">
                <div class="subscribe__input-wrapper p-relative">
                  <div class="subscribe__input">
                    <input
                      type="email"
                      v-model="email"
                      placeholder="Your e-mail"
                      required
                    />
                    <i class="fa-light fa-envelopes"></i>
                  </div>
                  <button class="subscribe__input-btn" type="submit">
                    {{ trans("Subscribe") }}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-xxl-7 col-xl-7">
          <div class="app__wrapper p-relative">
            <div class="app__inner theme-bg-dark p-relative">
              <div class="app__content d-sm-flex align-items-center">
                <div class="app__qr mr-60">
                  <img
                    v-lazy="
                      home?.qr_image
                        ? home?.qr_image
                        : 'assets/img/cta/qrcode.png'
                    "
                    alt="qrcode"
                  />
                </div>
                <div class="app__info">
                  <h3 v-html="home?.title">
                    
                  </h3>

                  <div class="app__download d-sm-flex align-items-center">
                    <a
                      v-if="home?.action_android_link"
                      :href="home.action_android_link"
                      target="_blank"
                    >
                      <div
                        class="app__download-item d-flex align-items-center transition-3"
                      >
                        <div class="app__download-icon mr-5">
                          <i
                            class="fa-brands"
                            :class="home.action_android_icon_name"
                          ></i>
                        </div>
                        <div class="app__download-text">
                          <p class="pt-2 pb-1">
                            {{ home.action_android_text }}
                          </p>
                        </div>
                      </div>
                    </a>
                    <a
                      v-if="home?.action_ios_link"
                      :href="home.action_ios_link"
                      target="_blank"
                    >
                      <div
                        class="app__download-item d-flex align-items-center transition-3"
                      >
                        <div class="app__download-icon mr-5">
                          <i
                            class="fa-brands"
                            :class="home.action_ios_icon_name"
                          ></i>
                        </div>
                        <div class="app__download-text">
                          <p class="pt-2 pb-1">{{ home.action_ios_text }}</p>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- cta area end -->
</template>
