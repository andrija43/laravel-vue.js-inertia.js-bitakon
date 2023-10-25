<template>
  <section class="creator__area">
    <slot name="creatorBanner">
      <div
        class="creator__banner include-bg"
      ></div>
    </slot>
    <div class="container">
      <div class="row">
        <div class="col-xxl-12">
          <div class="creator__user-wrapper text-center">
            <!-- user profile -->
            <slot name="profileHeader" />
          </div>
        </div>
      </div>
    </div>
    <div class="creator__border"></div>
    <!-- Page content -->
    <slot />
  </section>
  <Announcement />
</template>

<script setup>
"use strict";
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue";
import Announcement from "@/Pages/Frontend/Home/Partials/Announcement.vue";
import sharedComposable from "@/composables/sharedComposable";
defineOptions({ layout: FrontendLayout });
const { authUser } = sharedComposable();
</script>
