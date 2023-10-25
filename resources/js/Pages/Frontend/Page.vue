<script setup>
"use strict";
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue";
import Seo from "@/Pages/Frontend/Layout/Seo.vue";
import Announcement from "@/Pages/Frontend/Home/Partials/Announcement.vue";

defineOptions({ layout: FrontendLayout });
const props = defineProps(["page", "seo", "breadcrumb"]);
</script>
<template>
  <Seo :metaData="seo" />

  <!-- breadcrumb area start -->
  <section class="breadcrumb__area breadcrumb__border pt-160 pb-85 p-relative">
    <div class="breadrumb__shape">
      <img class="breadcrumb__shape-1" :src="breadcrumb" alt="" />
    </div>
    <div class="container">
      <div class="row">
        <div class="col-xxl-12">
          <div class="breadcrumb__content text-center">
            <h3 class="breadcrumb__title">{{ page.title }}</h3>
            <div class="breadcrumb__list">
              <span
                ><Link href="/">{{ trans("Home") }}</Link></span
              >
              <span class="dvdr tp-dot"
                ><i class="fa-solid fa-period"></i
              ></span>
              <span>{{ page.title }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- breadcrumb area end -->

  <!-- privacy & policy area start -->
  <section class="privacy__area pt-110 pb-90">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xxl-10">
          <div class="privacy__wrapper">
            <div class="text-justify base-text" v-html="page.description.value"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <Announcement />
  <!-- marque text area end -->
</template>
