<script setup>
"use strict";

import FrontendLayout from "@/Pages/Frontend/Layout/App.vue"
import Slider from "@/Pages/Frontend/HomeThree/Partials/Slider.vue"
import Process from "@/Pages/Frontend/HomeThree/Partials/Process.vue"
import Trading from "@/Pages/Frontend/HomeThree/Partials/Trending.vue"
import Creator from "@/Pages/Frontend/HomeThree/Partials/Creator.vue"
import Collection from "@/Pages/Frontend/HomeThree/Partials/Collection.vue"
import CallToAction from "@/Pages/Frontend/HomeThree/Partials/CallToAction.vue"
defineOptions({ layout: FrontendLayout })
const props = defineProps(["cta","seo"])
</script>

<template>
  <Seo :metaData="seo" />

  <!-- slider area start -->
  <Slider />
  <!-- Process -->
  <Process />
  <!-- Trading -->
  <Trading />
  <!-- Creator -->
  <Creator />
  <!-- collection -->
  <Collection />
  <!-- cta area -->
  <CallToAction :cta="cta" />
</template>
