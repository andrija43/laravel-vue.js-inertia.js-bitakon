<template>
  <HeaderSegment
    title="Our Partners"
    :segments="segments"
    :buttons="buttons"
  />
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
                      {{ totalBrands }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-elevator mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Total Partners") }}
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
                      {{ activeBrands }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-badge-check mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Active Partners") }}
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
                      {{ inActiveBrands }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-circle-cross mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Inactive Partners") }}
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
            <h3 class="mb-0">{{ trans("Partners / Brands") }}</h3>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th class="col-2">{{ trans("Image") }}</th>
                  <th class="col-3">{{ trans("Url") }}</th>
                  <th class="col-1">{{ trans("Type") }}</th>
                  <th class="col-2">{{ trans("Status") }}</th>
                  <th class="col-2">{{ trans("Created At") }}</th>
                  <th class="col-2 text-right">{{ trans("Action") }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="row in brands.data" :key="row.id">
                  <td class="text-left">
                    <img
                      :src="row.slug"
                      class="avatar rounded-square w-70-per"
                    />
                  </td>
                  <td class="text-left">
                    {{ row.title }}
                  </td>
                  <td class="text-left">
                    {{ row.lang == "en" ? "Partner" : row.lang }}
                  </td>

                  <td class="text-left">
                    <span
                      class="badge"
                      :class="
                        row.status == 1 ? 'badge-success' : 'badge-danger'
                      "
                    >
                      {{ row.status == 1 ? trans("Active") : trans("Draft") }}
                    </span>
                  </td>
                  <td>
                    {{ moment(row.created_at).format("D-MMM-Y") }}
                  </td>
                  <td class="text-right">
                    <div class="btn-group mb-2 float-right">
                      <button
                        @click="editPartnerForm = row"
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
                          class="dropdown-item has-icon edit-row"
                          href="#"
                          data-action="{{ route('admin.partner.update',$row->id) }}"
                          data-url="{{ $row->title }}"
                          data-type="{{ $row->lang }}"
                          data-status="{{ $row->status }}"
                          data-toggle="modal"
                          data-target="#editModal"
                        >
                          <i class="fi fi-rs-edit"></i>{{ trans("Edit") }}</a
                        >
                        <a
                          class="dropdown-item has-icon delete-confirm"
                          href="javascript:void(0)"
                          @click="
                            modal.initiate(
                              route('admin.partner.destroy', row.id)
                            )
                          "
                          ><i class="fas fa-trash"></i>{{ trans("Remove") }}
                        </a>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <template v-if="brands.data.length == 0">
              <div class="text-center mt-2">
                <div class="alert bg-gradient-primary text-white">
                  <span class="text-left">{{
                    trans("!Opps no records found")
                  }}</span>
                </div>
              </div>
            </template>
          </div>

          <div class="card-footer">
            <Paginate :links="brands.links" />
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- modal -->
  <div
    class="modal fade"
    id="addRecord"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <form
          method="POST"
          @submit.prevent="createPartner"
          class="ajaxform_instant_reload"
          enctype="multipart/form-data"
        >
          <div class="modal-header">
            <h3>{{ trans("Create Partner") }}</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ trans("Brand Url") }}</label>
              <input
                type="text"
                name="url"
                v-model="form.url"
                class="form-control"
              />
            </div>
            <div class="form-group">
              <label>{{ trans("Brand image") }}</label>
              <input
                @input="(e) => (form.image = e.target.files[0])"
                type="file"
                accept="image/*"
                name="image"
                required
                class="form-control"
              />
            </div>
            <div class="form-group">
              <label>{{ trans("Type") }}</label>
              <select class="form-control" name="type" v-model="form.type">
                <option value="partner">{{ trans("Partner / Brand") }}</option>
                <option value="integration">
                  {{ trans("Integration Partner") }}
                </option>
              </select>
            </div>
            <div class="form-group">
              <label>{{ trans("Status") }}</label>
              <select class="form-control" name="status">
                <option value="1">{{ trans("Active") }}</option>
                <option value="0">{{ trans("InActive") }}</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-neutral submit-button">
              {{ trans("Create Now") }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div
    class="modal fade"
    id="editModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <form
          method="POST"
          @submit.prevent="editPartner"
          class="ajaxform_instant_reload edit-form"
          enctype="multipart/form-data"
        >
          <div class="modal-header">
            <h3>{{ trans("Edit Partner") }}</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ trans("Brand Url") }}</label>
              <input
                type="text"
                name="url"
                v-model="editPartnerForm.title"
                class="form-control"
                id="url"
              />
            </div>
            <div class="form-group">
              <label>{{ trans("Brand image") }}</label>
              <input
                @input="(e) => (editPartnerForm.slug = e.target.files[0])"
                type="file"
                name="image"
                accept="image/*"
                class="form-control"
              />
            </div>
            <div class="form-group">
              <label>{{ trans("Type") }}</label>
              <select
                class="form-control"
                name="type"
                v-model="editPartnerForm.lang"
                id="type"
                required
              >
                <option value="partner">{{ trans("Partner / Brand") }}</option>
                <option value="integration">
                  {{ trans("Integration Partner") }}
                </option>
              </select>
            </div>
            <div class="form-group">
              <label>{{ trans("Status") }}</label>
              <select
                v-model="editPartnerForm.status"
                class="form-control"
                name="status"
                id="status"
              >
                <option value="1">{{ trans("Active") }}</option>
                <option value="0">{{ trans("InActive") }}</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-neutral submit-button">
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
import { useForm, router } from "@inertiajs/vue3"
import { createToast } from "mosha-vue-toastify"
import Paginate from "@/Components/Paginate.vue"
import moment from "moment"
import { ref } from "vue"
import sharedComposable from "@/composables/sharedComposable"

defineOptions({ layout: AdminLayout })
const { modal } = sharedComposable()
const props = defineProps([
  "brands",
  "totalBrands",
  "activeBrands",
  "inActiveBrands",
  "buttons",
  "segments"
])
const form = useForm({
  url: "",
  status: "1",
  type: "partner",
  image: ""
})
const editPartnerForm = ref({})
const createPartner = () => {
  form.post(route("admin.partner.store"), {
    onSuccess: () => {
      form.reset()
      createToast({
        title: "Congratulations",
        description: "Partner Created successfully"
      })
    }
  })
}
const editPartner = () => {
  if (!(editPartnerForm.value.slug instanceof File)) {
    editPartnerForm.value.slug = null
  }
  router.post(
    route("admin.partner.update", editPartnerForm.value.id),
    {
      _method: "patch",
      partner: editPartnerForm.value
    },
    {
      onSuccess: () => {
        editPartnerForm.value = {}
        createToast({
          title: "Congratulations",
          description: "Category Updated successfully"
        })
      }
    }
  )
}
</script>
