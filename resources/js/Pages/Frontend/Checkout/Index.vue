<script setup>
"use strict";
import { Head, router } from "@inertiajs/vue3"
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue"
import sharedComposable from "@/composables/sharedComposable"
import EmptyMessage from "@/Pages/Frontend/Layout/EmptyMessage.vue"
import { computed, ref } from "vue"
defineOptions({ layout: FrontendLayout })
const props = defineProps([
  "carts",
  "user",
  "gateways",
  "tax",
  "promptId",
  "collection"
])
const { formatCurrency, ToastAlert, textExcerpt } = sharedComposable()
const activeGateway = ref(props.gateways[0]?.id || 0)
const isProcessing = ref(false)
const destroyCart = (id) => {
  router.delete(route("user.cart.destroy", id), {
    onSuccess: () => {
      ToastAlert("Deleted", "Successfully Deleted")
    }
  })
}
const totalPrice = computed(() => {
  let totalPrice = 0

  for (const key in props.carts) {
    if (props.carts.hasOwnProperty(key)) {
      const item = props.carts[key]
      totalPrice += item.price
    }
  }
  return totalPrice
})
const manualPayment = ref({
  image: null,
  comment: ""
})
const findGateway = computed(() => {
  return props.gateways.find((gateway) => gateway.id === activeGateway.value)
})
const submit = (gateway_id) => {
  isProcessing.value = true
  router.post(
    route("user.checkout.store"),
    {
      gateway_id: gateway_id,
      total: totalPrice.value + props.tax || 0,
      prompt: props.promptId,
      collection: props.collection?.id,
      manualPayment: findGateway.value.is_auto == 0 ? manualPayment.value : null
    },
    {
      onFinish: () => (isProcessing.value = false)
    }
  )
}

const setImageURL = (value) => {
  return URL.createObjectURL(value)
}
</script>

