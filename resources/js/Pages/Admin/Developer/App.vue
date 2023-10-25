<template>  
    <Head title="App Settings" />
    <HeaderSegment 
    :title="trans('App Settings')" 
    :segments="segments" 
    :buttons="buttons"
    />
  <div class="container-fluid mt--6"> 
    <div class="row ">
	<div class="col-lg-5 mt-5">
        <strong>{{ trans('Application Settings') }}</strong>
        <p>{{ trans('Edit you application global settings') }}</p>
    </div>
    <div class="col-lg-7 mt-5">
        <form class="ajaxform" @submit.prevent="update">
        	<div class="card">
            <div class="card-body">
                <div class="from-group row">
                    <label class="col-lg-12">{{ trans('Application Name') }}</label>
                    <div class="col-lg-12">
                        <input type="text" name="name"  v-model="form.APP_NAME" required="" class="form-control">
                    </div>
                </div> 
                
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ trans('Visibility Of Site Error') }}</label>
                    <div class="col-lg-12">
                        <select class="form-control" name="app_debug" v-model="form.APP_DEBUG">
                            <option value="true" >{{ trans('Enable') }}</option>
                            <option value="false" >{{ trans('Disable') }}</option>
                        </select>
                    </div>
                </div>   
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ trans('Application Time Zone') }}</label>
                    <div class="col-lg-12">
                        <select class="form-control" name="timezone" v-model="form.TIME_ZONE">
                         
                            <option v-for="timezone, index in tzlist" :key="index" :value="timezone" >{{ timezone }}</option>
                                                   
                        </select>
                    </div>
                </div> 
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ trans('Application Default Language') }}</label>
                    <div class="col-lg-12">
                        <select class="form-control" name="default_lang" v-model="form.DEFAULT_LANG">
                           
                            <option v-for="langauge, langKey in  languages" :value="langKey" >{{ langauge }}</option>
                                             
                        </select>
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
const props = defineProps(['segments','buttons','id','tzlist','languages','appName','appDebug','timeZone','default_lang']);

const form = useForm({
    APP_NAME: props.appName,
    APP_DEBUG: props.appDebug,
    TIME_ZONE: props.timeZone,
    DEFAULT_LANG: props.default_lang,
});


function update() {
    const url =  route('admin.developer-settings.update',props.id)
    form.put(url);
}
</script>