<script setup>
"use strict";
import LoginModal from '@/Pages/Auth/LoginModal.vue'
import sharedComposable from '@/composables/sharedComposable'
import { router } from '@inertiajs/vue3'
import { share } from '@/composables/shareComposable'

const props = defineProps(['data', 'isFollowing', 'followers', 'followings'])
const { authUser, currentRoute, ToastAlert, copyToClipboard } = sharedComposable()
const host = window.location.origin
const profileLink = host + '/profile/' + props.data.username
const following = () => {
  if (authUser && authUser.id === props.data.id) {
    return
  }
  router.post(
    route('user.following'),
    { id: props.data.id },
    {
      onSuccess: () => {
        ToastAlert(
          props.isFollowing ? 'Followed' : 'Unfollowed',
          `${props.isFollowing ? 'Followed' : 'Unfollowed'} Successfully`
        )
      }
    }
  )
}
</script>

<template>
  <LoginModal />
  <div class="creator__user-thumb">
    <img
      lazy="loading"
      v-lazy="data.avatar ? data.avatar : `https://ui-avatars.com/api/?name=${data.name}`"
      alt="avatar"
    />
  </div>
  <h3 class="creator__user-title">{{ data.name }}</h3>
  <div class="creator__user-copyright d-inline-block">
    <div class="creator__user-copyright-inner d-flex align-items-center">
      <div class="creator__user-copyright-icon">
        <i class="fa-regular fa-magnifying-glass"></i>
      </div>
      <div class="creator__user-copyright-text">
        <span>{{ data.username }}</span>
        <button type="button" class="ml-10" @click="copyToClipboard(profileLink)">
          <svg
            width="15"
            height="15"
            viewBox="0 0 15 15"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <g opacity="0.6">
              <path
                d="M5.80388 13.2632H3.5941C1.28115 13.2632 0 11.9967 0 9.68638V3.57677C0 1.27497 1.27255 0 3.5941 0H7.52354C9.83649 0 11.1176 1.26642 11.1176 3.57677C11.1176 3.92761 10.8253 4.21854 10.4728 4.21854C10.1202 4.21854 9.8279 3.92761 9.8279 3.57677C9.8279 1.96808 9.14003 1.28353 7.52354 1.28353H3.5941C1.97762 1.28353 1.28975 1.96808 1.28975 3.57677V9.68638C1.28975 11.2951 1.97762 11.9796 3.5941 11.9796H5.80388C6.15641 11.9796 6.44875 12.2706 6.44875 12.6214C6.44875 12.9722 6.15641 13.2632 5.80388 13.2632Z"
                fill="white"
              />
              <path
                d="M11.8705 14H9.54195C8.17131 14 7.41211 13.1959 7.41211 11.729V7.84992C7.41211 6.38846 8.16622 5.57895 9.54195 5.57895H11.8705C13.2411 5.57895 14.0003 6.38302 14.0003 7.84992V11.729C14.0003 13.1959 13.2462 14 11.8705 14ZM9.54195 6.39389C8.58403 6.39389 8.17641 6.82852 8.17641 7.84992V11.729C8.17641 12.7504 8.58403 13.1851 9.54195 13.1851H11.8705C12.8284 13.1851 13.236 12.7504 13.236 11.729V7.84992C13.236 6.82852 12.8284 6.39389 11.8705 6.39389H9.54195Z"
                fill="white"
                stroke="white"
                stroke-width="0.2"
              />
            </g>
          </svg>
        </button>
      </div>
    </div>
  </div>
  <div class="creator__follow">
    <p>
      <span>{{ followers }}</span> {{ trans('followers') }}
    </p>
    <p>
      <span>{{ followings }}</span> {{ trans('following') }}
    </p>
  </div>
  <template v-if="authUser && authUser.id === data.id">
    <div class="creator__action">
      <ul>
        <li>
          <Link href="/dashboard"> {{ trans('Edit Profile') }} </Link>
        </li>
      </ul>
    </div>
  </template>
  <template v-else>
    <div class="creator__action">
      <ul>
        <li>
          <template v-if="!authUser">
            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#loginmodal">
              {{ trans('Follow') }}
            </a>
          </template>
          <template v-else>
            <a href="javascript:void(0)" @click="following">
              {{ isFollowing ? 'Unfollow' : 'Follow' }}
            </a>
          </template>
        </li>

        <li>
          <a
            href="javascript:void"
            @click="
              share.setItem(
                data.avatar ? data.avatar : `https://ui-avatars.com/api/?name=${data.name}`,
                data.name,
                '/profile/'
              )
            "
            data-bs-toggle="modal"
            data-bs-target="#sharemodal"
          >
            {{ trans('Share') }}
          </a>
        </li>
      </ul>
    </div>
  </template>
  <div class="creator__tab">
    <nav>
      <div class="nav nav-tabs justify-content-md-center" id="nav-tab" role="tablist">
        <Link
          :href="`/profile/${data.username}`"
          :class="{ active: currentRoute('Frontend/Profile/Index') }"
          class="nav-link"
        >
          {{ trans('Prompt') }}
        </Link>
        <Link
          :href="`/profile/${data.username}/collection`"
          :class="{
            active: currentRoute('Frontend/Profile/Collection/Index')
          }"
          class="nav-link"
        >
          {{ trans('Collection') }}
        </Link>
        <Link
          :href="`/profile/${data.username}/followers`"
          :class="{
            active: currentRoute('Frontend/Profile/Follower/Index')
          }"
          class="nav-link"
        >
          {{ trans('Followers') }}
        </Link>
        <Link
          :href="`/profile/${data.username}/followings`"
          :class="{
            active: currentRoute('Frontend/Profile/Following/Index')
          }"
          class="nav-link"
        >
          {{ trans('Followings') }}
        </Link>
      </div>
    </nav>
  </div>
</template>
