<script setup>
"use strict";
import { Head } from '@inertiajs/vue3'
import moment from 'moment'
import FrontendLayout from '@/Pages/Frontend/Layout/App.vue'
import DashboardLayout from '@/Pages/Frontend/Dashboard/Layout/App.vue'
import sharedComposable from '@/composables/sharedComposable'

const props = defineProps(['order', 'invoice_data', 'meta', 'prompts'])
defineOptions({ layout: [FrontendLayout, DashboardLayout] })
const { formatCurrency, ToastAlert } = sharedComposable()
</script>
<template>
  <Head title="Orders" />
  <section class="upcoming__area pb-120">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h2 class="base-text">{{ trans('Invoice') }}</h2>
          <div class="d-flex justify-content-between align-items-center">
            <div class="base-text">{{ trans('Invoice ID') }} {{ order.invoice_no }}</div>
            <p
              :class="
                order.status == 2
                  ? 'badge bg-warning'
                  : order.status == 1
                  ? 'badge bg-success'
                  : 'badge bg-danger'
              "
            >
              {{
                order.status === 0
                  ? trans('Incomplete')
                  : order.status === 1
                  ? trans('Complete')
                  : order.status === 2
                  ? trans('Pending')
                  : ''
              }}
            </p>
          </div>

          <hr />
          <div class="row">
            <div class="col-md-6">
              <address class="base-text">
                <strong>{{ trans('Billed To:') }}</strong
                ><br />
                {{ trans('Name') }}: {{ order.user.name }}<br />
                {{ trans('Address') }}: {{ order.user.address || 'none' }}<br />
                {{ trans('Email') }}: {{ order.user.email }}<br />
                {{ trans('Phone') }}: {{ order.user.phone || 'none' }}<br />
              </address>
            </div>
            <div class="col-md-6 text-md-right">
              <address class="base-text text-right">
                <strong>{{ trans('Billed From:') }}</strong
                ><br />
                {{ invoice_data.company_name }}<br />
                {{ invoice_data.address }}<br />
                {{ invoice_data.city }} <br />
                {{ invoice_data.post_code }}<br />
                {{ invoice_data.country }}
              </address>
            </div>
          </div>
          <div class="row base-text">
            <div class="col-md-6">
              <address>
                <strong>{{ trans('Payment Method:') }}</strong
                ><br />
                {{ trans('Name:') }} {{ order.gateway.name }}<br />
                {{ trans('Pay Id:') }} {{ order.payment_id }}<br />
              </address>
            </div>
            <div class="col-md-6 text-right">
              <address>
                <strong>{{ trans('Order Date:') }}</strong>
                {{ moment(order.created_at).format('DD-MM-YYYY') }}<br />
              </address>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xxl-12">
        <div class="upcoming__wrapper">
          <div class="upcoming__item">
            <div class="upcoming__table">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">{{ trans('Preview') }}</th>
                    <th scope="col">{{ trans('Name') }}</th>
                    <th scope="col">{{ trans('Model') }}</th>
                    <th scope="col">{{ trans('Price') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="prompt in prompts" :key="prompt.id">
                    <td>
                      <img
                        v-if="prompt.preview"
                        class="rounded"
                        width="80"
                        v-lazy="prompt.preview"
                        alt="preview"
                      />
                      <img
                        v-else
                        class="rounded"
                        width="80"
                        v-lazy="JSON.parse(prompt.meta).preview"
                        alt="preview"
                      />
                    </td>
                    <td>
                      <Link
                        :href="
                          route('user.orders.prompt.show', {
                            id: order.id,
                            slug: prompt.slug
                          })
                        "
                        v-if="order.status == 1"
                        >{{ prompt.title }}</Link
                      >
                      <a
                        href="javascript:void(0)"
                        @click="
                          ToastAlert(
                            trans('!Opps sorry'),
                            trans('The the order still in review for approval'),
                            'danger'
                          )
                        "
                        v-else
                      >
                        {{ prompt.title }}
                      </a>
                    </td>

                    <td>{{ prompt.model_title }}</td>
                    <td class="text-left">{{ formatCurrency(prompt.price) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <template v-if="meta">
          <div class="col-lg-8">
            <div class="section-title base-text">{{ trans('Payment Info:') }}</div>
            <br />
            <p class="section-lead base-text">{{ meta.comment }}</p>
            <p class="section-lead base-text">
              <a target="_blank" class="text-danger" :href="meta.screenshot">{{
                trans('Attachment')
              }}</a>
            </p>
          </div>
        </template>
        <div class="d-flex justify-content-end">
          <div class="col-lg-4 text-right base-text">
            <div class="invoice-detail-item">
              <div class="invoice-detail-name">
                {{ trans('Subtotal:') }} {{ formatCurrency(order.amount) }}
              </div>
            </div>
            <div class="invoice-detail-item">
              <div class="invoice-detail-name">
                {{ trans('Tax:') }} {{ formatCurrency(order.tax) }}
              </div>
            </div>
            <hr class="mt-2 mb-2" />
            <div class="invoice-detail-item">
              <div class="invoice-detail-value invoice-detail-value-lg">
                {{ trans('Total:') }}
                {{ formatCurrency(order.tax + order.amount) }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
