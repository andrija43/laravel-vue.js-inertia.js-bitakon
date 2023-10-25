<script setup>
"use strict";
import CollectionCard from "@/Pages/Frontend/Collection/Partials/CollectionCard.vue";
import { onMounted, ref } from "vue";
import axios from "axios";
const collections = ref([]);
onMounted(() => {
  setTimeout(() => {
    axios.get(route("api-home", { type: "collection" })).then((res) => {
      collections.value = res.data;
    });
  }, 1000);
});
</script>
<template>
  <section class="collection__area pt-125">
    <div class="container tp-container">
      <div class="row align-items-end">
        <div class="col-xxl-6">
          <div class="section__title-wrapper mb-40">
            <h4 class="section__title-stroke">{{ trans("Collections") }}</h4>
            <h3 class="section__title">
              {{ trans("Hot collections") }}
              <span><img src="/assets/img/icon/blast.png" alt="blast" /></span>
            </h3>
          </div>
        </div>
        <div class="col-xxl-6">
          <div class="collection__more text-md-end mb-40">
            <Link :href="route('collection.index')" class="tp-btn-border">
              {{ trans("View All") }}
            </Link>
          </div>
        </div>
      </div>

      <div class="row" v-if="collections.length > 0">
        <template v-for="collection in collections" :key="collection.id">
          <CollectionCard :collection="collection" />
        </template>
      </div>
      <h1 class="section__title-pre" v-else>{{ trans("Nothing Found") }}</h1>
    </div>
  </section>
</template>
