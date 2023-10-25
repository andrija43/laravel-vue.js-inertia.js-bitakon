<template>
  <div v-if="links.length > 3">
    <div class="paginate-container">
      <template v-for="(link, key) in links">
        <div
          v-if="link.url === null"
          :key="key"
          class="paginate-link paginate-link-null"
          v-html="link.label"
        ></div>
        <Link
          v-else
          :key="`link-${key}`"
          class="paginate-link paginate-link-active"
          :class="{ 'paginate-link-active-bg': link.active }"
          :href="link.url"
        >
          <span v-html="link.label"></span>
        </Link>
      </template>
    </div>
  </div>
</template>

<script setup>
"use strict";

defineProps({links: Array})
</script>