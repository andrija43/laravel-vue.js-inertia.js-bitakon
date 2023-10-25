<script setup>
"use strict";
const props = defineProps(['images'])
</script>

<template>
  <div class="col-xxl-7 col-xl-6 col-lg-6">
    <div class="product__details-thumb-grid">
      <div class="row gx-2 gy-2 nft__box-thumb">
        <template v-for="image in images" :key="image">
          <div class="col-sm-6">
            <img v-lazy="image" alt="image" />
          </div>
        </template>
      </div>
    </div>
  </div>
</template>
