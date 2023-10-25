<script setup>
"use strict";
import { onMounted, ref } from "vue";
import axios from "axios";
import sharedComposable from "@/composables/sharedComposable";
const blogs = ref([]);
onMounted(() => {
  setTimeout(() => {
    axios.get(route("api-home-two", { type: "blog" })).then((res) => {
      blogs.value = res.data;
    });
  }, 1000);
});
const { textExcerpt } = sharedComposable();
</script>
<template>
  <section class="blog__area pb-100">
    <div class="container">
      <div class="section__title-border mb-50">
        <div class="row">
          <div class="col-xxl-6 col-lg-6">
            <div class="section__title-wrapper-2 mr-15">
              <h3 class="section__title-2">{{ trans("Blogs on Ai") }}</h3>
            </div>
          </div>
          <div class="col-xxl-6 col-lg-6">
            <div class="blog__more text-lg-end">
              <Link href="/blogs" class="tp-btn-border">
                {{ trans("View all Blog") }}</Link
              >
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xxl-6 col-lg-6" v-for="blog in blogs" :key="blog.id">
          <div class="blog__item mb-30">
            <div
              class="blog__content-wrapper include-bg p-relative transition-3 fix"
              :style="{ backgroundImage: 'url(' + blog.preview.value + ')' }"
            >
              <div class="blog__content mb-20">
                <div class="blog__tag">
                  <span v-for="cat in blog.categories" :key="cat.id">
                    <Link :href="`/category/${cat.slug}/${cat.id}`">
                      {{ cat.title }}
                    </Link>
                  </span>
                </div>
                <h3 class="blog__title">
                  <Link :href="`/blog/${blog.slug}`">{{
                    textExcerpt(blog.title, 55)
                  }}</Link>
                </h3>
                <Link :href="`/blog/${blog.slug}`" class="link-btn">
                  {{ trans("Read More") }}
                  <i class="fa-regular fa-arrow-right-long"></i>
                </Link>
              </div>
            </div>
          </div>
        </div>
        <h1 class="section__title-pre" v-if="blogs.length < 1">
          {{ trans("Nothing Found") }}
        </h1>
      </div>
    </div>
  </section>
</template>
