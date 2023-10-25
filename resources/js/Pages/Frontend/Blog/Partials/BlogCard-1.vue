<template>
  <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-6">
    <div class="blog__grid-item mb-30">
      <div class="blog__grid-thumb w-img">
        <Link :href="props.data.posturl">
          <img lazy="loading" v-lazy="props.data.preview.value" alt="" />
        </Link>
      </div>
      <div class="blog__grid-content">
        <div class="blog__grid-tag">
          <template v-for="category in props.data.categories" :key="category.id">
            <Link :href="'/category/' + category.slug + '/' + category.id">
              {{ category.title }}
            </Link>
            &nbsp;
          </template>
        </div>

        <h3 class="blog__grid-title">
          <Link :href="props.data.posturl">{{ textExcerpt(props.data.title, 60) }}</Link>
        </h3>
        <div class="blog__grid-author d-flex align-items-center">
          <div class="blog__grid-author-info">
            <p>{{ props.data.created_at_date }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
"use strict";
import sharedComposable from '@/composables/sharedComposable'
import { Link } from '@inertiajs/vue3'
const props = defineProps(['data'])
const { textExcerpt } = sharedComposable()
</script>
