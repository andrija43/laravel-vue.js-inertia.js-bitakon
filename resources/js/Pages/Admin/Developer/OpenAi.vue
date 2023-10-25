<template>  
    <Head title="Open AI API Settings" />
    <HeaderSegment 
    :title="trans('OpenAI API Settings')" 
    :segments="segments" 
    :buttons="buttons"
    />
  <div class="container-fluid mt--6"> 
    <div class="row ">
	<div class="col-lg-5 mt-5">
        <strong>{{ trans('OpenAI API Settings') }}</strong>
        <p>{{ trans('Edit your OpenAI API settings for generate ai image the model will use DALL·E 2') }}</p>
    </div>
    <div class="col-lg-7 mt-5">
      <form class="ajaxform" @submit.prevent="update">
        	
        	<div class="card">
            <div class="card-body">
                
                <div class="from-group row mt-2">
                        <label class="col-lg-12">{{ trans('OpenAI API KEY') }}</label>
                        <div class="col-lg-12">
                           <input type="text" required class="form-control" v-model="form.OPENAI_API_KEY">
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
      'OPENAI_API_KEY',
      'segments',
      'buttons'
]);

const form = useForm({
    OPENAI_API_KEY: props.OPENAI_API_KEY,
})

function update() {
    const url =  route('admin.developer-settings.update',props.id)
    form.put(url, {onSuccess: () => {
            createToast({
                title: trans("Congratulations"),
                description: trans("OpenAI API Settings Updated")
            })
        }});
}      

</script>