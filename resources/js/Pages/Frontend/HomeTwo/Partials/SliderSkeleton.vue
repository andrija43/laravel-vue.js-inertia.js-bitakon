<script setup>
"use strict";
const props = defineProps({
  isLoading: {
    default: true
  }
})
</script>
<template>
  <div class="container pb-140 pt-120">
    <div class="row">
      <div class="col-xxl-6 col-xl-6 col-lg-6">
        <div
          class="slider__content-2 skeleton-content"
          :class="{ 'fade-in': isLoading }"
        >
          <div class="">
            <div class="slider__purchase-content">
              <p>
                <span class="skeleton-text"></span>
              </p>
            </div>
          </div>
          <h3 class="slider__title-2">
            <span class="skeleton-shape"></span>
          </h3>
          <p><span class="skeleton-text"></span></p>
          <p><span class="skeleton-text"></span></p>
          <p><span class="skeleton-text"></span></p>
          <div class="slider__btn-2 d-sm-flex align-items-center">
            <div class="skeleton-button"></div>
            <div class="skeleton-button"></div>
          </div>
        </div>
      </div>
      <div class="col-xxl-6 col-xl-6 col-lg-6">
        <div class="slider__bid-item pl-70">
          <div class="slider__bid-item-bg animated-bg"></div>
          <div class="slider__bid-content-skeleton">
            <div class="slider__bid-top">
              <h3><span class="skeleton-text"></span></h3>
            </div>
            <div class="slider__bid-info">
              <div class="slider__bid-collection">
                <p><span class="skeleton-text"></span></p>
                <div class="slider__bid-user d-flex align-items-center">
                  <div class="slider__bid-user-thumb mr-10">
                    <div class="skeleton-avatar"></div>
                  </div>
                  <div class="slider__bid-user-content">
                    <h3><span class="skeleton-text"></span></h3>
                  </div>
                </div>
              </div>
              <div class="slider__bid-highest">
                <p><span class="skeleton-text"></span></p>
                <h4><span class="skeleton-text"></span></h4>
              </div>
            </div>
            <div class="slider__bid-btn">
              <div class="skeleton-button"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
