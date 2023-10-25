<script setup>
"use strict";
import PromptCardSkeleton from '@/Pages/Frontend/Layout/PromptCardSkeleton.vue'
import { Navigation } from 'swiper'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { onMounted, ref } from 'vue'
import axios from 'axios'
// swiper styles
import 'swiper/css'
import 'swiper/css/navigation'
import sharedComposable from '@/composables/sharedComposable'
import { share } from '@/composables/shareComposable'
import { router } from '@inertiajs/vue3'
const { formatCurrency, textExcerpt, authUser, ToastAlert } = sharedComposable()
const navigationOptions = {
  nextEl: '.bid-next',
  prevEl: '.bid-prev'
}
const modules = [Navigation]
const prompts = ref([])
const loading = ref(true)
const getPrompts = () => {
  axios.get(route('api-home', { type: 'prompt' })).then((res) => {
    prompts.value = res.data
    loading.value = false
  })
}
onMounted(() => {
  setTimeout(() => getPrompts(), 1000)
})
const like = (id, is_liked) => {
  if (!authUser.value) {
    return router.get(route('login'))
  }
  console.log(+is_liked)
  router.post(
    route('user.like'),
    { id: id },
    {
      preserveScroll: true,
      onSuccess: () => {
        getPrompts()
        ToastAlert(
          `${+is_liked === 0 ? 'Like' : 'Disliked'} Successfully`,
          `${+is_liked === 0 ? 'Like' : 'Disliked'} Successfully`
        )
      }
    }
  )
}
</script>

<template>
  <section class="bid__area pt-60 pb-130 fix">
    <div class="container tp-container">
      <div class="row">
        <div class="col-xxl-6 col-sm-6">
          <div class="section__title-wrapper mb-40">
            <h4 class="section__title-stroke">{{ trans('Hot Release') }}</h4>
            <h3 class="section__title">
              {{ trans('Hot Release') }}
              <span><img src="assets/img/icon/fire.png" alt="fire icon" /></span>
            </h3>
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
            slidesPerView: 1
          },
          '420': {
            slidesPerView: 2
          },
          '868': {
            slidesPerView: 3
          },
          '1024': {
            slidesPerView: 4
          }
        }"
      >
        <template v-if="loading">
          <SwiperSlide v-for="i in 3" :key="i">
            <PromptCardSkeleton classes="col-xxl-12" :is-loading="true" />
          </SwiperSlide>
        </template>
        <h1 class="section__title-pre" v-else-if="!loading && prompts.length === 0">
          {{ trans('Nothing Found') }}
        </h1>
        <template v-else>
          <SwiperSlide v-for="prompt in prompts" :key="prompt.id">
            <div class="col-xxl-12">
              <div class="nft__box theme-bg-dark mb-30 transition-3">
                <div class="nft__box-top d-flex align-items-center justify-content-between">
                  <div class="nft__box-user">
                    <ul>
                      <li>
                        <Link :href="route('profile.show', prompt.username)">
                          <img
                            v-lazy="
                              prompt.avatar
                                ? prompt.avatar
                                : `https://ui-avatars.com/api/?name=${prompt.name}`
                            "
                            alt="avatar"
                          />
                        </Link>
                      </li>
                    </ul>
                  </div>
                  <div class="nft__box-more">
                    <button
                      type="button"
                      class="dropdown-toggle nft-more-btn"
                      data-bs-toggle="dropdown"
                      aria-expanded="false"
                    >
                      <i class="fa-regular fa-ellipsis"></i>
                    </button>
                    <div class="nft__more-content dropdown-menu dropdown-menu-end">
                      <ul>
                        <li>
                          <button
                            @click="
                              share.setItem(
                                prompt.preview ? prompt.preview : JSON.parse(prompt.meta).preview,
                                prompt.slug
                              )
                            "
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#sharemodal"
                          >
                            {{ trans('Share') }}
                          </button>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="nft__box-thumb m-img mb-20">
                  <Link :href="route('prompt.show', prompt.slug)">
                    <img
                      lazy="loading"
                      class="prompt-preview"
                      v-lazy="prompt.preview ? prompt.preview : JSON.parse(prompt.meta).preview"
                      alt="preview"
                    />
                  </Link>
                  <button
                    @click="like(prompt.id, prompt?.is_liked)"
                    type="button"
                    class="nft__box-popularity"
                  >
                    <a href="javascript:void(0)">
                      <i
                        class="fa-solid fa-heart"
                        :class="+prompt?.is_liked === 1 ? 'text-danger' : 'text-secondary'"
                      ></i>
                      {{ prompt.total_likes }}
                    </a>
                  </button>
                </div>
                <div class="nft__box-content">
                  <div
                    class="nft__box-content-top d-flex align-items-center justify-content-between"
                  >
                    <h3 class="nft__box-title">
                      <Link :href="route('prompt.show', prompt.slug)"
                        >{{ textExcerpt(prompt.title, 28) }}
                      </Link>
                    </h3>
                  </div>
                  <div class="nft__box-info d-flex align-items-center justify-content-between">
                    <div class="nft__box-price">
                      <p>{{ formatCurrency(prompt.price) }}</p>
                    </div>
                  </div>
                </div>
                <div class="nft__box-bottom d-flex align-items-center justify-content-between">
                  <div class="nft__box-highest">
                    <p>
                      {{ prompt.model_title }}
                    </p>
                  </div>
                  <div class="nft__box-bid">
                    <p><i class="fa-light fa-eye"></i> {{ prompt.total_views }}</p>
                  </div>
                </div>
              </div>
            </div>
          </SwiperSlide>
        </template>
      </Swiper>
    </div>
  </section>
</template>