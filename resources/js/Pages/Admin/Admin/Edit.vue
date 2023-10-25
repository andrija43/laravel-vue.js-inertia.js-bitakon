<template>
  <Head title="Edit Admin" />
     <HeaderSegment 
        :title="trans('Edit Admin')" 
        :segments="segments" 
        :buttons="buttons"
        />
     <div class="container-fluid mt--6">
        <form  @submit.prevent="update" >
           <div class="row">
              <div class="col-lg-5">
                 <strong>{{ trans('Edit Admin') }}</strong>
                 <p>{{ trans('Edit admin profile information') }}</p>
              </div>
              <div class="col-lg-7 card-wrapper">
                 <div class="card">
                    <div class="card-header">
                       <h3 class="mb-0">{{ trans('Edit Admin Details') }}</h3>
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
                          <input type="password" placeholder="Enter password"  v-model="form.password" name="password" class="form-control" id="password"   autocomplete="off">
                          <div class="invalid-feedback text-danger d-block" v-if="form.errors.password">
                             {{ form.errors.password }}
                          </div>
                       </div>
                       <div class="form-group">
                          <label for="password_confirmation">{{ trans('Password') }}</label>
                          <input type="password" placeholder="Confirm Password"  v-model="form.password_confirmation" name="password_confirmation" class="form-control" id="password_confirmation"   autocomplete="off">
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
                       <div class="form-group">
                          <label>{{ trans('Status') }}</label>
                          <select name="status" class="form-control" v-model="form.status">
                             <option value="1"> {{ trans('Active') }}</option>
                             <option value="0"> {{ trans('Deactive') }}</option>
                          </select>
                       </div>
                       <div class="from-group row mt-3">
                          <div class="col-lg-12">
                             <button class="btn btn-neutral submit-button">{{ trans('Update profile') }}</button>
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
  import { Head,useForm,router } from '@inertiajs/vue3';
  import { trans } from 'laravel-vue-i18n';
  import { createToast } from "mosha-vue-toastify";
  const props = defineProps(['segments','buttons','roles','user']);
  
  const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: null,
    password_confirmation: null,
    status: props.user.status,
    roles: props.user.roles[0].name
  });
  
  
  const update = ()=>{
   const url = route('admin.admin.update',props.user.id);
  
   form.put(url,{
        preserveScroll: true,
        onSuccess: () => {
          createToast(
          {
              title: "Congratulations",
              description: "Sub admin profile updated",
          },
          {
              transition: "slide",
              position: "top-right",
          }
        )
        }
    });
  }
</script>