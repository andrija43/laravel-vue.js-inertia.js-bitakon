<template>
  <HeaderSegment title="Reports" :segments="segments" :buttons="buttons" />
  <div class="container-fluid mt--6">
    <div class="row">
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
                      {{ totalReports }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi-rs-megaphone mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Total Reports") }}
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
                      {{ last7DayReports }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi-rs-calendar-week mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Last 7 Day Reports") }}
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
                      {{ last30DayReports }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi-rs-calendar mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Last 30 Day Reports") }}
                </h5>
                <p></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <!-- Card header -->
          <div class="card-header border-0">
            <h3 class="mb-0">{{ trans("Reports") }}</h3>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th class="col-3">{{ trans("Prompt") }}</th>                 
                  <th class="text-left col-7">{{ trans("Comment") }}</th>
                  <th class="text-right col-2">
                    {{ trans("Reporter") }}
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="report in reports.data" :key="report.id">
                  <td>
                    <a
                      target="_blank"
                      :href="`${host}/prompt/${report.prompt.slug}`"
                    >
                    <img
                      class="mr-3 rounded"
                      width="50"
                      :src="
                        report.prompt.preview
                          ? report.prompt.preview
                          : JSON.parse(report.prompt.meta).preview
                      "
                      alt="preview"
                    />
                    {{ textExcerpt(report.prompt.title, 30) }}
                    </a>
                  </td>
                  
                  <td class="text-left">
                    {{ textExcerpt(report.comment, 200) }}
                  </td>
                  <td class="text-right">
                    <Link preserve-scroll :href="route('admin.customer.show',report.user_id)">
                    {{ textExcerpt(report.user.name, 30) }}
                    </Link>
                  </td>
                </tr>
              </tbody>
            </table>
            <template v-if="reports.data.length == 0">
                    <div class="text-center mt-2">
                       <div class="alert bg-gradient-primary text-white">
                          <span class="text-left">{{
                          trans("!Opps no records found")
                          }}</span>
                       </div>
                    </div>
            </template>
          </div>

          <div class="card-footer py-4">
            <Paginate :links="reports.links" />
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

defineOptions({ layout: AdminLayout })

const { textExcerpt } = sharedComposable()
const props = defineProps([
  "reports",
  "buttons",
  "segments",
  "totalReports",
  "last7DayReports",
  "last30DayReports"
])
const host = window.location.origin
</script>
