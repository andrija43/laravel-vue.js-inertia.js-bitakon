<template>
  <HeaderSegment title="Order" :segments="segments" :buttons="buttons" />
  <div class="container-fluid mt--6">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <div class="invoice">
              <div class="invoice-print">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="invoice-title">
                      <span
                        :class="
                          order.status == 2
                            ? 'float-right badge badge-warning'
                            : order.status == 1
                            ? 'float-right badge badge-success'
                            : 'float-right badge badge-danger'
                        "
                      >
                        {{
                          order.status == 2
                            ? "pending"
                            : order.status == 1
                            ? "approved"
                            : "declined"
                        }}
                      </span>
                      <h2>{{ trans("Invoice") }}</h2>
                      <div class="invoice-number">
                        {{ trans("Order") }} {{ order.invoice_no }}
                      </div>
                    </div>

                    <hr />
                    <div class="row">
                      <div class="col-md-6">
                        <address>
                          <strong>{{ trans("Billed To:") }}</strong
                          ><br />
                          {{ trans("Name") }}: {{ order.user.name }}<br />
                          {{ trans("Address") }}: {{ order.user.address }}<br />
                          {{ trans("Email") }}: {{ order.user.email }}<br />
                          {{ trans("Phone") }}: {{ order.user.phone }}<br />
                        </address>
                      </div>
                      <div class="col-md-6 text-md-right">
                        <address>
                          <strong>{{ trans("Billed From:") }}</strong
                          ><br />
                          {{ invoice_data.company_name }}<br />
                          {{ invoice_data.address }}<br />
                          {{ invoice_data.city }} <br />
                          {{ invoice_data.post_code }}<br />
                          {{ invoice_data.country }}
                        </address>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <address>
                          <strong>{{ trans("Payment Method:") }}</strong
                          ><br />
                          {{ trans("Name:") }} {{ order.gateway.name }}<br />
                          {{ trans("Pay Id:") }} {{ order.payment_id }}<br />
                        </address>
                      </div>
                      <div class="col-md-6 text-md-right">
                        <address>
                          <strong>{{ trans("Order Date:") }}</strong>
                          {{ moment(order.created_at).format("DD-MM-YYYY")
                          }}<br />
                        </address>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row mt-4">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-md">
                        <tbody>
                          <tr>
                            <td class="col-2">
                              {{ trans("Preview") }}
                            </td>
                            <td class="col-3">
                              {{ trans("Prompt Title") }}
                            </td>
                            <td class="col-4">
                              {{ trans("Model Title") }}
                            </td>
                            <td class="col-3 text-right">
                              {{ trans("Price") }}
                            </td>
                          </tr>
                          <tr v-for="item in orderitems" :key="item.id">
                            <td>
                              <img
                                width="100"
                                class="rounded"
                                :src="
                                  item.prompt.preview
                                    ? item.prompt.preview
                                    : JSON.parse(item.prompt.meta).preview
                                "
                                alt="preview"
                              />
                            </td>
                            <td>{{ item.prompt.title }}</td>
                            <td>{{ item.prompt.promptmodel.title }}</td>
                            <td class="text-right">
                              {{ formatCurrency(item.prompt.price) }}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="row mt-4">
                      <div class="col-lg-8">
                        <template v-if="meta != null">
                          <div class="section-title ">
                            {{ trans("Payment Info:") }}
                          </div>
                          <br />
                          <p class="section-lead ">{{ meta.comment }}</p>
                          <p class="section-lead">
                            <a target="_blank" :href="meta.screenshot">
                              {{ trans("Attachment") }}
                            </a>
                          </p>
                        </template>
                      </div>
                      <div class="col-lg-4 text-right">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">
                            {{ trans("Subtotal:") }}
                            {{ formatCurrency(order.amount) }}
                          </div>
                        </div>
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">
                            {{ trans("Tax:") }} {{ formatCurrency(order.tax) }}
                          </div>
                        </div>
                        <hr class="mt-2 mb-2" />
                        <div class="invoice-detail-item">
                          <div
                            class="invoice-detail-value invoice-detail-value-lg"
                          >
                            {{ trans("Total:") }}
                            {{ formatCurrency(order.tax + order.amount) }}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr />
              <div class="text-md-right">
                <form
                  method="POST"
                  @submit.prevent="form.put('/admin/order/'+order.id)"
                >
                  <div class="row">
                    <div class="form-group col-sm-3">
                      <label class="float-left">{{
                        trans("Order Status")
                      }}</label>
                      <select
                        class="form-control"
                        name="status"
                        v-model="form.status"
                      >
                        <option value="1">{{ trans("Approved") }}</option>
                        <option value="2">{{ trans("Pending") }}</option>
                        <option value="0">{{ trans("Rejected") }}</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <br />
                      <button
                        class="btn btn-neutral btn-icon icon-left mt-2 submit-btn"
                        :disabled="form.processing"
                      >
                        {{ trans("Update") }}
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
"use strict";
import AdminLayout from "@/Pages/Admin/Layout/App.vue";
import moment from 'moment';
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue";
import { trans } from 'laravel-vue-i18n';
import { useForm } from '@inertiajs/vue3';
import sharedComposable from '@/composables/sharedComposable';
const props = defineProps(['order','invoice_data','segments','buttons','meta','orderitems']);
defineOptions({layout: AdminLayout})
const form = useForm({
  status: props.order.status,
})


const {formatCurrency} = sharedComposable()
</script>