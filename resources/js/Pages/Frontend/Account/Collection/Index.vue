<script setup>
"use strict";
import { Head } from '@inertiajs/vue3'
import FrontendLayout from '@/Pages/Frontend/Layout/App.vue'
import AccountLayout from '@/Pages/Frontend/Account/Layout/App.vue'
import EmptyMessage from '@/Pages/Frontend/Layout/EmptyMessage.vue'
import Paginate from '@/components/Paginate.vue'

defineOptions({ layout: [FrontendLayout, AccountLayout] })
const props = defineProps(['collections'])
</script>

<template>
  <Head title="Collections" />
  <div class="creator__item-wrapper pt-40 pb-120">
    <div class="container">
      <div class="row mb-4">
        <div class="product__details-info-bottom rounded pt-3 pb-3">
          <div class="product__details-bid d-sm-flex align-items-center justify-content-between">
            <div class="tt-page-title">
              <h3 class="base-text mt-2">{{ trans('Collections') }}</h3>
            </div>
            <div class="tt-action">
              <Link :href="route('user.collection.create')" class="header__wallet-btn ms-2">
                <i class="fa fa-plus" aria-hidden="true"></i>

                {{ trans('Create') }}
              </Link>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xxl-12">
          <div class="container">
            <div class="row" v-if="collections.data.length > 0">
              <div class="activity__wrapper">
                <template v-for="collection in collections.data" :key="collection.id">
                  <div
                    class="activity__item d-md-flex align-items-center justify-content-between mb-10"
                  >
                    <div class="activity__item-inner d-flex align-items-center">
                      <div class="activity__thumb mr-20">
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
                        <span class="activity__tag">
                          <svg
                            width="12"
                            height="11"
                            viewBox="0 0 12 11"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <path
                              d="M10.6691 6.54838L6.55412 10.6634C6.44752 10.7701 6.32092 10.8547 6.18158 10.9125C6.04223 10.9703 5.89287 11 5.74203 11C5.59119 11 5.44182 10.9703 5.30248 10.9125C5.16313 10.8547 5.03654 10.7701 4.92994 10.6634L0 5.73916V0H5.73916L10.6691 4.92994C10.8829 5.145 11.0029 5.43592 11.0029 5.73916C11.0029 6.0424 10.8829 6.33332 10.6691 6.54838Z"
                              fill="white"
                            />
                            <path
                              d="M2.86914 2.8696H2.87542"
                              stroke="#006EED"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                            />
                          </svg>
                        </span>
                      </div>
                      <div class="activity__content">
                        <h3 class="activity__title">
                          <Link :href="route('collection.show', collection.slug)">
                            {{ collection.name }}
                          </Link>
                        </h3>
                        <p>{{ collection.prompts_count }} {{ trans('Prompts') }}</p>
                      </div>
                    </div>
                    <div>
                      <Link
                        :href="route('user.collection.edit', collection.id)"
                        class="activity__status mr-20"
                      >
                        <i class="fa fa-pen base-text" aria-hidden="true"></i>
                      </Link>
                      <Link
                        as="button"
                        method="delete"
                        class="activity__status"
                        :href="route('user.collection.destroy', collection.id)"
                      >
                        <i class="fa fa-trash text-danger" aria-hidden="true"></i>
                      </Link>
                    </div>
                  </div>
                </template>
              </div>
            </div>
            <EmptyMessage
              message="We're sorry, it seems that you don't have any collection in your account."
              :href="route('user.collection.create')"
              btn-text="Let's Create"
              v-if="collections.data.length < 1"
            />
          </div>
        </div>

        <Paginate :links="collections.links" />
      </div>
    </div>
  </div>
</template>
