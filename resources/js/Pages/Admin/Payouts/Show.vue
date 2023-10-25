<template>
  <HeaderSegment
    :title="trans('Payout - ' + payout.invoice_no)"
    :segments="segments"
    :buttons="buttons"
  />
  <div class="container-fluid mt--6">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h4>{{ trans("Payout method info") }}</h4>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>{{ trans("Name") }}</th>
                    <th>{{ trans("Charge") }}</th>
                    <th>{{ trans("Charge Type") }}</th>
                    <th>{{ trans("Delay") }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ payout.method.name || "" }}</td>
                    <td>
                      {{
                        payout.method.percent_charge > 0
                          ? payout.method.percent_charge
                          : payout.method.fixed_charge
                      }}
                    </td>
                    <td>
                      <span
                        class="badge"
                        :class="
                          payout.method.percent_charge > 0
                            ? 'badge-primary'
                            : 'badge-warning'
                        "
                      >
                        {{
                          payout.method.percent_charge > 0
                            ? trans("Percantage")
                            : trans("Fixed")
                        }}
                      </span>
                    </td>
                    <td>{{ payout.method.delay || "" }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-body">
            <h4>{{ trans("Payout info") }}</h4>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <th>{{ trans("Amount") }}</th>
                  <th>{{ trans("User") }}</th>
                  <th>{{ trans("Email") }}</th>
                  <th>{{ trans("Charge") }}</th>
                  <th>{{ trans("Status") }}</th>
                  <th>{{ trans("Created At") }}</th>
                  <th>{{ trans("Action") }}</th>
                </thead>
                <tbody>
                  <td>{{ payout.amount + payout.currency }}</td>
                  <td>{{ payout.user.name || "" }}</td>
                  <td>{{ payout.user.email || "" }}</td>
                  <td>{{ payout.charge + payout.currency }}</td>
                  <td>
                    <span
                      class="badge"
                      :class="
                        payout.status == 'pending'
                          ? 'badge-warning'
                          : payout.status == 'failed'
                          ? 'badge-danger'
                          : 'badge-success'
                      "
                    >
                      {{ payout.status }}
                    </span>
                  </td>
                  <td>{{ payout.created_at_date }}</td>
                  <td>
                    <button
                      class="btn btn-sm btn-neutral dropdown-toggle"
                      type="button"
                      id="dropdownMenuButton2"
                      data-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                      {{ trans("Action") }}
                    </button>
                    <div class="dropdown-menu">
                      <a
                        class="dropdown-item"
                        @click="
                          modal.initiate(
                            route('admin.payouts.update', payout.id),
                            'put',
                            { status: 'completed' }
                          )
                        "
                        href="javascript:void(0)"
                      >
                        <i class="fa fi-rs-check" aria-hidden="true"></i>
                        {{ trans("Approve") }}
                      </a>
                      <a
                        class="dropdown-item"
                        @click="
                          modal.initiate(
                            route('admin.payouts.update', payout.id),
                            'put',
                            { status: 'failed' }
                          )
                        "
                        href="javascript:void(0)"
                      >
                        <i class="fa fi-rs-cross-small" aria-hidden="true"></i>
                        {{ trans("Reject") }}
                      </a>
                      <a
                        class="dropdown-item"
                        @click="
                          modal.initiate(
                            route('admin.payouts.update', payout.id),
                            'put',
                            { status: 'failed', paymentStatus: 'return' }
                          )
                        "
                        href="javascript:void(0)"
                      >
                        <i class="fa fi-rs-rotate-left" aria-hidden="true"></i>
                        {{ trans("Reject & revert balance") }}
                      </a>
                    </div>
                  </td>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <tr>
                  <th>
                    <h5>{{ trans("Current Balance") }}</h5>
                  </th>
                  <td class="text-end">
                    <h5>
                      {{ formatCurrency(payout.user.wallet || 0) }}
                    </h5>
                  </td>
                </tr>
                <tr v-for="(meta, index) in JSON.parse(payout.meta)">
                  <th>
                    <h5>
                      {{ index }}
                    </h5>
                  </th>
                  <td>
                    <h5>
                      {{ meta }}
                    </h5>
                  </td>
                </tr>
              </table>
            </div>
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
defineOptions({ layout: AdminLayout })
const props = defineProps(["payout", "usermethod", "segments", "buttons"])
const { formatCurrency, modal } = sharedComposable()
</script>
