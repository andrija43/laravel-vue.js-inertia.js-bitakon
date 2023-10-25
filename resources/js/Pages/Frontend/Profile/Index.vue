<script setup>
"use strict";
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue"
import ProfileLayout from "@/Pages/Frontend/Profile/Layout/App.vue"
import ProfileInfo from "@/Pages/Frontend/Profile/Layout/ProfileInfo.vue"
import Paginate from "@/Components/Paginate.vue"
import PromptCard from "@/Pages/Frontend/Prompt/Partials/PromptCard.vue"
import EmptyMessage from "@/Pages/Frontend/Layout/EmptyMessage.vue"
defineOptions({ layout: FrontendLayout })

const props = defineProps([
  "profile",
  "isFollowing",
  "followers",
  "followings",
  "prompts",
  "seo"
])
</script>

<template>
   <Seo :metaData="seo" />
  <ProfileLayout>
    <template #creatorBanner>
      <div
        class="creator__banner include-bg"
        :style="{
          backgroundImage: `url(${
            profile.cover_image
              ? profile.cover_image
              : '/assets/img/create/create-bg.jpg'
          })`
        }"
      ></div>
    </template>
    <!-- profile header -->
    <template #profileHeader>
      <ProfileInfo
        :data="profile"
        :isFollowing="isFollowing"
        :followings="followings"
        :followers="followers"
      />
    </template>

    <!-- profile data -->

    <div class="creator__item-wrapper pt-40 pb-120">
      <div class="container">
        <div class="row">
          <div v-if="prompts.data.length < 1" class="col-sm-12">
            <EmptyMessage
              message="This profile doesn't have any prompts."
              :href="route('prompt.index')"
              btn-text="Explore new prompts"
            />
          </div>
          <div class="col-xxl-12">
            <div class="row">
              <template v-for="prompt in prompts.data" :key="prompt.id">
                <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6">
                  <PromptCard :prompt="prompt" />
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>
      <Paginate :links="prompts.links" />
    </div>
  </ProfileLayout>
</template>
