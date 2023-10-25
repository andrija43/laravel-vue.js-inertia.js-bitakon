<template>
  <div
    class="report__modal modal fade"
    id="loginmodal"
    tabindex="-1"
    aria-labelledby="loginmodal"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered modal-lg">
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
        <section class="login__area">
          <div class="container">
            <div class="row">
              <div class="col-sm-12">
                <div class="login__wrapper">
                  <div class="login__shape">
                    <img
                      class="login__shape-1"
                      src="/assets/img/login/login-person.png"
                      alt=""
                    />
                  </div>
                  <div class="login__top text-center">
                    <h3>{{ trans('Login') }}</h3>
                    <p>
                      {{ trans('Don\'t have an account yet?') }}
                      <a :href="route('register')">{{ trans('Register') }}</a>
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
                      <div class="login__input-box">
                        <div
                          class="login__input-title d-flex align-items-center justify-content-between"
                        >
                          <h4>{{ trans('Password') }} <span>*</span></h4>
                          <div class="forgot-password">
                            <a :href="route('password.request')"
                              >{{ trans('Forgot Password?') }}</a
                            >
                          </div>
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

                      <div class="login__btn mb-20">
                        <button type="submit" class="tp-btn-4 w-100">
                          {{ trans('login') }}
                        </button>
                      </div>
                      <div class="login__signup text-center">
                        <p>{{ trans('Or') }} <a href="/register">{{ trans('Sing Up') }}</a> {{ trans('with email') }}</p>
                      </div>
                      <div class="login__option-wrapper">
                        <div
                          class="login__option-item mb-15"
                          v-if="googleClient"
                        >
                          <a href="/auth/google" class="login__option-btn w-100"
                            ><img src="/assets/img/icon/google.png" alt="" />
                            {{ trans('Continue with Google') }}</a
                          >
                        </div>
                        <div class="login__option-item" v-if="facebookClient">
                          <a
                            href="/auth/facebook"
                            class="login__option-btn w-100"
                            ><img src="/assets/img/icon/facebook.png" alt="" />
                           {{ trans('Continue with Facebook') }}</a
                          >
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>

<script setup>
"use strict";
import { useForm } from "@inertiajs/vue3";
const googleClient = computed(() => import.meta.env.VITE_GOOGLE_CLIENT_ID);
const facebookClient = computed(() => import.meta.env.VITE_FACEBOOK_CLIENT_ID);
import { computed, ref } from "vue";
const showPassword = ref(false);
const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const submit = () => {
  form.post(route("login"), {
    onFinish: () => form.reset("password"),
  });
};
</script>
