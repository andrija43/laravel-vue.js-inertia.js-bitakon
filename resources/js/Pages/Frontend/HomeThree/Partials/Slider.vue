<script setup>
"use strict";
import { router } from "@inertiajs/vue3"
import { ref, onMounted } from "vue"
import { Pagination } from "swiper"
import { Swiper, SwiperSlide } from "swiper/vue"
import axios from "axios"
import SliderSkeleton from "./SliderSkeleton.vue"
const loading = ref(false)
const query = ref("")
const type = ref("model")
const search = () => {
  if (type.value == "model") {
    router.get(route("prompt.index", { model: query.value }))
  }
  if (type.value == "prompt") {
    router.get(route("prompt.index", { s_query: query.value }))
  }
}
// swiper styles
import "swiper/css"
import "swiper/css/pagination"
const paginationOptions = {
  clickable: true
}
const modules = [Pagination]
const sliders = ref([])
onMounted(() => {
  loading.value = true
  axios.get(route("api-home-three", { type: "slider" })).then((res) => {
    sliders.value = res.data
    loading.value = false
  })
})
</script>

<template>
  <SliderSkeleton v-if="loading" />
  <section
    v-if="sliders.length > 0 && !loading"
    class="slider__area pt-40 pb-70 p-relative slider__height-3 d-flex align-items-center"
  >
    <div
      class="slider__bg-3"
      
    ></div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xxl-10">
          <div class="slider__content-3">
            <div class="slider__search text-center">
              <span> {{ trans("Collect Prompt") }}</span>
              <h3 class="slider__title-3">
                {{ trans("Collect digital art") }}
              </h3>

              <div class="slider__search-box mb-85">
                <form action="#">
                  <div class="slider__search-input">
                    <div
                      class="slider__search-category d-none d-sm-flex align-items-center"
                    >
                      <svg
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          opacity="0.4"
                          d="M7.8999 9.39999C8.72833 9.39999 9.3999 8.72842 9.3999 7.89999C9.3999 7.07157 8.72833 6.39999 7.8999 6.39999C7.07148 6.39999 6.3999 7.07157 6.3999 7.89999C6.3999 8.72842 7.07148 9.39999 7.8999 9.39999Z"
                          fill="white"
                        />
                        <path
                          d="M14.2998 9.39999C15.1282 9.39999 15.7998 8.72842 15.7998 7.89999C15.7998 7.07157 15.1282 6.39999 14.2998 6.39999C13.4714 6.39999 12.7998 7.07157 12.7998 7.89999C12.7998 8.72842 13.4714 9.39999 14.2998 9.39999Z"
                          fill="white"
                        />
                        <path
                          d="M1.5 9.39999C2.32843 9.39999 3 8.72842 3 7.89999C3 7.07157 2.32843 6.39999 1.5 6.39999C0.671573 6.39999 0 7.07157 0 7.89999C0 8.72842 0.671573 9.39999 1.5 9.39999Z"
                          fill="white"
                        />
                        <path
                          d="M7.8999 3C8.72833 3 9.3999 2.32843 9.3999 1.5C9.3999 0.671573 8.72833 0 7.8999 0C7.07148 0 6.3999 0.671573 6.3999 1.5C6.3999 2.32843 7.07148 3 7.8999 3Z"
                          fill="white"
                        />
                        <path
                          d="M7.8999 15.8C8.72833 15.8 9.3999 15.1284 9.3999 14.3C9.3999 13.4716 8.72833 12.8 7.8999 12.8C7.07148 12.8 6.3999 13.4716 6.3999 14.3C6.3999 15.1284 7.07148 15.8 7.8999 15.8Z"
                          fill="white"
                        />
                        <path
                          opacity="0.4"
                          d="M14.2998 3C15.1282 3 15.7998 2.32843 15.7998 1.5C15.7998 0.671573 15.1282 0 14.2998 0C13.4714 0 12.7998 0.671573 12.7998 1.5C12.7998 2.32843 13.4714 3 14.2998 3Z"
                          fill="white"
                        />
                        <path
                          opacity="0.4"
                          d="M14.2998 15.8C15.1282 15.8 15.7998 15.1284 15.7998 14.3C15.7998 13.4716 15.1282 12.8 14.2998 12.8C13.4714 12.8 12.7998 13.4716 12.7998 14.3C12.7998 15.1284 13.4714 15.8 14.2998 15.8Z"
                          fill="white"
                        />
                        <path
                          opacity="0.4"
                          d="M1.5 3C2.32843 3 3 2.32843 3 1.5C3 0.671573 2.32843 0 1.5 0C0.671573 0 0 0.671573 0 1.5C0 2.32843 0.671573 3 1.5 3Z"
                          fill="white"
                        />
                        <path
                          opacity="0.4"
                          d="M1.5 15.8C2.32843 15.8 3 15.1284 3 14.3C3 13.4716 2.32843 12.8 1.5 12.8C0.671573 12.8 0 13.4716 0 14.3C0 15.1284 0.671573 15.8 1.5 15.8Z"
                          fill="white"
                        />
                      </svg>
                      <div class="nice-select" tabindex="0">
                        <span class="current">{{ trans("Model") }}</span>
                        <ul class="list">
                          <li
                            data-value="Model"
                            class="option selected"
                            @click="type = 'model'"
                          >
                            {{ trans("Model") }}
                          </li>
                          <li
                            data-value="Prompt"
                            class="option"
                            @click="type = 'prompt'"
                          >
                            {{ trans("Prompt") }}
                          </li>
                        </ul>
                      </div>
                    </div>
                    <input
                      v-model="query"
                      type="text"
                      placeholder="Search Prompt, Model..."
                    />

                    <button @click.prevent="search" type="submit">
                      <i class="fa-regular fa-magnifying-glass"></i>
                    </button>
                  </div>
                </form>
              </div>

              <div class="slider__active-3 swiper-container">
                <div class="swiper-wrapper">
                  <div class="slider__thumb-shape-3">
                    <img
                      src="/assets/img/slider/3/slider-thumb-shape.png"
                      alt=""
                    />
                  </div>
                  <Swiper
                    :slides-per-view="1"
                    :space-between="10"
                    :modules="modules"
                    :pagination="paginationOptions"
                    :loop="true"
                  >
                    <SwiperSlide v-for="slider in sliders" :key="slider">
                      <div class="swiper-slide slider__item-3 p-relative">
                        <div class="slider__thumb-3">
                          <div class="image-container">
                            <Link
                              :href="route('prompt.show', s.prompt.slug)"
                              v-for="(s, i) in slider"
                              :key="s.id"
                            >
                              <img
                                class="slider-img2"
                                :class="{
                                  'slider-img2-first': i == 0,
                                  'slider-img2-last': i == 2
                                }"
                                :src="
                                  s.prompt.preview
                                    ? s.prompt.preview
                                    : JSON.parse(s.prompt.meta).preview
                                "
                                alt="preview"
                              />
                            </Link>
                          </div>

                          <div
                            class="slider__user-wrapper d-md-flex align-items-center justify-content-between"
                          >
                            <div
                              class="slider__user-thumb d-sm-flex align-items-center"
                            >
                              <ul class="mr-10">
                                <li v-for="s in slider" :key="s.id">
                                  <a
                                    :href="`/profile/${s.prompt.user.username}`"
                                    target="_blank"
                                  >
                                    <img
                                      class="avatar-img"
                                      :src="
                                        s.prompt.user.avatar
                                          ? s.prompt.user.avatar
                                          : `https://ui-avatars.com/api/?name=${s.prompt.user.name}&background=random&rounded=true`
                                      "
                                      alt="avatar"
                                    />
                                  </a>
                                </li>
                              </ul>
                              <p>
                                <template v-for="(s, i) in slider" :key="s.id">
                                  {{ s.prompt.title }}
                                  <span v-if="i < 2">,</span>
                                </template>
                              </p>
                            </div>
                            <div class="slider__user-more">
                              <Link
                                :href="route('prompt.index')"
                                class="tp-btn-transparent"
                              >
                                {{ trans("learn more") }}
                              </Link>
                            </div>
                          </div>
                        </div>
                      </div>
                    </SwiperSlide>
                  </Swiper>
                </div>
                <div class="slider-dot slider-dot-3 mt-40">
                  <div
                    class="slider-pagination-3 d-flex align-items-center justify-content-center"
                  ></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
