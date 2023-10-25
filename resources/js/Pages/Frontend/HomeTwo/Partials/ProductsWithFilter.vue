<script setup>
"use strict";
import PromptCard from "@/Pages/Frontend/Prompt/Partials/PromptCard.vue"
import PromptCardSkeleton from "@/Pages/Frontend/Layout/PromptCardSkeleton.vue"
import axios from "axios"
import { onMounted, ref } from "vue"
import sharedComposable from "@/composables/sharedComposable"

const { pickBy } = sharedComposable()
const prompts = ref([])
const promptmodels = ref([])
const loading = ref(true)
const filterForm = ref({
  type: "prompt",
  sort: "",
  order: "",
  model: ""
})
const getPrompts = async () => {
  await axios
    .get(route("api-home-two", pickBy(filterForm.value)))
    .then((res) => {
      prompts.value = res.data.prompts
      promptmodels.value = res.data.promptmodels
      loading.value = false
    })
}
const sorts = ref([
  { name: "Latest", value: "created_at", order: "asc" },
  { name: "Oldest", value: "created_at", order: "desc" },
  { name: "Low to High", value: "price", order: "asc" },
  { name: "High to Low", value: "price", order: "desc" }
])
const filters = ref([
  { name: "Most Liked", value: "total_likes", order: "desc" },
  { name: "Most Viewed", value: "total_views", order: "desc" }
])
onMounted(() => {
  setTimeout(() => {
    loading.value = true
    getPrompts()
  }, 1000)
})
const getOrderBy = (sort) => {
  filterForm.value.sort = sort.value
  filterForm.value.order = sort.order
  getPrompts()
}
const getModel = (id) => {
  filterForm.value.model = id
  getPrompts()
}
</script>

<template>
  <section class="nft__area pt-60 pb-120">
    <div class="container">
      <div class="section__title-border mb-30">
        <div class="row">
          <div class="col-xxl-6 col-md-6">
            <div class="section__title-wrapper-2 mr-15">
              <h3 class="section__title-2">{{ trans("Explore Prompt") }}</h3>
            </div>
          </div>
          <div class="col-xxl-6 col-md-6">
            <div class="nft__more text-sm-end">
              <Link :href="route('prompt.index')" class="tp-btn-border">
                {{ trans("View all") }}
              </Link>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6">
          <div class="nft__filter mb-35">
            <h4 class="nft__filter-title">{{ trans("SORT") }}</h4>
            <div class="nft__filter-item">
              <div class="nice-select" tabindex="0">
                <span class="current">{{
                  sorts
                    .filter((s) => s.value === "created_at")
                    .find((s) => s.value === filterForm.sort)?.name || "Default"
                }}</span>
                <ul class="list">
                  <li
                    :class="{
                      selected: sort.value === filterForm.sort
                    }"
                    @click="getOrderBy(sort)"
                    class="option"
                    v-for="sort in sorts.filter(
                      (s) => s.value === 'created_at'
                    )"
                    :key="sort.value"
                  >
                    {{ sort.name }}
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6">
          <div class="nft__filter mb-35">
            <h4 class="nft__filter-title">{{ trans("PRICE") }}</h4>
            <div class="nft__filter-item">
              <div class="nice-select" tabindex="0">
                <span class="current">{{
                  sorts
                    .filter((s) => s.value === "price")
                    .find((s) => s.value === filterForm.sort)?.name || "Default"
                }}</span>
                <ul class="list">
                  <li
                    :class="{
                      selected: sort.value === filterForm.sort
                    }"
                    @click="getOrderBy(sort)"
                    class="option"
                    v-for="sort in sorts.filter((s) => s.value === 'price')"
                    :key="sort.value"
                  >
                    {{ sort.name }}
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6">
          <div class="nft__filter mb-35">
            <h4 class="nft__filter-title">{{ trans("LIKES") }}</h4>
            <div class="nft__filter-item">
              <div class="nice-select" tabindex="0">
                <span class="current">{{
                  filters.find((s) => s.value === filterForm.sort)?.name ||
                  "Default"
                }}</span>
                <ul class="list">
                  <li
                    :class="{
                      selected: filters.find((s) => s.value === filterForm.sort)
                        ?.name
                    }"
                    @click="getOrderBy(filter)"
                    class="option"
                    v-for="filter in filters"
                    :key="filter.value"
                  >
                    {{ filter.name }}
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6">
          <div class="nft__filter mb-35">
            <h4 class="nft__filter-title">{{ trans("MODEL") }}</h4>
            <div class="nft__filter-item">
              <div class="nice-select" tabindex="0">
                <span class="current">{{
                  promptmodels.find((p) => p.id === filterForm.model)?.title ||
                  "Default"
                }}</span>
                <ul class="list">
                  <li
                    :class="{
                      selected: promptmodels.find(
                        (p) => p.id === filterForm.model
                      )?.title
                    }"
                    @click="getModel(model.id)"
                    class="option"
                    v-for="model in promptmodels"
                    :key="model.id"
                  >
                    {{ model.title }}
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <template v-if="loading">
          <PromptCardSkeleton
            v-for="i in 4"
            :key="i"
            classes="col-xxl-3 col-lg-4 col-md-6"
          />
        </template>
        <h1
          class="section__title-pre"
          v-else-if="!loading && prompts?.length === 0"
        >
          {{ trans("Nothing Found") }}
        </h1>
        <template v-else>
          <div
            class="col-xxl-3 col-xl-3 col-lg-4 col-md-4"
            v-for="prompt in prompts"
            :key="prompt.id"
          >
            <PromptCard :prompt="prompt" :successEvent="getPrompts" />
          </div>
        </template>
      </div>
    </div>
  </section>
</template>
