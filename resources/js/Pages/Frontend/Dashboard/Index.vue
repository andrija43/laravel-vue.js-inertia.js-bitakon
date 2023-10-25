<script setup>
"use strict";
import { Head } from "@inertiajs/vue3";
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue";
import DashboardLayout from "@/Pages/Frontend/Dashboard/Layout/App.vue";
import sharedComposable from "@/composables/sharedComposable";

defineOptions({ layout: [FrontendLayout, DashboardLayout] });
const { authUser, logout } = sharedComposable();
</script>

<template>
  <Head title="Dashboard" />
  <div class="container">
    <div class="create__form pb-120">
      <div class="create__upload base-text">
        <div>
          {{ trans("Hello") }} {{ authUser.name }} ( {{ trans("not") }}
          {{ authUser.name }}?
          <button class="fw-bold" @click="logout">{{ trans("Logout") }}</button
          >)
        </div>
        <div class="mt-10">
          {{ trans(`From your account dashboard you can view your`) }}
          <Link class="fw-bolder" href="/dashboard/orders">
            {{ trans(`Recent orders`) }}
          </Link>
          {{ trans(`and`) }}
          <Link class="fw-bolder" href="/dashboard/change-password">
            {{ trans(`edit your password`) }}
          </Link>
          {{ trans(`and`) }}
          <Link class="fw-bolder" href="/dashboard/info">
            {{ trans(`account details.`) }}</Link
          >
        </div>
      </div>
    </div>
  </div>
</template>
