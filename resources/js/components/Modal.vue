<script setup>
"use strict";
import { modal } from "@/composables/modalComposable"
</script>

<template>
  <transition name="fade" appear mode="out-in">
    <div v-if="modal.state" @click.self="modal.reset" class="c-modal-container">
      <div class="bg-white rounded p-5 c-modal-content">
        <div class="exclamation"><span>!</span></div>
        <h6 class="text-center mt-4">Are you sure?</h6>
        <p class="text-center mt-4 mb-4">{{ modal.message }}</p>
        <div class="d-flex justify-content-center">
          <button @click="modal.accept" class="btn btn-primary">
            {{ modal.btnText }}
          </button>
          <button @click="modal.reset" class="btn btn-danger">Cancel</button>
        </div>
      </div>
    </div>
  </transition>
</template>
