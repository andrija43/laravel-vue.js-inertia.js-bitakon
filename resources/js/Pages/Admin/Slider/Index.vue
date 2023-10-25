<template>
  <HeaderSegment title="Slider" :segments="segments" :buttons="buttons" />
  <div class="container-fluid mt--6">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="row d-flex justify-content-between flex-wrap">
          <div class="col">
            <div class="card card-stats">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <span
                      class="h2 font-weight-bold mb-0 total-transfers"
                      id="total-device"
                    >
                      {{ totalSliders }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-users-alt mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Total Slider") }}
                </h5>
                <p></p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card card-stats">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <span
                      class="h2 font-weight-bold mb-0 total-transfers"
                      id="total-active"
                    >
                      {{ activeSliders }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-comment-user mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Active Slider") }}
                </h5>
                <p></p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card card-stats">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <span
                      class="h2 font-weight-bold mb-0 completed-transfers"
                      id="total-inactive"
                    >
                      {{ inactiveSliders }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-delete-user mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Inactive Slider") }}
                </h5>
                <p></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <div class="card">
          <!-- Card header -->
          <div class="card-header border-0">
            <h3 class="mb-0">{{ trans("Prompts") }}</h3>
            <form
              class="card-header-form"
              method="GET"
              @submit.prevent="filterData.get('/admin/slider')"
            >
              <div class="input-group">
                <input
                  v-if="filterData.type !== 'status'"
                  type="text"
                  name="search"
                  v-model="filterData.search"
                  class="form-control"
                  placeholder="Search......"
                />
                <select
                  class="form-control"
                  name="type"
                  v-model="filterData.type"
                >
                  <option value="title">
                    {{ trans("Title") }}
                  </option>
                  <option value="status">
                    {{ trans("Status") }}
                  </option>
                </select>
                <div class="input-group-btn">
                  <button class="btn btn-neutral btn-icon">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th class="col-10">{{ trans("Prompt") }}</th>

                  <th class="col-1">{{ trans("Slider Status") }}</th>
                  <th class="col-1 text-right">{{ trans("Action") }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="slider in sliders.data" :key="slider.id">
                  <td class="text-left">
                    <a
                      :href="route('prompt.show', slider.slug)"
                      target="_blank"
                    >
                      <img
                        class="mr-3 rounded"
                        width="60"
                        :src="
                          slider.preview
                            ? slider.preview
                            : JSON.parse(slider.meta).preview
                        "
                        alt="preview"
                      />
                      {{ textExcerpt(slider.title, 50) }}
                    </a>
                  </td>

                  <td class="text-center">
                    <span v-if="slider.slider" class="badge badge-success">
                      {{ trans("Enabled") }}
                    </span>
                    <span v-else class="badge badge-danger">
                      {{ trans("Disabled") }}
                    </span>
                  </td>

                  <td class="text-right">
                    <div class="btn-group mb-2 float-right">
                      <button
                        class="btn btn-neutral btn-sm dropdown-toggle"
                        type="button"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                      >
                        {{ trans("Action") }}
                      </button>
                      <div class="dropdown-menu">
                        <a
                          class="dropdown-item has-icon"
                          @click="
                            () => {
                              editForm.prompt_id = slider.id
                              if (slider.slider) {
                                editForm.status = 1
                              } else {
                                editForm.status = 0
                              }
                            }
                          "
                          href="#"
                          data-toggle="modal"
                          data-target="#editModal"
                          ><i class="fi fi-rs-edit"></i>{{ trans("Edit") }}
                        </a>
                        <a
                          class="dropdown-item has-icon delete-confirm"
                          href="javascript:void(0)"
                          @click="
                            modal.initiate(
                              route('admin.team.destroy', slider.id)
                            )
                          "
                          ><i class="fas fa-trash"></i
                          >{{ trans("Remove Slider") }}
                        </a>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <template v-if="sliders.data.length == 0">
              <div class="text-center mt-2">
                <div class="alert bg-gradient-primary text-white">
                  <span class="text-left">{{
                    trans("!Opps no records found")
                  }}</span>
                </div>
              </div>
            </template>
          </div>
          <div class="card-footer py-4">
            <Paginate :links="sliders.links" />
          </div>
        </div>
      </div>
    </div>
  </div>
  <div
    class="modal fade"
    id="editModal"
    tabindex="-1"
    aria-labelledby="editModal"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <form @submit.prevent="updateSlider">
          <div class="modal-header">
            <h3>{{ trans("Edit FAQ") }}</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ trans("Select Status") }}</label>
              <select class="form-control" v-model="editForm.status" required>
                <option :selected="editForm.status === 1" value="1">
                  {{ trans("Active") }}
                </option>
                <option :selected="editForm.status === 0" value="0">
                  {{ trans("Draft") }}
                </option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="submit"
              class="btn btn-outline-primary col-12 submit-button"
            >
              {{ trans("Update") }}
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
import { useForm, router } from "@inertiajs/vue3"
import sharedComposable from "@/composables/sharedComposable"
import Paginate from "@/Components/Paginate.vue"
defineOptions({ layout: AdminLayout })

const { textExcerpt, modal, ToastAlert } = sharedComposable()
const props = defineProps([
  "sliders",
  "buttons",
  "segments",
  "totalSliders",
  "activeSliders",
  "inactiveSliders",
  "type",
  "request"
])
const editForm = useForm({
  status: null,
  prompt_id: null
})
const updateSlider = () => {
  router.post(route("admin.slider.store"), editForm, {
    onSuccess: () => {
      editForm.status = null
      editForm.prompt_id = null
      ToastAlert("Updated", "Slider Updated successfully")
    }
  })
}
const filterData = useForm({
  search: props.request.search,
  type: props.type
})
</script>
