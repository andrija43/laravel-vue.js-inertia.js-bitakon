<template>
  <!-- Sidenav -->
  <Modal />
  <Sidebar />
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Top-nav -->
    <HeaderSection />
    <ValidationErrors />

    <!-- Page content -->
    <slot></slot>
  </div>
</template>
<script setup>
"use strict";
import Sidebar from "@/Pages/Admin/Layout/Sidebar.vue"
import HeaderSection from "@/Pages/Admin/Layout/Headersection.vue"
import ValidationErrors from "@/components/ValidationErrors.vue"
import Modal from "@/components/Modal.vue"
</script>
