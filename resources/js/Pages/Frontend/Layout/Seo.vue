<script setup>
"use strict";
import { Head } from '@inertiajs/vue3'

const props = defineProps(["metaData"]);
const site_name = props.metaData.site_name || '';
const current_url = window.location.href;
const keyWords = props.metaData.tags || '';
const metaDescription = props.metaData.description || '';
const metaImage = props.metaData.preview || '';

</script>


<template>
  <Head >
    <title>{{ site_name }}</title>
    <meta name="description" itemprop="description" :content="metaDescription"/>
    <meta name="keywords" :content="keyWords" /> 
    <meta property="og:description"  :content="metaDescription" />
    <meta property="og:title" :content="site_name" />
    <meta property="og:url" :content="current_url" />
    
    <meta property="og:site_name" :content="site_name" />
    <meta property="og:image"   :content="metaImage" />
    <meta property="og:image:url"  :content="metaImage" />
  
    <meta name="twitter:card" :content="metaDescription" />
    <meta name="twitter:title" :content="site_name" />
    
  </Head>
</template>