<template>  
    <Head title="Cron Jobs" />
    <HeaderSegment 
    :title="trans('Cron Jobs')" 
    :segments="segments" 
    :buttons="buttons"
    />
  <div class="container-fluid mt--6"> 
    <div class="row" v-for="job in jobs" :key="job.key">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4>{{ job.title }}</h4>
			</div>
			<div class="card-body">
				<div class="code"><p class="text-white"> {{ job.url }}</p></div>
				<br>
				<strong>{{ job.time }}</strong>
			</div>
		</div>
	</div>
</div>

  </div>    
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
const props = defineProps(['segments','buttons','jobs']);
</script>