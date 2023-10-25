<template>
  <HeaderSegment title="Supports" :segments="segments" :buttons="buttons" />
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
                      {{ total }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-tickets-airline mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Total Tickets") }}
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
                      {{ openSupport }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-ticket-airline mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Open Tickets") }}
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
                      {{ pendingSupport }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-ticket-alt mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Pending Supports") }}
                </h5>
                <p></p>
              </div>
            </div>
          </div>
        </div>

        <template v-if="supports.data.length != 0">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12 table-responsive">
                  <table class="table col-12">
                    <thead>
                      <tr>
                        <th class="col-8">{{ trans("Subject") }}</th>
                        <th class="col-1">{{ trans("Conversations") }}</th>
                        <th class="col-1">{{ trans("Status") }}</th>
                        <th class="col-1 text-left">
                          {{ trans("Created At") }}
                        </th>
                        <th class="col-1 text-left">{{ trans("Ticket") }}</th>
                      </tr>
                    </thead>
                    <tbody class="tbody">
                      <tr v-for="support in supports.data" :key="support.id">
                        <td>
                          <Link
                            class="text-dark"
                            :href="route('user.support.show', support.id)"
                          >
                            {{ support.subject }}
                          </Link>
                        </td>
                        <td class="text-center">
                          {{ support.conversations_count }}
                        </td>
                        <td>
                          <span
                            class="badge"
                            :class="
                              support.status == 2
                                ? 'badge badge-warning'
                                : support.status == 1
                                ? 'badge badge-success'
                                : 'badge badge-danger'
                            "
                          >
                            {{
                              support.status == 2
                                ? "pending"
                                : support.status == 1
                                ? "Open"
                                : "Closed"
                            }}
                          </span>
                        </td>
                        <td class="text-center">
                          {{ moment(support.created_at).format("D MMM y") }}
                        </td>
                        <td>
                          <Link
                            :href="route('user.support.show', support.id)"
                            class="btn btn-neutral btn-sm"
                            >{{ trans("View Ticket") }}
                          </Link>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="d-flex justify-content-center">
                    <Paginate
                      :links="supports.links"
                      :currentPage="supports.current_page"
                      :from="supports.from"
                      :lastPage="supports.last_page"
                      :lastPageUrl="supports.last_page_url"
                      :nextpageurl="supports.next_page_url"
                      :perPage="supports.per_page"
                      :prevPageUrl="supports.prev_page_url"
                      :to="supports.to"
                      :total="supports.total"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </template>
        <template v-if="supports.data.length == 0">
          <div class="alert bg-gradient-primary text-white">
            <span class="text-left">{{
              trans("Opps you have not created any support now....")
            }}</span>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>

<script setup>
"use strict";

import AdminLayout from "@/Pages/User/Layout/App.vue";
import HeaderSegment from "@/Pages/User/Layout/HeaderSegment.vue";
import Paginate from "@/Components/Paginate.vue";
import moment from 'moment';

defineOptions({layout: AdminLayout})

const props = defineProps([
'supports' ,
'openSupport' ,
'pendingSupport' ,
'total' ,
'buttons' ,
'segments' ,
]);

</script>