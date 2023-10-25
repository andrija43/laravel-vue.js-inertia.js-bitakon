<template>
    <Head title="Mailchimp API Settings" />
       <HeaderSegment 
          :title="trans('Mailchimp API Settings')" 
          :segments="segments" 
          :buttons="buttons"
          />
       <div class="container-fluid mt--6">
          <div class="row ">
             <div class="col-lg-5 mt-5">
                <strong>{{ trans('Mailchimp API Settings') }}</strong>
                <p>{{ trans('Edit your Mailchimp API settings for receiving subscriber') }}</p>
             </div>
             <div class="col-lg-7 mt-5">
                <form class="ajaxform" @submit.prevent="update">
                   <div class="card">
                      <div class="card-body">
                         <div class="from-group row mt-2">
                            <label class="col-lg-12">{{ trans('API KEY') }}</label>
                            <div class="col-lg-12">
                               <input type="text" required class="form-control" v-model="form.NEWSLETTER_API_KEY">
                            </div>
                         </div>
                         <div class="from-group row mt-2">
                            <label class="col-lg-12">{{ trans('LIST ID') }}</label>
                            <div class="col-lg-12">
                               <input type="text" required class="form-control" v-model="form.NEWSLETTER_LIST_ID">
                            </div>
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
    import { trans } from 'laravel-vue-i18n';
    import { createToast } from "mosha-vue-toastify"
    const props = defineProps([
          'id',
          'NEWSLETTER_API_KEY',
          'NEWSLETTER_LIST_ID',
          'segments',
          'buttons'
    ]);
    
    const form = useForm({
        NEWSLETTER_API_KEY: props.NEWSLETTER_API_KEY,
        NEWSLETTER_LIST_ID: props.NEWSLETTER_LIST_ID,
    })
    
    function update() {
        const url =  route('admin.developer-settings.update',props.id)
        form.put(url, {onSuccess: () => {
                createToast({
                    title: trans("Congratulations"),
                    description: trans("Mailchimp API Settings Updated")
                })
            }});
    }      
    
 </script>