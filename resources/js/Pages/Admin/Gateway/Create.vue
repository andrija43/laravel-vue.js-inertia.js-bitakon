<template>  
    <Head title="Create Payment Gatewa" />
    <HeaderSegment 
      :title="trans('Create Payment Gateway')" 
      :segments="segments" 
      :buttons="buttons"
      />
  <div class="container-fluid mt--6"> 
    <div class="row ">
	<div class="col-lg-5 mt-5">
		<strong>{{ trans('Create Payment Gateway') }}</strong>
		<p>{{ trans('Create manual payment gateway for accepting payment') }}</p>
	</div>
	<div class="col-lg-7 mt-5">
		<form class="ajaxform_instant_reload" @submit.prevent="store" enctype="multipart/form-data">
			
			<div class="card">
				<div class="card-body">
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="name">{{ trans('Gateway Name') }}</label>
						<input v-model="form.name" type="text" :class=" form.errors.name ? 'form-control is-invalid' : 'form-control'" name="name" id="name"  >

                        <div class="invalid-feedback" v-if="form.errors.name">
                          {{ form.errors.name }}
                        </div>
					</div>
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="logo">{{ trans('Logo') }}</label>
						<input type="file" id="logo"  @input="(e) => (form.logo = e.target.files[0])" :class=" form.errors.logo ? 'form-control is-invalid' : 'form-control'" name="logo" accept="image/*">
						<div class="invalid-feedback" v-if="form.errors.logo">
                          {{ form.errors.logo }}
                        </div>						
					</div>
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="currency">{{ trans('Currency') }}</label>
						<input v-model="form.currency" type="text"  :class=" form.errors.currency ? 'form-control is-invalid' : 'form-control'" name="currency" id="currency"  required>
                        <div class="invalid-feedback" v-if="form.errors.currency">
                          {{ form.errors.currency }}
                        </div>	
					</div>
					
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="min_amount">{{ trans('Minimum Amount') }}</label>
						<input v-model="form.min_amount" type="number" name="min_amount" id="min_amount" step="any"   :class=" form.errors.min_amount ? 'form-control is-invalid' : 'form-control'" required>
                        <div class="invalid-feedback" v-if="form.errors.min_amount">
                          {{ form.errors.min_amount }}
                        </div>	
					</div>
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="max_amount">{{ trans('Maximum Amount') }}</label>
						<input v-model="form.max_amount" type="number" name="max_amount" id="max_amount" step="any"   :class=" form.errors.max_amount ? 'form-control is-invalid' : 'form-control'"  required>
                        <div class="invalid-feedback" v-if="form.errors.max_amount">
                          {{ form.errors.max_amount }}
                        </div>
					</div>
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="charge">{{ trans('Gateway Charge') }}</label>
						<input  type="number" step="any" v-model="form.charge"  :class=" form.errors.charge ? 'form-control is-invalid' : 'form-control'" name="charge" id="charge"  required >
                        <div class="invalid-feedback" v-if="form.errors.charge">
                          {{ form.errors.charge }}
                        </div>
					</div>
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="multiply">{{ trans('Multiply from base currency') }}</label>
						<input type="number" step="any" v-model="form.multiply"  :class=" form.errors.multiply ? 'form-control is-invalid' : 'form-control'" name="multiply" id="multiply"  required >
                        <div class="invalid-feedback" v-if="form.errors.multiply">
                          {{ form.errors.multiply }}
                        </div>
					</div>
					
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="status">{{ trans('Payment Instruction') }}</label>
						<textarea v-model="form.comment"  :class=" form.errors.comment ? 'form-control is-invalid' : 'form-control'" maxlength="1000" name="comment"></textarea>
                        <div class="invalid-feedback" v-if="form.errors.comment">
                          {{ form.errors.comment }}
                        </div>
					</div>
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="status">{{ trans('Status') }}</label>
						<select v-model="form.status" class="form-control selectric" name="status" id="status">
							<option value="1" >{{ trans('Active') }}</option>
							<option value="0" >{{ trans('Deactivate') }}</option>
						</select>
                        <div class="invalid-feedback" v-if="form.errors.status">
                          {{ form.errors.status }}
                        </div>
					</div>
					<div class="form-group mb-4">
						<button class="btn btn-neutral submit-button">{{ trans('Update') }}</button>
					</div>	
				</div>
			</div>
		</form>
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
import { useForm } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
const props = defineProps(['segments','buttons']);


const form = useForm({
    name: null,
    logo: null,
    currency: null,
    min_amount: 1,
    max_amount: 10,
    charge: 0,
    multiply: 1,
    comment: null,
    status: 1
});


const store = () =>{
    form.post('/admin/gateways');
}
</script>