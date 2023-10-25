<script setup>
"use strict";
import { Head, router } from "@inertiajs/vue3"
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue"
import { computed, ref } from "vue"
import sharedComposable from "@/composables/sharedComposable"
import axios from "axios"
import Paginate from "@/Components/Paginate.vue"
import { trans } from "laravel-vue-i18n"
const props = defineProps([
  "gateways",
  "credit_fee",
  "images",
  "generatedImages"
])
defineOptions({ layout: FrontendLayout })
const activeGateway = ref(props.gateways[0]?.id || 0)
const response = ref([])
const credits = ref(null)
const isProcessing = ref(false)

const conversionRate = ref(props.credit_fee)
const convertedAmount = computed(() => {
  return credits.value / conversionRate.value
})
const findGateway = computed(() => {
  return props.gateways.find((gateway) => gateway.id === activeGateway.value)
})
const { formatCurrency, authUser, pickBy, ToastAlert } = sharedComposable()
const form = ref({
  prompt: null,
  size: "",
  quantity: null
})
const errors = ref([])
const manualPayment = ref({
  image: null,
  comment: ""
})
const submit = (gateway_id) => {
  isProcessing.value = true
  router.post(
    route("user.generate.store"),
    {
      gateway_id: gateway_id,
      total: convertedAmount.value,
      credits: credits.value,
      manualPayment: findGateway.value.is_auto == 0 ? manualPayment.value : null
    },
    {
      onFinish: () => {
        credits.value = 0
        isProcessing.value = false
      }
    }
  )
}
const create = () => {
  isProcessing.value = true
  axios
    .post(route("api-generate"), pickBy(form.value))
    .then((res) => {
      response.value = res.data
      isProcessing.value = false
    })
    .catch((error) => {
      errors.value = error.response.data.errors;
      if (error.response.status == 401) {
        ToastAlert(trans('!Opps'), trans("You dont have enough credits please purchase some credits"), 'danger')
      }
      isProcessing.value = false
    })
}
const setImageURL = (value) => {
  return URL.createObjectURL(value)
}
</script>

