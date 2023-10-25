<script setup>
"use strict";
import { router, useForm } from '@inertiajs/vue3'
import FrontendLayout from '@/Pages/Frontend/Layout/App.vue'
import ProductGrid from '@/Pages/Frontend/Prompt/Partials/Grid.vue'
import ProductTab from '@/Pages/Frontend/Prompt/Partials/Tab.vue'
import UserPrompts from '@/Pages/Frontend/Prompt/Partials/UserPrompts.vue'
import Announcement from '@/Pages/Frontend/Home/Partials/Announcement.vue'
import { shallowRef, computed, onMounted, ref } from 'vue'
import sharedComposable from '@/composables/sharedComposable'
import { share } from '@/composables/shareComposable'
import LoginModal from '@/Pages/Auth/LoginModal.vue'
import axios from 'axios'
import moment from 'moment'
defineOptions({ layout: FrontendLayout })
const props = defineProps([
  'prompt',
  'seo',
  'promptSubmodels',
  'promptCategory',
  'promptcategoryimages',
  'promptModelRelation'
])
const activeTab = shallowRef(ProductGrid)
const similarPrompts = ref([])
const reviews = ref([])
const reviewPageNumber = ref(1)
const canReview = ref(false)
const loadMore = ref(true)
const { formatCurrency, ToastAlert, authUser } = sharedComposable()
const promptImages = computed(() => {
  if (props.prompt.gallery) {
    return JSON.parse(props.prompt.gallery)
  } else if (props.prompt.preview) {
    return [props.prompt.preview]
  } else if (JSON.parse(props.prompt.meta).preview) {
    return [JSON.parse(props.prompt.meta).preview]
  }
})

const getSimilarPrompts = () => {
  axios
    .get(
      route('api-prompts.index', {
        id: props.prompt.id,
        user_id: props.prompt.user_id
      })
    )
    .then((res) => {
      similarPrompts.value = res.data.similar_prompts
      canReview.value = res.data.canReview
    })
}
const getReviews = () => {
  axios
    .get(
      route('api-prompt.reviews', {
        id: props.prompt.id
      })
    )
    .then((res) => {
      reviews.value = res.data.data
      if (res.data.current_page === res.data.last_page) {
        return (loadMore.value = false)
      }
    })
}
const loadMoreReviews = () => {
  reviewPageNumber.value++
  axios
    .get(`/api/prompt/reviews?id=${props.prompt.id}&page=${reviewPageNumber.value}`)
    .then((res) => {
      reviews.value.push(...res.data.data)
      if (res.data.current_page === res.data.last_page) {
        return (loadMore.value = false)
      }
    })
}
onMounted(() => {
  if (props.prompt.layout_type === 'Grid') {
    activeTab.value = ProductGrid
  } else {
    activeTab.value = ProductTab
  }
  setTimeout(() => {
    getSimilarPrompts()
    getReviews()
  }, 1000)
})
const addToCart = (prompt) => {
  router.post(route('user.cart.store'), prompt, {
    onSuccess: () => {
      ToastAlert('Added', 'Added To Cart Successfully')
    }
  })
}
const buynow = (prompt) => {
  router.get(route('user.checkout.index', { prompt: prompt.id }))
}

const reviewForm = useForm({
  star: 1,
  comment: '',
  prompt_id: props.prompt.id
})
const reviewStore = () => {
  router.post(route('user.review.store'), reviewForm, {
    onSuccess: () => {
      reviewForm.reset()
      ToastAlert('Review Submitted Successfully', 'The Site Admin Will Review It Shortly')
    }
  })
}
const getDateSeconds = (date) => {
  const endDate = moment(date)
  const now = moment()
  const differenceInMilliseconds = endDate.diff(now)
  return differenceInMilliseconds
}
const like = () => {
  if (!authUser.value) {
    return router.get(route('login'))
  }
  router.post(
    route('user.like'),
    { id: props.prompt.id },
    {
      preserveScroll: true,
      onSuccess: () => {
        ToastAlert(
          `${props.prompt?.is_liked === 1 ? 'Like' : 'Disliked'} Successfully`,
          `${props.prompt?.is_liked === 1 ? 'Like' : 'Disliked'} Successfully`
        )
        if (props.successEvent) {
          props.successEvent()
        }
      }
    }
  )
}
const reportForm = useForm({
  comment: '',
  prompt_id: props.prompt.id
})
const submitReport = () => {
  reportForm.post(route('user.report'), {
    onSuccess: () => {
      ToastAlert('Report', 'Submitted Successfully')
      reportForm.reset('comment')
    }
  })
}
</script>

