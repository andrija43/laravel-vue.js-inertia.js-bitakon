<script setup>
"use strict";
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue"
import Slider from "@/Pages/Frontend/HomeTwo/Partials/Slider.vue"
import Collection from "@/Pages/Frontend/HomeTwo/Partials/Collection.vue"
import ProductsWithFilter from "@/Pages/Frontend/HomeTwo/Partials/ProductsWithFilter.vue"
import Cta from "@/Pages/Frontend/HomeTwo/Partials/CallToAction.vue"
import Discount from "@/Pages/Frontend/HomeTwo/Partials/Discount.vue"
import Brands from "@/Pages/Frontend/HomeTwo/Partials/Brands.vue"
import Blog from "@/Pages/Frontend/HomeTwo/Partials/Blog.vue"
import Announcement from "@/Pages/Frontend/Home/Partials/Announcement.vue"

defineOptions({ layout: FrontendLayout })
const props = defineProps(["cta","seo"])
</script>

<template>
  <Seo :metaData="seo" />

  <!-- slider area start -->
  <Slider />

  <!-- collection area start -->
  <Collection />

  <!-- nft area start -->
  <ProductsWithFilter />

  <!-- cta area start -->
  <Cta :cta="cta" />
  <!-- cta area end -->
  <Discount />

  <!-- brand area start -->
  <Brands />
  <!-- brand area end -->

  <!-- blog area start -->
  <Blog />
  <!-- blog area end -->

  <!-- marque text area start -->
  <Announcement />
  <!-- marque text area end -->
</template>
