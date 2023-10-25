<script setup>
"use strict";
import { Head } from "@inertiajs/vue3";
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue";
import DashboardLayout from "@/Pages/Frontend/Dashboard/Layout/App.vue";
import Paginate from "@/Components/Paginate.vue";
import moment from "moment";
import sharedComposable from "@/composables/sharedComposable";
import EmptyMessage from "@/Pages/Frontend/Layout/EmptyMessage.vue";
const props = defineProps(["creditlogs"]);
defineOptions({ layout: [FrontendLayout, DashboardLayout] });
const { formatCurrency } = sharedComposable();
</script>

<template>
  <Head title="Credit Logs" />
  <section class="upcoming__area pb-120">
    <div class="container">
      <div class="row">
        <div v-if="creditlogs.data.length > 0" class="col-xxl-12">
          <div class="upcoming__wrapper">
            <div class="upcoming__item">
              <div class="upcoming__table">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">{{ trans("Date") }}</th>
                      <th scope="col">{{ trans("Credits") }}</th>
                      <th scope="col">{{ trans("Price") }}</th>
                      <th scope="col">{{ trans("Status") }}</th>
                      <th scope="col">{{ trans("Gateway") }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="creditlog in creditlogs.data"
                      :key="creditlog.id"
                    >
                      <td>
                        {{
                          moment(creditlog.updated_at).format(
                            "DD MMM Y"
                          )
                        }}
                      </td>

                      <td>
                        {{ creditlog.credits }}
                      </td>
                      <td>
                        {{ formatCurrency(creditlog.price) }}
                      </td>
                      <td>
                        <span
                          :class="
                            creditlog.status == 1
                              ? 'badge bg-success'
                              : 'badge bg-warning'
                          "
                        >
                          {{ creditlog.status == 1 ? "Complete" : "Pending" }}
                        </span>
                      </td>
                      <td>
                        {{ creditlog.gateway.name }}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <br />
              <Paginate :links="creditlogs.links" />
            </div>
          </div>
        </div>
        <div v-else class="breadcrumb__title text-center">
          <EmptyMessage
                    type="text"
                    message="No record found"
                   
                  />
          
        </div>
      </div>
    </div>
  </section>
</template>
