<script setup>
"use strict";
const props = defineProps({
  isLoading: {
    default: false
  },
  count: {
    default: 6
  },
  classes: {
    default: "col-xxl-2 col-xl-2 col-lg-4 col-md-4 col-sm-6"
  }
})
</script>

<template>
  <div :class="classes" v-for="i in count" :key="i">
    <div
      class="seller__item theme-bg-dark mb-30 transition-3 seller-skeleton-loader"
      :class="{ 'fade-in': isLoading }"
    >
      <div class="seller__top d-flex justify-content-between">
        <div class="seller__rank">
          <span><i class="fa-light fa-trophy"></i> #</span>
        </div>
        <div class="seller__action">
          <ul>
            <li>
              <a href="#" class="plus-minus">
                <i class="fa-regular fa-square-plus"></i>
                <i class="fa-regular fa-square-minus"></i>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa-regular fa-arrow-up-right"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="seller__content text-center">
        <div class="seller__thumb">
          <div class="skeleton-avatar"></div>
        </div>
        <div class="seller__info">
          <h3 class="seller__name">
            <div class="skeleton-name"></div>
          </h3>
          <div
            class="seller__revenue d-flex align-items-center justify-content-center"
          >
            <div class="seller__revenue-icon">
              <i class="fa-brands fa-ethereum"></i>
            </div>
            <div class="seller__revenue-amount">
              <p>
                <span></span>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
