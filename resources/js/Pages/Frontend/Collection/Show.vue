<script setup>
"use strict";
import { router } from "@inertiajs/vue3"
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue"
import Announcement from "@/Pages/Frontend/Home/Partials/Announcement.vue"
import PromptCard from "@/Pages/Frontend/Prompt/Partials/PromptCard.vue"
import EmptyMessage from "@/Pages/Frontend/Layout/EmptyMessage.vue"
import Paginate from "@/Components/Paginate.vue"
import { ref } from "vue"
import sharedComposable from "@/composables/sharedComposable"
defineOptions({ layout: FrontendLayout })
const props = defineProps([
  "prompts",
  "collection",
  "categories",
  "promptmodels",
  "seo"
])
const { pickBy } = sharedComposable()
const filterForm = ref({
  model: "",
  category: "",
  sort: "",
  order: "",
  rating: ""
})
const filterSidebarState = ref(true)
const sorts = ref([
  { name: "Latest", value: "created_at", order: "asc" },
  { name: "Oldest", value: "created_at", order: "desc" },
  { name: "Low to High", value: "price", order: "asc" },
  { name: "High to Low", value: "price", order: "desc" }
])
const filterPrompt = () => {
  router.get(
    route("collection.show", props.collection.slug),
    pickBy(filterForm.value),
    {
      preserveState: true,
      replace: true
    }
  )
}
const getModelSlug = (event) => {
  const checkbox = event.target
  if (checkbox.checked) {
    filterForm.value.category = ""
    filterForm.value.model = checkbox.value
    filterPrompt()
  } else {
    checkbox.checked = true
  }
}
const getCategorySlug = (event) => {
  const checkbox = event.target
  if (checkbox.checked) {
    filterForm.value.category = checkbox.value
    filterPrompt()
  } else {
    checkbox.checked = true
  }
}
const getSortBy = (sort) => {
  filterForm.value.sort = sort.value
  filterForm.value.order = sort.order
  filterPrompt()
}
const getRating = (rating) => {
  filterForm.value.rating = rating
  filterPrompt()
}
</script>

