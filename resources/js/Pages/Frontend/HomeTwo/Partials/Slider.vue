<script setup>
"use strict";
import sharedComposable from '@/composables/sharedComposable'
import { Navigation, EffectFade } from 'swiper'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { onMounted, ref, computed } from 'vue'
import axios from 'axios'
import SliderSkeleton from './SliderSkeleton.vue'
// swiper styles
import 'swiper/css'
import 'swiper/css/navigation'
import 'swiper/css/effect-fade'
import { router } from '@inertiajs/vue3'

const navigationOptions = {
  nextEl: '.slider-button-next',
  prevEl: '.slider-button-prev'
}
const modules = [Navigation, EffectFade]
const sliders = ref([])
const sliderIndex = ref(0)
const loading = ref(false)
const { formatCurrency, authUser, ToastAlert, textExcerpt } = sharedComposable()

const getSlider = () => {
  axios.get(route('api-home-two', { type: 'slider' })).then((res) => {
    sliders.value = res.data
    loading.value = false
  })
}
onMounted(() => {
  loading.value = true

  getSlider()
})
const onSwiper = (swiper) => {
  sliderIndex.value = swiper.realIndex
}

const findSlider = computed(() => {
  return sliders.value[sliderIndex.value]
})
const like = (id) => {
  if (!authUser.value) {
    return router.get(route('login'))
  }
  router.post(
    route('user.like'),
    { id: id },
    {
      preserveScroll: true,
      onSuccess: () => {
        getSlider()
        ToastAlert(
          `${findSlider.value?.is_liked === 0 ? 'Like' : 'Disliked'} Successfully`,
          `${findSlider.value?.is_liked === 0 ? 'Like' : 'Disliked'} Successfully`
        )
      }
    }
  )
}
</script>

<template>
  <SliderSkeleton v-if="loading" />
  <section class="slider__area pb-140 pt-120 p-relative fix">
    <div class="slider__shape">
      <img
        class="slider__shape-1"
        src="assets/img/slider/2/slider-shape-1.png"
        alt="slider__shape"
      />
      <img
        class="slider__shape-2"
        src="assets/img/slider/2/slider-shape-2.png"
        alt="slider__shape"
      />
    </div>

    <div class="slider__active-2 slider__bid-area" v-show="sliders.length > 0 && !loading">
      <div class="single-slider d-flex align-items-center">
        <div class="container">
          <div class="row">
            <div class="col-xxl-6 col-xl-6 col-lg-6">
              <div class="slider__content-2">
                <h3 class="slider__title-2">
                  {{ trans('Create') }}, <span> {{ trans('Explore') }}</span>
                  {{
                    trans(`&
                  Collect digital Art and`)
                  }}
                  <span class="has-shape">
                    {{ trans('Prompts') }}
                    <img
                      class="slider-title-shape"
                      src="assets/img/icon/slider-stoke-shape.svg"
                      alt="title"
                    />
                  </span>
                </h3>
                <p>
                  {{
                    trans(`If you are an artist and want to be a successful artist then
                  learn to how to create digital art with prompt.`)
                  }}
                </p>

                <div class="slider__btn-2 d-sm-flex align-items-center">
                  <Link :href="route('prompt.index')" class="tp-btn-gradient active mr-15 mb-15">
                    {{ trans('View Market') }}
                  </Link>
                  <Link :href="route('user.prompt.create')" class="tp-btn-border mb-15">
                    {{ trans('Create Prompt') }}
                  </Link>
                </div>
              </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6">
              <div class="slider__bid-item pl-70">
                <div class="slider__bid-item-bg"></div>

                <Swiper
                  @slideChange="onSwiper"
                  style="z-index: -10"
                  :slides-per-view="1"
                  :space-between="10"
                  :modules="modules"
                  :navigation="navigationOptions"
                  :loop="true"
                  :effect="'fade'"
                >
                  <SwiperSlide class="slider__bid-thumb" v-for="slider in sliders" :key="slider">
                    <img width="350" :src="slider.preview" alt="preview" />
                  </SwiperSlide>
                </Swiper>

                <div class="slider__bid-content">
                  <div class="slider__bid-top">
                    <h3>{{ trans('Hottest Prompt') }}</h3>
                  </div>
                  <div class="slider__bid-info">
                    <h3 class="slider__bid-title">
                      <Link :href="route('prompt.show', findSlider?.slug ?? '')">
                        {{ textExcerpt(findSlider?.title || '', 20) }}
                      </Link>
                    </h3>
                    <div class="slider__bid-popularity">
                      <a type="button" @click="like(findSlider?.id)">
                        <i class="fa-solid fa-heart"></i>
                        {{ findSlider?.total_likes }}
                      </a>
                    </div>
                    <div class="slider__bid-collection">
                      <p>{{ trans('Author') }}</p>

                      <div class="slider__bid-user d-flex align-items-center">
                        <div class="slider__bid-user-thumb mr-10">
                          <img
                            :src="
                              findSlider?.user.avatar
                                ? findSlider?.user.avatar
                                : `https://ui-avatars.com/api/?name=${findSlider?.user.name}`
                            "
                            alt="avatar"
                          />
                        </div>
                        <div class="slider__bid-user-content">
                          <h3>{{ findSlider?.user.name }}</h3>
                        </div>
                      </div>
                    </div>
                    <div class="slider__bid-highest">
                      <p>{{ trans('Price') }}</p>
                      <h4>
                        <span>{{ formatCurrency(findSlider?.price) }}</span>
                      </h4>
                    </div>
                  </div>
                  <div class="slider__bid-btn">
                    <Link
                      :href="
                        route('user.checkout.index', {
                          prompt: findSlider?.id
                        })
                      "
                      class="slider-bid-btn"
                    >
                      {{ trans('Buy Now') }} <i class="fa-regular fa-arrow-right"></i>
                    </Link>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <button type="button" class="slick-prev slick-arrow slider-btn slider-button-next">
        <i class="fa-regular fa-angle-left"></i>
      </button>
      <button type="button" class="slick-next slick-arrow slider-btn slider-button-prev">
        <i class="fa-regular fa-angle-right"></i>
      </button>
    </div>
  </section>
</template>