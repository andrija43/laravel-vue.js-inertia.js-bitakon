<script setup>
"use strict";

import { router } from "@inertiajs/vue3";
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue";
import Announcement from "@/Pages/Frontend/Home/Partials/Announcement.vue";
import EmptyMessage from "@/Pages/Frontend/Layout/EmptyMessage.vue";
import Paginate from "@/Components/Paginate.vue";
import { ref } from "vue";
import sharedComposable from "@/composables/sharedComposable";
import moment from "moment";
defineOptions({ layout: FrontendLayout });

const { pickBy, formatCurrency } = sharedComposable();
const props = defineProps(["prompts", "seo"]);
const filterForm = ref({
  sort: "",
  order: "",
});
const sorts = ref([
  { name: "Latest", value: "created_at", order: "asc" },
  { name: "Oldest", value: "created_at", order: "desc" },
  { name: "Low to High", value: "prompts_count", order: "asc" },
  { name: "High to Low", value: "prompts_count", order: "desc" },
]);

const filterPrompt = () => {
  router.get(route("collection.index"), pickBy(filterForm.value), {
    preserveState: true,
    replace: true,
  });
};
const getSortBy = (sort) => {
  filterForm.value.sort = sort.value;
  filterForm.value.order = sort.order;
  filterPrompt();
};
const buynow = (prompt) => {
  router.get(route("user.checkout.index", { prompt: prompt.id }));
};
const getDateSeconds = (date) => {
  const endDate = moment(date);
  const now = moment();
  const differenceInMilliseconds = endDate.diff(now);
  return differenceInMilliseconds;
};
</script>

<template>
  <Seo :metaData="seo" />
  <!-- breadcrumb area start -->
  <section class="breadcrumb__area pt-80 pb-40 p-relative">
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
            <h3 class="breadcrumb__title">{{ trans(`On Sale`) }}</h3>
            <div class="breadcrumb__list">
              <span>
                <Link href="/"> {{ trans(`Home`) }}</Link>
              </span>
              <span class="dvdr tp-dot"
                ><i class="fa-solid fa-period"></i
              ></span>
              <span> {{ trans("On Sale") }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- content -->
  <section class="shop__filter pb-100">
    <div class="shop__filter-top"></div>
    <div class="container">
      <div class="row mt-40">
        <template v-for="prompt in prompts.data" :key="prompt.id">
          <div class="col-xxl-4">
            <div class="auction__item auction__item-2 auction__item-bg mb-30">
              <div class="auction__thumb m-img mb-15">
                <Link :href="route('prompt.show', prompt.slug)">
                  <img
                    :src="
                      prompt.preview
                        ? prompt.preview
                        : JSON.parse(prompt.meta).preview
                    "
                    alt="preview"
                  />
                </Link>
              </div>
              <div class="auction__content">
                <h3 class="auction__title">
                  <button
                    @click="router.visit(route('prompt.show', prompt.slug))"
                  >
                    {{ prompt.title }}
                  </button>
                </h3>

                <div class="auction__author mb-15 d-flex align-items-center">
                  <div class="auction__author-thumb mr-10">
                    <Link :href="`/profile/${prompt.user.username}`">
                      <img
                        :src="
                          prompt.user.avatar
                            ? prompt.user.avatar
                            : `https://ui-avatars.com/api/?name=${prompt.user.name}`
                        "
                        alt="avatar"
                      />
                    </Link>
                  </div>
                  <div class="auction__author-content">
                    <h4>
                      <span>{{ trans("by") }}</span>
                      <Link
                        :href="`/profile/${prompt.user.username}`"
                        class="ml-5"
                      >
                        {{ prompt.user.name }}
                      </Link>
                    </h4>
                  </div>
                </div>
                <div
                  class="auction__bid-status mb-15 d-flex align-items-end justify-content-between"
                >
                  <div class="auction__bid-current">
                    <p>{{ trans("Price") }}</p>
                    <h5>
                      {{ formatCurrency(prompt.price)
                      }}<span class="text-danger ml-10">
                        -{{ prompt.discount.percentage }}%</span
                      >
                    </h5>
                  </div>
                  <div class="auction__bid-ammount"></div>
                </div>
                <div class="auction__countdown-wrapper mb-30">
                  <div class="auction__countdown">
                    <vue-countdown
                      class="d-flex align-items-center"
                      :time="getDateSeconds(prompt.discount?.will_expire)"
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
                  <button @click="buynow(prompt)" class="tp-btn-2">
                    {{ trans("Buy Now") }}
                  </button>
                  <p class="base-text mt-2">{{ prompt.promptmodel.title }}</p>
                </div>
              </div>
            </div>
          </div>
        </template>
        <Paginate :links="prompts.links" />
        <EmptyMessage
          message="We're sorry, it seems that no prompt is on sale right now."
          :href="route('prompt.index')"
          btn-text="Let's Browse"
          v-if="prompts.data.length < 1"
        />
      </div>
    </div>
  </section>

  <!-- marque text area start -->
  <Announcement />
</template>
