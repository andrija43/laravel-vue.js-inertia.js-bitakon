<template>  
    <Head title="SEO Settings" />
    <HeaderSegment 
    :title="trans('SEO Settings')" 
    :segments="segments" 
    :buttons="buttons"
    />
  <div class="container-fluid mt--6"> 
    <div class="row">
	<div class="col">
		<div class="card">
			<!-- Card header -->
			<div class="card-header border-0">
				<h3 class="mb-0">{{ trans('SEO List') }}</h3>
			</div>
			<!-- Light table -->
			<div class="table-responsive">
				<table class="table align-items-center table-flush">
					<thead class="thead-light">
						<tr>
							<th class="col-2">{{ trans('Page') }}</th>
							<th class="col-2">{{ trans('Meta Title') }}</th>							
							<th class="col-8 text-right">{{ trans('Action') }}</th>
						</tr>
					</thead>					
						
                    <tbody>
						<tr v-for="seo in posts">
							<td class="text-left">
								{{ seo.key }}
							</td>
							<td class="text-left">
								{{ seo.content.site_name  }}
							</td>
							
							<td class="text-right">
								<Link :href="route('admin.seo.edit',seo.id)" class="btn btn-neutral btn-sm"><i class="fas fa-edit"></i></Link>
							</td>
						</tr>
						
					</tbody>
				</table>				
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
import { Head, Link } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
const props = defineProps(['segments','buttons','posts']);
</script>