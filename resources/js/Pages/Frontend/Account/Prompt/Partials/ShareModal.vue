<script setup>
"use strict";
import { computed } from 'vue'
import { share } from "@/composables/shareComposable";

const shareLink = computed(() => window.location.origin + share.prefix + share.link)
</script>

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
              <img :src="share.preview" alt="preview" />
            </div>
          </div>
          <div class="share__social">
            <h3>{{ trans('Share this') }} {{ share.prefix.split("/")[1] }}</h3>
            <a
              :href="`https://www.facebook.com/sharer/sharer.php?u=${shareLink}`"
              target="_blank"
              ><i class="fa-brands fa-facebook-f"></i
            ></a>
            <a
              :href="`https://twitter.com/intent/tweet?url=${shareLink}`"
              target="_blank"
              ><i class="fa-brands fa-twitter"></i
            ></a>
            <a
              :href="`https://www.linkedin.com/sharing/share-offsite/?url=${shareLink}`"
              target="_blank"
              ><i class="fa-brands fa-linkedin-in"></i
            ></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

