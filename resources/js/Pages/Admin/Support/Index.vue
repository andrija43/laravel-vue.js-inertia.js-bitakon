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
                      {{ totalSupports }}
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
                      <i class="fi fi-rs-time-forward mt-2"></i>
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
          <div class="col">
            <div class="card card-stats">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <span
                      class="h2 font-weight-bold mb-0 completed-transfers"
                      id="total-inactive"
                    >
                      {{ closedSupport }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-comment-slash mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Closed Supports") }}
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
            <h3 class="mb-0">{{ trans("Tickets") }}</h3>
            <form
              action=""
              class="card-header-form"
              method="GET"
              @submit.prevent="filterData.get('/admin/support')"
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
                  <option value="email">
                    {{ trans("User Email") }}
                  </option>
                  <option value="ticket_no">
                    {{ trans("Ticket No") }}
                  </option>
                  <option value="subject">
                    {{ trans("Subject") }}
                  </option>
                </select>
                <div class="input-group-btn">
                  <button class="btn btn-primary btn-icon">
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
                  <th class="col-1">{{ trans("Ticket No") }}</th>
                  <th class="col-6">{{ trans("Subject") }}</th>
                  <th class="col-1">
                    {{ trans("Conversations") }}
                  </th>
                  <th class="col-1">{{ trans("Status") }}</th>
                  <th class="col-1">{{ trans("User") }}</th>
                  <th class="col-1 text-left">
                    {{ trans("Created At") }}
                  </th>
                  <th class="col-1 text-left">
                    {{ trans("Ticket") }}
                  </th>
                </tr>
              </thead>

              <template v-if="supports.data.length != 0">
                <tbody class="list">
                  <tr v-for="support in supports.data" :key="support.id">
                    <td class="text-center">
                      {{ support.ticket_no }}
                    </td>
                    <td>
                      <a
                        class="text-dark"
                        :href="'/admin/support/' + support.id"
                      >
                        {{ imitedString(support.subject, 50) }}
                      </a>
                    </td>
                    <td class="text-center">
                      {{ support.conversations_count }}
                    </td>
                    <td>
                      <span
                        :class="
                          support.status == 2
                            ? 'badge badge-warning'
                            : support.status == 1
                            ? 'badge badge-success'
                            : 'badge badge-danger'
                        "
                      >
                        {{
                          trans(
                            support.status == 2
                              ? "pending"
                              : support.status == 1
                              ? "Open"
                              : "Closed"
                          )
                        }}
                      </span>
                    </td>
                    <td class="text-center">
                      <a
                        :href="'/admin/customer/' + support.user_id"
                        class="text-dark"
                      >
                        {{ support.user?.name ?? "" }}
                      </a>
                    </td>
                    <td class="text-center">
                      {{ moment(support.created_at).format("d MMM y") }}
                    </td>
                    <td>
                      <Link
                        :href="'/admin/support/' + support.id"
                        class="btn btn-neutral btn-sm"
                      >
                        {{ trans("View Ticket") }}
                      </Link>
                    </td>
                  </tr>
                </tbody>
              </template>
            </table>

            <template v-if="supports.data.length == 0">
              <div class="text-center mt-2">
                <div class="alert bg-gradient-primary text-white">
                  <span class="text-left">{{
                    trans("!Opps no support query found")
                  }}</span>
                </div>
              </div>
            </template>
          </div>
          <div class="card-footer py-4">
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

<script setup>
"use strict";
import AdminLayout from "@/Pages/Admin/Layout/App.vue";
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue";
import { Link, useForm } from "@inertiajs/vue3";

import Paginate from "@/Components/Paginate.vue";
import moment from 'moment';

defineOptions({layout: AdminLayout})

const props = defineProps([
    "segments",
    "buttons",
    "request",
    "supports",
    "pendingSupport",
    "openSupport",
    "closedSupport",
    "totalSupports",
    "type",
]);

const filterData = useForm({
    search: props.request.search,
    type: props.type,
});




function imitedString(text,maxLength) {
      if (text.length <= maxLength) {
        return text;
      } else {
        return text.substring(0, maxLength) + '...';
      }
    }
</script>
