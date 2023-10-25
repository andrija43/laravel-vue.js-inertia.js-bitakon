<script setup>
"use strict";

import FrontendLayout from "@/Pages/Frontend/Layout/App.vue";
import Announcement from "@/Pages/Frontend/Home/Partials/Announcement.vue";
import { Link } from "@inertiajs/vue3";
import Feature from "@/Pages/Frontend/Home/Partials/Feature.vue";
defineOptions({ layout: FrontendLayout });
const props = defineProps(["seo", "faqs"]);
</script>
<template>
  <Seo :metaData="seo" />
  <!-- breadcrumb area start -->
  <section class="breadcrumb__area breadcrumb__border pt-100 pb-85 p-relative">
    <div class="breadrumb__shape">
      <img
        class="breadcrumb__shape-1"
        src="/assets/img/breadcrumb/breadcrumb-shape-1.png"
        alt=""
      />
    </div>
    <div class="container">
      <div class="row">
        <div class="col-xxl-12">
          <div class="breadcrumb__content text-center">
            <h3 class="breadcrumb__title">{{ trans("FAQ's") }}</h3>
            <div class="breadcrumb__list">
              <span
                ><Link href="/">{{ trans("Home") }}</Link></span
              >
              <span class="dvdr tp-dot"
                ><i class="fa-solid fa-period"></i
              ></span>
              <span>{{ trans("faq") }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- breadcrumb area end -->

  <Feature />
  <!-- support area end -->

  <!-- faq area start -->
  <section class="faq__area pb-110">
    <div class="container tp-container">
      <div class="row">
        <div class="col-lg-6">
          <div class="faq__tab-content">
            <div class="accordion" id="sale-accordion">
              <template v-for="(faq, index) in faqs" :key="index">
                <div class="accordion-item" v-if="(index + 1) % 2 != 0">
                  <h2 class="accordion-header" :id="`headingOne${faq.id}`">
                    <button
                      class="accordion-button collapsed"
                      type="button"
                      data-bs-toggle="collapse"
                      :data-bs-target="`#collapseOne${faq.id}`"
                      aria-expanded="true"
                      aria-controls="collapseOne"
                    >
                      {{ faq.title }}
                    </button>
                  </h2>
                  <div
                    :id="`collapseOne${faq.id}`"
                    class="accordion-collapse collapse"
                    :aria-labelledby="`headingOne${faq.id}`"
                    data-bs-parent="#sale-accordion"
                  >
                    <div class="accordion-body">
                      <p>{{ faq.excerpt ? faq.excerpt.value : "" }}</p>
                    </div>
                  </div>
                </div>
              </template>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="faq__tab-content">
            <div class="accordion" id="template-accordion">
              <template v-for="(faq, index) in faqs" :key="index">
                <div class="accordion-item" v-if="(index + 1) % 2 == 0">
                  <h2 class="accordion-header" :id="`headingOne${faq.id}`">
                    <button
                      class="accordion-button collapsed"
                      type="button"
                      data-bs-toggle="collapse"
                      :data-bs-target="`#collapseSix${faq.id}`"
                      aria-expanded="false"
                      aria-controls="collapseSix"
                    >
                      {{ faq.title }}
                    </button>
                  </h2>
                  <div
                    :id="`collapseSix${faq.id}`"
                    class="accordion-collapse collapse"
                    :aria-labelledby="`headingOne${faq.id}`"
                    data-bs-parent="#template-accordion"
                  >
                    <div class="accordion-body">
                      <p>{{ faq.excerpt.value || "" }}</p>
                    </div>
                  </div>
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- faq area end -->

  <Announcement />
  <!-- marque text area end -->
</template>
