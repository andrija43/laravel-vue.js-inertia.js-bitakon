<template>
  <Head title="Customer Profile" />
  <HeaderSegment
    :title="trans('Customer')"
    :segments="segments"
    :buttons="buttons"
  />
  <div class="container-fluid mt--6">
    <div class="row">
      <div class="col-sm-4">
        <div class="card card-profile">
          <div class="card-img-top bg-gradient-info ">
            <img
            :src="
              customer.cover_image
                ? customer.cover_image
                : `/assets/img/creator/creator-bg.jpg`
            "
            class="user-profile-bg"
            alt=""
          />
          </div>
          <div class="row justify-content-center">
            <div class="col-lg-3 order-lg-2">
              <div class="card-profile-image">
                <a href="#">
                  <img
                    :src="
                      customer.avatar == null
                        ? 'https://ui-avatars.com/api/?name=' + customer.name
                        : customer.avatar
                    "
                    class="rounded-circle"
                  />
                </a>
              </div>
            </div>
          </div>

          <div class="card-body pt-2">
            <div class="row">
              <div class="col">
                <div class="card-profile-stats d-flex justify-content-center">
                  <div>
                    <span class="heading">{{ customer.orders_count }}</span>
                    <span class="description">{{ trans("Orders") }}</span>
                  </div>
                  <div>
                    <span class="heading"><span
                      :class="
                        customer.status == 1
                          ? 'badge badge-success badge-sm'
                          : 'badge badge-danger badge-sm'
                      "
                      ><small>{{
                        customer.status == 1 ? "Active" : "Suspended"
                      }}</small></span
                    ></span>
                    <span class="description">{{ trans("Status") }}</span>
                  </div>
                 
                </div>
              </div>
            </div>
            <div class="text-center">
              <h5 class="h3">
                {{ customer.name }}
              </h5>
              <div class="h5 font-weight-300">
                <i class="ni location_pin mr-2"></i>{{ trans("Join Date: ") }}
                {{ customer.created_at_date }}<br />
                <i class="ni location_pin mr-2"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-8">
        <div class="card">
          <div class="card-body">
            <div
              class="timeline timeline-one-side"
              data-timeline-content="axis"
              data-timeline-axis-style="dashed"
            >
              <div class="timeline-block">
                <span class="timeline-step badge-success">
                  <i class="ni ni-circle-08"></i>
                </span>
                <div class="timeline-content">
                  <small class="text-muted font-weight-bold">{{
                    trans("Bio")
                  }}</small>
                  <p>{{ trans("Name : ") }} {{ customer.name }}</p>
                  <p>{{ trans("Email : ") }} {{ customer.email }}</p>
                  <p>{{ trans("Phone : ") }} {{ customer.phone }}</p>
                  <p>{{ trans("Address : ") }} {{ customer.address }}</p>
                </div>
              </div>
              <div class="timeline-block">
                <span class="timeline-step badge-danger">
                  <i class="ni ni-chart-pie-35"></i>
                </span>
                <div class="timeline-content">
                  <small class="text-muted font-weight-bold">{{
                    trans("Other Info")
                  }}</small>
                  <p>
                    {{ trans("Prompts:") }}
                    {{ orderInfo.prompts }}
                  </p>
                  <p>
                    {{ trans("Collections:") }} 
                    {{ orderInfo.collections }}
                  </p>
                  <p>
                    {{ trans("Order Created:") }}
                    {{ orderInfo.order_created }}
                  </p>
                  <p>
                    {{ trans("Total Sells:") }} 
                    {{ orderInfo.order_received }}
                  </p>
                </div>
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
            <h3 class="mb-0">{{ trans("Orders") }}</h3>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th class="col-1">{{ trans("Order No") }}</th>
                  <th class="col-2">{{ trans("Payment Mode") }}</th>
                  <th class="col-1">{{ trans("Amount") }}</th>
                  <th class="col-1">{{ trans("Status") }}</th>

                  <th class="col-2">{{ trans("Created At") }}</th>
                  <th class="col-1">{{ trans("View") }}</th>
                </tr>
              </thead>

              <tbody class="list" v-if="orders.length != 0">
                <tr v-for="order in orders.data" :key="order.id">
                  <td>
                    <Link :href="route('admin.order.show', order.id)">
                      {{ order.invoice_no }}
                    </Link>
                  </td>

                  <td>
                    {{ order.gateway.name }}
                  </td>

                  <td>
                    {{ formatCurrency(order.amount) }}
                  </td>
                  <td>
                    <span
                      :class="
                        order.status == 2
                          ? 'badge badge-warning'
                          : order.status == 1
                          ? 'badge badge-success'
                          : 'badge badge-danger'
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
                  </td>

                  <td>
                    {{ order.created_at_diff }}
                  </td>
                  <td>
                    <Link
                      :href="route('admin.order.show', order.id)"
                      class="btn btn-neutral btn-sm"
                      >{{ trans("View") }}</Link
                    >
                  </td>
                </tr>
              </tbody>
            </table>

            <div v-if="orders.data.length == 0" class="text-center mt-2">
              <div class="alert bg-gradient-primary text-white">
                <span class="text-left">{{
                  trans("!Opps no orders found")
                }}</span>
              </div>
            </div>
          </div>
          <div class="card-footer py-4">
            <Paginate :links="orders.links" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
"use strict";

import AdminLayout from "@/Pages/Admin/Layout/App.vue";
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue";
import Paginate from "@/Components/Paginate.vue";
import { Head } from '@inertiajs/vue3';
import sharedComposable from '@/composables/sharedComposable';

defineOptions({layout: AdminLayout})
const props = defineProps(['customer','orders','segments','buttons','orderInfo']);
const {formatCurrency} = sharedComposable()
</script>