<template>
  <Head title="Checkout" />
  <!-- breadcrumb area start -->
  <section class="breadcrumb__area breadcrumb__border pt-40 pb-40 p-relative">
    <div class="breadrumb__shape">
      <img
        class="breadcrumb__shape-1"
        src="/assets/img/breadcrumb/breadcrumb-shape-1.png"
        alt="shape"
      />
    </div>
    <div class="container">
      <div class="row">
        <div class="col-xxl-12">
          <div class="breadcrumb__content text-center">
            <h3 class="breadcrumb__title">{{ trans("Checkout") }}</h3>
            <div class="breadcrumb__list">
              <span
                ><Link href="/">{{ trans("Home") }}</Link></span
              >
              <span class="dvdr tp-dot"
                ><i class="fa-solid fa-period"></i
              ></span>
              <span> {{ trans("Checkout") }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- content -->
  <section class="collection__grid pt-60 pb-120">
    <div class="container">
      <div class="row">
        <div class="col-xxl-7 col-xl-7 col-lg-7 rounded">
          <div class="col-xxl-12 col-lg-4 col-md-6">
            <div class="features__item mb-30 pink-bg theme-bg-dark">
              <div class="features__item-inner">
                <div class="features__content">
                  <h4 class="features__title">
                    {{ user.name }}
                  </h4>
                  <p>
                    {{ user.phone || "" }}
                  </p>
                  <p>{{ JSON.parse(user.meta)?.address || "" }}</p>
                  <p>{{ "Country" }}</p>
                </div>
              </div>
            </div>
          </div>

          <div
            class="product__details-info"
            v-if="
              (collection?.prompts !== 0 && collection?.price > 1) ||
              Object.keys(carts).length > 0
            "
          >
            <div class="product__details-info-tab mt-20">
              <nav>
                <div class="d-flex" role="tablist">
                  <div class="nft__nav mb-5">
                    <nav>
                      <div class="nav nav-tabs">
                        <button
                          v-for="getaway in gateways"
                          :key="getaway.id"
                          class="nav-link h-3-r"
                          :class="{
                            active: getaway.id === activeGateway
                          }"
                          @click="activeGateway = getaway.id"
                          type="button"
                        >
                          <img :src="getaway.logo" alt="" height="15" />
                          {{ getaway.name }}
                        </button>
                      </div>
                    </nav>
                  </div>
                </div>
              </nav>
            </div>

            <div class="checkout-container">
              <template v-for="(gateway, key) in gateways" :key="key">
                <div
                  v-if="activeGateway === gateway.id"
                  class="col-sm-12 gateway-form"
                  :id="'gateway-form' + gateway.id"
                >
                  <template v-if="gateway.currency != null">
                    <div
                      class="d-flex justify-content-between align-items-center checkout-getaway"
                    >
                      <p>{{ trans("Currency") }}</p>
                      <p>{{ gateway.currency }}</p>
                    </div>
                  </template>
                  <template v-if="gateway.charge != 0">
                    <div
                      class="d-flex justify-content-between align-items-center checkout-getaway"
                    >
                      <p>{{ trans("Charge") }}</p>
                      <p>{{ formatCurrency(gateway.charge) }}</p>
                    </div>
                  </template>

                  <div class="table-responsive">
                    <template v-if="gateway.comment != null">
                      <div
                        class="d-flex justify-content-between align-items-center checkout-getaway border-bottom"
                      >
                        <p>{{ trans("Payment Instruction") }}</p>
                        <p>
                          {{ gateway.comment }}
                        </p>
                      </div>
                    </template>
                    <template v-if="gateway.phone_required == 1">
                      <div class="create__input-box mt-2">
                        <label class="text-white mb-5 "
                          ><b class="base-text">{{ trans("Your phone number") }}</b></label
                        >
                        <div class="create__input">
                          <input
                            type="number"
                            name="phone"
                            class=""
                            required
                            :value="user.phone"
                          />
                        </div>
                      </div>
                    </template>
                    <template v-if="gateway.is_auto == 0">
                      <div class="col-xxl-12 mt-3">
                        <div class="create__input-box">
                          <h4 class="pb-10">
                            * {{ trans("Submit your payment proof") }}
                          </h4>
                          <div class="create__upload text-center">
                            <p>{{ trans("JPG, PNG.") }}</p>
                            <label for="input-preview">{{
                              trans("Select a file")
                            }}</label>
                            <input
                              @input="
                                (e) => {
                                  manualPayment.image = e.target.files[0]
                                }
                              "
                              required
                              id="input-preview"
                              type="file"
                              accept="image/*"
                            />
                          </div>
                        </div>
                      </div>
                      <section v-if="manualPayment.image">
                        <button
                          @click="manualPayment.image = null"
                          type="button"
                          class="position-absolute btn btn-danger btn-sm"
                        >
                          <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                        <img
                          class="col-xxl-2"
                          :src="setImageURL(manualPayment.image)"
                          alt="preview"
                        />
                      </section>
                      <div class="create__input-box">
                        <label class="text-white mb-5">
                          <b>*{{ trans("Comment") }}</b>
                        </label>
                        <div class="create__input">
                          <textarea
                            v-model="manualPayment.comment"
                            required
                            name="comment"
                            maxlength="500"
                            placeholder="Comment"
                          ></textarea>
                        </div>
                      </div>
                    </template>
                  </div>
                </div>
              </template>

              <button
                @click="submit(activeGateway)"
                :disabled="isProcessing"
                type="submit"
                class="header__wallet-btn w-100 mt-10"
              >
                {{ isProcessing ? trans("Processing") : trans("Pay Now") }}
              </button>
            </div>
          </div>
        </div>

        <div class="col-xxl-5 col-xl-5 col-lg-5">
          <div class="cta__wrapper-2 p-4">
            <div class="row align-items-center">
              <div class="activity__widget">
                <h2 class="activity__widget-title">
                  {{ trans("Order Summary") }}
                </h2>
                <!-- collection -->
                <template v-if="collection?.isCollection">
                  <EmptyMessage
                    class="mb-10"
                    v-if="collection.prompts === 0 && collection.price < 1"
                    href="/"
                    btn-text="Home"
                    message="We're sorry, it seems that you already purchased every prompt from this collection."
                  />
                  <div
                    v-else
                    class="activity__item d-md-flex align-items-center justify-content-between mb-20"
                  >
                    <div class="activity__item-inner d-flex align-items-center">
                      <div class="activity__thumb mr-20">
                        <img
                          lazy="loading"
                          v-lazy="
                            collection.preview
                              ? collection.preview
                              : 'assets/img/collection/user/collection-user-1.jpg'
                          "
                          alt="preview"
                        />
                      </div>
                      <div class="activity__content">
                        <h3 class="activity__title">
                          {{ textExcerpt(collection.name, 20) }}
                        </h3>
                        <p>
                          {{ formatCurrency(collection.price) }}
                          | {{ trans("Prompts") }} {{ collection.prompts }}
                        </p>
                      </div>
                    </div>
                  </div>

                  <h3
                    class="activity__widget-title d-flex justify-content-between"
                  >
                    {{ trans("Subtotal :") }}
                    <span>{{ formatCurrency(collection.price) }}</span>
                  </h3>
                  <h3
                    class="activity__widget-title d-flex justify-content-between"
                  >
                    {{ trans("Tax :") }}
                    <span>{{ formatCurrency(+tax || 0) }}</span>
                  </h3>
                  <h3
                    class="activity__widget-title d-flex justify-content-between"
                  >
                    {{ trans("Total :") }}
                    <span>{{
                      formatCurrency(
                        collection.price + findGateway.charge + +tax
                      )
                    }}</span>
                  </h3>
                </template>
                <!-- prompts -->
                <template v-else>
                  <template v-for="cart in carts" :key="cart.id">
                    <div
                      class="activity__item d-md-flex align-items-center justify-content-between mb-20"
                    >
                      <div
                        class="activity__item-inner d-flex align-items-center"
                      >
                        <div class="activity__thumb mr-20">
                          <Link :href="route('prompt.show', cart.slug)">
                            <img
                              lazy="loading"
                              v-lazy="
                                cart.preview
                                  ? cart.preview
                                  : 'assets/img/collection/user/collection-user-1.jpg'
                              "
                              alt="preview"
                            />
                          </Link>
                        </div>
                        <div class="activity__content">
                          <h3 class="activity__title">
                            <Link :href="route('prompt.show', cart.slug)">
                              {{ textExcerpt(cart.title, 20) }}
                            </Link>
                          </h3>
                          <p>
                            {{ formatCurrency(cart.price) }}
                            | {{ cart.model }}
                          </p>
                        </div>
                      </div>
                      <button
                        type="button"
                        @click="destroyCart(cart.id)"
                        class="activity__status"
                      >
                        <i
                          class="fa fa-trash text-danger"
                          aria-hidden="true"
                        ></i>
                      </button>
                    </div>
                  </template>
                  <h3
                    class="activity__widget-title d-flex justify-content-between"
                  >
                    {{ trans("Subtotal :") }}
                    <span>{{ formatCurrency(totalPrice) }}</span>
                  </h3>
                  <h3
                    class="activity__widget-title d-flex justify-content-between"
                  >
                    {{ trans("Tax :") }}
                    <span>{{ formatCurrency(+tax || 0) }}</span>
                  </h3>
                  <h3
                    class="activity__widget-title d-flex justify-content-between"
                  >
                    {{ trans("Total :") }}
                    <span>
                      {{
                        formatCurrency(totalPrice + findGateway.charge + +tax)
                      }}
                    </span>
                  </h3>
                </template>
              </div>
            </div>
          </div>
        </div>
      </div>
      <EmptyMessage
        message="We're sorry, it seems that you don't have any prompts in your cart."
        :href="route('prompt.index')"
        btn-text="Let's Browsing"
        v-if="carts.length < 1 && !collection?.isCollection"
      />
    </div>
  </section>
</template>
