<script setup>
"use strict";
import { Head } from "@inertiajs/vue3";
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue";
import DashboardLayout from "@/Pages/Frontend/Dashboard/Layout/App.vue";
import Paginate from "@/Components/Paginate.vue";
import EmptyMessage from "@/Pages/Frontend/Layout/EmptyMessage.vue";
const props = defineProps(["orders"]);
defineOptions({ layout: [FrontendLayout, DashboardLayout] });
</script>

<template>
  <Head title="Orders" />
  <section class="upcoming__area pb-120">
    <div class="container">
      <div class="row">
        <div v-if="orders.data.length > 0" class="col-xxl-12">
          <div class="upcoming__wrapper">
            <div class="upcoming__item">
              <div class="upcoming__table">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">{{ trans("Invoice") }}</th>
                      <th scope="col">{{ trans("Amount") }}</th>
                      <th scope="col">{{ trans("Status") }}</th>
                      <th scope="col">{{ trans("Date") }}</th>
                      <th scope="col">{{ trans("Action") }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="order in orders.data" :key="order.id">
                      <td>
                        <Link :href="route('user.orders.show', order.id)"
                          >#{{ order.invoice_no }}</Link
                        >
                      </td>
                      <td class="color-red">{{ order.amountFormat }}</td>
                      <td>
                        {{
                          order.status === 0
                            ? trans("Incomplete")
                            : order.status === 1
                            ? trans("Complete")
                            : order.status === 2
                            ? trans("Pending")
                            : ""
                        }}
                      </td>
                      <td>{{ order.created_at_diff }}</td>
                      <td class="color-green product__details-meta">
                        <Link :href="route('user.orders.show', order.id)"
                          ><i class="fa-light fa-eye"></i>
                          {{ trans("View") }}</Link
                        >
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <br />
              <Paginate :links="orders.links" />
            </div>
          </div>
        </div>
        <div v-else class="breadcrumb__title text-center">
          <EmptyMessage
                    type="text"
                    message="No order record found"
                   
                  />
        </div>
      </div>
    </div>
  </section>
</template>
