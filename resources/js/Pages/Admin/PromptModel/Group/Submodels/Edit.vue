<template>  
    <Head title="Prompt Model" />
    <HeaderSegment 
      :title="trans('Edit Prompt Sub Model')" 
      :segments="segments" 
      :buttons="buttons"
      />
  <div class="container-fluid mt--6"> 
    <div class="row ">
	<div class="col-lg-5 mt-5">
		<strong>{{ trans('Edit Prompt Sub Model') }}</strong>
		<p>{{ trans('Edit Model for select the type of prompt the seller want to sell') }}</p>
	</div>
	<div class="col-lg-7 mt-5">
		<form class="ajaxform_instant_reload" @submit.prevent="store" enctype="multipart/form-data">
			
			<div class="card">
				<div class="card-body">
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="name">{{ trans('Model Name') }}</label>
						<input required placeholder="Example: GTP/ChatGPT, DALL-E, Midjourney, Stable Diffusion, PromptBase" v-model="form.name" type="text" :class=" form.errors.name ? 'form-control is-invalid' : 'form-control'" name="name" id="name"  >

                        <div class="invalid-feedback" v-if="form.errors.name">
                          {{ form.errors.name }}
                        </div>
					</div>
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="logo">{{ trans('Prompt Model Preview Image') }}</label>
						<input type="file" id="logo" @input="(e) => (form.preview = e.target.files[0])"   :class=" form.errors.preview ? 'form-control is-invalid' : 'form-control'" name="logo" accept="image/*">
						<div class="invalid-feedback" v-if="form.errors.preview">
                          {{ form.errors.preview }}
                        </div>						
					</div>
                    <div class="form-group mb-4">
						<label class="col-form-label text-md-right required" >{{ trans('Description For Frontend') }}</label>
						<textarea maxlength="5000" placeholder="Example: Explore expertly crafted Midjourney prompts for stunning digital art, designs, photography and more." required v-model="form.meta['frontend_description']" type="text" :class=" form.errors.frontend_description ? 'form-control is-invalid' : 'form-control'" cols="20" rows="5"></textarea>
                        <div class="invalid-feedback" v-if="form.errors.frontend_description">
                          {{ form.errors.frontend_description }}
                        </div>					
					</div>
                    <div class="form-group mb-4">
						<label class="col-form-label text-md-right required" >{{ trans('Instrcution For Prompt File Submission Page') }}</label>
						<textarea 
                        placeholder="Example: Copy and paste your Midjourney prompt.
