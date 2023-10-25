<script setup>
"use strict";
const props = defineProps({
  isLoading: {
    default: true
  }
})
</script>

<template>
  <div class="container tp-container mt-80">
    <div class="row">
      <div class="col-xxl-5 col-xl-5">
        <div
          class="p-relative fix skeleton-loader"
          :class="{ 'fade-in': isLoading }"
        >
          <div class="skeleton-thumb-big"></div>
        </div>
      </div>
      <div class="col-xxl-7 col-xl-7">
        <div class="row">
          <div
            v-for="s in 6"
            :key="s"
            class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6"
          >
            <div
              class="p-relative fix skeleton-loader"
              :class="{ 'fade-in': isLoading }"
            >
              <div class="skeleton-thumb"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
