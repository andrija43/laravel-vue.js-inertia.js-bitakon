<script setup>
"use strict";

import FrontendLayout from "@/Pages/Frontend/Layout/App.vue"
import ProfileLayout from "@/Pages/Frontend/Profile/Layout/App.vue"
import UserCard from "@/Pages/Frontend/Profile/Layout/UserCard.vue"
import Paginate from "@/Components/Paginate.vue"
import ProfileInfo from "@/Pages/Frontend/Profile/Layout/ProfileInfo.vue"
import EmptyMessage from "@/Pages/Frontend/Layout/EmptyMessage.vue"
defineOptions({ layout: FrontendLayout })
const props = defineProps([
  "profile",
  "isFollowing",
  "followers",
  "followings",
  "all_followings",
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
              <template
                v-for="following in all_followings.data"
                :key="following"
              >
                <UserCard :user="following.user" />
              </template>
            </div>
          </div>
        </div>
      </div>
      <div
        v-if="all_followings.data.length < 1"
        class="breadcrumb__title text-center"
      >
        <EmptyMessage
          message="This author does not follow anyone currently. Please check back later."
          :href="route('top-sellers.index')"
          btn-text="Visit our authors"
        />
      </div>
      <Paginate :links="all_followings.links" />
    </div>
  </ProfileLayout>
</template>
