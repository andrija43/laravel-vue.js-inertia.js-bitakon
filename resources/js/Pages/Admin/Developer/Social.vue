<template>
    <Head title="Social Login Settings" />
       <HeaderSegment 
          :title="trans('Social Auth Settings')" 
          :segments="segments" 
          :buttons="buttons"
          />
       <div class="container-fluid mt--6">
          <div class="row ">
             <div class="col-lg-5 mt-5">
                <strong>{{ trans('Login With Gmail') }}</strong>
                <p>{{ trans('Edit API settings for customers can register with Google') }}</p>
             </div>
             <div class="col-lg-7 mt-5">
                <form class="ajaxform" @submit.prevent="update('google')">
                   <div class="card">
                      <div class="card-body">
                         <div class="from-group row mt-2">
                            <label class="col-lg-12">{{ trans('GOOGLE CLIENT ID:') }}</label>
                            <div class="col-lg-12">
                               <input type="text"  class="form-control" v-model="googleForm.GOOGLE_CLIENT_ID">
                            </div>
                         </div>
                         <div class="from-group row mt-2">
                            <label class="col-lg-12">{{ trans('GOOGLE CLIENT SECRET: ') }}</label>
                            <div class="col-lg-12">
                               <input type="text"  class="form-control" v-model="googleForm.GOOGLE_CLIENT_SECRET">
                            </div>
                         </div>
                         <div class="from-group row mt-2">
                            <label class="col-lg-12">{{ trans('APP redirection url') }}</label>
                            <span class="text-primary ml-3 mt-1">{{ GOOGLE_REDIRECT_URL }}</span>
                         </div>
                         <div class="from-group row mt-3">
                            <div class="col-lg-12">
                               <button class="btn btn-neutral submit-button btn-sm float-left" >{{ trans('Update Settings') }}</button>
                            </div>
                         </div>
                      </div>
                   </div>
                </form>
             </div>
          </div>

          <div class="row ">
             <div class="col-lg-5 mt-5">
                <strong>{{ trans('Login With Facebook') }}</strong>
                <p>{{ trans('Edit API settings for customers can register with Facebook') }}</p>
             </div>
             <div class="col-lg-7 mt-5">
                <form class="ajaxform" @submit.prevent="update('facebook')">
                   <div class="card">
                      <div class="card-body">
                         <div class="from-group row mt-2">
                            <label class="col-lg-12">{{ trans('FACEBOOK CLIENT ID:') }}</label>
                            <div class="col-lg-12">
                               <input type="text"  class="form-control" v-model="facebookForm.FACEBOOK_CLIENT_ID">
                            </div>
                         </div>
                         <div class="from-group row mt-2">
                            <label class="col-lg-12">{{ trans('FACEBOOK CLIENT SECRET: ') }}</label>
                            <div class="col-lg-12">
                               <input type="text"  class="form-control" v-model="facebookForm.FACEBOOK_CLIENT_SECRET">
                            </div>
                         </div>
                         <div class="from-group row mt-2">
                            <label class="col-lg-12">{{ trans('APP redirection url') }}</label>
                            <span class="text-primary ml-3 mt-1">{{ FACEBOOK_REDIRECT_URL }}</span>
                         </div>
                         <div class="from-group row mt-3">
                            <div class="col-lg-12">
                               <button class="btn btn-neutral submit-button btn-sm float-left">{{ trans('Update Settings') }}</button>
                            </div>
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
    import { Head,useForm } from '@inertiajs/vue3';
    import { createToast } from "mosha-vue-toastify"
    import { trans } from 'laravel-vue-i18n';
    
    const props = defineProps([
          'id',
          'GOOGLE_CLIENT_ID',
          'GOOGLE_CLIENT_SECRET',
          'GOOGLE_REDIRECT_URL',
          'FACEBOOK_CLIENT_ID',
          'FACEBOOK_CLIENT_SECRET',
          'FACEBOOK_REDIRECT_URL',
          'segments',
          'buttons'
    ]);
    
    const googleForm = useForm({
         GOOGLE_CLIENT_ID: props.GOOGLE_CLIENT_ID,
         GOOGLE_CLIENT_SECRET: props.GOOGLE_CLIENT_SECRET,
         type: 'google'
    });

    const facebookForm = useForm({
        FACEBOOK_CLIENT_ID: props.FACEBOOK_CLIENT_ID,
        FACEBOOK_CLIENT_SECRET: props.FACEBOOK_CLIENT_SECRET,
        type: 'facebook'
    });
    
    function update(type) {
        const url =  route('admin.developer-settings.update',props.id)
        type == 'google' ? googleForm.put(url,  {onSuccess: () => {
            createToast({
                title: trans("Congratulations"),
                description: trans("Google Auth API Settings Updated")
            })
        }}) 
        
        : facebookForm.put(url,  {onSuccess: () => {
            createToast({
                title: trans("Congratulations"),
                description: trans("Facebook Auth API Settings Updated")
            })
        }});
        
    }      
    
 </script>