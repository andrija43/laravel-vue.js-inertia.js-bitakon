<template>
  <Head title="Prompt Model" />
  <HeaderSegment
    :title="trans('Prompt Model Groups')"
    :segments="segments"
    :buttons="buttons"
  />
  <div class="container-fluid mt--6">
    <div class="row">
      <div class="col">
        <div class="card">
          <!-- Card header -->
          <div class="card-header border-0">
            <h3 class="mb-0">{{ trans("Model Groups") }}</h3>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th scope="col" class="sort col-8">{{ trans("Name") }}</th>

                  <th scope="col" class="sort col-1 text-right">
                    {{ trans("Sub Models") }}
                  </th>
                  <th scope="col" class="sort col-1 text-right">
                    {{ trans("Status") }}
                  </th>
                  <th scope="col" class="sort col-2 text-center">
                    {{ trans("Action") }}
                  </th>
                </tr>
              </thead>
              <tbody class="list">
                <tr class="mt-5" v-for="model in groups" :key="model.id">
                  <th scope="row">
                    <div class="media align-items-center">
                      <div class="media-body">
                        <span class="name mb-0 text-sm">{{ model.title }}</span>
                      </div>
                    </div>
                  </th>

                  <td class="text-center">
                    {{ model.submodels_count }}
                  </td>

                  <td class="text-right">
                    <span class="badge badge-dot text-right">
                      <i
                        :class="model.status == 1 ? 'bg-success' : 'bg-danger'"
                      ></i>
                      <span class="status">{{
                        model.status == 1 ? "Active" : "Disabled"
                      }}</span>
                    </span>
                  </td>

                  <td class="text-center">
                    <div class="btn-group dropleft">
                      <button
                        type="button"
                        class="btn btn-neutral btn-sm dropdown-toggle"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                      >
                        {{ trans("Actions") }}
                      </button>
                      <div class="dropdown-menu">
                        <a
                          href="javascript:void(0)"
                          data-toggle="modal"
                          data-target="#editRow"
                          class="dropdown-item pt-2"
                          @click="editModel(model)"
                          >{{ trans("Edit Model") }}</a
                        >
                        <Link
                          class="dropdown-item"
                          :href="
                            route('admin.prompt-sub-model.index', model.id)
                          "
                          >{{ trans("Sub Models") }}</Link
                        >
                        <a
                          class="dropdown-item"
                          href="javascript:void(0)"
                          @click="
                            modal.initiate(
                              route('admin.prompt-model.destroy', model.id)
                            )
                          "
                          >{{ trans("Remove") }}</a
                        >
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div
    class="modal fade"
    id="addRecord"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" @submit.prevent="store">
          <div class="modal-header">
            <h3>{{ trans("Create Model Group") }}</h3>
            <button
              type="button"
              class="close close-button"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ trans("Model Name") }}</label>
              <input
                type="text"
                v-model="form.name"
                name="name"
                class="form-control"
                required=""
                placeholder="GPT Type"
              />
            </div>
            <div class="form-group">
              <label>{{ trans("Sub Model Selection Instruction") }}</label>
              <input
                type="text"
                v-model="form.select_instruction"
                name="name"
                class="form-control"
                required=""
                placeholder="Select what type of GPT prompt this is."
              />
            </div>
            <div class="row mt-2">
              <div class="col-sm-12 d-flex">
                <label class="custom-toggle custom-toggle-primary">
                  <input
                    type="checkbox"
                    v-model="form.status"
                    name="status"
                    id="status"
                  />
                  <span
                    class="custom-toggle-slider rounded-circle"
                    data-label-off="No"
                    data-label-on="Yes"
                  ></span>
                </label>
                <label class="mt-1 ml-1" for="status"
                  ><h4>
                    &nbsp {{ trans("Activate This Group For Selection?") }}
                  </h4></label
                >
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="submit"
              class="btn btn-outline-primary col-12 submit-button"
            >
              {{ trans("Create Now") }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div
    class="modal fade"
    id="editRow"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" @submit.prevent="update">
          <div class="modal-header">
            <h3>{{ trans("Edit Model Group") }}</h3>
            <button
              type="button"
              class="close close-button"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ trans("Model Name") }}</label>
              <input
                type="text"
                v-model="editForm.name"
                name="name"
                class="form-control"
                required=""
                placeholder="GPT Type"
              />
            </div>
            <div class="form-group">
              <label>{{ trans("Sub Model Selection Instruction") }}</label>
              <input
                type="text"
                v-model="editForm.select_instruction"
                name="name"
                class="form-control"
                required=""
                placeholder="Select what type of GPT prompt this is."
              />
            </div>
            <div class="row mt-2">
              <div class="col-sm-12 d-flex">
                <label class="custom-toggle custom-toggle-primary">
                  <input
                    type="checkbox"
                    v-model="editForm.status"
                    name="status"
                    id="status"
                  />
                  <span
                    class="custom-toggle-slider rounded-circle"
                    data-label-off="No"
                    data-label-on="Yes"
                  ></span>
                </label>
                <label class="mt-1 ml-1" for="status"
                  ><h4>
                    &nbsp {{ trans("Activate This Group For Selection?") }}
                  </h4></label
                >
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="submit"
              class="btn btn-outline-primary col-12 submit-button"
            >
              {{ trans("Update Now") }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
"use strict";
import AdminLayout from "@/Pages/Admin/Layout/App.vue"
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue"
import { Head, Link, useForm } from "@inertiajs/vue3"
import sharedComposable from "@/composables/sharedComposable"
import { createToast } from "mosha-vue-toastify"
defineOptions({ layout: AdminLayout })
const { modal } = sharedComposable()
const props = defineProps(["model", "groups", "segments", "buttons"])
const form = useForm({
  name: null,
  select_instruction: null,
  status: false
})

const editForm = useForm({
  name: null,
  select_instruction: null,
  status: false,
  id: null
})

function editModel(model) {
  editForm.name = model.title
  editForm.select_instruction = model.slug
  editForm.status = model.status == 1 ? true : false
  editForm.id = model.id
}

const store = () => {
  form.post(route("admin.prompt-submodel-store", props.model.id), {
    onSuccess: () => {
      form.reset()
      createToast({
        title: "Congratulations",
        description: "Prompt Model Group Created Successfully"
      })
    }
  })
}

const update = () => {
  editForm.put(route("admin.prompt-submodel-update", editForm.id), {
    onSuccess: () => {
      form.reset()
      createToast({
        title: "Congratulations",
        description: "Prompt Model Group Updated Successfully"
      })
    }
  })
}
</script>