<template>
  <Seo :metaData="seo" />
  <LoginModal />
  <section class="product__details-area pt-60 pb-120">
    <div class="container">
      <div class="row">
        <!-- activeTab -->
        <component :is="activeTab" :images="promptImages" />

        <div class="col-xxl-5 col-xl-6 col-lg-6">
          <div class="product__details-wrapper">
            <h3 class="product__details-title">{{ prompt.title }}</h3>

            <div class="product__details-bid-info">
              <p>
                <span>{{ prompt.promptmodel.title }}</span>
              </p>
            </div>
            <div class="product__details-meta">
              <a href="javascript:void(0)" @click="like">
                <i
                  class="fa-light fa-heart"
                  :class="prompt?.is_liked === 1 ? 'text-danger' : 'text-secondary'"
                ></i>
                {{ prompt.total_likes }}
              </a>
              <a href="javascript:void(0)">
                <i class="fa-light fa-eye"></i> {{ prompt.total_views }}
              </a>
              <a
                @click="
                  share.setItem(
                    prompt.preview ? prompt.preview : JSON.parse(prompt.meta).preview,
                    prompt.slug
                  )
                "
                href="javascript:void(0)"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#sharemodal"
                ><i class="fa-light fa-share-nodes"></i> {{ trans('Share') }}</a
              >
              <a
                href="#"
                class="more dropdown-toggle nft-more-btn"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                ><i class="fa-solid fa-ellipsis"></i
              ></a>
              <div class="nft__more-content dropdown-menu dropdown-menu-end">
                <ul>
                  <li>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#reportmodal">
                      {{ trans('Report') }}
                    </button>
                  </li>
                </ul>
              </div>
            </div>

            <div class="product__details-info d-sm-flex align-items-center justify-content-between">
              <div class="product__details-info-item mb-30">
                <p>{{ trans('Creator') }}</p>
                <div class="product__details-creator d-flex align-items-center">
                  <div class="product__details-creator-thumb verified mr-10">
                    <Link :href="`/profile/${prompt.user.username}`">
                      <img
                        :src="
                          prompt.user.avatar == null
                            ? `https://ui-avatars.com/api/?name=${prompt.user.name}`
                            : prompt.user.avatar
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
                <div class="product__details-info-item mb-30">
                  <p>{{ trans('Collection') }}</p>
                  <div class="product__details-collection d-flex align-items-center">
                    <div class="product__details-collection-thumb mr-10">
                      <Link :href="`/collection/${prompt.collection.slug}`">
                        <img :src="prompt.collection.preview" alt="preview" />
                      </Link>
                    </div>
                    <div class="product__details-collection-content">
                      <h3>
                        <Link :href="`/collection/${prompt.collection.slug}`">
                          {{ prompt.collection.name }}
                        </Link>
                      </h3>
                    </div>
                  </div>
                </div>
              </template>
            </div>
            <!-- details tab -->
            <div class="product__details-info">
              <div class="product__details-info-top">
                <div class="product__details-info-tab">
                  <nav>
                    <div class="nav nav-tabs" id="product-nav-tab" role="tablist">
                      <button
                        class="nav-link active text-decoration-none"
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
                        class="nav-link text-decoration-none"
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
                        class="nav-link text-decoration-none"
                        id="nav-reviews-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#nav-reviews"
                        type="button"
                        role="tab"
                        aria-controls="nav-reviews"
                        aria-selected="true"
                      >
                        {{ trans('Reviews') }}
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
                        <span class="base-text">{{ promptCategory.name }}</span>

                        <template v-if="prompt.promptmodel.has_submodel">
                          <template v-for="submodel in promptSubmodels" :key="submodel.id">
                            <h4 class="mt-20">{{ submodel.model.title }}</h4>
                            <Link :href="route('promptmodel.show', prompt.promptmodel.slug)">
                              {{ submodel.title }}
                            </Link>
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
                    id="nav-reviews"
                    role="tabpanel"
                    aria-labelledby="nav-reviews-tab"
                  >
                    <div class="product__details-tab-item max-h-5-overflow mt-10">
                      <template v-if="canReview">
                        <div class="product__details-tab-item max-h-5-overflow mb-4">
                          <div class="col-xxl-12">
                            <div class="create__input-box">
                              <h4 class="pb-5">
                                {{ trans('Rating') }}
                              </h4>

                              <div class="create__input">
                                <div class="nice-select" tabindex="0">
                                  <span class="current">
                                    {{ trans('1 star') }}
                                  </span>

                                  <ul class="list">
                                    <template v-for="rating in [1, 2, 3, 4, 5]" :key="rating">
                                      <li class="option" @click="reviewForm.star = rating">
                                        {{ rating }} {{ trans('star') }}
                                      </li>
                                    </template>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-xxl-12">
                            <div class="create__input-box">
                              <h4>{{ trans('Review') }}</h4>

                              <div class="create__input mt-5">
                                <textarea
                                  v-model="reviewForm.comment"
                                  placeholder="Type Your Review"
                                ></textarea>
                              </div>
                            </div>
                          </div>
                          <div class="col-xxl-12">
                            <div class="create__btn">
                              <button @click.prevent="reviewStore" type="button" class="tp-btn-3">
                                {{ trans('Submit') }}
                              </button>
                            </div>
                          </div>
                        </div>
                      </template>

                      <template v-for="review in reviews" :key="review.id">
                        <div class="postbox__author d-md-flex align-items-center px-3 py-2 mb-10">
                          <div class="mr-10">
                            <Link :href="`/profile/${review.user.username}`">
                              <img
                                class="rounded-circle"
                                width="40"
                                :src="
                                  review.user.avatar
                                    ? review.user.avatar
                                    : `https://ui-avatars.com/api/?name=${review.user.name}`
                                "
                                alt="avatar"
                              />
                            </Link>
                          </div>
                          <div class="postbox__author-content">
                            <h5 class="base-text">
                              <Link :href="`/profile/${review.user.username}`">
                                {{ review.user.name }} -
                              </Link>
                              <i class="fa fa-star text-warning mr-5" aria-hidden="true"></i
                              >{{ review.star }}
                            </h5>
                            <p class="reviews-text">
                              {{ review.comment }}
                            </p>
                          </div>
                        </div>
                      </template>
                      <template v-if="reviews.length < 1">
                        <h5 class="base-text mt-5">{{ trans('No Review') }}</h5>
                      </template>
                      <div v-if="loadMore && reviews.length > 1">
                        <button @click.prevent="loadMoreReviews" type="button" class="base-text">
                          {{ trans('Load more...') }}
                        </button>
                      </div>
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
                    <h4>
                      {{ formatCurrency(prompt.price) }}
                      <span v-if="prompt.discount" class="text-danger ml-10">
                        -{{ prompt.discount.percentage }}%
                      </span>
                    </h4>
                  </div>
                  <div v-if="prompt.discount" class="product__details-bid-countdown mb-15">
                    <div class="product-bid-countdown">
                      <vue-countdown
                        class="d-flex align-items-center"
                        :time="getDateSeconds(prompt.discount?.will_expire)"
                        v-slot="{ days, hours, minutes, seconds }"
                      >
                        <div class="cdown day">
                          <span class="time-count">{{ days }}</span>
                          <p>{{ trans('Days') }}</p>
                        </div>
                        <div class="cdown hour">
                          <span class="time-count">{{ hours }}</span>
                          <p>{{ trans('Hrs') }}</p>
                        </div>
                        <div class="cdown minutes">
                          <span class="time-count">{{ minutes }}</span>
                          <p>{{ trans('Min') }}</p>
                        </div>
                        <div class="cdown second">
                          <span class="time-count">{{ seconds }}</span>
                          <p>{{ trans('Sec') }}</p>
                        </div>
                      </vue-countdown>
                    </div>
                  </div>
                </div>
                <div class="product__details-info-btn">
                  <template v-if="authUser">
                    <button
                      @click="buynow(prompt)"
                      class="tp-btn-2 active mr-10 w-50 text-decoration-none"
                    >
                      {{ trans('Buy Now') }}
                    </button>

                    <button type="button" @click="addToCart(prompt)" class="tp-btn-2">
                      {{ trans('Add To Cart') }}
                    </button>
                  </template>

                  <template v-else>
                    <button
                      class="tp-btn-2 active mr-10 w-50 text-decoration-none"
                      data-bs-toggle="modal"
                      data-bs-target="#loginmodal"
                    >
                      {{ trans('Buy Now') }}
                    </button>
                    <button class="tp-btn-2" data-bs-toggle="modal" data-bs-target="#loginmodal">
                      {{ trans('Add To Cart') }}
                    </button>
                  </template>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <template v-if="similarPrompts.length > 0">
      <UserPrompts
        :successEvent="getSimilarPrompts"
        :prompts="similarPrompts"
        :username="prompt.user.username"
      />
    </template>
  </section>
  <!-- report modal -->
  <div
    class="report__modal modal fade"
    id="reportmodal"
    tabindex="-1"
    aria-labelledby="reportmodal"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="report__close">
          <button
            type="button"
            class="report__close-btn"
            data-bs-dismiss="modal"
            aria-label="Close"
          >
            <i class="fa-regular fa-xmark"></i>
          </button>
        </div>
        <div class="report__wrapper">
          <h3 class="report__title">
            {{ trans('Describe briefly about your report.') }}
          </h3>

          <form @submit.prevent="submitReport" class="pt-10">
            <div class="report__input-box">
              <h4>{{ trans('Message') }}</h4>
            </div>
            <div class="report__input">
              <textarea v-model="reportForm.comment" placeholder="Write your message"></textarea>
            </div>
            <div class="report__button">
              <button type="submit" class="tp-btn-square">
                {{ trans('Send') }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- marque text area start -->
  <Announcement />
</template>
