<template>
  <nav
    class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white"
    id="sidenav-main"
  >
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header d-flex align-items-center">
        <Link href="/home" :class="'navbar-brand'">
          <img
            src="http://prompt.test/uploads/logo.png"
            class="navbar-brand-img"
            alt="..."
          />
        </Link>
        <div class="ml-auto">
          <!-- Sidenav toggler -->
          <div
            class="sidenav-toggler d-none d-xl-block"
            data-action="sidenav-unpin"
            data-target="#sidenav-main"
          >
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <Link
                class="nav-link"
                :class="{ active: currentRoute('User/Dashboard') }"
                :href="route('user.dashboard.index')"
              >
                <i class="fi fi-rs-dashboard"></i>
                <span class="nav-link-text">{{ trans("Dashboard") }}</span>
              </Link>
            </li>
          </ul>
          <!-- Divider -->

          <h6 class="navbar-heading p-0 text-muted mt-4">
            {{ trans("Settings") }}
          </h6>
          <ul class="navbar-nav mb-md-3">
            <li class="nav-item"></li>
            <li class="nav-item">
              <Link
                :class="{ active: currentRouteGroup('User/Subscription') }"
                class="nav-link"
                href="/user/subscription"
              >
                <i class="ni ni-spaceship"></i>
                <span class="nav-link-text">{{ trans("Subscription") }}</span>
              </Link>
            </li>

            <li class="nav-item">
              <Link
                :class="{ active: currentRouteGroup('User/Support') }"
                class="nav-link"
                href="/user/support"
              >
                <i class="fas fa-headset"></i>
                <span class="nav-link-text">{{ trans("Help & Support") }}</span>
              </Link>
            </li>

            <li class="nav-item">
              <Link class="nav-link" :href="route('user.payout-methods.index')">
                <i class="fi fi-rs-calendar-clock"></i>
                <span class="nav-link-text">{{ trans("Payout Methods") }}</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link
                :class="{ active: currentRouteGroup('User/Profile') }"
                class="nav-link"
                href="/user/profile"
              >
                <i class="ni ni-settings-gear-65"></i>
                <span class="nav-link-text">{{
                  trans("Profile Settings")
                }}</span>
              </Link>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="javascript:void(0)" @click="logout">
                <i class="ni ni-button-power"></i>
                <span class="nav-link-text">{{ trans("Logout") }}</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
"use strict";
import { Link } from '@inertiajs/vue3'
import sharedComposable from '@/composables/sharedComposable';

const { currentRoute, currentRouteGroup, logout } = sharedComposable()
</script>