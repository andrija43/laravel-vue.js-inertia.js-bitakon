<script setup>
"use strict";
import { Head } from '@inertiajs/vue3'
import FrontendLayout from '@/Pages/Frontend/Layout/App.vue'
import DashboardLayout from '@/Pages/Frontend/Dashboard/Layout/App.vue'
import { computed } from 'vue'
import sharedComposable from '@/composables/sharedComposable'
defineOptions({ layout: [FrontendLayout, DashboardLayout] })
const props = defineProps([
  'prompt',
  'promptSubmodels',
  'promptCategory',
  'promptcategoryimages',
  'promptModelRelation',
  'promptFiles'
])

const { formatCurrency } = sharedComposable()
const promptImage = computed(() => {
  if (props.prompt.preview) {
    return props.prompt.preview
  } else if (JSON.parse(props.prompt.meta).preview) {
    return JSON.parse(props.prompt.meta).preview
  }
})
</script>

<template>
  <Head title="Prompts" />
  <section class="product__details-area">
    <div class="container">
      <div class="row">
        <div class="col-xxl-12 mt-30">
          <div class="product__details-wrapper">
            <Link :href="route('prompt.show', prompt.slug)">
              <h3 class="product__details-title">{{ prompt.title }}</h3></Link
            >

            <div class="product__details-bid-info">
              <p>
                <span>{{ prompt.promptmodel.title }}</span>
              </p>
            </div>

            <div class="product__details-info d-sm-flex align-items-center justify-content-between">
              <div class="product__details-info-item">
                <p>{{ trans('Creator') }}</p>
                <div class="product__details-creator d-flex align-items-center">
                  <div class="product__details-creator-thumb verified mr-10">
                    <Link :href="`/profile/${prompt.user.username}`">
                      <img
                        v-lazy="
                          prompt.user.avatar
                            ? prompt.user.avatar
                            : `https://ui-avatars.com/api/?name=${prompt.user.name}`
                        "
                        alt=""
                      />
                    </Link>
                  </div>
                  <div class="product__details-creator-content">
                    <h3>
                      <Link :href="`/profile/${prompt.user.username}`">{{ prompt.user.name }}</Link>
                    </h3>
                  </div>
                </div>
              </div>

              <template v-if="prompt.collection">
                <div class="product__details-info-item">
                  <p>{{ trans('Collection') }}</p>
                  <div class="product__details-collection d-flex align-items-center">
                    <div class="product__details-collection-thumb mr-10">
                      <Link :href="route('collection.show', prompt.collection.slug)">
                        <img v-lazy="prompt.collection.preview" alt="preview" />
                      </Link>
                    </div>
                    <div class="product__details-collection-content">
                      <h3>
                        <Link :href="route('collection.show', prompt.collection.slug)">
                          {{ prompt.collection.name }}
                        </Link>
                      </h3>
                    </div>
                  </div>
                </div>
              </template>
            </div>
          </div>
        </div>
        <!-- details tab -->
        <div class="col-xxl-12 mt-30">
          <div class="product__details-info">
            <div class="product__details-info-top">
              <div class="product__details-info-tab">
                <nav>
                  <div class="nav nav-tabs" id="product-nav-tab" role="tablist">
                    <button
                      class="nav-link active"
                      id="nav-details-tab"
                      data-bs-toggle="tab"
                      data-bs-target="#nav-details"
                      type="button"
                      role="tab"
                      aria-controls="nav-details"
                      aria-selected="true"
                    >
                      {{ trans('Details') }}
                    </button>
                    <button
                      class="nav-link"
                      id="nav-description-tab"
                      data-bs-toggle="tab"
                      data-bs-target="#nav-description"
                      type="button"
                      role="tab"
                      aria-controls="nav-description"
                      aria-selected="true"
                    >
                      {{ trans('Description') }}
                    </button>
                    <button
                      class="nav-link"
                      id="nav-instruction-tab"
                      data-bs-toggle="tab"
                      data-bs-target="#nav-instruction"
                      type="button"
                      role="tab"
                      aria-controls="nav-instruction"
                      aria-selected="true"
                    >
                      {{ trans('Instructions') }}
                    </button>
                  </div>
                </nav>
              </div>
            </div>
            <div class="product__details-info-tab-content">
              <div class="tab-content" id="product-details">
                <div
                  class="tab-pane fade show active text-decoration-none"
                  id="nav-details"
                  role="tabpanel"
                  aria-labelledby="nav-details-tab"
                >
                  <div class="product__details-tab-item">
                    <div class="product__details-category">
                      <h4>{{ trans('Category') }}</h4>
                      {{ promptCategory.name }}

                      <template v-if="prompt.promptmodel.has_submodel">
                        <template v-for="submodel in promptSubmodels" :key="submodel.id">
                          <h4 class="mt-20">{{ submodel.model.title }}</h4>
                          {{ submodel.title }}
                        </template>
                      </template>
                    </div>
                  </div>
                </div>
                <div
                  class="tab-pane fade text-decoration-none"
                  id="nav-description"
                  role="tabpanel"
                  aria-labelledby="nav-description-tab"
                >
                  <div class="product__details-tab-item max-h-5-overflow">
                    <div class="base-text" v-html="JSON.parse(prompt.meta).description"></div>
                  </div>
                </div>
                <div
                  class="tab-pane fade text-decoration-none"
                  id="nav-instruction"
                  role="tabpanel"
                  aria-labelledby="nav-description-tab"
                >
                  <div class="product__details-tab-item max-h-5-overflow">
                    <template v-for="(file, key, i) in JSON.parse(promptFiles.files)" :key="i">
                      <p class="base-text mb-0 text-capitalize">{{ key.replaceAll('_', ' ') }} :</p>
                      <p class="base-text">{{ file }}</p>
                    </template>
                  </div>
                </div>
              </div>
            </div>
            <!-- price -->
            <div class="product__details-info-bottom">
              <div
                class="product__details-bid d-sm-flex align-content-center justify-content-between"
              >
                <div class="product__details-bid-status mb-15">
                  <p>{{ trans('Price') }}</p>
                  <h4>{{ formatCurrency(prompt.price) }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
