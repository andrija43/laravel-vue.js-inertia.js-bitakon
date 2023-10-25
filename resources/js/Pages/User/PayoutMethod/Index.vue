<template>
  <HeaderSegment title="Supports" :segments="segments" :buttons="buttons" />
  <div class="container-fluid mt--6">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="row d-flex justify-content-between flex-wrap">
          <template v-for="method in methods" :key="method">
            <div class="col">
              <div class="card card-stats">
                <div class="card-body">
                  <h1>{{ method.name }}</h1>
                  <Link :href="route('admin.payout-methods.edit', method.id)"
                    >{{ trans('Edit') }}</Link
                  >
                </div>
              </div>
            </div>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
"use strict";
import AdminLayout from "@/Pages/User/Layout/App.vue";
import HeaderSegment from "@/Pages/User/Layout/HeaderSegment.vue";
import sharedComposable from '@/composables/sharedComposable';

defineOptions({layout: AdminLayout})
const {authUser} = sharedComposable()
const props = defineProps([
'buttons' ,
'segments' ,
'methods'
]);

</script>