<template>
  <ul>
    <template v-for="items in mainMenu" :key="items.id">
      <li
        :class="{ 'has-dropdown': item.children?.length > 0 }"
        v-for="item in JSON.parse(items.data)"
        :key="item.id"
      >
        <Link v-if="item.href" :href="item.href" :target="item.target">
          {{ item.text }}
        </Link>

        <template v-if="item.children?.length > 0">
          <NestedComponent :children="item.children" />
        </template>
      </li>
    </template>
  </ul>
</template>

<script setup>
"use strict";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import NestedComponent from "./NestedMenu.vue";
const mainMenu = computed(() => {
    return usePage().props.menus.filter(
        (item) => item.position === "main-menu"
    ) || [];
});
</script>