<template>
  <Head title="Generate" />
  <div class="container mt-80 mb-100">
    <div class="d-flex justify-content-end align-items-center mb-80">
      <span class="base-text">{{ authUser.credits }}</span>
      <button
        data-bs-toggle="modal"
        data-bs-target="#creditmodal"
        class="tp-btn-border ml-20"
      >
        {{ trans("buy credits") }}
      </button>
    </div>
    <div class="d-flex align-items-center flex-md-row flex-column">
      <div class="header__search-input w-100">
        <input type="text" v-model="form.prompt" placeholder="Search" />
        <button type="submit" class="header__search-btn">
          <i class="fa-regular fa-magnifying-glass header__search-btn"></i>
        </button>
      </div>
      <div class="shop__filter-sort d-flex align-items-center mr-10">
        <div class="nice-select" tabindex="0">
          <span class="current">{{ form.quantity || "Quantity" }}</span>
          <ul class="list">
            <li
              class="option"
              @click="form.quantity = q"
              v-for="q in [1, 2, 3, 4, 5]"
              :key="q"
            >
              {{ q }}
            </li>
          </ul>
        </div>
      </div>
      <div class="shop__filter-sort d-flex align-items-center mr-10">
        <div class="nice-select" tabindex="0">
          <span class="current">{{ form.size || "Select Size" }}</span>
          <ul class="list">
            <li class="option" @click="form.size = '256x256'">256x256</li>
            <li class="option" @click="form.size = '512x512'">512x512</li>
            <li class="option" @click="form.size = '1024x1024'">1024x1024</li>
          </ul>
        </div>
      </div>
      <button
        @click="create"
        :disabled="isProcessing"
        class="header__wallet-btn"
      >
        {{ isProcessing ? trans("Generating...") : trans("Create") }}
      </button>
    </div>
    <div class="mt-10" v-if="errors">
      <h6 class="text-danger" v-for="(error, key) in errors" :key="key">
        {{ error[0] }}
      </h6>
    </div>
    <div class="d-flex flex-wrap mt-100" v-if="response.created">
      <section
        class="col-xxl-2 mr-10 mb-10 generated-images-parent"
        v-for="(image, i) in response.data"
        :key="i"
      >
        <img :src="image.url" class="img-thumbnail" alt="img" />
        <a class="generated-image-child" target="_blank" :href="image.url" download>
          <i class="fa fa-download fa-lg" aria-hidden="true"></i>
        </a>
      </section>
    </div>
    <template v-else>
      <div class="d-flex flex-wrap mt-100 mb-50" v-if="images.length > 0">
        <section
          class="col-xxl-2 mr-10 mb-10 generated-images-parent"
          v-for="(image, i) in images"
          :key="i"
        >
          <img :src="image" class="img-thumbnail" alt="img" />
          <a
            class="generated-image-child"
            target="_blank"
            :href="image"
            download
          >
            <i class="fa fa-download fa-lg" aria-hidden="true"></i>
          </a>
        </section>
      </div>
      <Paginate :links="generatedImages.links" />
    </template>
  </div>

  <div
    class="share__modal modal"
    id="creditmodal"
    tabindex="-1"
    aria-labelledby="creditmodal"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-4">
        <div class="share__modal-content text-center">
          <div class="share__social">
            <h3>{{ trans("Buy Credits") }}</h3>
          </div>
          <h5 class="text-base">
            {{ conversionRate }} {{ trans("credits") }} =
            {{ formatCurrency(1) }}
          </h5>

          <div class="col-xxl-12 mt-20">
            <div class="create__input-box">
              <div class="create__input">
                <input
                  step="5"
                  type="number"
                  v-model.number="credits"
                  placeholder="Enter Credit amount"
                />
              </div>
            </div>
          </div>
          <h5 class="base-text text-left">
            {{ trans("Total:") }} {{ formatCurrency(convertedAmount || 0) }}
          </h5>
          <div class="product__details-info">
            <div class="product__details-info-tab mt-20">
              <nav>
                <div class="d-flex" role="tablist">
                  <div class="nft__nav mb-5">
                    <nav>
                      <div class="nav nav-tabs">
                        <button
                          v-for="getaway in gateways"
                          :key="getaway.id"
                          class="nav-link text-decoration-none pt-1 pb-1"
                          :class="{
                            active: getaway.id === activeGateway
                          }"
                          @click="activeGateway = getaway.id"
                          type="button"
                        >
                          <span class="base-text"> {{ getaway.name }}</span>
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
                  <template v-if="gateway.charge != 0">
                    <div
                      class="d-flex justify-content-between align-items-center checkout-getaway"
                    >
                      <p>{{ trans("Charge") }}</p>
                      <p>
                        {{ formatCurrency(gateway.charge) }}
                      </p>
                    </div>
                  </template>

                  <div class="table-responsive">
                    <template v-if="gateway.comment != null">
                      <div
                        class="d-flex justify-content-between align-items-center checkout-getaway border-bottom"
                      >
                        <p>
                          {{ trans("Payment Instruction") }}
                        </p>
                        <p>
                          {{ gateway.comment }}
                        </p>
                      </div>
                    </template>
                    <template v-if="gateway.phone_required == 1">
                      <div class="create__input-box mt-2">
                        <label class="text-white mb-5"
                          ><b>{{ trans("Your phone number") }}</b></label
                        >
                        <input
                          type="number"
                          name="phone"
                          class=""
                          required
                          :value="user.phone"
                        />
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
                          class="col-xxl-3"
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
                :disabled="!credits"
                type="submit"
                class="header__wallet-btn w-100 mt-10"
              >
                {{ isProcessing ? trans("Processing...") : trans("Pay Now") }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
