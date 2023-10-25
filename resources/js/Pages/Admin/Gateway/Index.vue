<template>  
    <Head title="Dashboard" />
    <HeaderSegment 
      :title="trans('Payment Gateways')" 
      :segments="segments" 
      :buttons="buttons"
      />
  <div class="container-fluid mt--6"> 
    <div class="row d-flex justify-content-between flex-wrap">
	<div class="col">
		<div class="card card-stats">
			<div class="card-body">
				<div class="row">
					<div class="col">
						<span class="h2 font-weight-bold mb-0 total-transfers" id="total-device">
							{{ totalGateways }}
						</span>
					</div>
					<div class="col-auto">
						<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
							<i class="fi fi-rs-bank mt-2"></i>
						</div>
					</div>
				</div>
				<p class="mt-3 mb-0 text-sm">
				</p><h5 class="card-title  text-muted mb-0">{{ trans('Total Gateways') }}</h5>
				<p></p>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card card-stats">
			<div class="card-body">
				<div class="row">
					<div class="col">
						<span class="h2 font-weight-bold mb-0 total-transfers" id="total-active">
							{{ active_gateway }}
						</span>
					</div>
					<div class="col-auto">
						<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
							<i class="fi  fi-rs-badge-check mt-2"></i>
						</div>
					</div>
				</div>
				<p class="mt-3 mb-0 text-sm">
				</p><h5 class="card-title  text-muted mb-0">{{ ('Active Gateways') }}</h5>
				<p></p>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card card-stats">
			<div class="card-body">
				<div class="row">
					<div class="col">
						<span class="h2 font-weight-bold mb-0 completed-transfers" id="total-inactive">
							{{ inactive_gateway }}
						</span>
					</div>
					<div class="col-auto">
						<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
							<i class="fi fi-rs-delete-document mt-2"></i>
						</div>
					</div>
				</div>
				<p class="mt-3 mb-0 text-sm">
				</p><h5 class="card-title  text-muted mb-0">{{ trans('Inactive Gateways') }}</h5>
				<p></p>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col">
		<div class="card">
			<!-- Card header -->
			<div class="card-header border-0">
				<h3 class="mb-0">{{ trans('Gateways') }}</h3>
			</div>
			<!-- Light table -->
			<div class="table-responsive">
				<table class="table align-items-center table-flush">
					<thead class="thead-light">
						<tr>
							<th scope="col" class="sort col-3" >{{ trans('Name') }}</th>
							<th scope="col" class="sort col-1 text-right">{{ trans('Minimum Amount') }}</th>
							<th scope="col" class="sort col-1 text-right">{{ trans('Maximum Amount') }}</th>
							<th scope="col" class="sort col-1 text-right">{{ trans('Charge') }}</th>
							<th scope="col" class="sort col-1 text-right">{{ trans('Currency') }}</th>
							<th scope="col" class="sort col-1 text-right">{{ trans('Gateway Status') }}</th>
							<th scope="col" class="sort col-2 text-right">{{ trans('Payment Mode') }}</th>
							<th scope="col" class="sort col-2 text-right">{{ trans('Edit') }}</th>
						</tr>
					</thead>
					<tbody class="list">
						
						<tr v-for="gateway in gateways" :key="gateways.id">
							<th scope="row">
								<div class="media align-items-center">
									
									<Link v-if="gateway.logo != null" :href="'/admin/gateways/'+gateway.id+'/edit'" class="avatar rounded-square mr-3">
										<img alt="" :src=" gateway.logo ">
									</Link>
									
									<div class="media-body">
										<span class="name mb-0 text-sm">{{ gateway.name }}</span>
									</div>
								</div>
							</th>
							<td class="text-center">{{ number_format(gateway.min_amount,2) }}</td>
							<td class="text-center">{{ number_format(gateway.max_amount,2) }}</td>
							<td class="text-right">{{ gateway.charge }} {{ gateway.currency != null ? gateway.currency : '' }}</td>
							<td class="text-right">{{ gateway.currency }}</td>
							<td class="text-center">
								<span class="badge badge-dot text-right">
									<i :class=" gateway.status == 1 ? 'bg-success' : 'bg-danger'"></i>
									<span class="status">{{ gateway.status == 1 ? 'Active' : 'Disabled' }}</span>
								</span>
							</td>
							
							<td class="text-right">
								<span class="badge badge-dot ">
									<i :class=" gateway.test_mode == 1 ? 'bg-danger' : 'bg-success' "></i>
									<span class="status">{{ gateway.test_mode == 1 ? 'Sandbox' : 'Live' }}</span>
								</span>
							</td>
							<td class="text-right">
								<Link class="btn btn-sm btn-neutral" :href="'/admin/gateways/'+gateway.id+'/edit'">
									<i class="fas fa-edit"></i>
                                </Link>
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
    layout: AdminLayout,
    components: { Link }
}

</script>

<script setup>
"use strict";
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue";
import { Head, Link } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
const props = defineProps(['gateways','active_gateway','totalGateways','inactive_gateway','segments','buttons']);


function number_format(number, decimals, dec_point, thousands_point) {

if (number == null || !isFinite(number)) {
    throw new TypeError("number is not valid");
}

if (!decimals) {
    var len = number.toString().split('.').length;
    decimals = len > 1 ? len : 0;
}

if (!dec_point) {
    dec_point = '.';
}

if (!thousands_point) {
    thousands_point = ',';
}

number = parseFloat(number).toFixed(decimals);

number = number.replace(".", dec_point);

var splitNum = number.split(dec_point);
splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
number = splitNum.join(dec_point);

return number;
}
</script>