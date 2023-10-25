<template>
  <div class="basic-pagination mt-20" v-if="links.length > 3">
    <nav>
      <ul>
        <template v-for="(link, p) in links" :key="p">
          <li>
            <Link v-if="link.url != null" :href="link.url">
              <span :class="{ current: link.active }">
                {{ link.label === "&laquo; Previous" ? "ok" : link.label }}
              </span>
            </Link>
          </li>
        </template>
      </ul>
    </nav>
  </div>
</template>
<script setup>
"use strict";
import { Link } from "@inertiajs/vue3";
const props = defineProps(["links"]);
</script>
