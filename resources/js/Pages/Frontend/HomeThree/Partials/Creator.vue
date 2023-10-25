<script setup>
"use strict";
import { onMounted, ref } from 'vue'
import axios from 'axios'
const creators = ref([])
const loading = ref(true)
const filter = () => {
  loading.value = true
  axios.get(route('api-home-three', { type: 'creator' })).then((res) => {
    creators.value = res.data
    loading.value = false
  })
}
onMounted(() => {
  setTimeout(() => filter(), 1000)
})
</script>

<template>
  <section class="creator__area pt-30 pb-30">
    <div class="container">
      <div class="section__title-border mb-40">
        <div class="row">
          <div class="col-xxl-6 col-md-6">
            <div class="section__title-wrapper-3">
              <h3 class="section__title-3">
                {{ trans('Top creator this week') }}
              </h3>
            </div>
          </div>
          <div class="col-xxl-6 col-md-6">
            <div class="creator__more text-md-end">
              <Link href="/top-sellers" class="tp-btn-border square">
                {{ trans('View Ranking') }}
              </Link>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <template v-if="creators.length > 0">
          <template v-for="creator in creators" :key="creator.id">
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
              <div
                class="creator__item transition-3 d-flex align-items-center justify-content-between mb-25"
              >
                <div class="creator__item-inner d-flex align-items-center">
                  <div class="creator__thumb mr-20">
                    <Link :href="route('profile.show', creator.username)">
                      <img
                        lazy="loading"
                        v-lazy="
                          creator.avatar
                            ? creator.avatar
                            : `https://ui-avatars.com/api/?name=${creator.name}`
                        "
                        alt=""
                      />
                    </Link>
                  </div>
                  <div class="creator__content">
                    <h3 class="creator__title">
                      <Link :href="route('profile.show', creator.username)">{{
                        creator.username
                      }}</Link>
                    </h3>
                    <div class="creator__revenue d-flex align-items-center">
                      <div class="creator__revenue-icon mr-10">
                        <i class="fa-light fa-arrow-up-big-small"></i>
                      </div>
                      <div class="creator__revenue-text">
                        <p>{{ creator.total_sold }} {{ trans(' - Sales') }}</p>
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
