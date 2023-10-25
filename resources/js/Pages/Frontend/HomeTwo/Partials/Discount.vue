<script setup>
"use strict";
import axios from "axios"
import { onMounted, ref } from "vue"
import sharedComposable from "@/composables/sharedComposable"
import moment from "moment"
import { router } from "@inertiajs/vue3"

const { pickBy, formatCurrency, textExcerpt, ToastAlert } = sharedComposable()
const loading = ref(true)
const prompts = ref([])
const discount = ref([])
const filterForm = ref({
  type: "top"
})
const getPrompts = async () => {
  await axios
    .get(route("api-home-two", pickBy(filterForm.value)))
    .then((res) => {
      prompts.value = res.data.prompts
      discount.value = res.data.discount
      loading.value = false
    })
}

onMounted(() => {
  setTimeout(() => {
    getPrompts()
  }, 1500)
})
const getDateSeconds = (date) => {
  const endDate = moment(date)
  const now = moment()
  const differenceInMilliseconds = endDate.diff(now)
  return differenceInMilliseconds
}
const addToCart = (prompt) => {
  router.post(route("user.cart.store"), prompt, {
    preserveScroll: true,
    onSuccess: () => {
      ToastAlert("Added", "Added To Cart Successfully")
    }
  })
}
</script>

