<template>
  <HeaderSegment title="Credit logs" :segments="segments" :buttons="buttons" />
  <div class="container-fluid mt--6">
    <div class="row">
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
                      {{ totalCreditlog }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-file-invoice-dollar mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Total Credit Requests") }}
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
                      {{ activeCreditlog }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-money-check mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Approved Credits Orders") }}
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
                      {{ inactiveCreditlog }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-crossed-eye mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Pending Credit Orders") }}
                </h5>
                <p></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <!-- Card header -->
          <div class="card-header border-0">
            <h3 class="mb-0">{{ trans("Credit logs") }}</h3>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th>{{ trans("Date") }}</th>
                  <th>{{ trans("User Name") }}</th>
                  <th>{{ trans("Credits") }}</th>

                  <th>
                    {{ trans("Price") }}
                  </th>
                  <th>
                    {{ trans("Status") }}
                  </th>
                  <th>
                    {{ trans("Gateway") }}
                  </th>
                  <th>
                    {{ trans("Comment") }}
                  </th>
                  <th>
                    {{ trans("Attachment") }}
                  </th>
                  <th class="col-2 text-right">
                    {{ trans("Action") }}
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="creditlog in creditlogs.data" :key="creditlog.id">
                  <td class="text-left">
                    {{ moment(creditlog.updated_at).format("DD MMM, YYYY") }}
                  </td>
                  <td class="text-left">
                    <Link :href="'/admin/customer/' + creditlog.user_id">
                      {{ textExcerpt(creditlog.user.name, 30) }}
                    </Link>
                  </td>
                  <td class="text-left">
                    {{ creditlog.credits }}
                  </td>
                  <td class="text-left">
                    {{ formatCurrency(creditlog.price) }}
                  </td>
                  <td>
                    <span
                      :class="
                        creditlog.status == 1
                          ? 'badge badge-success'
                          : 'badge badge-warning'
                      "
                    >
                      {{ creditlog.status == 1 ? "Complete" : "Pending" }}
                    </span>
                    
                  </td>
                  <td>
                    {{ creditlog.gateway.name }}
                  </td>
                  <td>
                    <span v-if="creditlog?.meta">
                      {{ JSON.parse(creditlog.meta).comment }}
                    </span>
                    <span v-else>{{ trans("None") }}</span>
                  </td>
                  <td>
                    <template v-if="creditlog?.meta">
                      <a :href="JSON.parse(creditlog.meta).screenshot" target="_blank">{{ trans('View Attachment') }}</a>
                    </template>
                    <span v-else>{{ trans("None") }}</span>
                  </td>
                  <td class="text-right">
                    <a
                          class="btn btn-neutral btn-sm"
                          @click="editCreditlogForm = creditlog"
                          href="#"
                          data-toggle="modal"
                          data-target="#editModal"
                        >
                         {{ trans("Edit Order") }}</a
                        >
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="text-center mt-2" v-if="creditlogs.data.length == 0">
              <div class="alert bg-gradient-primary text-white">
                <span class="text-left">{{
                  trans("!Opps no records found")
                }}</span>
              </div>
            </div>
          </div>

          <div class="card-footer py-4">
            <Paginate :links="creditlogs.links" />
          </div>
        </div>
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
          @submit.prevent="editReview"
          
          
        >
          <div class="modal-header">
            <h3>{{ trans("Edit Order") }}</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ trans("Status") }}</label>
              <select v-model="editCreditlogForm.status" class="form-control">
                <option value="1" :selected="editCreditlogForm.status === 1">
                  {{ trans("Approved") }}
                </option>
                <option value="0" :selected="editCreditlogForm.status === 0">
                  {{ trans("Pending") }}
                </option>
              </select>
            </div>
            <div class="form-group">
              <label>{{ trans("Credits") }}</label>
              <input
                v-model="editCreditlogForm.credits"
                class="form-control"
                maxlength="500"
                required
              />
            </div>
            <div class="form-group">
              <label>{{ trans("Payment ID:") }}</label>
              <br>
              <span class="text-primary">{{ editCreditlogForm.payment_id }}</span>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-neutral submit-button">
                {{ trans("Update") }}
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>



  <div
    class="modal fade"
    id="per_credit_fee"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <form
          method="POST"
          @submit.prevent="creditfeeUpdate"
          class="ajaxform_instant_reload"
          enctype="multipart/form-data"
        >
          <div class="modal-header">
            <h3>{{ trans("Edit charge") }}</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ trans("Per credit recharge fee") }}</label>
              <input
                type="number"
                step="any"
                required
                v-model="creditfeeForm.per_credit_fee"
                class="form-control"
              />
            </div>
           
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-neutral submit-button">
              {{ trans("Save changes") }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>  

  <div
    class="modal fade"
    id="image_generate_charge"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <form
         
          @submit.prevent="generateImageChargeUpdate"
         
        >
          <div class="modal-header">
            <h3>{{ trans("Edit charge for per image generation") }}</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ trans("Credit Fee") }}</label>
              <input
                type="number"
                step="any"
                required
                v-model="generateChargeForm.image_generate_charge"
                class="form-control"
              />
            </div>
           
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-neutral submit-button">
              {{ trans("Save changes") }}
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
import { router, useForm } from "@inertiajs/vue3"
import sharedComposable from "@/composables/sharedComposable"
import Paginate from "@/Components/Paginate.vue"
import { ref } from "vue"
import moment from "moment"

defineOptions({ layout: AdminLayout })
const { textExcerpt, modal, ToastAlert, formatCurrency } = sharedComposable()
const props = defineProps([
  "creditlogs",
  "buttons",
  "segments",
  "totalCreditlog",
  "activeCreditlog",
  "inactiveCreditlog",
  "per_credit_fee",
  "image_generate_charge"
])

const editCreditlogForm = ref({})

const creditfeeForm = useForm({
  per_credit_fee: props.per_credit_fee
});

const generateChargeForm = useForm({
  image_generate_charge: props.image_generate_charge
});

const creditfeeUpdate = () => {
  router.put(
    route("admin.updateCreditCharge"),
    creditfeeForm,
    {
      onSuccess: () => {
        ToastAlert("Congratulations",'Credit fee updated successfully')
      }
    }
  )
}

const generateImageChargeUpdate = () => {
  router.put(
    route("admin.updateImageGenerateCharge"),
    generateChargeForm,
    {
      onSuccess: () => {
        ToastAlert("Congratulations", 'Image generate charge updated successfully')
      }
    }
  )
}

const editReview = () => {
  router.patch(
    route("admin.credit-logs.update", editCreditlogForm.value.id),
    editCreditlogForm.value,
    {
      onSuccess: () => {
        ToastAlert("Updated", "Creditlog Updated successfully")
      }
    }
  )
}
</script>
