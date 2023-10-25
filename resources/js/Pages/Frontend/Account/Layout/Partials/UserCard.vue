<script setup>
"use strict";
import { ref, onMounted } from 'vue'
import sharedComposable from '@/composables/sharedComposable';
const props = defineProps(['user'])
const userMeta = ref(null)
const {textExcerpt} = sharedComposable()
onMounted(() => {
    if (props.user.meta) {
        userMeta.value = JSON.parse(props.user.meta)
    }
})
</script>

<template>
  <div class="col-xxl-3">
    <div class="creator__grid-item mb-30">
      <div class="creator__grid-bg w-img">
        <Link :href="`/profile/${user.username}`">
          <img
            :src="
              user.cover_image
                ? user.cover_image
                : `/assets/img/creator/creator-bg.jpg`
            "
            alt="cover"
          />
        </Link>
      </div>
      <div class="creator__grid-content text-center">
        <div class="creator__grid-thumb">
          <Link :href="`/profile/${user.username}`">
            <img
              :src="
                user.avatar
                  ? user.avatar
                  : `https://ui-avatars.com/api/?name=${user.name}`
              "
              alt="avatar"
            />
          </Link>
        </div>
        <h3 class="creator__grid-title">
          <Link :href="`/profile/${user.username}`">{{ user.name }}</Link>
        </h3>
        <div class="creator__grid-social">
          <template v-if="userMeta?.socials">
            <a
              v-for="(social, key) in userMeta.socials"
              :key="key"
              :href="social"
              target="_blank"
            >
              <i :class="`fa-brands fa-${key}`"></i>
            </a>
          </template>
        </div>
        <p>{{ userMeta?.bio ? textExcerpt(userMeta.bio, 40) : "None" }}</p>
      </div>
    </div>
  </div>
</template>