<template>
  <section class="auction__area pt-105 pb-50">
    <div class="container">
      <div class="auction__border mb-40">
        <div class="row">
          <div class="col-xxl-6 col-md-6">
            <div class="section__title-wrapper-2 mr-15">
              <h3 class="section__title-2">{{ trans("Top Prompts") }}</h3>
            </div>
          </div>
          <div class="col-xxl-6 col-md-6">
            <div class="auction__more text-md-end">
              <Link href="/prompt" class="tp-btn-border">
                {{ trans("View all") }}
              </Link>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <template v-if="discount && !loading">
          <div class="col-xxl-4 col-xl-5 col-lg-6">
            <div class="auction__item auction__item-bg mb-30">
              <div class="auction__thumb m-img mb-15">
                <Link :href="route('prompt.show', discount.slug)">
                  <img
                    class="fixed-img-discount"
                    v-lazy="
                      discount.preview ? discount.preview : discount.preview
                    "
                    alt="preview"
                  />
                </Link>
              </div>
              <div class="auction__content">
                <h3 class="auction__title">
                  <Link :href="route('prompt.show', discount.slug)">{{
                    discount.title
                  }}</Link>
                </h3>

                <div class="auction__author mb-15 d-flex align-items-center">
                  <div class="auction__author-thumb mr-10">
                    <Link :href="`/profile/${discount.user?.username}`">
                      <img
                        v-lazy="
                          discount.user?.avatar
                            ? discount.user?.avatar
                            : `https://ui-avatars.com/api/?name=${discount.user?.name}`
                        "
                        alt="avatar"
                      />
                    </Link>
                  </div>
                  <div class="auction__author-content">
                    <h4>
                      <span> {{ trans("by") }}</span>
                      <Link
                        :href="`/profile/${discount.user?.username}`"
                        class="ml-5"
                      >
                        {{ discount.user?.name }}
                      </Link>
                    </h4>
                  </div>
                </div>
                <div
                  class="auction__bid-status mb-15 d-flex align-items-end justify-content-between"
                >
                  <div class="auction__bid-current">
                    <p>Price</p>
                    <h5>
                      {{ formatCurrency(discount.price) }}
                      <span class="text-danger ml-10">
                        -{{ discount.discount?.percentage }}%</span
                      >
                    </h5>
                  </div>
                </div>
                <div class="auction__countdown-wrapper mb-30">
                  <div class="auction__countdown">
                    <vue-countdown
                      class="d-flex align-items-center"
                      :time="getDateSeconds(discount.discount?.will_expire)"
                      v-slot="{ days, hours, minutes, seconds }"
                    >
                      <div class="cdown day">
                        <span class="time-count">{{ days }}</span>
                        <p>{{ trans("Days") }}</p>
                      </div>
                      <div class="cdown hour">
                        <span class="time-count">{{ hours }}</span>
                        <p>{{ trans("Hrs") }}</p>
                      </div>
                      <div class="cdown minutes">
                        <span class="time-count">{{ minutes }}</span>
                        <p>{{ trans("Min") }}</p>
                      </div>
                      <div class="cdown second">
                        <span class="time-count">{{ seconds }}</span>
                        <p>{{ trans("Sec") }}</p>
                      </div>
                    </vue-countdown>
                  </div>
                </div>
                <div
                  class="auction__btn d-sm-flex align-items-center justify-content-between"
                >
                  <button @click="addToCart(discount)" class="tp-btn-gradient">
                    Add To Cart
                  </button>
                  <Link
                    type="button"
                    class="tp-btn-gradient active"
                    :href="
                      route('user.checkout.index', {
                        prompt: discount.id
                      })
                    "
                  >
                    {{ trans("Buy Now") }}
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </template>
        <div class="col-xxl-4 col-xl-7 col-lg-6">
          <div class="auction__sm-wrapper">
            <template v-for="prompt in prompts.slice(0, 3)" :key="prompt.id">
              <div class="auction__sm-item d-sm-flex align-items-center mb-30">
                <div class="auction__sm-thumb mr-20">
                  <Link :href="route('prompt.show', prompt.slug)">
                    <img
                      lazy="loading"
                      v-lazy="
                        prompt.preview
                          ? prompt.preview
                          : JSON.parse(prompt.meta).preview
                      "
                      alt="preview"
                    />
                  </Link>
                </div>
                <div class="auction__sm-content">
                  <h3 class="auction__sm-title">
                    <Link :href="route('prompt.show', prompt.slug)">
                      {{ textExcerpt(prompt.title, 18) }}
                    </Link>
                  </h3>
                  <div
                    class="auction__sm-author d-flex align-items-center mb-20"
                  >
                    <div class="auction__sm-price mr-10">
                      <p>
                        {{ formatCurrency(prompt.price) }}
                      </p>
                    </div>
                    <div class="auction__sm-show">
                      <small>{{ prompt.model_title }}</small>
                    </div>
                  </div>
                  <div class="auction__sm-btn">
                    <Link
                      :href="
                        route('user.checkout.index', {
                          prompt: discount?.id
                        })
                      "
                      class="tp-btn-gradient"
                    >
                      {{ trans("Buy Now") }}
                    </Link>
                  </div>
                </div>
              </div>
            </template>
          </div>
        </div>
        <div v-if="prompts.length > 3" class="col-xxl-4 col-xl-7 col-lg-6">
          <div class="auction__sm-wrapper">
            <template v-for="prompt in prompts.slice(3, 6)" :key="prompt.id">
              <div class="auction__sm-item d-sm-flex align-items-center mb-30">
                <div class="auction__sm-thumb mr-20">
                  <Link :href="route('prompt.show', prompt.slug)">
                    <img
                      lazy="loading"
                      v-lazy="
                        prompt.preview
                          ? prompt.preview
                          : JSON.parse(prompt.meta).preview
                      "
                      alt="preview"
                    />
                  </Link>
                </div>
                <div class="auction__sm-content">
                  <h3 class="auction__sm-title">
                    <Link :href="route('prompt.show', prompt.slug)">
                      {{ textExcerpt(prompt.title, 18) }}
                    </Link>
                  </h3>
                  <div
                    class="auction__sm-author d-flex align-items-center mb-20"
                  >
                    <div class="auction__sm-price mr-10">
                      <p>
                        {{ formatCurrency(prompt.price) }}
                      </p>
                    </div>
                    <div class="auction__sm-show">
                      <small>{{ prompt.model_title }}</small>
                    </div>
                  </div>
                  <div class="auction__sm-btn">
                    <Link
                      :href="
                        route('user.checkout.index', {
                          prompt: discount.id
                        })
                      "
                      class="tp-btn-gradient"
                    >
                      {{ trans("Buy Now") }}
                    </Link>
                  </div>
                </div>
              </div>
            </template>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
