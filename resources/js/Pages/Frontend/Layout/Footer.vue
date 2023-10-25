<template>
  <footer>
    <div class="footer__area">
      <div class="footer__top">
        <div class="container tp-container">
          <div class="footer__top-border pt-65 pb-40">
            <div class="row">
              <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-4 col-sm-6">
                <div class="footer__widget mb-50">
                  <div class="footer__info">
                    <div class="footer__logo">
                      <Link href="/">
                        <img
                          class="logo-white"
                          :src="$page.props.primaryData?.logo"
                          alt="logo"
                        />
                        <img
                          class="logo-black"
                          :src="$page.props.primaryData?.logo_dark"
                          alt="logo"
                        />
                      </Link>
                    </div>
                    <p>
                      {{ $page.props.footerData?.footer.description }}
                    </p>

                    <div class="footer__social">
                      <a
                        target="_blank"
                        v-for="(social, key) in $page.props.primaryData[
                          'socials'
                        ]"
                        :href="social"
                        :key="key"
                      >
                        <i class="fa-brands" :class="`fa-${key}`"> </i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <template v-if="footer.length > 0">
                <template v-for="items in footer.slice(0, 3)" :key="items.id">
                  <div class="col-xxl-2 col-xl-2 col-lg-4 col-md-4 col-sm-6">
                    <div class="footer__widget footer-col-2 mb-50">
                      <h3 class="footer__widget-title">{{ items.name }}</h3>
                      <template v-if="JSON.parse(items.data)?.length > 0">
                        <ul>
                          <li
                            v-for="item in JSON.parse(items.data)"
                            :key="item.id"
                          >
                            <Link
                              v-if="item.href"
                              :href="item.href"
                              :target="item.target"
                            >
                              {{ item.text }}
                            </Link>
                          </li>
                        </ul>
                      </template>
                    </div>
                  </div>
                </template>
              </template>
              <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-4 col-sm-6">
                <div class="footer__widget footer-col-5 mb-50">
                  <h3 class="footer__widget-title">{{ trans("Language") }}</h3>

                  <div class="footer__lang-wrapper">
                    <div class="footer__lang mb-25">
                      <div class="nice-select" tabindex="0">
                        <span class="current">{{
                          $page.props.languages[$page.props.locale] || "English"
                        }}</span>
                        <ul class="list">
                          <li
                            @click="switchLanguage(key)"
                            v-for="(language, key) in $page.props.languages"
                            :key="key"
                            class="option"
                          >
                            {{ trans(language) }}
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="footer__lang-certificate">
                      <img
                        class="light"
                        :src="$page.props.footerData?.certificate_image"
                        alt="logo"
                      />
                      <img
                        class="dark"
                        :src="$page.props.footerData?.certificate_image_dark"
                        alt="logo"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="footer__bottom">
        <div class="container tp-container">
          <div class="row">
            <div class="col-xxl-6 col-sm-6">
              <div class="footer__copyright">
                <p>
                  <a href="/">©{{ $page.props.app_name || "" }}</a
                  >, {{ year }} {{ trans("All rights reserved.") }}
                </p>
              </div>
            </div>
            <div class="col-xxl-6 col-sm-6">
              <div class="footer__menu text-sm-end">
                <Link href="/page/terms-and-conditions">{{
                  trans("Terms")
                }}</Link>
                <Link href="/page/privacy-policy">{{
                  trans("Privacy policy")
                }}</Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
"use strict";
import { router, usePage } from "@inertiajs/vue3"
import { computed } from "vue"
const footer = computed(() => {
  return (
    usePage().props.menus.filter((item) => item.position.includes("footer")) ||
    []
  )
})
const year = computed(() => {
  return new Date().getFullYear()
})
const switchLanguage = (key) => {
  router.patch(route("set-locale", key))
}
</script>
