<script setup>
"use strict";
import sharedComposable from "@/composables/sharedComposable"
import { Navigation } from "swiper"
import { Swiper, SwiperSlide } from "swiper/vue"
import { onMounted, ref } from "vue"
import axios from "axios"
import SliderSkeleton from "./SliderSkeleton.vue"
// swiper styles
import "swiper/css"
import "swiper/css/navigation"

const navigationOptions = {
  nextEl: ".slider-button-next",
  prevEl: ".slider-button-prev"
}
const modules = [Navigation]
const sliders = ref([])
const loading = ref(false)
const { formatCurrency } = sharedComposable()
onMounted(() => {
  loading.value = true

  axios.get(route("api-home", { type: "slider" })).then((res) => {
    sliders.value = res.data
    loading.value = false
  })
})
</script>

<template>
  <SliderSkeleton v-if="loading" />
  <section
    class="slider__area slider__bg pt-100 pb-70"
    v-if="sliders.length > 0 && !loading"
  >
    <div class="container tp-container p-relative">
      <Swiper
        :slides-per-view="1"
        :space-between="10"
        :modules="modules"
        :navigation="navigationOptions"
        :loop="true"
      >
        <SwiperSlide v-for="slider in sliders" :key="slider">
          <div class="row">
            <div class="col-xxl-5 col-xl-5">
              <div class="slider__item p-relative fix mb-30">
                <img
                  :src="
                    slider[0].prompt.preview
                      ? slider[0].prompt.preview
                      : JSON.parse(slider[0].prompt.meta).preview
                  "
                  class="slider__thumb include-bg slider-large-img1"
                  alt="img"
                />
                <div class="slider__content">
                  <h3 class="slider__title">
                    <Link :href="route('prompt.show', slider[0].prompt.slug)">{{
                      slider[0].prompt.title
                    }}</Link>
                  </h3>
                  <span>{{ formatCurrency(slider[0].prompt.price) }}</span>
                </div>
              </div>
            </div>
            <div class="col-xxl-7 col-xl-7">
              <div class="row">
                <div
                  v-for="s in slider.slice(1)"
                  :key="s"
                  class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6"
                >
                  <div class="slider__item-sm p-relative fix mb-15">
                    <img
                      :src="
                        s.prompt.preview || JSON.parse(s.prompt.meta).preview
                      "
                      class="slider__thumb include-bg slider-small-img1"
                      alt="img"
                    />
                    <div class="slider__content-sm">
                      <h3 class="slider__title-sm">
                        <Link :href="route('prompt.show', s.prompt.slug)">{{
                          s.prompt.title
                        }}</Link>
                      </h3>
                      <span>{{ formatCurrency(s.prompt.price) }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </SwiperSlide>
      </Swiper>

      <div v-if="sliders.length > 1" class="slider__nav">
        <button class="slider-button-next">
          <i class="fa-light fa-angle-right"></i>
        </button>
        <button class="slider-button-prev">
          <i class="fa-light fa-angle-left"></i>
        </button>
      </div>
    </div>
  </section>
</template>
