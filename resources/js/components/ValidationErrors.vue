<script setup>
"use strict";

import { computed } from "vue"
import { usePage } from "@inertiajs/vue3"
const errors = computed(() => usePage().props.errors)
const close = () => (usePage().props.errors = [])
const hasErrors = computed(() => Object.keys(errors.value).length > 0)
</script>

<template>
  <transition name="slide-right">
    <div v-if="hasErrors" class="validation-errors">
      <div class="d-flex justify-content-end">
        <button class="btn btn-danger btn-sm" @click="close">Close</button>
      </div>
      <div class="error-list">
        <p v-for="(error, key) in errors" :key="key">
          * {{ error.replace(/[.,]/g, " ") }}
        </p>
      </div>
    </div>
  </transition>
</template>
