<script setup>
"use strict";
import { Head } from '@inertiajs/vue3';
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue";
import AccountLayout from "@/Pages/Frontend/Account/Layout/App.vue";
import PromptCard from "@/Pages/Frontend/Account/Prompt/Partials/PromptCard.vue";
import EmptyMessage from '@/Pages/Frontend/Layout/EmptyMessage.vue';

defineOptions({layout: [FrontendLayout, AccountLayout]})
const props = defineProps(['favorites'])
</script>

<template>
  <Head title="Favorites" />
  <div class="creator__item-wrapper pt-40 pb-120">
    <div class="container">
      <div class="row">
        <div class="col-xxl-12">
          <div class="row">
            <template v-for="favorite in favorites.data" :key="favorite.id">
              <PromptCard :prompt="favorite" />
            </template>
          </div>
          <EmptyMessage
            message="We're sorry, it seems that you don't have any favorite prompt."
            :href="route('prompt.index')"
            btn-text="Let's Browsing"
            v-if="favorites.data.length < 1"
          />
        </div>
      </div>
    </div>
  </div>
</template>