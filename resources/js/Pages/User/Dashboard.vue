<template>
    <HeaderSegment :title="trans('Dashboard')" :segments="segments" :buttons="buttons" />
    <div class="container-fluid mt--6">{{ trans('dashboard') }}</div>

    <template v-if="success">
        <div class="col-sm-12">
            <div class="alert bg-gradient-success text-white alert-dismissible fade show success-alert" role="alert">
                <span class="alert-icon">
                    <img src="/uploads/firework.png" alt="image" />
                </span>
                <span class="alert-text"><strong>{{ trans("Congratulations ") }}</strong>
                    {{ success }}</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        </div>
    </template>

    <template v-if="usePage().props['saasError']">
        <div class="col-sm-12">
            <div class="alert bg-gradient-primary text-white alert-dismissible fade show" role="alert">
                <a :href="user.plan_id == null
                    ? '/user/subscription'
                    : '/user/subscription/' + user.plan_id
                    ">
                    <span class="alert-icon"><i class="fi fi-rs-info text-white"></i></span>
                </a>
                <span class="alert-text">
                    <strong>{{ trans("!Opps ") }}</strong>
                    <a class="text-white" :href="user.plan_id == null
                        ? '/user/subscription'
                        : '/user/subscription/' + user.plan_id
                        ">
                        {{ usePage().props['saasError'] }}
                    </a>
                </span>
            </div>
        </div>
    </template>
</template>

<script setup>
"use strict";
import AdminLayout from "@/Pages/User/Layout/App.vue";
import HeaderSegment from "@/Pages/User/Layout/HeaderSegment.vue";
import { usePage } from '@inertiajs/vue3';
defineOptions({ layout: AdminLayout });
const props = defineProps([
    "segments",
    "buttons",
    "sassError",
    "user",
    "success",
]);
</script>
