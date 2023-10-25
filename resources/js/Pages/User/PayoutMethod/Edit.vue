<template>
  <div class="table-responsive">
    <table class="table align-items-center table-flush">
      <thead class="thead-light">
        <tr>
          <th class="col-6">{{ trans("Translation Key") }}</th>
          <th class="col-6">{{ trans("Translated Value") }}</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="(value, key) in payoutmethod" :key="key">
          <td>
            {{ key }}
          </td>
          <td>
            <input type="text" class="form-control" v-model="posts[key]" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
"use strict";
import AdminLayout from "@/Pages/User/Layout/App.vue";
import sharedComposable from '@/composables/sharedComposable';

defineOptions({layout: AdminLayout})
const {authUser} = sharedComposable()
const props = defineProps([
'buttons' ,
'segments',
'payoutmethod'
]);

</script>
