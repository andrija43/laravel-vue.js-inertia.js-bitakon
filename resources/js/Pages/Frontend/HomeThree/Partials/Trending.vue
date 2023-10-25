<script setup>
"use strict";
import PromptCardSkeleton from "@/Pages/Frontend/Layout/PromptCardSkeleton.vue";
import PromptCard from "@/Pages/Frontend/Prompt/Partials/PromptCard.vue";
import { onMounted, ref } from "vue";
import sharedComposable from "@/composables/sharedComposable";
import axios from "axios";

const { pickBy } = sharedComposable();
const filterForm = ref({
  type: "trending",
  model: "",
  category: "",
  rating: "",
  s_query: "",
});
const loading = ref(true);
const data = ref([]);
const filterPrompt = () => {
  loading.value = true;
  axios.get(route("api-home-three", pickBy(filterForm.value))).then((res) => {
    data.value = res.data;
    loading.value = false;
  });
};
const getModelSlug = (event) => {
  const checkbox = event.target;
  if (checkbox.checked) {
    filterForm.value.category = "";
    filterForm.value.model = checkbox.value;
    filterPrompt();
  } else {
    checkbox.checked = true;
  }
};
const getCategorySlug = (event) => {
  const checkbox = event.target;
  if (checkbox.checked) {
    filterForm.value.category = checkbox.value;
    filterPrompt();
  } else {
    checkbox.checked = true;
  }
};
const getRating = (rating) => {
  filterForm.value.rating = rating;
  filterPrompt();
};
const search = () => {
  if (filterForm.value.s_query) {
    filterPrompt();
  }
};
onMounted(() => {
  setTimeout(() => {
    filterPrompt();
  }, 1000);
});
</script>

<template>
  <section class="nft__area pb-50">
    <div class="container">
      <div class="section__title-border mb-40">
        <div class="row align-items-end">
          <div class="col-xxl-6 col-lg-6 col-md-7">
            <div class="section__title-wrapper-3">
              <h3 class="section__title-3">
                {{ trans("Trending") }} <br />
                {{ trans("Prompts of this season") }}
              </h3>
            </div>
          </div>
          <div class="col-xxl-6 col-lg-6 col-md-5">
            <div class="nft__search text-end float-md-end fix mb-15">
              <form @submit.prevent="search" @keypress.enter="search">
                <div class="nft__search-input">
                  <input
                    v-model="filterForm.s_query"
                    type="text"
                    placeholder="Search"
                  />
                  <button type="submit">
                    <i class="fa-regular fa-magnifying-glass"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xxl-3 col-xl-3 col-lg-4">
          <div class="nft__filter-wrapper">
            <div class="nft__filter-top d-flex justify-content-between pb-0">
              <div class="">
                <i class="fa fa-filter base-text fa-lg" aria-hidden="true"></i>
              </div>

              <p class="base-text">
                {{ data.prompts?.length || 0 }} {{ trans("Prompts") }}
              </p>
            </div>
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
                      {{ trans("Ratings") }}
                    </button>
                  </h2>
                  <div
                    id="collapseOne"
                    class="accordion-collapse collapse show"
                    aria-labelledby="nft_status"
                    data-bs-parent="#nftaccordion"
                  >
                    <div class="accordion-body">
                      <div class="nft__filer-status mb-15">
                        <button
                          type="button"
                          @click="getRating('')"
                          class="nft__filter-check d-flex align-items-center"
                        >
                          <input
                            type="checkbox"
                            name="model"
                            value=""
                            :checked="filterForm.rating === ''"
                          />
                          <label class="m-check-label" for="m-auction">{{
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
                  <h2 class="accordion-header" id="nft_status_2">
                    <button
                      class="accordion-button collapsed"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapseTwo"
                      aria-expanded="true"
                      aria-controls="collapseTwo"
                    >
                      {{ trans("AI Models") }}
                    </button>
                  </h2>
                  <div
                    id="collapseTwo"
                    class="accordion-collapse collapse"
                    aria-labelledby="nft_status_2"
                    data-bs-parent="#nftaccordion"
                  >
                    <div class="accordion-body">
                      <div
                        class="nft__filter-price tp-range-slider tp-range-slider-dark mb-20"
                      >
                        <button
                          type="button"
                          @click="getModelSlug"
                          class="nft__filter-check d-flex align-items-center"
                        >
                          <input
                            type="checkbox"
                            name="model"
                            id="model-0"
                            value=""
                            :checked="filterForm.model === ''"
                          />
                          <label class="m-check-label" for="model-0">{{
                            trans("All")
                          }}</label>
                        </button>
                        <template
                          v-for="model in data.promptmodels"
                          :key="model.id"
                        >
                          <button
                            type="button"
                            @click="getModelSlug"
                            class="nft__filter-check d-flex align-items-center"
                          >
                            <input
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
                          </button>
                        </template>
                      </div>
                    </div>
                  </div>
                </div>
                <template v-if="data.categories?.length > 0">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="nft_status_3">
                      <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseThree"
                        aria-expanded="true"
                        aria-controls="collapseThree"
                      >
                        {{ trans("Category") }}
                      </button>
                    </h2>
                    <div
                      id="collapseThree"
                      class="accordion-collapse collapse"
                      aria-labelledby="nft_status_3"
                      data-bs-parent="#nftaccordion"
                    >
                      <div class="accordion-body">
                        <div class="nft__filer-status mb-15">
                          <button
                            type="button"
                            @click="getCategorySlug"
                            class="nft__filter-check d-flex align-items-center"
                          >
                            <input
                              type="checkbox"
                              name="category"
                              id="model-category-0"
                              value=""
                              :checked="filterForm.category === ''"
                            />
                            <label
                              class="m-check-label"
                              for="model-category-0"
                              >{{ trans("All") }}</label
                            >
                          </button>
                          <template
                            v-for="category in data.categories"
                            :key="category.id"
                          >
                            <button
                              type="button"
                              @click="getCategorySlug"
                              class="nft__filter-check d-flex align-items-center"
                            >
                              <input
                                type="checkbox"
                                name="category"
                                :id="`model-category-${category.id}`"
                                :value="category.slug"
                                :checked="filterForm.category === category.slug"
                              />
                              <label
                                class="m-check-label"
                                :for="`model-category-${category.id}`"
                              >
                                {{ category.name }}
                              </label>
                            </button>
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
        <div class="col-xxl-9 col-xl-9 col-lg-8">
          <div class="row">
            <template v-if="loading">
              <PromptCardSkeleton
                v-for="i in 3"
                :key="i"
                classes="col-xxl-4 col-xl-4 col-lg-6 col-md-6"
                :is-loading="true"
              />
            </template>
            <h1
              class="section__title-pre"
              v-else-if="!loading && data.prompts?.length === 0"
            >
              {{ trans("Nothing Found") }}
            </h1>
            <template v-else>
              <template v-for="prompt in data.prompts" :key="prompt.id">
                <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6">
                  <PromptCard :successEvent="filterPrompt" :prompt="prompt" />
                </div>
              </template>
            </template>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
