<script setup>
"use strict";

import { computed } from 'vue'
const props = defineProps({
  errors: {
    required: true,
  },
})
const hasErrors = computed(() => Object.keys(props.errors).length > 0)
const formatErrorMessage = (error) => {
    const message = error.$message;
    const propertyName = error.$property.replace(/[.,_]/g, " ");
    const replacement = error.$message.includes("value") ? "value" : "Value";
    
    return message.replace(replacement, propertyName);
  }
</script>

<template>
  <div v-if="hasErrors">
    <p class="text-danger" v-for="(error, key) in errors" :key="key">
      {{ formatErrorMessage(error) }}
    </p>
  </div>
</template>