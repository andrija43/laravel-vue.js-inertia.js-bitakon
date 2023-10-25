<template>
  <HeaderSegment
    :title="trans('Create Prompt Category')"
    :segments="segments"
    :buttons="buttons"
  />
  <div class="container-fluid mt--6">
    <div class="row">
      <div class="col-lg-5 mt-5">
        <strong>{{ trans("Create Prompt Category") }}</strong>
        <p>
          {{ trans("Create category for Prompt Model") }}
        </p>
      </div>
      <div class="col-lg-7 mt-5">
        <form
          class="ajaxform_instant_reload"
          @submit.prevent="store"
          enctype="multipart/form-data"
        >
          <div class="card">
            <div class="card-body">
              <div class="form-group mb-4">
                <label class="col-form-label text-md-right required" for="name">
                  {{ trans("Category Name") }}
                </label>
                <input
                  class="form-control"
                  required
                  placeholder="Category Name"
                  v-model="form.name"
                  type="text"
                  name="name"
                />
              </div>
              <div class="form-group mb-4">
                <label class="col-form-label text-md-right required" for="logo">
                  {{ trans("Preview Image") }}</label
                >
                <input
                  type="file"
                  id="logo"
                  @input="(e) => (form.preview = e.target.files[0])"
                  required
                  class="form-control"
                  name="logo"
                  accept="image/*"
                />
              </div>
              <div class="form-group">
                <label>{{ trans("Prompt Model") }}</label>
                <select
                  class="form-control"
                  v-model="form.promptmodel_id"
                  required
                >
                  <option value="">{{ trans("Select Model") }}</option>
                  <option
                    :value="model.id"
                    v-for="model in promptModels"
                    :key="model.id"
                  >
                    {{ model.title }}
                  </option>
                </select>
              </div>
              <div class="d-flex mt-2">
                <label class="custom-toggle custom-toggle-primary">
                  <input
                    v-model="form.is_filterable"
                    type="checkbox"
                    class="save-template"
                  />
                  <span
                    class="custom-toggle-slider rounded-circle"
                    data-label-off="No"
                    data-label-on="Yes"
                  ></span>
                </label>
                <label class="mt-1 ml-1" for="status">
                  <h4>{{ trans("Filterable") }}</h4>
                </label>
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
                <button class="btn btn-neutral submit-button">
                  {{ trans("Create") }}
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
"use strict";
import AdminLayout from "@/Pages/Admin/Layout/App.vue";
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue";
import { useForm } from '@inertiajs/vue3';
const props = defineProps(['segments','buttons','promptModels']);
import { createToast } from "mosha-vue-toastify";
defineOptions({layout: AdminLayout})

const form = useForm({
    name: null,
    preview: null,
    is_filterable: false,
    meta:{},
    status: true,
    promptmodel_id: ''
});

const store = () => {
 form.post(route('admin.prompt-category.store'),{
    onSuccess: () => {
        form.reset()
        createToast(
        {
            title: trans("Congratulations"),
            description: trans("Prompt Category Created Successfully"),
        }
      )
    }
 })
}

</script>