<script setup>
"use strict";
import { Head } from '@inertiajs/vue3';
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue";
import EmptyMessage from '@/Pages/Frontend/Layout/EmptyMessage.vue';
import Paginate from "@/Components/Paginate.vue";
import AccountLayout from "@/Pages/Frontend/Account/Layout/App.vue";
import PromptCard from "@/Pages/Frontend/Account/Prompt/Partials/PromptCard.vue";

defineOptions({layout: [FrontendLayout, AccountLayout]})
const props = defineProps(['prompts','activePrompts', 'pendingPrompts', 'disabledPrompts'])

</script>

<template>
  <Head title="Prompt" />
  <div class="creator__item-wrapper pt-40 pb-120">
    <div class="container">
      <div class="row">
        <div class="col-sm-4">
          <div class="contact__info-item d-flex align-items-center">
            <div class="contact__icon mr-15">
              <span>
                <img src="/assets/img/check.png" height="40" alt="img" />
              </span>
            </div>
            <div class="contact__text">
              <p>{{ trans("Total Active Prompts") }}</p>
              <h4>
                <a>{{ activePrompts }}</a>
              </h4>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="contact__info-item d-flex align-items-center">
            <div class="contact__icon mr-15 contact-discord">
              <span>
                <img src="/assets/img/pending.png" height="40" alt="img" />
              </span>
            </div>
            <div class="contact__text">
              <p>{{ trans("Total Pending Prompts") }}</p>
              <h4>
                <a>{{ pendingPrompts }}</a>
              </h4>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="contact__info-item d-flex align-items-center">
            <div class="contact__icon mr-15 contact-location">
              <span>
                <img src="/assets/img/cancel.png" height="40" alt="img" />
              </span>
            </div>
            <div class="contact__text">
              <p>{{ trans("Total Disabled Prompts") }}</p>
              <h4>
                <a>{{ disabledPrompts }}</a>
              </h4>
            </div>
          </div>
        </div>
      </div>

      <div class="row mb-4 mt-20">
        <div class="product__details-info-bottom rounded pt-3 pb-3">
          <div
            class="product__details-bid d-sm-flex align-items-center justify-content-between"
          >
            <div class="tt-page-title">
              <h3 class="base-text mt-2">{{ trans("Prompts") }}</h3>
            </div>
            <div class="tt-action">
              <Link
                :href="route('user.prompt.create')"
                class="header__wallet-btn ms-2"
              >
                <i class="fa fa-plus" aria-hidden="true"></i>

                {{ trans("Create prompt") }}
              </Link>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xxl-12">
          <div class="row">
            <template v-for="prompt in prompts.data" :key="prompt.id">
              <PromptCard :prompt="prompt" />
            </template>
            <EmptyMessage
              message="We're sorry, it seems that you don't have any prompt in your account at the moment."
              :href="route('user.prompt.create')"
              btn-text="Let's Create a Prompt"
              v-if="prompts.data.length < 1"
            />
          </div>
        </div>
      </div>

      <Paginate :links="prompts.links" />
    </div>
  </div>
</template>