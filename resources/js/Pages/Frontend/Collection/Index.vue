<script setup>
"use strict";
import { router } from "@inertiajs/vue3"
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue"
import Announcement from "@/Pages/Frontend/Home/Partials/Announcement.vue"
import Paginate from "@/Components/Paginate.vue"
import CollectionCard from "./Partials/CollectionCard.vue"
import EmptyMessage from "@/Pages/Frontend/Layout/EmptyMessage.vue"
import { ref } from "vue"
import sharedComposable from "@/composables/sharedComposable"
defineOptions({ layout: FrontendLayout })
const { pickBy } = sharedComposable()
const props = defineProps(["collections", "seo"])
const filterForm = ref({
  sort: "",
  order: ""
})
const sorts = ref([
  { name: "Latest", value: "created_at", order: "asc" },
  { name: "Oldest", value: "created_at", order: "desc" },
  { name: "Low to High", value: "prompts_count", order: "asc" },
  { name: "High to Low", value: "prompts_count", order: "desc" }
])

const filterPrompt = () => {
  router.get(route("collection.index"), pickBy(filterForm.value), {
    preserveState: true,
    replace: true
  })
}
const getSortBy = (sort) => {
  filterForm.value.sort = sort.value
  filterForm.value.order = sort.order
  filterPrompt()
}
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
            <h3 class="breadcrumb__title">{{ trans("Collections") }}</h3>
            <div class="breadcrumb__list">
              <span>
                <Link href="/">{{ trans("Home") }}</Link>
              </span>
              <span class="dvdr tp-dot"
                ><i class="fa-solid fa-period"></i
              ></span>
              <span>{{ trans("Collection") }}</span>
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
          <div
            class="shop__filter-top-right d-md-flex align-items-center justify-content-end"
          >
            <div class="shop__filter-sort d-flex align-items-center">
              <p>{{ trans("Sort by:") }}</p>
              <div class="nice-select" tabindex="0">
                <span class="current">{{
                  sorts.find((s) => s.value === filterForm.sort)?.name ||
                  sorts[0].name
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
            <div class="row" v-if="collections.data.length > 0">
              <template
                v-for="collection in collections.data"
                :key="collection.id"
              >
                <CollectionCard :collection="collection" />
              </template>
            </div>
            <EmptyMessage
              type="text"
              message="We're sorry, No collection were found."
              v-else
            />
          </div>
          <Paginate :links="collections.links" />
        </div>
      </div>
    </div>
  </section>

  <!-- marque text area start -->
  <Announcement />
</template>
