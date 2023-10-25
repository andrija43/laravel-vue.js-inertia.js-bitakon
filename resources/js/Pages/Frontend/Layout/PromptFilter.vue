<script setup>
"use strict";
import PromptCard from "@/Pages/Frontend/Prompt/Partials/PromptCard.vue";
import PromptCardSkeleton from "@/Pages/Frontend/Layout/PromptCardSkeleton.vue";
import axios from "axios";
import { onMounted, ref } from "vue";
import sharedComposable from "@/composables/sharedComposable";

const { pickBy } = sharedComposable();
const prompts = ref([]);
const filterForm = ref({
  model: "",
  category: "",
  sort: "",
  order: "",
});
const getPrompts = async () => {
  await axios
    .get(route("api-filtered-prompts", pickBy(filterForm.value)))
    .then((res) => {
      prompts.value = res.data;
    });
};
const sorts = ref([
  { name: "Latest", value: "created_at", order: "asc" },
  { name: "Oldest", value: "created_at", order: "desc" },
  { name: "Low to High", value: "price", order: "asc" },
  { name: "High to Low", value: "price", order: "desc" },
]);
onMounted(() => {
  setTimeout(() => {
    getPrompts();
  }, 1000);
});
const getSortBy = (sort) => {
  filterForm.value.sort = sort.value;
  filterForm.value.order = sort.order;
  getPrompts();
};
</script>

<template>
  <section class="nft__area pt-60 pb-120">
    <div class="container">
      <div class="row">
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6">
          <div class="nft__filter mb-35">
            <h4 class="nft__filter-title">{{ trans("SORT") }}</h4>
            <div class="nft__filter-item">
              <div class="nice-select" tabindex="0">
                <span class="current">{{
                  sorts.find((s) => s.value === filterForm.sort)?.name ||
                  "Default"
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
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6">
          <div class="nft__filter mb-35">
            <h4 class="nft__filter-title">{{ trans("LIKES") }}</h4>
            <div class="nft__filter-item">
              <div class="nice-select" tabindex="0">
                <span class="current">{{ trans("Most liked") }}</span>
                <ul class="list">
                  <li
                    data-value="Most liked"
                    @click="
                      getSortBy({
                        name: 'Most liked',
                        value: 'total_likes',
                        order: 'desc',
                      })
                    "
                    class="option selected"
                  >
                    {{ trans("Most liked") }}
                  </li>
                  <li data-value="Most Viewed" class="option">
                    {{ trans("Most Viewed") }}
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <template v-if="prompts.data?.length > 0">
          <div
            class="col-xxl-3 col-xl-3 col-lg-4 col-md-4"
            v-for="prompt in prompts.data"
            :key="prompt.id"
          >
            <PromptCard :prompt="prompt" />
          </div>
        </template>
        <template v-else>
          <PromptCardSkeleton
            classes="col-xxl-3 col-xl-3 col-lg-4 col-md-4"
            :count="4"
          />
        </template>
      </div>
    </div>
  </section>
</template>
