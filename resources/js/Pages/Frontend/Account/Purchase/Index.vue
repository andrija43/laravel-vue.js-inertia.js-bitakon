<script setup>
"use strict";
import { Head } from '@inertiajs/vue3';
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue";
import AccountLayout from "@/Pages/Frontend/Account/Layout/App.vue";
import Card from "@/Pages/Frontend/Account/Purchase/Partials/Card.vue";
import EmptyMessage from '@/Pages/Frontend/Layout/EmptyMessage.vue';
const props = defineProps([
    'orders'
]);
defineOptions({layout: [FrontendLayout, AccountLayout]})

</script>

<template>
  <Head title="Prompt" />
  <div class="creator__item-wrapper pt-40 pb-120">
    <div class="container">
      <div class="row">
        <div v-if="orders.data.length > 0" class="col-xxl-12">
          <Card :orders="orders.data" />
        </div>
       
        <EmptyMessage
          message="We're sorry, it seems that you haven't bought any prompt."
          :href="route('prompt.index')"
          btn-text="Let's Browsing"
          v-if="orders.data.length < 1"
        />
      </div>
    </div>
  </div>
</template>