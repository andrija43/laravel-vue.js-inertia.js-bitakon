<script setup>
"use strict";
const props = defineProps({
  isLoading: {
    default: true
  },
  classes: {
    default: "col-xxl-4 col-xl-4 col-lg-6 col-md-6"
  }
})
</script>
<template>
  <div :class="classes">
    <div class="col-xxl-12 skeleton-loader" :class="{ 'fade-in': isLoading }">
      <div class="nft__box theme-bg-dark mb-30 transition-3">
        <div
          class="nft__box-top d-flex align-items-center justify-content-between"
        >
          <div class="nft__box-user">
            <ul>
              <li>
                <div class="skeleton-avatar"></div>
              </li>
            </ul>
          </div>
          <div class="nft__box-more">
            <div class="skeleton-ellipsis"></div>
          </div>
        </div>
        <div class="nft__box-thumb m-img mb-10">
          <div class="skeleton-preview"></div>
        </div>
        <div class="nft__box-content pb-10">
          <div
            class="nft__box-content-top d-flex align-items-center justify-content-between"
          >
            <div class="skeleton-title"></div>
            <div>
              <div class="skeleton-small"></div>
            </div>
          </div>
          <div
            class="nft__box-info d-flex align-items-center justify-content-between"
          >
            <div class="skeleton-price"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
