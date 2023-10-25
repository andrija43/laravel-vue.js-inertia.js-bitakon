<script setup>
"use strict";
import { onMounted, ref } from 'vue'
import axios from 'axios'
const features = ref([])
onMounted(() => {
  setTimeout(() => {
    axios.get(route('api-home', { type: 'features' })).then((res) => {
      features.value = res.data
    })
  }, 1000)
})
</script>
<template>
  <section class="features__area pt-120 pb-70">
    <div class="container tp-container">
      <div class="row">
        <div class="col-xxl-11">
          <div class="section__title-wrapper text-center mb-60">
            <h4 class="section__title-stroke center">
              {{ trans('Create and sell') }}
            </h4>
            <h3 class="section__title">
              {{ trans('Create and sell your Prompt') }}
            </h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xxl-3 col-lg-4 col-md-6" v-for="(feature, i) in features" :key="feature.id">
          <div
            class="features__item mb-30 theme-bg-dark"
            :class="{
              'yellow-bg': i === 1,
              'pink-bg': i === 2,
              'green-bg': i === 3
            }"
          >
            <div class="features__item-inner">
              <div class="features__icon">
                <img class="dark" width="80" v-lazy="feature.preview.value" alt="preview" />
                <img class="light" width="80" v-lazy="feature.slug" alt="preview" />
              </div>
              <div class="features__content">
                <h4 class="features__title">
                  {{ feature.title }}
                </h4>
                <p>{{ feature.excerpt.value }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
