<template>
  <Head title="Customers" />
  <HeaderSegment
    :title="trans('Customers')"
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
                      {{ totalCustomers }}
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
                  {{ trans("Total Customers") }}
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
                      {{ totalActiveCustomers }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-map-marker-check mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Active Customers") }}
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
                      {{ totalExpiredCustomers }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-user-time mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Expired Customers") }}
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
                      {{ totalSuspendedCustomers }}
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
                  {{ trans("Suspended Customers") }}
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
            <h3 class="mb-0">{{ trans("Customers") }}</h3>
            <form
              @submit.prevent="filterData.get('/admin/customer')"
              class="card-header-form"
            >
              <div class="input-group">
                <input
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
                  <option value="email">{{ trans("User Email") }}</option>
                  <option value="name">{{ trans("Name") }}</option>
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
                  <th class="col-2">{{ trans("Name") }}</th>
                  <th class="col-2">{{ trans("Email") }}</th>
                  <th class="col-2">{{ trans("Wallet") }}</th>
                  <th class="col-2">{{ trans("Credit") }}</th>
                  <th class="col-1">{{ trans("Orders") }}</th>
                  <th class="col-1">{{ trans("Status") }}</th>
                  <th class="col-1 text-left">{{ trans("Created At") }}</th>
                  <th class="col-1 text-left">{{ trans("Action") }}</th>
                </tr>
              </thead>

              <tbody class="list" v-if="customers.length != 0">
                <tr v-for="customer in customers.data" :key="customer.id">
                  <td class="text-left">
                    {{ customer.name }}
                  </td>
                  <td>
                    <a class="text-dark" :href="`mailto:${customer.email}`">
                      {{ customer.email }}
                    </a>
                  </td>

                  <td>
                    {{ customer.wallet }}
                  </td>
                  <td>
                    {{ customer.credits }}
                  </td>
                  <td class="text-center">
                    {{ customer.orders_count }}
                  </td>

                  <td>
                    <span
                      :class="
                        customer.status == 1
                          ? 'badge badge-success'
                          : 'badge badge-danger'
                      "
                    >
                      {{ customer.status == 1 ? "Active" : "Suspended" }}
                    </span>
                  </td>

                  <td class="text-center">
                    {{ customer.created_at_date }}
                  </td>
                  <td>
                    <div class="dropdown">
                      <a
                        class="btn btn-sm btn-icon-only text-light"
                        href="#"
                        role="button"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                      >
                        <i class="fas fa-ellipsis-v"></i>
                      </a>
                      <div
                        class="dropdown-menu dropdown-menu-right dropdown-menu-arrow"
                      >
                        <Link
                          class="dropdown-item"
                          :href="'/admin/customer/' + customer.id"
                          >{{ trans("View") }}</Link
                        >
                        <Link
                          class="dropdown-item"
                          :href="`/admin/customer/${customer.id}/edit`"
                          >{{ trans("Edit") }}</Link
                        >
                        <Link
                          class="dropdown-item delete-confirm"
                          href="#"
                          @click="
                            modal.initiate('/admin/customer/' + customer.id)
                          "
                          >{{ trans("Remove") }}</Link
                        >
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>

            <div class="text-center mt-2" v-if="customers.length == 0">
              <div class="alert bg-gradient-primary text-white">
                <span class="text-left">{{
                  trans("!Opps no records found")
                }}</span>
              </div>
            </div>
          </div>
          <div class="card-footer py-4">
            <Paginate :links="customers.links" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
"use strict";

import AdminLayout from "@/Pages/Admin/Layout/App.vue"
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue"
import sharedComposable from "@/composables/sharedComposable"
import { Head, useForm } from "@inertiajs/vue3"
defineOptions({ layout: AdminLayout })
const { modal } = sharedComposable()
const props = defineProps([
  "segments",
  "buttons",
  "customers",
  "request",
  "type",
  "totalCustomers",
  "totalActiveCustomers",
  "totalSuspendedCustomers",
  "totalExpiredCustomers"
])
const filterData = useForm({
  search: props.request.search,
  type: props.type ? props.type : "email"
})
</script>
