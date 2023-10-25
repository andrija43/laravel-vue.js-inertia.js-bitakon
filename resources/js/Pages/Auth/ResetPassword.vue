<script setup>
"use strict";
import { Head, useForm } from "@inertiajs/vue3"
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue"
import sharedComposable from "@/composables/sharedComposable"
import { ref } from "vue"
defineOptions({ layout: FrontendLayout })
const props = defineProps({
  email: {
    type: String,
    required: true
  },
  token: {
    type: String,
    required: true
  }
})
const { ToastAlert } = sharedComposable()
const showPassword = ref(false)
const showConfirmationPassword = ref(false)
const form = useForm({
  token: props.token,
  email: props.email,
  password: "",
  password_confirmation: ""
})

const submit = () => {
  form.post(route("password.store"), {
    onSuccess: () => {
      ToastAlert("Reset Request", "Submitted Successfully")
    },
    onFinish: () => form.reset()
  })
}
</script>

<template>
  <Head title="Reset Password" />
  <section class="breadcrumb__area pt-60 pb-40 p-relative">
    <div class="breadrumb__shape">
      <img
        class="breadcrumb__shape-1"
        src="assets/img/breadcrumb/breadcrumb-shape-1.png"
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
                src="assets/img/login/login-person.png"
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
                    <h4>Enter email <span>*</span></h4>
                  </div>
                  <div class="login__input">
                    <input
                      v-model="form.email"
                      required
                      autofocus
                      type="email"
                      placeholder="Enter your email"
                    />
                    <span class="login__input-icon">
                      <i class="fa-light fa-envelope"></i>
                    </span>
                  </div>
                </div>
                <div class="login__input-box">
                  <div
                    class="login__input-title d-flex align-items-center justify-content-between"
                  >
                    <h4>Password <span>*</span></h4>
                  </div>
                  <div class="login__input">
                    <input
                      v-model="form.password"
                      required
                      :type="showPassword ? 'text' : 'password'"
                      placeholder="Enter your Password"
                    />
                    <span class="login__input-icon">
                      <i class="fa-light fa-lock"></i>
                    </span>
                    <span class="login__input-password-visible">
                      <i
                        v-if="showPassword"
                        @click="showPassword = false"
                        class="fa-light fa-eye"
                      ></i>
                      <i
                        v-else
                        @click="showPassword = true"
                        class="fa-light fa-eye-slash"
                      ></i>
                    </span>
                  </div>
                </div>
                <div class="login__input-box">
                  <div
                    class="login__input-title d-flex align-items-center justify-content-between"
                  >
                    <h4>Confirm Password <span>*</span></h4>
                  </div>
                  <div class="login__input">
                    <input
                      v-model="form.password_confirmation"
                      required
                      :type="showConfirmationPassword ? 'text' : 'password'"
                      placeholder="Confirm your password"
                    />
                    <span class="login__input-icon">
                      <i class="fa-light fa-lock"></i>
                    </span>
                    <span class="login__input-password-visible">
                      <i
                        v-if="showConfirmationPassword"
                        @click="showConfirmationPassword = false"
                        class="fa-light fa-eye"
                      ></i>
                      <i
                        v-else
                        @click="showConfirmationPassword = true"
                        class="fa-light fa-eye-slash"
                      ></i>
                    </span>
                  </div>
                </div>
                <div class="login__btn mb-20">
                  <button
                    type="submit"
                    class="tp-btn-4 w-100"
                    :disabled="form.processing"
                  >
                    {{ trans("Reset Password") }}
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
