<script setup>
"use strict";
   import { useForm } from "@inertiajs/vue3";
   import FrontendLayout from "@/Pages/Frontend/Layout/App.vue";
   import { computed, ref } from "vue";
   import Seo from "../Frontend/Layout/Seo.vue";
   defineOptions({ layout: FrontendLayout });
   const props = defineProps(["seo"]);
   
   const form = useForm({
     email: "",
     password: "",
     remember: false,
   });
   const showPassword = ref(false);
   const submit = () => {
     form.post(route("login"), {
       onFinish: () => form.reset("password"),
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
                     <h3>{{ trans('Login') }}</h3>
                     <p>
                        {{ trans('Don\'t have an account yet?') }}
                        <Link :href="route('register')">
                        {{ trans('Register') }}</Link>
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
                                 <Link :href="route('password.request')">
                                 {{ trans('Forgot Password?') }}
                                 </Link>
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
                           <button type="submit" class="tp-btn-4 w-100">{{ trans('login') }}</button>
                        </div>
                        <div class="login__signup text-center">
                           <p>
                              {{ trans('Or') }} 
                              <Link :href="route('register')">
                              {{ trans('Sing In') }}</Link> {{ trans('with') }} 
                           </p>
                        </div>
                        <div class="login__option-wrapper">
                           <div class="login__option-item mb-15" v-if="googleClient">
                              <a href="/auth/google" class="login__option-btn w-100"
                                 >
                              <img src="/assets/img/icon/google.png" alt="" />
                              {{ trans('Continue with Google') }}
                              </a>
                           </div>
                           <div class="login__option-item" v-if="facebookClient">
                              <a href="/auth/facebook" class="login__option-btn w-100"
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
   <!-- login area end -->
</template>