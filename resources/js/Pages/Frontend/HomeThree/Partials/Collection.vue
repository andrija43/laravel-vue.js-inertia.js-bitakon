<script setup>
"use strict";
import { onMounted, ref } from 'vue'
import axios from 'axios'
const collections = ref([])
onMounted(() => {
  setTimeout(() => {
    axios.get(route('api-home-three', { type: 'collection' })).then((res) => {
      collections.value = res.data
    })
  }, 1000)
})
</script>

<template>
  <section class="collection__area pt-55 pb-30">
    <div class="container">
      <div class="section__title-border mb-40">
        <div class="row">
          <div class="col-xxl-6 col-md-6">
            <div class="section__title-wrapper-3">
              <h3 class="section__title-3">
                {{ trans('Featured collections') }}
              </h3>
            </div>
          </div>
          <div class="col-xxl-6 col-md-6">
            <div class="collection__more-3 text-md-end">
              <Link :href="route('collection.index')" class="tp-btn-border square">
                {{ trans('View all collections') }}
              </Link>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <template v-if="collections.length > 0">
          <template v-for="collection in collections" :key="collection.id">
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
              <div class="collection__box p-relative fix mb-30">
                <img
                  lazy="loading"
                  class="collection__box-bg"
                  v-lazy="
                    collection.preview
                      ? collection.preview
                      : '/assets/img/collection/3/sm/collection-sm-7.jpg'
                  "
                  alt="preview"
                />
                <div class="collection__box-top d-flex justify-content-between">
                  <div class="collection__box-tag">
                    <Link
                      :href="
                        route('user.checkout.index', {
                          collection: collection.id
                        })
                      "
                    >
                      {{ trans('Buy Now') }}
                    </Link>
                  </div>
                  <div class="collection__box-thumb">
                    <img
                      v-lazy="
                        collection.preview
                          ? collection.preview
                          : '/assets/img/collection/3/sm/collection-sm-7.jpg'
                      "
                      alt="preview"
                    />
                  </div>
                </div>
                <div class="collection__box-bottom">
                  <div class="collection__box-info">
                    <h3 class="collection__box-title">
                      <Link :href="route('collection.show', collection.slug)">{{
                        collection.name
                      }}</Link>
                    </h3>
                    <p>{{ collection.prompts_count }} {{ trans('Prompts') }}</p>
                  </div>
                  <div class="collection__box-user d-inline-block">
                    <div class="collection__box-user-inner d-flex align-items-center">
                      <div class="collection__box-user-thumb mr-10">
                        <Link :href="`/profile/${collection.user.username}`">
                          <img
                            v-lazy="
                              collection.user.avatar
                                ? collection.user.avatar
                                : `https://ui-avatars.com/api/?name=${collection.user.name}`
                            "
                            alt="avatar"
                          />
                        </Link>
                      </div>
                      <div class="collection__box-user-content">
                        <h5>
                          <Link :href="`/profile/${collection.user.username}`">
                            {{ collection.user.name }}
                          </Link>
                        </h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </template>
        </template>
        <h1 class="section__title-pre" v-else>{{ trans('Nothing Found') }}</h1>
      </div>
    </div>
  </section>
</template>
