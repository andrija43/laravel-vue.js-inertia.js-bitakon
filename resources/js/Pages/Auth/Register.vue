<script setup>
"use strict";
import { useForm } from "@inertiajs/vue3";
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue";
defineOptions({ layout: FrontendLayout });
const props = defineProps(["seo"]);

import { computed, ref } from "vue";
const showPassword = ref(false);
const showConfirmationPassword = ref(false);
const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("register"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
const googleClient = computed(() => import.meta.env.VITE_GOOGLE_CLIENT_ID);
const facebookClient = computed(() => import.meta.env.VITE_FACEBOOK_CLIENT_ID);
</script>

<template>
  <Seo :metaData="seo" />
  <section class="breadcrumb__area pt-60 pb-40 p-relative">
    <div class="breadrumb__shape">
      <img
        class="breadcrumb__shape-1"
        src="assets/img/breadcrumb/breadcrumb-shape-1.png"
        alt="shape"
      />
    </div>
  </section>
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
                src="assets/img/login/login-shape-1.png"
                alt=""
              />
              <img
                class="login__shape-3"
                src="assets/img/login/login-shape-2.png"
                alt=""
              />
              <img
                class="login__shape-4"
                src="assets/img/login/login-shape-3.png"
                alt=""
              />
            </div>
            <div class="login__top text-center">
              <h3>{{ trans('Register') }}</h3>
              <p>
               {{ trans('Already have an account?') }}
                <Link :href="route('login')">{{ trans('Sign in') }} </Link>
              </p>
            </div>
            <div class="login__form">
              <form @submit.prevent="submit">
                <div class="login__input-box">
                  <div class="login__input-title">
                    <h4>{{ trans('Enter name') }} <span>*</span></h4>
                  </div>
                  <div class="login__input">
                    <input
                      type="text"
                      required
                      v-model="form.name"
                      placeholder="Your name"
                    />
                    <span class="login__input-icon">
                      <i class="fa-solid fa-user"></i>
                    </span>
                  </div>
                </div>
                <div class="login__input-box">
                  <div class="login__input-title">
                    <h4>{{ trans('Enter email') }} <span>*</span></h4>
                  </div>
                  <div class="login__input">
                    <input
                      type="email"
                      required
                      v-model="form.email"
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
                    <h4>{{ trans('Password') }} <span>*</span></h4>
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
                    <h4>{{ trans('Confirm Password') }}<span>*</span></h4>
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
                  <button type="submit" class="tp-btn-4 w-100">{{ trans('register') }}</button>
                </div>
                <div class="login__signup text-center">
                  <p>{{  trans('Or')  }} <Link href="/login">{{ trans('Sing up') }}</Link> {{ trans('with') }}</p>
                </div>
                <div class="login__option-wrapper">
                  <div class="login__option-item mb-15" v-if="googleClient">
                    <a href="/auth/google" class="login__option-btn w-100"
                      ><img src="assets/img/icon/google.png" alt="" /> 
                      {{ trans('Continue with Google') }}
                      </a>
                  </div>
                  <div class="login__option-item" v-if="facebookClient">
                    <a href="/auth/facebook" class="login__option-btn w-100">
                      <img src="assets/img/icon/facebook.png" alt="" />
                      {{ trans('Continue with Facebook') }}
                      </a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
