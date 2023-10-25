<script setup>
"use strict";
import TopSellerSkeleton from "@/Pages/Frontend/Layout/TopSellerSkeleton.vue"
import { onMounted, ref } from "vue"
import axios from "axios"
const sellers = ref([])
const loading = ref(true)
const sort = ref("")
onMounted(() => {
  setTimeout(() => {
    axios.get(route("api-home", { type: "seller" })).then((res) => {
      sellers.value = res.data
      loading.value = false
    })
  }, 1000)
})
const filter = (value) => {
  sort.value = value
  loading.value = true
  axios
    .get(route("api-home", { sort: sort.value, type: "seller" }))
    .then((res) => {
      sellers.value = res.data
      loading.value = false
    })
}
const sellerRankClasses = [
  "",
  "clr-green",
  "clr-orange",
  "clr-purple",
  "clr-yellow",
  "clr-pink"
]
</script>

<template>
  <section class="seller__area pt-115 pb-60">
    <div class="container tp-container">
      <div class="row">
        <div class="col-xxl-9 col-lg-9 col-sm-7">
          <div class="section__title-wrapper mb-40">
            <h4 class="section__title-stroke">{{ trans("Popular") }}</h4>
            <span class="section__title-pre"> {{ trans("Popular") }} </span>
            <h3 class="section__title section__title-blue">
              {{ trans("Sellers") }}
            </h3>
          </div>
        </div>
        <div class="col-xxl-3 col-lg-3 col-sm-5">
          <div class="seller__date ml-15">
            <div class="seller__date-select">
              <h3>{{ trans("TimeFrame") }}</h3>
              <div class="nice-select" tabindex="0">
                <span class="current">{{ trans('Today') }}</span>
                <ul class="list">
                  <li @click="filter('today')" class="option selected focus">
                    {{ trans("Today") }}
                  </li>
                  <li @click="filter('yesterday')" class="option">
                    {{ trans("Yesterday") }}
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <TopSellerSkeleton v-if="loading" :is-loading="true" />
        <h1
          class="section__title-pre"
          v-else-if="!loading && sellers.length === 0"
        >
          {{ trans("Nothing Found") }}
        </h1>
        <template v-else>
          <template v-for="(seller, i) in sellers" :key="seller.id">
            <div class="col-xxl-2 col-xl-2 col-lg-4 col-md-4 col-sm-6">
              <div
                class="seller__item theme-bg-dark mb-30 transition-3"
                :class="sellerRankClasses[i]"
              >
                <div class="seller__top d-flex justify-content-between">
                  <div class="seller__rank">
                    <span><i class="fa-light fa-trophy"></i> #{{ i + 1 }}</span>
                  </div>
                  <div class="seller__action">
                    <ul>
                      <li>
                        <a
                          :href="`/profile/${seller.username}`"
                         
                          class="plus-minus"
                        >
                          <i class="fa-regular fa-square-plus"></i>
                          <i class="fa-regular fa-square-minus"></i>
                        </a>
                      </li>

                      <li>
                        <a
                          :href="`/profile/${seller.username}`"
                         
                        >
                          <i class="fa-regular fa-arrow-up-right"></i>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="seller__content text-center">
                  <div class="seller__thumb">
                    <a :href="`/profile/${seller.username}`" >
                      <img
                        :src="
                          seller.avatar
                            ? seller.avatar
                            : `https://ui-avatars.com/api/?name=${seller.name}`
                        "
                        alt="avatar"
                      />
                    </a>
                  </div>
                  <div class="seller__info">
                    <h3 class="seller__name">
                      <Link
                        :href="`/profile/${seller.username}`"
                      
                        >{{ seller.name }}</Link
                      >
                    </h3>
                    <div
                      class="seller__revenue d-flex align-items-center justify-content-center"
                    >
                      <div class="seller__revenue-icon">
                        <i class="fa-light fa-file-image"></i>
                      </div>
                      <div class="seller__revenue-ammount">
                        <p>
                          <span>{{ seller.total_sold }}</span>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </template>
        </template>
      </div>
    </div>
  </section>
</template>
