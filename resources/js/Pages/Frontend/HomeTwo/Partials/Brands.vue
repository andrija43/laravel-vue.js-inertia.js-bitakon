<script setup>
"use strict";
import { onMounted, ref } from 'vue'
import axios from 'axios'
const brands = ref([])
onMounted(() => {
  setTimeout(() => {
    axios.get(route('api-home-two', { type: 'brands' })).then((res) => {
      brands.value = res.data
    })
  }, 1200)
})
</script>

<template>
  <div class="brand__area pt-15 pb-70">
    <div class="container">
      <div class="row row-cols-xxl-5 justify-content-center">
        <template v-for="brand in brands" :key="brand.id">
          <div class="col">
            <div class="brand__item text-center mb-30">
              <img v-lazy="brand.slug" alt="logo" />
            </div>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>
