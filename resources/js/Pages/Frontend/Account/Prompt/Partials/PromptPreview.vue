<script setup>
"use strict";
import sharedComposable from '@/composables/sharedComposable';

const props = defineProps({
    accept_image: {default: false},
    preview_image: {default: null},
    title: {default: 'Amazing Prompt'},
    price: {default: 5},
    modelTitle: {default: ''},
    ytUrl: {default: null}
});
const { textExcerpt, formatCurrency } = sharedComposable()
const setImageURL = (value) => {
  if (value instanceof File) {
    return URL.createObjectURL(value)
  } else {
    return value
  }
};
const getVideoKey = () => {
  if (props.ytUrl) return props.ytUrl.substr(props.ytUrl.lastIndexOf('/') + 1)
}

</script>
<template>
  <div class="col-xxl-4 col-xl-4 col-lg-4">
    <div class="create__preview mr-70 mb-60">
      <div class="nft__box theme-bg-dark mb-30 transition-3">
        <h3 class="create__preview-title">{{ trans('Preview') }}</h3>
        <div
          class="nft__box-top d-flex align-items-center justify-content-between"
        >
          <div class="nft__box-user">
            <ul>
              <li>
                <a href="javascript:void(0)">
                  <img src="/assets/img/bid/2/bid-user-1.jpg" alt="" />
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
          </div>
        </div>
        <div class="nft__box-thumb w-img mb-20">
          <a href="javascript:void(0)">
            <img
              v-if="accept_image"
              :src="
                setImageURL(preview_image) || '/assets/img/bid/2/bid-img-1.jpg'
              "
              alt="preview"
            />
            <img
              v-else
              :src="
                preview_image
                  ? preview_image
                  : '/assets/img/bid/2/bid-img-1.jpg'
              "
              alt="preview"
            />
          </a>
          <div class="nft__box-popularity">
            <a href="javascript:void(0)"
              ><i class="fa-solid fa-heart"></i> 24</a
            >
          </div>
        </div>
        <div class="nft__box-content">
          <div
            class="nft__box-content-top d-flex align-items-center justify-content-between"
          >
            <h3 class="nft__box-title">
              <a href="javascript:void(0)">{{
                textExcerpt(title) || "Amazing Prompt"
              }}</a>
            </h3>
            <div class="nft__box-trending-icon">
              <span><i class="fa-brands fa-ethereum"></i></span>
            </div>
          </div>
          <div
            class="nft__box-info d-flex align-items-center justify-content-between"
          >
            <div class="nft__box-price">
              <p>
                {{ formatCurrency(price || 5) }}
              </p>
            </div>
            <div class="nft__box-stock">
              <p>{{ modelTitle }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <iframe
      v-if="ytUrl"
      class="rounded"
      width="360"
      height="200"
      :src="`https://www.youtube.com/embed/${getVideoKey()}`"
      title="YouTube video player"
      frameborder="0"
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
      allowfullscreen
    ></iframe>
  </div>
</template>