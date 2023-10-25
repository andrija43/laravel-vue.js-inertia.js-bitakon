<script setup>
"use strict";
import { useForm } from "@inertiajs/vue3"
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue"
import Seo from "../Frontend/Layout/Seo.vue"
import sharedComposable from "@/composables/sharedComposable"
defineProps({
  status: {
    type: String
  },
  seo: {
    default: []
  }
})
defineOptions({ layout: FrontendLayout })
const form = useForm({
  email: ""
})
const { ToastAlert } = sharedComposable()
const submit = () => {
  form.post(route("password.email"), {
    onSuccess: () => {
      ToastAlert("Reset Request", "Submitted Successfully")
      form.reset()
    }
  })
}
</script>

<template>
  <Seo :metaData="seo" />
  <section class="breadcrumb__area pt-60 pb-40 p-relative">
    <div class="breadrumb__shape">
      <img
        class="breadcrumb__shape-1"
        src="/assets/img/breadcrumb/breadcrumb-shape-1.png"
        alt="shape"
      />
    </div>
  </section>
  <!-- form -->
  <section class="login__area pb-120">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xxl-6 col-xl-6 col-lg-8">
          <div class="login__wrapper">
            <div class="login__shape">
              <img
                class="login__shape-1"
                src="/assets/img/login/login-person.png"
                alt=""
              />
              <img
                class="login__shape-2"
                src="/assets/img/login/login-shape-1.png"
                alt=""
              />
              <img
                class="login__shape-3"
                src="/assets/img/login/login-shape-2.png"
                alt=""
              />
              <img
                class="login__shape-4"
                src="/assets/img/login/login-shape-3.png"
                alt=""
              />
            </div>
            <div class="login__top text-center">
              <h3>{{ trans("Forgot your password?") }}</h3>
              <p>
                {{
                  trans(`No problem. Just let us know your email
                address and we will email you a password reset link that will
                allow you to choose a new one.`)
                }}
              </p>
            </div>
            <div class="login__form">
              <form @submit.prevent="submit">
                <div class="login__input-box">
                  <div class="login__input-title">
                    <h4>{{ trans('Enter email') }} <span>*</span></h4>
                  </div>
                  <div class="login__input">
                    <input
                      v-model="form.email"
                      required
                      type="email"
                      placeholder="Enter your email"
                    />
                    <span class="login__input-icon">
                      <i class="fa-light fa-envelope"></i>
                    </span>
                  </div>
                </div>

                <div class="login__btn mb-20">
                  <button
                    type="submit"
                    class="tp-btn-4 w-100"
                    :disabled="form.processing"
                  >
                    {{ trans(form.processing ? `Please wait....` : `Submit`) }}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
