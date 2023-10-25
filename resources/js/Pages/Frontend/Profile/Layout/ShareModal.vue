<template>
  <div
    class="share__modal modal fade"
    id="sharemodal"
    tabindex="-1"
    aria-labelledby="sharemodal"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="share__modal-content text-center">
          <div class="share__nft-content">
            <div class="share__thumb">
              <img v-lazy="avatar ? avatar : `https://ui-avatars.com/api/${name}`" alt="avatar" />
            </div>
          </div>
          <div class="share__social">
            <h3>{{ trans('Share this Profile') }}</h3>
            <a :href="`https://www.facebook.com/sharer/sharer.php?u=${url}`" target="_blank"
              ><i class="fa-brands fa-facebook-f"></i
            ></a>
            <a :href="`https://twitter.com/intent/tweet?url=${url}`" target="_blank"
              ><i class="fa-brands fa-twitter"></i
            ></a>
            <a :href="`https://www.linkedin.com/sharing/share-offsite/?url=${url}`" target="_blank"
              ><i class="fa-brands fa-linkedin-in"></i
            ></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
"use strict";
const props = defineProps(['url', 'avatar', 'name'])
</script>
