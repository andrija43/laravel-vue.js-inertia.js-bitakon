<script setup>
"use strict";
import { Head, useForm } from "@inertiajs/vue3";
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue";
const form = useForm({
  password: "",
});
defineOptions({ layout: FrontendLayout });
const submit = () => {
  form.post(route("password.confirm"), {
    onFinish: () => form.reset(),
  });
};
</script>

<template>
  <Head title="Confirm Password" />
  <section class="breadcrumb__area pt-60 pb-40 p-relative">
    <div class="breadrumb__shape">
      <img
        class="breadcrumb__shape-1"
        src="/assets/img/breadcrumb/breadcrumb-shape-1.png"
        alt="shape"
      />
    </div>
  </section>
  <!-- login area start -->
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
              <p>
                {{
                  trans(`This is a secure area of the application. Please confirm your password
    before continuing.`)
                }}
              </p>
            </div>
            <div class="login__form">
              <form @submit.prevent="submit">
                <div class="login__input-box">
                  <div class="login__input-title">
                    <h4>Enter Password <span>*</span></h4>
                  </div>
                  <div class="login__input">
                    <input
                      v-model="form.password"
                      required
                      type="password"
                      placeholder="Enter your password"
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
                    {{ trans('Submit') }}
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
