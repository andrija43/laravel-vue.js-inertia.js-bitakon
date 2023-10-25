<script setup>
"use strict";
import sharedComposable from '@/composables/sharedComposable'
import { router } from '@inertiajs/vue3'
import { share } from '@/composables/shareComposable'
const { formatCurrency, textExcerpt, ToastAlert } = sharedComposable()
const props = defineProps(['prompt'])

const like = () => {
  router.post(
    route('user.like'),
    { id: props.prompt.id },
    {
      onSuccess: () => {
        ToastAlert(
          `${props.prompt?.is_liked === 1 ? 'Like' : 'Disliked'} Successfully`,
          `${props.prompt?.is_liked === 1 ? 'Like' : 'Disliked'} Successfully`
        )
      },
      preserveState: true
    }
  )
}
const requestRemove = () => {
  router.patch(
    route('user.prompt.updateStatus', { id: props.prompt.id }),
    {},
    {
      onSuccess: () => {
        ToastAlert('Successfully', 'Request Submitted Successfully')
      }
    }
  )
}
</script>
<template>
  <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6">
    <div class="nft__box theme-bg-dark mb-30 transition-3">
      <div class="nft__box-top d-flex align-items-center justify-content-between">
        <div class="nft__box-user">
          <ul>
            <li>
              <a href="javascript:void(0)">
                <img
                  lazy="loading"
                  v-lazy="
                    prompt.user.avatar
                      ? prompt.user.avatar
                      : `https://ui-avatars.com/api/?name=${prompt.user.name}`
                  "
                  alt="avatar"
                />
              </a>
            </li>
          </ul>
        </div>
        <div class="nft__box-more">
          <button
            type="button"
            class="dropdown-toggle nft-more-btn"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          >
            <i class="fa-regular fa-ellipsis"></i>
          </button>
          <div class="nft__more-content dropdown-menu dropdown-menu-end">
            <ul>
              <li v-if="prompt.status == 1">
                <button
                  @click="
                    share.setItem(
                      prompt.preview ? prompt.preview : JSON.parse(prompt.meta).preview,
                      prompt.slug
                    )
                  "
                  type="button"
                  data-bs-toggle="modal"
                  data-bs-target="#sharemodal"
                >
                  {{ trans('Share') }}
                </button>
              </li>
              <li v-if="prompt.status == 1">
                <button type="button">
                  <Link :href="route('user.prompt.edit', prompt.id)">{{ trans('Edit') }}</Link>
                </button>
              </li>
              <li>
                <button @click="requestRemove" type="button">
                  {{ trans('Request For Removal') }}
                </button>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="nft__box-thumb m-img mb-20">
        <Link :href="prompt.status === 1 ? route('prompt.show', prompt.slug) : '#'">
          <img
            lazy="loading"
            class="prompt-preview"
            v-lazy="prompt.preview ? prompt.preview : JSON.parse(prompt.meta).preview"
            alt="preview"
          />
        </Link>
        <button @click="like" type="button" class="nft__box-popularity">
          <a href="javascript:void(0)">
            <i
              class="fa-solid fa-heart"
              :class="prompt?.is_liked === 1 ? 'text-danger' : 'text-secondary'"
            ></i>
            {{ prompt.total_likes }}
          </a>
        </button>
      </div>
      <div class="nft__box-content">
        <div class="nft__box-content-top d-flex align-items-center justify-content-between">
          <h3 class="nft__box-title">
            <Link :href="prompt.status === 1 ? route('prompt.show', prompt.slug) : '#'">
              {{ textExcerpt(prompt.title, 20) }}
            </Link>
          </h3>
          <div class="nft__box-trending-icon mt-10" v-if="prompt.avg_ratings > 0">
            <p class="d-flex align-items-center">
              <small class="mr-5">{{ prompt.avg_ratings }}</small>
              <i class="fa fa-star text-warning" aria-hidden="true"></i>
            </p>
          </div>
        </div>
        <div class="nft__box-info d-flex align-items-center justify-content-between">
          <div class="nft__box-price">
            <p>{{ formatCurrency(prompt.price) }}</p>
          </div>
          <div class="nft__box-price">
            <p>
              {{
                prompt.status === 0
                  ? trans('Disabled')
                  : prompt.status === 1
                  ? trans('Active')
                  : prompt.status === 2
                  ? trans('Pending')
                  : ''
              }}
            </p>
          </div>
        </div>
      </div>
      <div class="nft__box-bottom d-flex align-items-center justify-content-between">
        <div class="nft__box-highest">
          <p>
            {{ prompt.promptmodel.title }}
          </p>
        </div>
        <div class="nft__box-bid">
          <p>
            <i class="fa-light fa-eye"></i>
            {{ prompt.total_views }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>