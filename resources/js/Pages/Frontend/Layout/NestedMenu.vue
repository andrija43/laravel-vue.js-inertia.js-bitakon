<template>
  <ul class="submenu">
    <li
      :class="{ 'has-dropdown': child.children?.length > 0 }"
      v-for="child in children"
      :key="child.id"
    >
      <Link v-if="child.href" :href="child.href" :target="child.target">
        {{ child.text }}
      </Link>
      <template v-if="child.children?.length > 0">
        <NestedComponent :children="child.children" />
      </template>
    </li>
  </ul>
</template>

<script setup>
"use strict";
import NestedComponent from "./NestedMenu.vue";
defineProps({
    children: {
        type: [Array, Object],
    },
});
</script>
