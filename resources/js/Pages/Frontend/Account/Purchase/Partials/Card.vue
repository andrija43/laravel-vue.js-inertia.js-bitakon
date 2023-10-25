<template>
  <div class="row">
    <div class="col-lg-6" v-for="order in orders" :key="order.id">
      <div class="bid__item mb-30 theme-bg-dark">
        <div class="bid__item-wrapper">
          <div class="bid__list-wrapper d-sm-flex align-items-center">
            <div class="bid__list-left">
              <div class="bid__thumb m-img mb-15">
                <Link :href="route('prompt.show', order.slug)">
                  <img
                    lazy="loading"
                    v-lazy="order.preview ? order.preview : JSON.parse(order.meta).preview"
                    alt="preview"
                  />
                </Link>
              </div>
            </div>
            <div class="bid__list-right pl-30">
              <div class="bid__top d-flex align-items-center justify-content-between mb-20">
                <div class="bid__user">
                  <ul>
                    <li>
                      <Link :href="`/profile/${order.username}`">
                        <img
                          lazy="loading"
                          v-lazy="
                            order.avatar
                              ? order.avatar
                              : `https://ui-avatars.com/api/?name=${order.name}`
                          "
                          alt="avatar"
                        />
                        <span class="px-2 base-text">{{ order.name }}</span>
                      </Link>
                    </li>
                  </ul>
                </div>
                <div class="bid__popularity">
                  <i class="icon_heart"></i>
                  {{ order.total_likes }}
                </div>
              </div>
              <div class="bid__content">
                <div class="bid__content-top d-flex align-items-center justify-content-between">
                  <h3 class="bid__title">
                    <Link :href="route('prompt.show', order.slug)">{{ order.title }}</Link>
                  </h3>
                </div>
                <div class="bid__info d-flex align-items-center justify-content-between">
                  <div class="bid__highest">
                    <p>
                      <span>{{ formatCurrency(order.price) }}</span>
                    </p>
                  </div>
                  <div class="bid__stock">
                    <p>{{ order.model_title }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
"use strict";
import sharedComposable from '@/composables/sharedComposable'
const props = defineProps(['orders'])
const { formatCurrency } = sharedComposable()
</script>
