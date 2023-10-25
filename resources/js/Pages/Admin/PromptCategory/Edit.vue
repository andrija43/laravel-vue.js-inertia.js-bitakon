<template>
  <HeaderSegment
    :title="trans('Edit Prompt Category')"
    :segments="segments"
    :buttons="buttons"
  />
  <div class="container-fluid mt--6">
    <div class="row">
      <div class="col-lg-5 mt-5">
        <strong>{{ trans("Edit Prompt Category") }}</strong>
        <p>
          {{ trans("Edit category for Prompt Model") }}
        </p>
      </div>
      <div class="col-lg-7 mt-5">
        <form
          class="ajaxform_instant_reload"
          @submit.prevent="update"
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
                  v-model="promptcategory.name"
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
                  @input="(e) => (promptcategory.preview = e.target.files[0])"
                  class="form-control"
                  name="logo"
                  accept="image/*"
                />
              </div>
              <div class="form-group">
                <label>{{ trans("Prompt Model") }}</label>
                <select
                  class="form-control"
                  v-model="promptcategory.promptmodel_id"
                  required
                >
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
                    v-model="editForm.is_filterable"
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
                    v-model="editForm.status"
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
                  {{ trans("Update") }}
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
import { router } from "@inertiajs/vue3";
import { createToast } from "mosha-vue-toastify";
import { onMounted, ref } from "vue";
const props = defineProps([
    "segments",
    "buttons",
    "promptModels",
    "promptcategory",
]);
defineOptions({ layout: AdminLayout });
const editForm = ref({
    status: null,
    is_filterable: null,
});
onMounted(() => {
    editForm.value.status = props.promptcategory.status == 1 ? true : false;
    editForm.value.is_filterable =
        props.promptcategory.is_filterable == 1 ? true : false;
});
const update = () => {
    if (!(props.promptcategory.preview instanceof File)) {
      props.promptcategory.preview = null
    }
    props.promptcategory.status = editForm.value.status;
    props.promptcategory.is_filterable = editForm.value.is_filterable;
    router.post(route("admin.prompt-category.update", props.promptcategory.id),
    {
        _method: 'PATCH',
        category: props.promptcategory
    },
    {
        onSuccess: () => {
            createToast({
                title: trans("Congratulations"),
                description: trans("Prompt Category Updated Successfully"),
            });
        },
    });
};
</script>
