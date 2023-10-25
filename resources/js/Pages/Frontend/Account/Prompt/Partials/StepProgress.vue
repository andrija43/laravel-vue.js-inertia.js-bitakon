<script setup>
"use strict";
const props = defineProps({
  step: { default: 2 },
  maxStep: { default: 4 },
  multiply: { default: 25 }
})

const emit = defineEmits(["prevStep"])
</script>

<template>
  <div class="progress-bar-container mt-10">
    <button @click="emit('prevStep')">
      <i class="fa fa-angle-left fa-lg" aria-hidden="true"></i>
    </button>
    <div class="progress">
      <div
        class="progress-bar"
        role="progressbar"
        :style="{
          width: step * multiply + '%'
        }"
        aria-valuenow="50"
        aria-valuemin="0"
        aria-valuemax="100"
      ></div>
    </div>

    <span class="progress-count">{{ step }} / {{ maxStep }}</span>
  </div>
</template>
