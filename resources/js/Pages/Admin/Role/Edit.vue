<template>  
  <Head title="Edit Admin Role" />
  <HeaderSegment 
  :title="trans('Edit Admin Role')" 
  :segments="segments" 
  :buttons="buttons"
  />

</template>

<script>
"use strict";
import AdminLayout from "@/Pages/Admin/Layout/App.vue";
export default{
layout: AdminLayout
}

</script>

<script setup>
"use strict";
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue";
import { Head } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
const props = defineProps(['segments','buttons']);
</script>