<template>
  <!-- <PreLoader /> -->
  <!-- back to top start -->
  <div class="progress-wrap">
    <svg
      class="progress-circle svg-content"
      width="100%"
      height="100%"
      viewBox="-1 -1 102 102"
    >
      <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
  </div>
  <!-- back to top end -->
  <HeaderSection />
  <!-- theme -->
  <div class="theme__settings transition-3">
    <div class="theme__settings-btn">
      <button
        type="button"
        class="theme__settings-expand"
        id="theme-setting-toggle"
      >
        <i class="fa-solid fa-gear"></i>
      </button>
      <button
        type="button"
        class="theme__settings-close"
        id="theme-setting-close"
      >
        <i class="fa-regular fa-xmark"></i>
      </button>
    </div>
    <div class="theme__settings-wrapper text-center">
      <div class="theme__switch mb-30">
        <h4 class="theme__settings-title">
          {{ trans("Select your desired theme") }}
        </h4>
        <!-- light dark moode switcher start -->
        <div class="my_switcher setting-option">
          <ul>
            <li>
              <a
                href="javascript: void(0);"
                data-theme="dark"
                class="setColor dark theme__switcher-btn"
              >
                <i class="fa-light fa-moon"></i> {{ trans("Dark") }}
              </a>
            </li>
            <li>
              <a
                href="javascript: void(0);"
                data-theme="light"
                class="setColor light theme__switcher-btn"
              >
                <i class="fa-light fa-brightness-low"></i> {{ trans("Light") }}
              </a>
            </li>
          </ul>
        </div>
        <!-- light dark moode switcher end -->
      </div>
    </div>
  </div>
  <ShareModal />
  <div class="body-overlay"></div>
  <ValidationErrors />

  <!-- Main content -->
  <main>
    <!-- Page content -->
    <slot></slot>
  </main>
  <FrontendFooter />
</template>

<script setup>
"use strict";
import HeaderSection from "@/Pages/Frontend/Layout/HeaderSection.vue";
import ShareModal from "@/Pages/Frontend/Account/Prompt/Partials/ShareModal.vue";
import FrontendFooter from "@/Pages/Frontend/Layout/Footer.vue";
import ValidationErrors from "@/Pages/Frontend/Layout/ValidationErrors.vue";
</script>
