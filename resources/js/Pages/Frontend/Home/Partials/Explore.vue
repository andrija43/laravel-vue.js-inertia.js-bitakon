<script setup>
"use strict";
import PromptCard from "@/Pages/Frontend/Prompt/Partials/PromptCard.vue"
import PromptCardSkeleton from "@/Pages/Frontend/Layout/PromptCardSkeleton.vue"
import { onMounted, ref } from "vue"
import axios from "axios"
import sharedComposable from "@/composables/sharedComposable"
const { pickBy } = sharedComposable()
const prompts = ref([])
const models = ref([])
const loading = ref(true)
const activeModel = ref(1)
const sorts = ref([
  { name: "Recently added", value: "created_at", order: "asc" },
  { name: "Low to High", value: "price", order: "asc" },
  { name: "High to Low", value: "price", order: "desc" },
  { name: "Top Viewed", value: "total_views", order: "desc" }
])
const filterForm = ref({
  model_id: "",
  type: "explore",
  sort: "",
  order: ""
})
const getPrompts = () => {
  axios.get(route("api-home", pickBy(filterForm.value))).then((res) => {
    prompts.value = res.data.prompts
  })
}
onMounted(() => {
  setTimeout(() => {
    axios.get(route("api-home", { type: "explore" })).then((res) => {
      prompts.value = res.data.prompts
      models.value = res.data.models
      activeModel.value = models.value[0].id
      loading.value = false
    })
  }, 1000)
})
const filter = (model_id) => {
  filterForm.value.model_id = model_id
  loading.value = true
  axios.get(route("api-home", pickBy(filterForm.value))).then((res) => {
    activeModel.value = model_id
    prompts.value = res.data.prompts
    loading.value = false
  })
}
const getSortBy = (sort) => {
  filterForm.value.sort = sort.value
  filterForm.value.order = sort.order
  loading.value = true
  axios.get(route("api-home", pickBy(filterForm.value))).then((res) => {
    prompts.value = res.data.prompts
    loading.value = false
  })
}
</script>
<template>
  <section class="nft__area nft__overlay pt-110">
    <div class="container tp-container">
      <div class="row">
        <div class="col-xxl-9">
          <div class="section__title-wrapper mb-40">
            <h4 class="section__title-stroke">{{ trans("Explore") }}</h4>
            <h3 class="section__title">{{ trans("Explore Prompts") }}</h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xxl-9 col-xl-10">
          <div class="nft__nav mb-35">
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button
                  v-for="model in models"
                  :key="model.id"
                  class="nav-link"
                  :class="{ active: activeModel === model.id }"
                  @click="filter(model.id)"
                  type="button"
                >
                  {{ model.title }}
                </button>
              </div>
            </nav>
          </div>
        </div>
        <div class="col-xxl-3 col-xl-2">
          <div
            class="nft__right d-flex justify-content-xl-end align-items-end mb-35"
          >
            <div class="nft__select">
              <div class="nice-select" tabindex="0">
                <span class="current">{{ trans("Recently added") }}</span>
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
      <div class="row">
        <div class="col-xxl-12">
          <div class="tab-content nft__tab" id="nfvtabcontent">
            <div
              class="tab-pane fade show active"
              id="nav-trending"
              role="tabpanel"
              aria-labelledby="nav-trending-tab"
            >
              <div class="row">
                <template v-if="loading">
                  <PromptCardSkeleton
                    v-for="i in 4"
                    :key="i"
                    classes="col-xxl-3 col-lg-4 col-md-6"
                    :is-loading="true"
                  />
                </template>
                <h1
                  class="section__title-pre"
                  v-else-if="!loading && prompts.length === 0"
                >
                  {{ trans("Nothing Found") }}
                </h1>
                <template v-else>
                  <template v-for="prompt in prompts" :key="prompt.id">
                    <div class="col-xxl-3 col-lg-4 col-md-6">
                      <PromptCard :prompt="prompt" :successEvent="getPrompts" />
                    </div>
                  </template>
                </template>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xxl-12">
          <div class="nft__more text-center mt-20">
            <Link :href="route('prompt.index')" class="tp-load-more">
              <i class="fa-light fa-arrow-rotate-right"></i>
              {{ trans("View all items") }}
            </Link>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