<template>
  <Seo :metaData="seo" />
  <!-- breadcrumb area start -->
  <section class="breadcrumb__area pt-60 pb-60 p-relative">
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
            <h3 class="breadcrumb__title">
              {{ collection.name }}
            </h3>

            <div class="breadcrumb__list">
              <span
                ><Link href="/">{{ trans("Home") }}</Link></span
              >
              <span class="dvdr tp-dot"
                ><i class="fa-solid fa-period"></i
              ></span>
              <span> {{ trans("Collection") }}</span>
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
          <div class="col-xxl-3 col-xl-3 col-lg-4">
            <div class="shop__filter-btn">
              <p>
                <i class="fa-regular fa-sliders-simple"></i>
                {{ trans("Filter") }}
              </p>
              <button
                @click="filterSidebarState = !filterSidebarState"
                class="filter-clear float-end"
                type="button"
              >
                <i class="fa-regular fa-xmark" v-if="filterSidebarState"></i>
                <i class="fa-regular fa-eye" v-if="!filterSidebarState"></i>
              </button>
            </div>
          </div>

          <div class="col-xxl-9 col-xl-9 col-lg-8 order-first order-lg-last">
            <div
              class="shop__filter-top-right d-md-flex align-items-center justify-content-end"
            >
              <div class="shop__filter-sort d-flex align-items-center">
                <p>{{ trans("Sort by") }}:</p>
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
    </div>
    <div class="container">
      <div class="row">
        <div class="col-xxl-3 col-xl-3 col-lg-4" v-show="filterSidebarState">
          <Link
            :href="
              route('user.checkout.index', {
                collection: collection.id
              })
            "
            class="header__wallet-btn w-100 mt-10 mb-10 text-center"
          >
            {{ trans("Buy This Collection") }}
          </Link>
          <div class="nft__filter-wrapper nft__filter-wrapper-2">
            <div class="nft__filter-accordion">
              <div class="accordion">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="nft_status">
                    <button
                      class="accordion-button"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapseOne"
                      aria-expanded="true"
                      aria-controls="collapseOne"
                    >
                      {{ trans("Rating") }}
                    </button>
                  </h2>
                  <div
                    id="collapseOne"
                    class="accordion-collapse collapse show"
                  >
                    <div class="accordion-body">
                      <div class="nft__filer-status mb-15">
                        <button
                          type="button"
                          class="nft__filter-check d-flex align-items-center"
                        >
                          <input
                            @click="getRating('')"
                            type="checkbox"
                            name="model"
                            value=""
                            id="model-rating"
                            :checked="filterForm.rating === ''"
                          />
                          <label class="m-check-label" for="model-rating">{{
                            trans("All")
                          }}</label>
                        </button>
                        <template
                          v-for="rating in [1, 2, 3, 4, 5]"
                          :key="rating"
                        >
                          <button
                            type="button"
                            @click="getRating(rating)"
                            class="nft__filter-check d-flex align-items-center"
                          >
                            <input
                              type="checkbox"
                              name="rating"
                              :value="rating"
                              :checked="filterForm.rating === rating"
                            />
                            <label class="m-check-label" for="m-auction">
                              {{ rating }} {{ trans("Star") }}
                            </label>
                          </button>
                        </template>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="nft_status">
                    <button
                      class="accordion-button"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapseOne"
                      aria-expanded="true"
                      aria-controls="collapseOne"
                    >
                      {{ trans("AI Models") }}
                    </button>
                  </h2>
                  <div
                    id="collapseOne"
                    class="accordion-collapse collapse show"
                  >
                    <div class="accordion-body">
                      <div class="nft__filer-status mb-15">
                        <div
                          class="nft__filter-check d-flex align-items-center"
                        >
                          <input
                            @click="getModelSlug"
                            type="checkbox"
                            name="model"
                            id="model-0"
                            value=""
                            :checked="filterForm.model === ''"
                          />
                          <label class="m-check-label" for="model-0">{{
                            trans("All")
                          }}</label>
                        </div>
                        <template v-for="model in promptmodels" :key="model.id">
                          <div
                            class="nft__filter-check d-flex align-items-center"
                          >
                            <input
                              @click="getModelSlug"
                              type="checkbox"
                              name="model"
                              :id="`model-${model.id}`"
                              :value="model.slug"
                              :checked="filterForm.model === model.slug"
                            />
                            <label
                              class="m-check-label"
                              :for="`model-${model.id}`"
                            >
                              {{ model.title }}
                            </label>
                          </div>
                        </template>
                      </div>
                    </div>
                  </div>
                </div>
                <template v-if="categories.length > 0">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="nft_status">
                      <button
                        class="accordion-button"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo"
                        aria-expanded="true"
                        aria-controls="collapseTwo"
                      >
                        {{ trans("Categories") }}
                      </button>
                    </h2>
                    <div
                      id="collapseTwo"
                      class="accordion-collapse collapse show"
                    >
                      <div class="accordion-body">
                        <div class="nft__filer-status mb-15">
                          <div
                            class="nft__filter-check d-flex align-items-center"
                          >
                            <input
                              @change="getCategorySlug"
                              type="checkbox"
                              name="category"
                              value=""
                              id="prompt-category0"
                              :checked="filterForm.category === ''"
                            />
                            <label
                              class="m-check-label"
                              for="prompt-category0"
                              >{{ trans("All") }}</label
                            >
                          </div>
                          <template
                            v-for="category in categories"
                            :key="category.id"
                          >
                            <div
                              class="nft__filter-check d-flex align-items-center"
                            >
                              <input
                                @change="getCategorySlug"
                                type="checkbox"
                                name="category"
                                :id="`prompt-category${category.id}`"
                                :value="category.slug"
                                :checked="filterForm.category === category.slug"
                              />
                              <label
                                class="m-check-label"
                                :for="`prompt-category${category.id}`"
                              >
                                {{ category.name }}
                              </label>
                            </div>
                          </template>
                        </div>
                      </div>
                    </div>
                  </div>
                </template>
              </div>
            </div>
          </div>
        </div>
        <div
          :class="
            filterSidebarState
              ? 'col-xxl-9 col-xl-9 col-lg-8'
              : 'col-xxl-12 col-xl-12 col-lg-12'
          "
        >
          <div class="shop__product-wrapper pt-40 pl-10">
            <div class="shop__product-tab">
              <div class="row">
                <template v-for="prompt in prompts.data" :key="prompt.id">
                  <div
                    :class="
                      filterSidebarState
                        ? 'col-xxl-4 col-xl-4 col-lg-6 col-md-6'
                        : 'col-xxl-3 col-xl-3 col-lg-6 col-md-6'
                    "
                  >
                    <PromptCard :prompt="prompt" />
                  </div>
                </template>

                <EmptyMessage
                  type="text"
                  message="We're sorry, No prompts were found."
                  v-if="prompts.data.length < 1"
                />
              </div>
            </div>
          </div>
        </div>
        <Paginate :links="prompts.links" />
      </div>
    </div>
  </section>
  <!-- marque text area start -->
  <Announcement />
</template>
