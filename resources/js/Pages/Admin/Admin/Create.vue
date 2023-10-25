<template>  
    <Head title="Create Admin" />
    <HeaderSegment 
    :title="trans('Create Admin')" 
    :segments="segments" 
    :buttons="buttons"
    />
    <div class="container-fluid mt--6"> 
    <form  @submit.prevent="form.post(route('admin.admin.store'))" >
	
	<div class="row">
		<div class="col-lg-5">
			<strong>{{ trans('Create Admin') }}</strong>
			<p>{{ trans('add admin profile information') }}</p>
		</div>
		<div class="col-lg-7 card-wrapper">
			<!-- Alerts -->
			<div class="card">
				<div class="card-header">
					<h3 class="mb-0">{{ trans('Create Admin') }}</h3>
				</div>
				<div class="card-body">
					<div class="form-group">
							<label for="name">{{ trans('Name')  }}</label>
							<input type="text" placeholder="Enter Name" v-model="form.name" class="form-control" id="name" required=""  autocomplete="off">
                            <div class="invalid-feedback text-danger d-block" v-if="form.errors.name">
                                {{ form.errors.name }}
                            </div>
						</div>
						<div class="form-group">
							<label for="email">{{ trans('Email') }}</label>
							<input type="email" placeholder="Enter Email"  v-model="form.email" name="email" class="form-control" id="email" required=""  autocomplete="off">
                            <div class="invalid-feedback text-danger d-block" v-if="form.errors.email">
                                {{ form.errors.email }}
                            </div>
                        </div>
						<div class="form-group">
							<label for="password">{{ trans('Password') }}</label>
							<input type="password" placeholder="Enter password"  v-model="form.password" name="password" class="form-control" id="password" required=""  autocomplete="off">
                            <div class="invalid-feedback text-danger d-block" v-if="form.errors.password">
                                {{ form.errors.password }}
                            </div>
                        </div>
						<div class="form-group">
							<label for="password_confirmation">{{ trans('Password') }}</label>
							<input type="password" placeholder="Confirm Password"  v-model="form.password_confirmation" name="password_confirmation" class="form-control" id="password_confirmation" required=""  autocomplete="off">
                            <div class="invalid-feedback text-danger d-block" v-if="form.errors.password_confirmation">
                                {{ form.errors.password_confirmation }}
                            </div>
                        </div>

						<div class="form-group">
							<label >{{ trans('Assign Roles') }}</label>
							<select required  v-model="form.roles" id="roles" class="form-control">
								
								<option v-for="role in roles" :key="role.id" :value="role.name">{{ role.name }}</option>
								
							</select>
                            <div class="invalid-feedback text-danger d-block" v-if="form.errors.roles">
                                {{ form.errors.roles }}
                            </div>
						</div>
					<div class="from-group row mt-3">
						<div class="col-lg-12">
							<button class="btn btn-neutral submit-button">{{ trans('Create') }}</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
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
import { Head,useForm } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
const props = defineProps(['segments','buttons','roles']);

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    roles: null,
});
</script>