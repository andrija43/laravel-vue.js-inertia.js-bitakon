<template>  
    <Head title="Storage" />
    <HeaderSegment 
    :title="trans('Storage Settings')" 
    :segments="segments" 
    :buttons="buttons"
    />
  <div class="container-fluid mt--6"> 
    <div class="row ">
	<div class="col-lg-5 mt-5">
        <strong>{{ trans('Application Storage Settings') }}</strong>
        <p>{{ trans('Edit your app storage settings for store uploaded files') }}</p>
    </div>
    <div class="col-lg-7 mt-5">
      <form class="ajaxform" @submit.prevent="update">
        	
        	<div class="card">
            <div class="card-body">
                <div class="from-group row">
                    <label class="col-lg-12">{{ trans('Storage Upload Mode') }}</label>
                    <div class="col-lg-12">
                       <select class="form-control" v-model="form.FILESYSTEM_DISK" name="FILESYSTEM_DISK" id="disk-method">
                           <option value="public" >{{ trans('Own server (Uploads folder)') }}</option>
                           <option value="wasabi" >{{ trans('Wasabi') }}</option>
                       </select>
                    </div>
                </div> 
                
                <div v-if="form.FILESYSTEM_DISK != 'public'">
                    <div class="from-group row mt-2">
                        <label class="col-lg-12">{{ trans('Wasabi Access Key Id') }}</label>
                        <div class="col-lg-12">
                           <input type="text" name="WAS_ACCESS_KEY_ID" class="form-control" v-model="form.WAS_ACCESS_KEY_ID">
                        </div>
                    </div> 
                    <div class="from-group row mt-2">
                        <label class="col-lg-12">{{ trans('Wasabi Secret Access Key') }}</label>
                        <div class="col-lg-12">
                           <input type="text" name="SECRET_ACCESS_KEY" class="form-control" v-model="form.SECRET_ACCESS_KEY">
                        </div>
                    </div> 
                    <div class="from-group row mt-2">
                        <label class="col-lg-12">{{ trans('Wasabi Default Region') }}</label>
                        <div class="col-lg-12">
                           <input type="text" name="WAS_DEFAULT_REGION" class="form-control" v-model="form.WAS_DEFAULT_REGION">
                        </div>
                    </div> 
                    <div class="from-group row mt-2">
                        <label class="col-lg-12">{{ trans('Wasabi Bucket Name') }}</label>
                        <div class="col-lg-12">
                           <input type="text" name="WAS_BUCKET" class="form-control" v-model="form.WAS_BUCKET">
                        </div>
                    </div> 
                    <div class="from-group row mt-2">
                        <label class="col-lg-12">{{ trans('Wasabi Endpoint') }}</label>
                        <div class="col-lg-12">
                           <input type="text" name="WAS_ENDPOINT" class="form-control"  v-model="form.WAS_ENDPOINT">
                        </div>
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

const props = defineProps([
      'id',
      'FILESYSTEM_DISK',
      'WAS_ACCESS_KEY_ID',
      'SECRET_ACCESS_KEY',
      'WAS_DEFAULT_REGION',
      'WAS_BUCKET',
      'WAS_ENDPOINT',
      'segments',
      'buttons'
]);

const form = useForm({
     FILESYSTEM_DISK: props.FILESYSTEM_DISK,
     WAS_ACCESS_KEY_ID: props.WAS_ACCESS_KEY_ID,
     SECRET_ACCESS_KEY: props.SECRET_ACCESS_KEY,
     WAS_DEFAULT_REGION: props.WAS_DEFAULT_REGION,
     WAS_BUCKET: props.WAS_BUCKET,
     WAS_ENDPOINT: props.WAS_ENDPOINT,
})

function update() {
    const url =  route('admin.developer-settings.update',props.id)
    form.put(url);
}      
</script>