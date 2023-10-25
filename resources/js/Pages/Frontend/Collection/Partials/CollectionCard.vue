<script setup>
"use strict";
const props = defineProps(['collection'])
</script>

<template>
  <div class="col-lg-4 col-md-6">
    <div class="collection__item text-center mb-30 theme-bg-dark">
      <div class="collection__item-inner">
        <div class="collection__thumb-wrapper">
          <div class="row gx-2">
            <template v-if="collection.prompt_previews.length > 0">
              <template v-for="(preview, i) in collection.prompt_previews" :key="preview.preview">
                <div :class="i === 3 ? 'col-xxl-12' : 'col-xxl-4 col-sm-4 col-4'">
                  <div class="collection__thumb mb-10 m-img">
                    <Link :href="route('collection.show', collection.slug)">
                      <img lazy="loading" v-lazy="preview.preview" alt="preview" />
                    </Link>
                  </div>
                </div>
              </template>
            </template>
            <div class="col-xxl-12" v-else>
              <div class="collection__thumb mb-10 m-img">
                <Link :href="route('collection.show', collection.slug)">
                  <img
                    lazy="loading"
                    v-lazy="
                      collection.preview
                        ? collection.preview
                        : '/assets/img/collection/collection-big-1.jpg'
                    "
                    alt="preview"
                  />
                </Link>
              </div>
            </div>
          </div>
        </div>
        <div class="collection__content">
          <div class="collection__profile">
            <Link :href="route('collection.show', collection.slug)">
              <img
                lazy="loading"
                v-lazy="
                  collection.preview
                    ? collection.preview
                    : 'assets/img/collection/user/collection-user-1.jpg'
                "
                alt="preview"
              />
            </Link>
          </div>
          <h3 class="collection__title">
            <Link :href="route('collection.show', collection.slug)">{{ collection.name }}</Link>
          </h3>
          <p>{{ collection.prompts_count }} {{ trans('Prompts') }}</p>
        </div>
      </div>
    </div>
  </div>
</template>
