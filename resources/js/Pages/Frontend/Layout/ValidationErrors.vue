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
    <div v-if="hasErrors" class="validation-errors-home">
      <div class="wallet__item wallet-red-bg">
        <div class="d-flex justify-content-end">
          <button class="btn text-danger" @click="close">
            <i class="fa fa-times fa-lg" aria-hidden="true"></i>
          </button>
        </div>
        <div class="wallet__item-fix p-4">
          <div class="wallet__item-inner text-center">
            <div class="wallet__content">
              <div class="error-list">
                <p v-for="(error, key) in errors" :key="key">
                  * {{ error.replace(/[.,]/g, " ") }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>
