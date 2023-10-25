<script setup>
"use strict";
import { Head, Link, router } from "@inertiajs/vue3"
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue"
import sharedComposable from "@/composables/sharedComposable"
import { computed } from "vue"
defineOptions({ layout: FrontendLayout })
const props = defineProps(["carts"])
const { formatCurrency, ToastAlert, textExcerpt } = sharedComposable()

const destroyCart = (id) => {
  router.delete(route("user.cart.destroy", id), {
    onSuccess: () => {
      ToastAlert("Deleted", "Successfully Deleted")
    }
  })
}
const totalPrice = computed(() => {
  let totalPrice = 0

  for (const key in props.carts) {
    if (props.carts.hasOwnProperty(key)) {
      const item = props.carts[key]
      totalPrice += item.price
    }
  }
  return totalPrice
})
</script>

<template>
  <Head title="Cart" />
  <!-- breadcrumb area start -->
  <section class="breadcrumb__area breadcrumb__border pt-40 pb-40 p-relative">
    <div class="breadrumb__shape">
      <img
        class="breadcrumb__shape-1"
        src="/assets/img/breadcrumb/breadcrumb-shape-1.png"
        alt="shape"
      />
    </div>
    <div class="container">
      <div class="row">
        <div class="col-xxl-12">
          <div class="breadcrumb__content text-center">
            <h3 class="breadcrumb__title">{{ trans("Cart") }}</h3>
            <div class="breadcrumb__list">
              <span
                ><Link href="/">{{ trans("Home") }}</Link></span
              >
              <span class="dvdr tp-dot"
                ><i class="fa-solid fa-period"></i
              ></span>
              <span>{{ trans("Cart") }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- content -->
  <section class="collection__grid pt-60 pb-120">
    <div class="container">
      <div class="section__title-wrapper mb-40">
        <h4 class="section__title-stroke">{{ trans("Cart History") }}</h4>
        <h3 class="section__title">{{ trans("Cart") }}</h3>
      </div>
      <div class="row" v-if="Object.keys(carts).length > 0">
        <div class="col-xxl-8 col-xl-8 col-lg-8">
          <template v-for="cart in carts" :key="cart.id">
            <div class="bid__item mb-30 theme-bg-dark">
              <div class="bid__item-wrapper">
                <div class="bid__list-wrapper d-sm-flex align-items-center">
                  <div class="bid__list-left">
                    <div class="bid__thumb m-img mb-15">
                      <img
                        lazy="loading"
                        height="150"
                        width="150"
                        v-lazy="
                          cart.preview
                            ? cart.preview
                            : 'assets/img/collection/user/collection-user-1.jpg'
                        "
                        alt="preview"
                      />
                    </div>
                  </div>
                  <div class="bid__list-right pl-30">
                    <div class="bid__content">
                      <div
                        class="bid__content-top d-flex align-items-center justify-content-between"
                      >
                        <h3 class="bid__title">
                          {{ textExcerpt(cart.title, 20) }}
                        </h3>

                        <button type="button" @click="destroyCart(cart.id)">
                          <i
                            class="fa fa-trash text-danger"
                            aria-hidden="true"
                          ></i>
                        </button>
                      </div>
                      <div
                        class="bid__info d-flex align-items-center justify-content-between"
                      >
                        <div class="bid__highest">
                          <p>
                            <span>{{ formatCurrency(cart.price) }}</span>
                          </p>
                        </div>
                        <div class="bid__stock">
                          <p>{{ cart.model }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </template>
        </div>
        <div class="col-xxl-4 col-xl-4 col-lg-4">
          <div class="wallet__item wallet-blue-bg mb-30">
            <div class="wallet__item-fix">
              <div class="wallet__item-inner text-center">
                <div class="wallet__title mb-20">
                  {{ trans("Total") }} : {{ formatCurrency(totalPrice) }}
                </div>
                <div class="wallet__content">
                  <div class="product__details-info-btn">
                    <Link
                      :href="route('user.checkout.index')"
                      class="tp-btn-2 active mb-10 w-100 text-center"
                    >
                      {{ trans("Checkout") }}
                    </Link>
                    <Link
                      :href="route('prompt.index')"
                      class="tp-btn-2 w-100 text-center"
                    >
                      {{ trans("Continue Shopping") }}
                    </Link>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-else class="breadcrumb__title text-center">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          version="1.1"
          xmlns:xlink="http://www.w3.org/1999/xlink"
          xmlns:svgjs="http://svgjs.com/svgjs"
          width="212"
          height="150"
          x="0"
          y="0"
          viewBox="0 0 48 48"
          style="enable-background: new 0 0 512 512"
          xml:space="preserve"
          class=""
        >
          <g>
            <linearGradient
              id="a"
              x1="24"
              x2="24"
              y1="47"
              y2="27"
              gradientUnits="userSpaceOnUse"
            >
              <stop offset="0" stop-color="#54a5ff"></stop>
              <stop offset="1" stop-color="#8ad3fe"></stop>
            </linearGradient>
            <linearGradient
              id="b"
              x1="24"
              x2="24"
              y1="21.09"
              y2=".71"
              gradientUnits="userSpaceOnUse"
            >
              <stop offset="0" stop-color="#d3e6f5"></stop>
              <stop offset="1" stop-color="#f0f7fc"></stop>
            </linearGradient>
            <g data-name="Shopping Basket">
              <path
                fill="url(#a)"
                d="M37.38 47H10.62a4 4 0 0 1-4-3.6L5 27h38l-1.64 16.4a4 4 0 0 1-3.98 3.6z"
                data-original="url(#a)"
                class=""
              ></path>
              <g fill="#4795ea">
                <path
                  d="M24 44a1 1 0 0 1-1-1V31a1 1 0 0 1 2 0v12a1 1 0 0 1-1 1zM18 44a1 1 0 0 1-1-1V31a1 1 0 0 1 2 0v12a1 1 0 0 1-1 1zM12 44a1 1 0 0 1-1-1V31a1 1 0 0 1 2 0v12a1 1 0 0 1-1 1zM30 44a1 1 0 0 1-1-1V31a1 1 0 0 1 2 0v12a1 1 0 0 1-1 1zM36 44a1 1 0 0 1-1-1V31a1 1 0 0 1 2 0v12a1 1 0 0 1-1 1z"
                  fill="#4795ea"
                  data-original="#4795ea"
                  class=""
                ></path>
                <rect
                  width="42"
                  height="4"
                  x="3"
                  y="23"
                  rx="1"
                  fill="#4795ea"
                  data-original="#4795ea"
                  class=""
                ></rect>
              </g>
              <path
                fill="url(#b)"
                d="M33 9.71a9 9 0 0 0-9.28-9A9.1 9.1 0 0 0 15 9.7a9 9 0 0 0 7.43 8.86l1.12 2.25a.5.5 0 0 0 .9 0l1.12-2.25A9 9 0 0 0 33 9.71z"
                data-original="url(#b)"
              ></path>
              <path
                fill="#ffb369"
                d="m25.41 9.71 2.3-2.3a1 1 0 0 0 0-1.41 1 1 0 0 0-1.42 0L24 8.29 21.71 6a1 1 0 0 0-1.42 0 1 1 0 0 0 0 1.41l2.3 2.3-2.3 2.29a1 1 0 0 0 0 1.41 1 1 0 0 0 1.42 0L24 11.12l2.29 2.29a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.41zM5 39a1 1 0 0 1-.71-1.71l13-13a1 1 0 0 1 1.42 1.42l-13 13A1 1 0 0 1 5 39zM43 39a1 1 0 0 0 .71-1.71l-13-13a1 1 0 0 0-1.42 1.42l13 13A1 1 0 0 0 43 39z"
                data-original="#ffb369"
                class=""
              ></path>
            </g>
          </g>
        </svg>

        <h4 class="wallet__title mt-10">
          {{ trans("Basket Is Feeling Lonely") }}
        </h4>

        <Link
          :href="route('prompt.index')"
          class="tp-btn-2 active w-25 text-center header__wallet-btn"
        >
          {{ trans("Lets Fill It Up!") }}
        </Link>
      </div>
    </div>
  </section>
</template>
