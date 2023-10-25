<script setup>
"use strict";
import { onMounted, ref } from 'vue'
import axios from 'axios'
const features = ref([])
onMounted(() => {
  setTimeout(() => {
    axios.get(route('api-home-three', { type: 'process' })).then((res) => {
      features.value = res.data
    })
  }, 1000)
})
</script>
<template>
  <section class="process__area pt-80 pb-120">
    <div class="container">
      <div class="row">
        <div class="col-xxl-12">
          <div class="section__title-wrapper-3 text-center mb-50">
            <h4 class="section__title-stroke section__title-stroke-2 center">
              {{ trans('Create and sell your Prompt') }}
            </h4>
            <span class="section__title-pre section__title-pre-2">
              {{ trans('How it works') }}
            </span>
            <h3 class="section__title-3">
              {{ trans('Create and sell your Prompt') }}
            </h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div
          class="col-xxl-3 col-xl-3 col-lg-4 col-md-6"
          v-for="feature in features"
          :key="feature.id"
        >
          <div class="process__item mb-30">
            <div class="process__icon mb-30">
              <span>
                <img width="30" class="light" v-lazy="feature.preview.value" alt="preview" />
                <img width="30" class="dark" v-lazy="feature.slug" alt="preview" />
              </span>
            </div>
            <div class="process__content">
              <h3 class="process__title">
                <a href="javascript:void(0)">{{ feature.title }}</a>
              </h3>
              <p>{{ feature.excerpt.value }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
