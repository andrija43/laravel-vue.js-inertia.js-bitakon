<script setup>
"use strict";
import { ref } from "vue";

const props = defineProps(["images"]);

const activeImage = ref(0);
</script>

<template>
  <div class="col-xxl-7 col-xl-6 col-lg-6" :class="images.length > 1 ? '' : ''">
    <div class="product__details-thumb-tab d-sm-flex align-items-start">
      <div v-if="images.length > 1" class="product__details-thumb-btn mr-30">
        <nav>
          <div
            class="nav nav-tabs flex-sm-column max-h-8-overflow styled-scrollbar"
            id="nav-tab"
            role="tablist"
          >
            <template v-for="(image, i) in images" :key="image">
              <button
                @click="activeImage = i"
                class="nav-link active"
                type="button"
              >
                <img class="mr-10" :src="image" alt="image" />
              </button>
            </template>
          </div>
        </nav>
      </div>
      <div class="product__details-thumb-content">
        <div class="tab-content" id="nav-tabContent">
          <template v-for="(image, i) in images" :key="image">
            <div v-if="activeImage === i">
              <img :src="image" alt="image" />
            </div>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>
