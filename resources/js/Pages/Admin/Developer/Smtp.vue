<template>  
    <Head title="SMTP Settings" />
    <HeaderSegment 
    :title="trans('SMTP MAIL Settings')" 
    :segments="segments" 
    :buttons="buttons"
    />
  <div class="container-fluid mt--6"> 
    <div class="row ">
	<div class="col-lg-5 mt-5">
        <strong>{{ trans('SMTP mail Settings') }}</strong>
        <p>{{ trans('Edit you smtp settings for mail transaction') }}</p>
    </div>
    <div class="col-lg-7 mt-5">
        <form class="ajaxform" @submit.prevent="update">
        	
        	<div class="card">
            <div class="card-body">
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ trans('Use Queue Job For Mail Transaction?') }}</label>
                    <div class="col-lg-12">
                     <select name="QUEUE_MAIL" class="form-control" v-model="form.QUEUE_MAIL">
                        <option value="true" >{{ trans('Enable') }}</option>
                        <option value="false" >{{ trans('Disable') }}</option>
                      </select>
                    </div>
                </div>
                <div class="from-group row">
                    <label class="col-lg-12">{{ trans('Mail driver type') }}</label>
                    <div class="col-lg-12">
                        <select name="MAIL_DRIVER_TYPE" v-model="form.MAIL_DRIVER_TYPE" class="form-control">
                            <option value="MAIL_MAILER" >{{ trans('MAIL MAILER') }}</option>
                            <option value="MAIL_DRIVER" >{{ trans('MAIL DRIVER') }}</option>
                        </select>
                    </div>
                </div> 
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ trans('Mail Driver') }}</label>
                    <div class="col-lg-12">
                     <select name="MAIL_DRIVER" v-model="form.MAIL_DRIVER" class="form-control">
                        <option value="sendmail" >{{ trans('sendmail') }}</option>
                        <option value="smtp" >{{ trans('smtp') }}</option>
                      </select>
                    </div>
                </div>                
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ trans('Mail Host') }}</label>
                    <div class="col-lg-12">
                     <input type="text"   name="MAIL_HOST" v-model="form.MAIL_HOST" class="form-control" required="" >
                    </div>
                </div> 
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ trans('Mail Port') }}</label>
                    <div class="col-lg-12">
                     <input type="text" v-model="form.MAIL_PORT"   name="MAIL_PORT" class="form-control" required="" >
                    </div>
                </div> 
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ trans('Mail Username') }}</label>
                    <div class="col-lg-12">
                     <input type="text" v-model="form.MAIL_USERNAME"  name="MAIL_USERNAME" class="form-control" required="" >
                    </div>
                </div> 
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ trans('Mail Password') }}</label>
                    <div class="col-lg-12">
                     <input type="text" v-model="form.MAIL_PASSWORD"  name="MAIL_PASSWORD" class="form-control" required="" >
                    </div>
                </div> 
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ trans('Mail Encryption') }}</label>
                    <div class="col-lg-12">
                     <select name="MAIL_ENCRYPTION" v-model="form.MAIL_ENCRYPTION" class="form-control">
                        <option value="ssl" >{{ trans('SSL') }}</option>
                        <option value="tls" >{{ trans('TLS') }}</option>
                      </select>
                    </div>
                </div> 
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ trans('Mail From Address') }}</label>
                    <div class="col-lg-12">
                     <input type="email" v-model="form.MAIL_FROM_ADDRESS"  name="MAIL_FROM_ADDRESS" class="form-control" placeholder="email" required="" >
                    </div>
                </div> 
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ trans('Mail From Name') }}</label>
                    <div class="col-lg-12">
                     <input type="text" v-model="form.MAIL_FROM_NAME"  name="MAIL_FROM_NAME" class="form-control" placeholder="Website Name" required="" >
                    </div>
                </div> 
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ trans('Incoming Mail') }}</label>
                    <div class="col-lg-12">
                     <input type="email" v-model="form.MAIL_TO"  name="MAIL_TO" class="form-control" placeholder="email" required="" >
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
            'mailDriver',
            'segments',
            'buttons',
            'QUEUE_MAIL',
            'MAIL_DRIVER_TYPE',
            'MAIL_HOST',
            'MAIL_PORT',
            'MAIL_USERNAME',
            'MAIL_PASSWORD',
            'MAIL_ENCRYPTION',
            'MAIL_FROM_ADDRESS',
            'MAIL_FROM_NAME',
            'MAIL_TO'
]);


const form = useForm({
    QUEUE_MAIL: props.QUEUE_MAIL,
    MAIL_DRIVER_TYPE: props.MAIL_DRIVER_TYPE,
    MAIL_DRIVER: props.mailDriver,
    MAIL_HOST: props.MAIL_HOST,
    MAIL_PORT: props.MAIL_PORT,
    MAIL_USERNAME: props.MAIL_USERNAME,
    MAIL_PASSWORD: props.MAIL_PASSWORD,
    MAIL_ENCRYPTION: props.MAIL_ENCRYPTION,
    MAIL_FROM_ADDRESS: props.MAIL_FROM_ADDRESS,
    MAIL_FROM_NAME: props.MAIL_FROM_NAME,
    MAIL_TO: props.MAIL_TO
});


function update() {
    const url =  route('admin.developer-settings.update',props.id)
    form.put(url);
}      
</script>