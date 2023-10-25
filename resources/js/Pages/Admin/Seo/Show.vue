<template>  
    <Head title="Edit SEO Settings" />
    <HeaderSegment 
    :title="trans('Edit SEO Settings')" 
    :segments="segments" 
    :buttons="buttons"
    />
  <div class="container-fluid mt--6"> 
    <form  @submit.prevent="update"  enctype="multipart/form-data">
	
	<div class="row">
		<div class="col-lg-5">
			<strong>{{ trans('Edit page seo settings') }}</strong>
			<p>{{ trans('Edit page seo and necessary information from here') }}</p>
		</div>
		<div class="col-lg-7 card-wrapper">
			<!-- Alerts -->
			<div class="card">
				<div class="card-header">
					<h3 class="mb-0">{{ trans('Edit Settings') }}</h3>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>{{ trans('Meta Title') }}</label>
						<input type="text"  v-model="form.metadata['site_name']" required=""  class="form-control">
					</div>
					<div class="form-group">
						<label>{{ trans('Meta Description') }}</label>
						<textarea v-model="form.metadata['matadescription']" required="" class="summernote form-control h-200"></textarea>
					</div>
					<div class="form-group">
						<label>{{ trans('Meta Tags') }}</label>
						<input type="text" v-model="form.metadata['matatag']"  required="" class="form-control">
					</div>
				
					<div class="form-group" v-if="!form.metadata['matatag']">
						<label>{{ trans('Twitter Site Title') }}</label>
						<input type="text" v-memo="form.metadata['matatag']"  required=""  class="form-control">
					</div>
					
					<div class="form-group">
						<label>{{ trans('Meta Image') }}</label>
						<input
                        @input="
                            (e) => (form.image = e.target.files[0])
                        "
                        type="file" accept="image/*"  class="form-control">
					</div>
					<div class="from-group row mt-3">
						<div class="col-lg-12">
							<button class="btn btn-neutral submit-button">{{ trans('Save Changes') }}</button>
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
const props = defineProps(['segments','buttons','id','contents']);
const form = useForm({
    _method: 'patch',
    metadata: props.contents,
    image: '',
});


const update = ()=>{
    const  url = route('admin.seo.update',props.id);
    router.post(url,form, 
    {
      onSuccess: () => {
        createToast(
        {
            title: "Congratulations",
            description: "SEO Metadata updated successfully",
        },
        {
            transition: "slide",
            position: "top-right",
        }
      )
    }
  })
}

</script>