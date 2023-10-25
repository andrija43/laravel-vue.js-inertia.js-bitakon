<template>
  <Head :title="title || ''" />
  <div class="header pb-6">
    <div class="container-fluid">
      <div class="header-body">
        <div class="row align-items-center py-4">
          <div class="col-lg-6 col-7">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
              <ol class="breadcrumb breadcrumb-links">
                <li class="breadcrumb-item">
                  <a href="/login"><i class="fas fa-home"></i></a>
                </li>

                <li v-if="title != null" class="breadcrumb-item">
                  <a href="#">{{ title }}</a>
                </li>
                <template v-if="segments != null">
                  <li
                    v-for="segment in segments"
                    :key="segment.index"
                    class="breadcrumb-item"
                    aria-current="page"
                  >
                    <a href="#">{{ segment }}</a>
                  </li>
                </template>
              </ol>
            </nav>
          </div>
          <template v-if="buttons != null">
            <div class="col-lg-6 col-5 text-right">
              <template v-for="button in buttons" :key="button.index">
                <Link
                  v-if="button.url != '#'"
                  :href="button.url"
                  class="btn btn-sm btn-neutral"
                  preserve-scroll
                >
                  <div v-html="button.name"></div>
                </Link>

                <a
                  v-else
                  @click="(e) => e.preventDefault()"
                  data-toggle="modal"
                  :data-target="button.target"
                  href="#"
                  class="btn btn-sm btn-neutral"
                >
                  <div v-html="button.name"></div>
                </a>
              </template>
            </div>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
"use strict";
import { Link, Head } from '@inertiajs/vue3'

defineProps(['title','segments','buttons'])
</script>