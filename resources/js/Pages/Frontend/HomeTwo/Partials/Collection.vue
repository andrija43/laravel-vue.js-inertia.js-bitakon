<script setup>
"use strict";
import { onMounted, ref } from 'vue'
import axios from 'axios'
import sharedComposable from '@/composables/sharedComposable'
const collections = ref([])
const order = ref('desc')
const { textExcerpt } = sharedComposable()
const getCollection = () => {
  axios
    .get(
      route('api-home-two', {
        type: 'collection',
        order: order.value
      })
    )
    .then((res) => {
      collections.value = res.data
    })
}
onMounted(() => {
  setTimeout(() => {
    getCollection()
  }, 1000)
})
</script>
<template>
  <section class="collection__area collection__counter include-bg pt-120 pb-100">
    <div class="container">
      <div class="row">
        <div class="col-xxl-6 col-lg-6">
          <div class="collection__select d-sm-flex align-items-center mb-30">
            <div class="section__title-wrapper-2 mr-15">
              <h3 class="section__title-2">{{ trans(`Top collections`) }}</h3>
            </div>
          </div>
        </div>
        <div class="col-xxl-6 col-lg-6">
          <div class="collection__right d-sm-flex align-items-center justify-content-lg-end">
            <div class="collection__nav">
              <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <button
                    @click="
                      () => {
                        order = 'desc'
                        getCollection()
                      }
                    "
                    class="nav-link"
                    :class="{ active: order === 'desc' }"
                    type="button"
                  >
                    {{ trans('High') }}
                  </button>
                  <button
                    @click="
                      () => {
                        order = 'asc'
                        getCollection()
                      }
                    "
                    class="nav-link"
                    :class="{ active: order === 'asc' }"
                    type="button"
                  >
                    {{ trans('Low') }}
                  </button>
                </div>
              </nav>
            </div>
            <div class="collection__more ml-10">
              <Link :href="route('collection.index')" class="tp-btn-border">
                {{ trans('view all') }}
              </Link>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xxl-12">
          <div class="row">
            <template v-if="collections.length > 0">
              <template v-for="collection in collections" :key="collection.id">
                <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-6">
                  <div class="collection__list d-flex align-items-center mb-20 transition-3">
                    <div class="collection__list-thumb collection__list-rank mr-20">
                      <img lazy="loading" v-lazy="collection.preview" alt="preview" />
                    </div>
                    <div class="collection__list-content">
                      <Link
                        class="collection__list-title"
                        :href="route('collection.show', collection.slug)"
                      >
                        {{ textExcerpt(collection.name, 20) }}
                      </Link>
                      <div class="collection__list-revenue d-flex align-items-center">
                        <div class="collection__list-revenue-icon mr-5">
                          <span>
                            <i class="fa-light fa-file-image"></i>
                          </span>
                        </div>
                        <div class="collection__list-revenue-text">
                          <p>
                            <span>{{ collection.prompts_count }}</span>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </template>
            </template>
            <h1 class="section__title-pre" v-else>
              {{ trans('Nothing Found') }}
            </h1>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
