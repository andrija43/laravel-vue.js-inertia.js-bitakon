<script setup>
"use strict";

import FrontendLayout from "@/Pages/Frontend/Layout/App.vue";
import ProfileLayout from "@/Pages/Frontend/Profile/Layout/App.vue";
import UserCard from "@/Pages/Frontend/Profile/Layout/UserCard.vue";
import Paginate from "@/Components/Paginate.vue";
import EmptyMessage from '@/Pages/Frontend/Layout/EmptyMessage.vue';
import ProfileInfo from "@/Pages/Frontend/Profile/Layout/ProfileInfo.vue";
defineOptions({ layout: FrontendLayout });
const props = defineProps([
  "profile",
  "isFollowing",
  "followers",
  "followings",
  "all_followers",
  "seo"
]);
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
          })`,
        }"
      ></div>
    </template>
    <template #profileHeader>
      <ProfileInfo
        :data="profile"
        :isFollowing="isFollowing"
        :followings="followings"
        :followers="followers"
      />
    </template>
    <div class="creator__item-wrapper pt-40 pb-120">
      <div class="container">
        <div class="row">
          <div class="creator__wrapper">
            <div class="row">
              <template v-for="follower in all_followers.data" :key="follower">
                <UserCard :user="follower.follower" />
              </template>
            </div>
          </div>
        </div>
      </div>
      <div
        v-if="all_followers.data.length < 1"
        class="breadcrumb__title text-center"
      >
      <EmptyMessage
              message="This author does not have any followers. Please check back later."
              :href="route('top-sellers.index')"
              btn-text="Visit our authors"
             
            />
      </div>
      <Paginate :links="all_followers.links" />
    </div>
  </ProfileLayout>
</template>
