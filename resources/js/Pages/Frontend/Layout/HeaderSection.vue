<script setup>
"use strict";
import sharedComposable from "@/composables/sharedComposable"
import { useForm } from "@inertiajs/vue3"
import MainMenu from "@/Pages/Frontend/Layout/MainMenu.vue"
const { authUser, logout, textExcerpt, copyToClipboard, formatCurrency } =
  sharedComposable()
const host = window.location.origin
const profileLink = authUser.value
  ? host + "/profile/" + authUser.value.username
  : ""

const form = useForm({
  s_query: ""
})

const searchPrompt = () => {
  form.get(route("prompt.index"))
}
</script>

<template>
  <header>
    <div
      id="header-sticky"
      class="header__area header__border header__padding header__bg header__sticky"
    >
      <div class="container tp-container">
        <div class="header__wrapper p-relative">
          <div class="row align-items-center">
            <div class="col-xxl-1 col-xl-1 col-lg-2 col-md-6 col-4">
              <div class="logo header__logo">
                <Link href="/">
                  <img
                    class="logo-white"
                    :src="$page.props.primaryData?.logo"
                    alt="logo"
                  />
                  <img
                    class="logo-black"
                    :src="$page.props.primaryData?.logo_dark"
                    alt="logo"
                  />
                </Link>
              </div>
            </div>
            <div class="col-xxl-8 col-xl-8 col-lg-5 d-none d-lg-block">
              <div class="header__menu-wrapper d-flex align-items-center">
                <div class="header__search mr-30 ml-5">
                  <form
                    @submit.prevent="searchPrompt"
                    @keypress.enter="searchPrompt"
                  >
                    <div class="header__search-input">
                      <input
                        type="text"
                        v-model="form.s_query"
                        placeholder="Search"
                      />
                      <button type="submit" class="header__search-btn">
                        <i class="fa-regular fa-magnifying-glass"></i>
                      </button>
                    </div>
                  </form>
                </div>
                <div class="main-menu">
                  <nav id="mobile-menu">
                    <MainMenu />
                  </nav>
                </div>
              </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-5 col-md-6 col-8">
              <div
                class="header__right-wrapper d-flex justify-content-end align-items-center"
              >
                <div
                  class="header__right d-none d-sm-flex justify-content-end align-items-center"
                >
                  <div class="header__notification">
                    <Link :href="route('user.cart.index')">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"
                        />
                      </svg>

                      <span class="notification-count">{{
                        $page.props.cartItems
                      }}</span>
                    </Link>
                  </div>
                  <!-- normal -->
                  <div class="header__wallet-wrapper" id="header__user">
                    <template v-if="authUser">
                      <div class="header__wallet ml-30">
                        <Link
                          href="/account"
                          class="header__wallet-btn"
                          id="connectbtn"
                        >
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125"
                            />
                          </svg>
                          {{ trans("Dashboard") }}
                        </Link>
                      </div>
                      <div class="header__user ml-10">
                        <Link :href="`/profile/${authUser.username}`">
                          <img
                            :src="
                              authUser.avatar
                                ? authUser.avatar
                                : `https://ui-avatars.com/api/?name=${authUser.name}`
                            "
                            alt="avatar"
                          />
                        </Link>
                        <div class="wallet__dropdown tp-wallet-dropdown">
                          <div class="wallet__dropdown-cover">
                            <img
                              :src="
                                authUser.cover_image
                                  ? authUser.cover_image
                                  : `/assets/img/user/user-cover.png`
                              "
                              alt="cover"
                            />
                          </div>
                          <div
                            class="wallet__dropdown-top d-flex align-items-end"
                          >
                            <div class="wallet__dropdown-user mr-15">
                              <img
                                :src="
                                  authUser.avatar
                                    ? authUser.avatar
                                    : `https://ui-avatars.com/api/?name=${authUser.name}`
                                "
                                alt="avatar"
                              />
                            </div>
                            <div class="wallet__dropdown-user-content">
                              <h4>{{ textExcerpt(authUser.name, 20) }}</h4>
                            </div>
                          </div>
                          <div
                            class="wallet__dropdown-id d-flex justify-content-between align-items-center"
                          >
                            <h5>{{ trans('Profile:') }}</h5>
                            <small>
                              {{ textExcerpt(profileLink, 14) }}
                            </small>
                            <button
                              type="button"
                              @click="copyToClipboard(profileLink)"
                            >
                              <svg
                                width="15"
                                height="15"
                                viewBox="0 0 15 15"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                              >
                                <path
                                  d="M5.80388 13.2632H3.5941C1.28115 13.2632 0 11.9967 0 9.68638V3.57677C0 1.27497 1.27255 0 3.5941 0H7.52354C9.83649 0 11.1176 1.26642 11.1176 3.57677C11.1176 3.92761 10.8253 4.21854 10.4728 4.21854C10.1202 4.21854 9.8279 3.92761 9.8279 3.57677C9.8279 1.96808 9.14003 1.28353 7.52354 1.28353H3.5941C1.97762 1.28353 1.28975 1.96808 1.28975 3.57677V9.68638C1.28975 11.2951 1.97762 11.9796 3.5941 11.9796H5.80388C6.15641 11.9796 6.44875 12.2706 6.44875 12.6214C6.44875 12.9722 6.15641 13.2632 5.80388 13.2632Z"
                                  fill="#3771FE"
                                />
                                <path
                                  d="M11.8705 14H9.54195C8.17131 14 7.41211 13.1959 7.41211 11.729V7.84992C7.41211 6.38846 8.16622 5.57895 9.54195 5.57895H11.8705C13.2411 5.57895 14.0003 6.38302 14.0003 7.84992V11.729C14.0003 13.1959 13.2462 14 11.8705 14ZM9.54195 6.39389C8.58403 6.39389 8.17641 6.82852 8.17641 7.84992V11.729C8.17641 12.7504 8.58403 13.1851 9.54195 13.1851H11.8705C12.8284 13.1851 13.236 12.7504 13.236 11.729V7.84992C13.236 6.82852 12.8284 6.39389 11.8705 6.39389H9.54195Z"
                                  fill="#3771FE"
                                  stroke="#3771FE"
                                  stroke-width="0.2"
                                />
                              </svg>
                            </button>
                          </div>
                          <div class="wallet__dropdown-balance">
                            <p>
                              {{ trans('Balance:') }}
                              {{ formatCurrency(authUser.wallet || 0) }}
                            </p>
                          </div>
                          <div class="wallet__dropdown-action">
                            <ul>
                              <li>
                                <Link href="/account/prompt/create">
                                  <i class="fa-regular fa-shopping-bag"></i>
                                  {{ trans('Upload Prompt') }}
                                </Link>
                              </li>
                              <li>
                                <Link href="/generate">
                                  <i class="fa-solid fa-file-image"></i>
                                  {{ trans('AI Generate') }}
                                </Link>
                              </li>
                              <li>
                                <Link :href="`/profile/${authUser.username}`">
                                  <i class="fa-regular fa-user"></i> {{ trans('Profile') }}
                                </Link>
                              </li>
                              <li>
                                <Link href="/dashboard/orders">
                                  <i class="fa-solid fa-bags-shopping"></i> {{ trans('Purchase History') }}
                                </Link>
                              </li>
                              <li>
                                <Link href="/dashboard"
                                  ><i class="fa-regular fa-gear"></i>
                                  {{ trans('Settings') }}
                                </Link>
                              </li>
                              <li>
                                <a href="javascript:void(0)" @click="logout"
                                  ><i
                                    class="fa-regular fa-arrow-right-from-bracket"
                                  ></i>
                                  {{ trans('Logout') }}
                                </a>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </template>
                    <div v-else class="header__wallet ml-30">
                      <Link
                        :href="route('login')"
                        class="header__wallet-btn"
                        id="connectbtn"
                      >
                        {{ trans('Login') }}
                      </Link>
                    </div>
                  </div>
                  <!-- mobile -->
                </div>
                <div
                  class="header__bar d-flex align-items-center ml-10 d-xl-none"
                >
                  <div class="header__notification">
                    <Link :href="route('user.cart.index')">
                      <svg
                        id="header-cart-svg"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"
                        />
                      </svg>

                      <span class="notification-count">{{
                        $page.props.cartItems
                      }}</span>
                    </Link>
                  </div>
                  <button
                    type="button"
                    class="hamurger-btn ml-20"
                    data-bs-toggle="modal"
                    data-bs-target="#offcanvasmodal"
                  >
                    <span></span>
                    <span></span>
                    <span></span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- offcanvas area start -->
  <div class="offcanvas__area">
    <div
      class="modal fade"
      id="offcanvasmodal"
      tabindex="-1"
      aria-labelledby="offcanvasmodal"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="offcanvas__wrapper">
            <div class="offcanvas__content">
              <div
                class="offcanvas__top mb-40 d-flex justify-content-between align-items-center"
              >
                <div class="offcanvas__logo logo">
                  <Link href="/">
                    <img
                      class="logo-black"
                      :src="$page.props.primaryData?.logo_dark"
                      alt="logo"
                    />
                  </Link>
                </div>
                <div class="offcanvas__close">
                  <button
                    class="offcanvas__close-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#offcanvasmodal"
                  >
                    <i class="fal fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="offcanvas__search mb-25">
                <form
                  @submit.prevent="searchPrompt"
                  @keypress.enter="searchPrompt"
                >
                  <input
                    type="text"
                    v-model="form.s_query"
                    placeholder="What are you searching for?"
                  />
                  <button type="submit"><i class="far fa-search"></i></button>
                </form>
              </div>
              <div class="mobile-menu fix mb-40"></div>
              <div class="offcanvas__wallet mb-25 d-sm-none">
                <Link href="/account" class="offcanvas__wallet-btn">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125"
                    />
                  </svg>
                  {{ trans('Dashboard') }}
                </Link>
                &nbsp
                <Link href="/dashboard/orders" class="offcanvas__wallet-btn">
                  <i class="fa-solid fa-bags-shopping"></i>
                  &nbsp
                  {{ trans('My Orders') }}
                </Link>
              </div>

              <div class="offcanvas__contact mt-30 mb-20">
                <h4>{{ trans("Contact Info") }}</h4>
                <ul>
                  <li class="d-flex align-items-center">
                    <div class="offcanvas__contact-icon mr-15">
                      <i class="fal fa-map-marker-alt"></i>
                    </div>
                    <div class="offcanvas__contact-text">
                      {{ $page.props.primaryData?.address }}
                    </div>
                  </li>
                  <li class="d-flex align-items-center">
                    <div class="offcanvas__contact-icon mr-15">
                      <i class="far fa-phone"></i>
                    </div>
                    <div class="offcanvas__contact-text">
                      <a
                        :href="`tel:+${$page.props.primaryData?.contact_phone}`"
                        >{{ $page.props.primaryData?.contact_phone }}</a
                      >
                    </div>
                  </li>
                  <li class="d-flex align-items-center">
                    <div class="offcanvas__contact-icon mr-15">
                      <i class="fal fa-envelope"></i>
                    </div>
                    <div class="offcanvas__contact-text">
                      <a
                        :href="`mailto:${$page.props.primaryData?.contact_email}`"
                      >
                        {{ $page.props.primaryData?.contact_email }}
                      </a>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="offcanvas__social">
                <ul>
                  <li>
                    <a
                      target="_blank"
                      v-for="(social, key) in $page.props.primaryData[
                        'socials'
                      ]"
                      :href="social"
                      :key="key"
                    >
                      <i class="fa-brands" :class="`fa-${key}`"> </i>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- offcanvas area end -->
</template>