*Include all your settings as tags within the prompt (e.g. --v 4 --q 2)" maxlength="500"  v-model="form.meta['submission_page_description']" type="text" :class=" form.errors.submission_page_description ? 'form-control is-invalid' : 'form-control'" cols="20" rows="5"></textarea>
                        <div class="invalid-feedback" v-if="form.errors.submission_page_description">
                          {{ form.errors.submission_page_description }}
                        </div>					
					</div>
                    
                    
                    <div>
                        <div class="form-group mb-4">
						<label class="col-form-label text-md-right" >{{ trans('Video Guide for how to submit prompt file (Youtube link only)') }}</label>
						<input  placeholder="Example: https://youtu.be/8yaUyKIeFUo" v-model="form.video_guide" type="text" :class=" form.errors.video_guide ? 'form-control is-invalid' : 'form-control'"  >

                        <div class="invalid-feedback" v-if="form.errors.video_guide">
                          {{ form.errors.video_guide }}
                        </div>					
					</div>
                    <div class="form-group mb-4">
						<label class="col-form-label text-md-right required" >{{ trans('Prompt Example For Prompt File Field Placeholder tip') }}</label>
						<textarea placeholder="Example: An Impressionist oil painting of [Flower] in a purple vase.."  v-model="form.meta['example_promptfile']" type="text" :class=" form.errors.frontend_description ? 'form-control is-invalid' : 'form-control'" cols="20" rows="5"></textarea>
                        <div class="invalid-feedback" v-if="form.errors.example_promptfile">
                          {{ form.errors.example_promptfile }}
                        </div>					
					</div>
                    <div class="form-group mb-4">
						<label class="col-form-label text-md-right required" >{{ trans('Prompt Instructions Placeholder tip') }}</label>
						<textarea placeholder="Example: Tip: You can use 25mm, or 35mm camera lens."  v-model="form.meta['example_promptfile_instruction']" type="text" :class=" form.errors.frontend_description ? 'form-control is-invalid' : 'form-control'" cols="20" rows="5"></textarea>
                        <div class="invalid-feedback" v-if="form.errors.example_promptfile_instruction">
                          {{ form.errors.example_promptfile_instruction }}
                        </div>					
					</div>

					<div class="d-flex mt-2">
                        <label class="custom-toggle custom-toggle-primary">
                        <input
                            v-model="form.accept_image"
                            type="checkbox"                                                       
                            id="accept_image"                            
                            class="save-template"
                        />
                        <span
                            class="custom-toggle-slider rounded-circle"
                            data-label-off="No"
                            data-label-on="Yes"
                        ></span>
                        </label>
                        <label class="mt-1 ml-1" for="accept_image">
                        <h4>{{ trans("Required to upload image?") }}</h4>
                        </label>
                    </div>
                    <div class="form-group mb-4" v-if="form.accept_image">
						<label class="col-form-label text-md-right required" >{{ trans('Upload Image instruction') }}</label>
						<textarea required placeholder="Example: Only upload your images generated by Midjourney."  v-model="form.meta['image_upload_instruction']" type="text" :class=" form.errors.frontend_description ? 'form-control is-invalid' : 'form-control'" cols="20" rows="5"></textarea>
                        <div class="invalid-feedback" v-if="form.errors.image_upload_instruction">
                          {{ form.errors.image_upload_instruction }}
                        </div>					
					</div>


					<div class="d-flex mt-2">
                        <label class="custom-toggle custom-toggle-primary">
                        <input
                            v-model="form.accept_profile"
                            type="checkbox"                                                       
                            id="accept_image"                            
                            class="save-template"
                        />
                        <span
                            class="custom-toggle-slider rounded-circle"
                            data-label-off="No"
                            data-label-on="Yes"
                        ></span>
                        </label>
                        <label class="mt-1 ml-1" for="accept_image">
                        <h4>{{ trans("Required to accept profile?") }}</h4>
                        </label>
                    </div>
                    <div class="form-group mb-4" v-if="form.accept_profile">
						<label class="col-form-label text-md-right required" >{{ trans('Add profile instruction') }}</label>
						<textarea required placeholder=""  v-model="form.meta['profile_instruction']" type="text" :class=" form.errors.frontend_description ? 'form-control is-invalid' : 'form-control'" cols="20" rows="5"></textarea>
                        <div class="invalid-feedback" v-if="form.errors.profile_instruction">
                          {{ form.errors.profile_instruction }}
                        </div>					
					</div>

                    <div class="d-flex mt-2">
                        <label class="custom-toggle custom-toggle-primary">
                        <input
                            v-model="form.accept_image_ratio"
                            type="checkbox"                                                       
                            id="accept_image_ratio"                            
                            class="save-template"
                        />
                        <span
                            class="custom-toggle-slider rounded-circle"
                            data-label-off="No"
                            data-label-on="Yes"
                        ></span>
                        </label>
                        <label class="mt-1 ml-1" for="accept_image_ratio">
                        <h4>{{ trans("Can select image ration (for stable diffusion)") }}</h4>
                        </label>
                    </div>
                    <div class="d-flex mt-2">
                        <label class="custom-toggle custom-toggle-primary">
                        <input
                            v-model="form.accept_seed"
                            type="checkbox"                                                       
                            id="accept_seed"                            
                            class="save-template"
                        />
                        <span
                            class="custom-toggle-slider rounded-circle"
                            data-label-off="No"
                            data-label-on="Yes"
                        ></span>
                        </label>
                        <label class="mt-1 ml-1" for="accept_seed">
                        <h4>{{ trans("Can enter image seed (for stable diffusion)") }}</h4>
                        </label>
                    </div>
                    <div class="d-flex mt-2">
                        <label class="custom-toggle custom-toggle-primary">
                        <input
                            v-model="form.negative_prompt"
                            type="checkbox"                                                       
                            id="negative_prompt"                            
                            class="save-template"
                        />
                        <span
                            class="custom-toggle-slider rounded-circle"
                            data-label-off="No"
                            data-label-on="Yes"
                        ></span>
                        </label>
                        <label class="mt-1 ml-1" for="negative_prompt">
                        <h4>{{ trans("Accept Negative Prompt (for stable diffusion)") }}</h4>
                        </label>
                    </div>                   
                    </div>

                    <div class="d-flex mt-2">
                        <label class="custom-toggle custom-toggle-primary">
                        <input
                            v-model="form.status"
                            type="checkbox"                                                       
                            id="status"                            
                            class="save-template"
                        />
                        <span
                            class="custom-toggle-slider rounded-circle"
                            data-label-off="No"
                            data-label-on="Yes"
                        ></span>
                        </label>
                        <label class="mt-1 ml-1" for="status">
                        <h4>{{ trans("Status") }}</h4>
                        </label>
                    </div>
					
					<div class="form-group mb-4">
						<button class="btn btn-neutral submit-button">{{ trans('Create') }}</button>
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
    layout: AdminLayout,
}

</script>

<script setup>
"use strict";
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue";
import { useForm } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
const props = defineProps(['segments','buttons','model']);


const form = useForm({
    name: props.model.title,
    preview: null,
   
    meta: props.model.meta,
    video_guide: props.model.guide,
    accept_image: props.model.accept_image == 1 ? true : false,						
    accept_profile: props.model.accept_profile_link  == 1 ? true : false,
    accept_image_ratio: props.model.accept_image_size_measurement  == 1 ? true : false,
    accept_seed: props.model.accept_image_size_measurement  == 1 ? true : false,
    negative_prompt:  props.model.accept_negative_prompt  == 1 ? true : false,
    status: props.model.status  == 1 ? true : false
});



   
const store = () => {
 form.put(route('admin.prompt-sub-models.update',props.model.id),{
    onSuccess: () => {
        form.reset()
        createToast(
        {
            title: trans("Congratulations"),
            description: trans("Prompt Model Created Successfully"),
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