<script setup>
"use strict";
import { Head } from "@inertiajs/vue3"
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue"
defineOptions({ layout: FrontendLayout })
</script>

<template>
  <Head title="Thank You" />

  <!-- content -->
  <div class="container">
    <div class="create__form pt-55 pb-120">
      <div class="create__upload text-center confetti">
        <img
          class="light w-25"
          src="/assets/img/confetti.gif"
          alt="congratulations"
        />
        <img
          class="dark w-25"
          src="/assets/img/dark-confetti.gif"
          alt="congratulations"
        />
        <p class="base-text">
          {{ trans("Congratulations Your Order Successfully Submitted!") }}
        </p>
        <Link href="/dashboard/orders" class="header__wallet-btn mt-10">
          {{ trans("View Orders") }}
        </Link>
      </div>
    </div>
  </div>
</template>
