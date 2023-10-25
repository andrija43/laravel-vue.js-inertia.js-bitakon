<script setup>
"use strict";
import { Navigation } from "swiper";
import { Swiper, SwiperSlide } from "swiper/vue";
import PromptCard from "@/Pages/Frontend/Prompt/Partials/PromptCard.vue";
// swiper styles
import "swiper/css";
import "swiper/css/navigation";
const props = defineProps(["prompts", "username", "successEvent"]);
const navigationOptions = {
  nextEl: ".bid-next",
  prevEl: ".bid-prev",
};
const modules = [Navigation];
</script>

<template>
  <section class="bid__area pt-60 pt-110 fix">
    <div class="container">
      <div class="row">
        <div class="col-xxl-6 col-sm-6">
          <div class="section__title-wrapper mb-40">
            <h4 class="section__title-stroke">{{ trans("More from") }}</h4>
            <h3 class="section__title">{{ username }}</h3>
          </div>
        </div>
        <div class="col-xxl-6 col-sm-6">
          <div class="bid__nav text-sm-end">
            <button type="button" class="slick-prev slick-arrow bid-prev">
              <i class="fa-regular fa-angle-left"></i>
            </button>
            <button type="button" class="slick-next slick-arrow bid-next">
              <i class="fa-regular fa-angle-right"></i>
            </button>
          </div>
        </div>
      </div>

      <Swiper
        :slidesPerView="4"
        :spaceBetween="20"
        :modules="modules"
        :navigation="navigationOptions"
        :breakpoints="{
          '260': {
            slidesPerView: 1,
          },
          '420': {
            slidesPerView: 2,
          },
          '868': {
            slidesPerView: 3,
          },
          '1024': {
            slidesPerView: 4,
          },
        }"
      >
        <SwiperSlide v-for="prompt in prompts" :key="prompt.id">
          <PromptCard :successEvent="successEvent" :prompt="prompt" />
        </SwiperSlide>
      </Swiper>
    </div>
  </section>
</template>
