<script setup>
"use strict";
import { router } from '@inertiajs/vue3'
import FrontendLayout from '@/Pages/Frontend/Layout/App.vue'
import Announcement from '@/Pages/Frontend/Home/Partials/Announcement.vue'
import Paginate from '@/components/Paginate.vue'
import TopSellerSkeleton from '@/Pages/Frontend/Layout/TopSellerSkeleton.vue'
import EmptyMessage from '@/Pages/Frontend/Layout/EmptyMessage.vue'
import { ref } from 'vue'
import sharedComposable from '@/composables/sharedComposable'
defineOptions({ layout: FrontendLayout })
const { pickBy } = sharedComposable()
const props = defineProps(['sellers', 'seo'])
const filterForm = ref({
  sort: '',
  order: '',
  s_query: ''
})
const sorts = ref([
  { name: 'High to Low', value: 'total_sold', order: 'desc' },
  { name: 'Low to High', value: 'total_sold', order: 'asc' }
])
const loading = ref(false)
const filterSeller = () => {
  loading.value = true
  router.get(route('top-sellers.index'), pickBy(filterForm.value), {
    preserveState: true,
    replace: true,
    onFinish: () => {
      loading.value = false
    }
  })
}
const getSortBy = (sort) => {
  filterForm.value.sort = sort.value
  filterForm.value.order = sort.order
  filterSeller()
}
const sellerRankClasses = [
  '',
  'clr-green',
  'clr-orange',
  'clr-purple',
  'clr-yellow',
  'clr-pink',
  'clr-orange',
  'clr-purple',
  'clr-green'
]
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
            <h3 class="breadcrumb__title">{{ trans('Top Sellers') }}</h3>
            <div class="breadcrumb__list">
              <span
                ><Link href="/">{{ trans('Home') }}</Link></span
              >
              <span class="dvdr tp-dot"><i class="fa-solid fa-period"></i></span>
              <span>{{ trans('Top Sellers') }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- content -->
  <section class="shop__filter pb-100">
    <div class="shop__filter-top">
      <div class="container">
        <div class="row">
          <div class="shop__filter-top-right d-md-flex align-items-center justify-content-between">
            <div class="nft__search text-end float-md-end fix mb-15">
              <form @submit.prevent="filterSeller" @keypress.enter="filterSeller">
                <div class="nft__search-input">
                  <input v-model="filterForm.s_query" type="text" placeholder="Search" />
                  <button type="submit">
                    <i class="fa-regular fa-magnifying-glass"></i>
                  </button>
                </div>
              </form>
            </div>
            <div class="shop__filter-sort d-flex align-items-center">
              <p>{{ trans('Sort by:') }}</p>
              <div class="nice-select" tabindex="0">
                <span class="current">{{
                  sorts.find((s) => s.value === filterForm.sort)?.name || sorts[0].name
                }}</span>
                <ul class="list">
                  <li
                    @click="getSortBy(sort)"
                    class="option"
                    v-for="sort in sorts"
                    :key="sort.value"
                  >
                    {{ sort.name }}
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-xxl-12 col-xl-8 col-lg-6">
          <div class="shop__product-wrapper pt-40 pl-10">
            <div class="row" v-if="loading">
              <TopSellerSkeleton :is-loading="true" />
            </div>
            <div class="row" v-if="sellers.data.length > 0 && !loading">
              <template v-for="(seller, i) in sellers.data" :key="seller.id">
                <div class="col-xxl-2 col-xl-2 col-lg-4 col-md-4 col-sm-6">
                  <div
                    class="seller__item theme-bg-dark mb-30 transition-3"
                    :class="sellerRankClasses[parseInt(i.toString()[0])]"
                  >
                    <div class="seller__top d-flex justify-content-between">
                      <div class="seller__rank">
                        <span><i class="fa-light fa-trophy"></i> #{{ i + 1 }}</span>
                      </div>
                      <div class="seller__action">
                        <ul>
                          <li>
                            <Link :href="`/profile/${seller.username}`">
                              <i class="fa-regular fa-arrow-up-right"></i>
                            </Link>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="seller__content text-center">
                      <div class="seller__thumb">
                        <Link :href="`/profile/${seller.username}`">
                          <img
                            v-lazy="
                              seller.avatar
                                ? seller.avatar
                                : `https://ui-avatars.com/api/?name=${seller.name}`
                            "
                            alt="avatar"
                          />
                        </Link>
                      </div>
                      <div class="seller__info">
                        <h3 class="seller__name">
                          <Link :href="route('profile.show', seller.username)">{{
                            seller.name
                          }}</Link>
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
            </div>
            <EmptyMessage
              type="text"
              message="We're sorry, No seller were found."
              v-if="sellers.data.length < 1 && !loading"
            />
          </div>
          <Paginate :links="sellers.links" />
        </div>
      </div>
    </div>
  </section>

  <!-- marque text area start -->
  <Announcement />
</template>
