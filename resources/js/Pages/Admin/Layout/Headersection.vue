<template>
  <!-- Top nav -->
  <nav
    class="navbar navbar-top navbar-expand navbar-light bg-secondary border-bottom"
  >
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Search form -->
        <form
          class="navbar-search navbar-search-dark form-inline mr-sm-3"
          id="navbar-search-main"
        ></form>
        <!-- Navbar links -->
        <ul class="navbar-nav align-items-center ml-md-auto">
          <li class="nav-item d-xl-none">
            <!-- Sidenav toggler -->
            <div
              class="pr-3 sidenav-toggler sidenav-toggler-light"
              data-action="sidenav-pin"
              data-target="#sidenav-main"
            >
              <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
              </div>
            </div>
          </li>
        </ul>
        <!-- start -->
        <div class="navbar-nav align-items-center ml-md-auto">
          <div class="card-header-action dropdown">
            <button
              data-toggle="dropdown"
              class="btn btn-neutral btn-sm dropdown-toggle overview-target"
            >
              {{ $page.props.languages[$page.props.locale] }}
            </button>
            <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
              <li v-for="(language, key) in $page.props.languages" :key="key">
                <Link
                  as="button"
                  :href="route('set-locale', key)"
                  method="patch"
                  class="dropdown-item overview-list"
                >
                  {{ trans(language) }}
                </Link>
              </li>
            </ul>
          </div>
        </div>

        <!-- finish -->
        <ul class="navbar-nav align-items-center ml-auto ml-md-0">
          <li class="nav-item dropdown">
            <a
              class="nav-link pr-0"
              href="#"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <img
                    alt="Image placeholder"
                    :src="
                      authUser.avatar == null
                        ? `https://ui-avatars.com/api/?name=${authUser.name}`
                        : `${authUser.avatar}`
                    "
                  />
                </span>
                <div class="media-body ml-2 d-none d-lg-block">
                  <span class="mb-0 text-sm font-weight-bold">{{
                    authUser.name
                  }}</span>
                </div>
              </div>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-header noti-title">
                <h6 class="text-overflow m-0">{{ trans('Welcome!') }}</h6>
              </div>
              <Link
                :href="route('admin.profile.setting')"
                class="dropdown-item"
              >
                <i class="ni ni-single-02"></i>
                <span>{{ trans('My profile') }}</span>
              </Link>
             
              <div class="dropdown-divider"></div>
              <a
                href="javascript:void(0)"
                @click="logout"
                class="dropdown-item"
              >
                <i class="ni ni-user-run"></i>
                <span>{{ trans('Logout') }}</span>
              </a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Header -->
</template>

<script setup>
"use strict";
import sharedComposable from '@/composables/sharedComposable';

const { authUser, logout } = sharedComposable()
</script>
