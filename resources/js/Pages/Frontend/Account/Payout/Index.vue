<script setup>
"use strict";
import { Head, Link } from "@inertiajs/vue3";
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue";
import AccountLayout from "@/Pages/Frontend/Account/Layout/App.vue";
import sharedComposable from "@/composables/sharedComposable";

const { authUser, formatCurrency } = sharedComposable();
const props = defineProps(["pending_amount", "approved_amount", "methods"]);

defineOptions({ layout: [FrontendLayout, AccountLayout] });

const options = {
  responsive: true,
  maintainAspectRatio: false,
};
</script>

<template>
  <Head :title="trans('Payout Methods')" />
  <div class="creator__item-wrapper pt-40 pb-120">
    <section class="contact__info pb-70">
      <div class="container">
        <div class="contact__info-wrapper">
          <div class="row justify-content-center">
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
              <div class="contact__info-item d-flex align-items-center mb-50">
                <div class="contact__icon mr-15">
                  <span>
                    <img src="/uploads/money-bag.png" height="35" alt="" />
                  </span>
                </div>
                <div class="contact__text">
                  <p>{{ trans("Available Balance") }}</p>
                  <h4>
                    <a>{{ formatCurrency(authUser.wallet || 0) }}</a>
                  </h4>
                </div>
              </div>
            </div>
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
              <div class="contact__info-item d-flex align-items-center mb-50">
                <div class="contact__icon mr-15 contact-discord">
                  <span>
                    <img src="/uploads/money-process.png" height="35" alt="" />
                  </span>
                </div>
                <div class="contact__text">
                  <p>{{ trans("Pending For Withdraw") }}</p>
                  <h4>
                    <a>{{ approved_amount }}</a>
                  </h4>
                </div>
              </div>
            </div>
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
              <div class="contact__info-item d-flex align-items-center mb-50">
                <div class="contact__icon mr-15 contact-location">
                  <span>
                    <img src="/uploads/receive-amount.png" height="35" alt="" />
                  </span>
                </div>
                <div class="contact__text">
                  <p>{{ trans("Total Withdrawal Amount") }}</p>
                  <h4>
                    <a>{{ approved_amount }}</a>
                  </h4>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="col-sm-10">
            <div class="activity__wrapper mr-60">
              <div
                v-for="method in props.methods"
                :key="method.id"
                class="activity__item d-md-flex align-items-center justify-content-between mb-10"
              >
                <div class="activity__item-inner d-flex align-items-center">
                  <div class="activity__thumb mr-20">
                    <a href="javascript:void(0)">
                      <img :src="method.image" alt="" />
                    </a>
                    <span
                      class="activity__tag"
                      v-if="method.usermethod == null"
                    >
                      <svg
                        width="12"
                        height="11"
                        viewBox="0 0 12 11"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M10.6691 6.54838L6.55412 10.6634C6.44752 10.7701 6.32092 10.8547 6.18158 10.9125C6.04223 10.9703 5.89287 11 5.74203 11C5.59119 11 5.44182 10.9703 5.30248 10.9125C5.16313 10.8547 5.03654 10.7701 4.92994 10.6634L0 5.73916V0H5.73916L10.6691 4.92994C10.8829 5.145 11.0029 5.43592 11.0029 5.73916C11.0029 6.0424 10.8829 6.33332 10.6691 6.54838Z"
                          fill="white"
                        ></path>
                        <path
                          d="M2.86914 2.8696H2.87542"
                          stroke="#006EED"
                          stroke-width="2"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        ></path>
                      </svg>
                    </span>
                    <span class="activity__tag check" v-else>
                      <svg
                        width="13"
                        height="9"
                        viewBox="0 0 13 9"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M11.1818 1L4.18182 8L1 4.81818"
                          stroke="white"
                          stroke-width="2"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        ></path>
                      </svg>
                    </span>
                  </div>
                  <div class="activity__content">
                    <h3 class="activity__title">
                      <Link
                        v-if="method.usermethod != null"
                        :href="route('user.payout.edit', method.id)"
                        >{{ method.name }}</Link
                      >
                      <a v-else href="javascript:void(0)">{{ method.name }}</a>
                    </h3>
                    <p>
                      {{ trans("Payout Limitation: ") }}
                      <span
                        >{{ method.min_limit + " - " + method.max_limit }}
                        {{ method.currency_name }}</span
                      >
                    </p>
                  </div>
                </div>
                <div class="activity__status">
                  <p>
                    <Link
                      :href="
                        method.usermethod != null
                          ? route('user.payout.show', method.id)
                          : route('user.payout.edit', method.id)
                      "
                      class="header__wallet-btn"
                    >
                      {{
                        method.usermethod != null
                          ? trans("Make Payout")
                          : trans("Setup Account")
                      }}
                    </Link>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
