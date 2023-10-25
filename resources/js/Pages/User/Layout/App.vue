<template>
  <!-- Sidenav -->
  <Sidebar />
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <HeaderSection />
    <ValidationErrors />
    <!-- Page content -->
    <slot></slot>
  </div>
</template>
 <script setup>
 "use strict";
 import Sidebar from "@/Pages/User/Layout/Sidebar.vue";
 import HeaderSection from "@/Pages/User/Layout/Headersection.vue";
 import ValidationErrors from '@/components/ValidationErrors.vue';
 </script>