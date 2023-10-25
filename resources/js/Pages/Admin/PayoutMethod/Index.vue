<template>
  <HeaderSegment
    title="Payout method"
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
                      {{ totalPayoutmethod }}
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
                  {{ trans("Total Payout Methods") }}
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
                      {{ totalActivePayoutmethod }}
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
                  {{ trans("Active Payout Methods") }}
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
                      {{ totalInActivePayoutmethod }}
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
                  {{ trans("Inactive Payout Methods") }}
                </h5>
                <p></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="card">
          <!-- Card header -->
          <div class="card-header border-0">
            <h3 class="mb-0">{{ trans("Payout Methods") }}</h3>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th>{{ trans("Name") }}</th>
                  <th>{{ trans("Currency") }}</th>
                  <th>{{ trans("Limit") }}</th>
                  <th class="text-center">{{ trans("Charge") }}</th>
                  <th>{{ trans("Status") }}</th>
                  <th>{{ trans("Created At") }}</th>
                  <th class="text-right">{{ trans("Action") }}</th>
                </tr>
              </thead>
              <tbody class="list" v-if="methods.data.length != 0">
                <tr v-for="method in methods.data" :key="method.id">
                  <td>
                    <img
                      :src="method.image"
                      alt=""
                      class="avatar rounded-square mr-3"
                    />
                    {{ method.name }}
                  </td>
                  <td>{{ method.currency_name }}</td>
                  <td>
                    {{ method.min_limit + " - " + method.max_limit }}
                    {{ method.currency_name }}
                  </td>
                  <td class="text-center">
                    {{
                      method.charge_type == "percentage"
                        ? method.percent_charge + "%"
                        : method.fixed_charge + " " + method.currency_name
                    }}
                  </td>
                  <td class="text-left">
                    <span
                      class="badge"
                      :class="
                        method.status == 1 ? 'badge-success' : 'badge-danger'
                      "
                    >
                      {{
                        method.status == 1 ? trans("Active") : trans("Draft")
                      }}
                    </span>
                  </td>
                  <td>
                    {{ moment(method.created_at).format("DD MMM Y") }}
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
                        <Link
                          class="dropdown-item has-icon"
                          :href="route('admin.payout-methods.edit', method.id)"
                        >
                          <i class="fi fi-rs-edit"></i
                          >{{ trans("Edit Method") }}
                        </Link>
                        <a
                          class="dropdown-item has-icon delete-confirm"
                          href="javascript:void(0)"
                          @click="
                            modal.initiate(
                              route('admin.payout-methods.destroy', method.id)
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
            <div class="text-center mt-2" v-if="methods.data.length == 0">
              <div class="alert bg-gradient-primary text-white">
                <span class="text-left">{{
                  trans("!Opps no records found")
                }}</span>
              </div>
            </div>
          </div>
          <div class="card-footer py-4">
            <Paginate
              :links="methods.links"
              :currentPage="methods.current_page"
              :from="methods.from"
              :lastPage="methods.last_page"
              :lastPageUrl="methods.last_page_url"
              :nextpageurl="methods.next_page_url"
              :perPage="methods.per_page"
              :prevPageUrl="methods.prev_page_url"
              :to="methods.to"
              :total="methods.total"
            />
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
import Paginate from "@/Components/Paginate.vue"
import moment from "moment"
const { modal } = sharedComposable()
defineOptions({ layout: AdminLayout })

const props = defineProps([
  "methods",
  "buttons",
  "segments",
  "totalPayoutmethod",
  "totalActivePayoutmethod",
  "totalInActivePayoutmethod"
])
</script>
