<script setup>
"use strict";

import sharedComposable from '@/composables/sharedComposable'
import AdminLayout from '@/Pages/Admin/Layout/App.vue'
import HeaderSegment from '@/Pages/Admin/Layout/HeaderSegment.vue'
import { router } from '@inertiajs/vue3'
import moment from 'moment'
import { ref, computed } from 'vue'
import VueApexCharts from 'vue3-apexcharts'
defineOptions({ layout: AdminLayout })
const props = defineProps([
  'segments',
  'buttons',
  'todaysOrder',
  'pendingOrder',
  'payoutRequest',
  'promptRequest',
  'orders',
  'creditOrders',
  'earnings',
  'topCustomer',
  'topSeller',
  'popularPrompts',
  'recentOrders',
  'topPrompts',
  'pendingPrompt',
  'recentPrompt',
  'topCollection',
  'recentPayoutRequest',
  'orderSales',
  'creditOrdersTotal',
  'request'
])
const { formatCurrency, pickBy } = sharedComposable()
const filterForm = ref({
  order_timeline: props.request?.order_timeline,
  sales_timeline: props.request?.sales_timeline,
  earning_timeline: props.request?.earning_timeline,
  credit_timeline: props.request?.credit_timeline
})

const timelineLists = ref([
  { text: 'Last 7 days', value: 7 },
  { text: 'Last 30 days', value: 30 },
  { text: 'Last 3 months', value: 90 }
])
const filter = () => {
  router.get(route('admin.dashboard.index'), pickBy(filterForm.value), {
    preserveState: true,
    preserveScroll: true,
    replace: true
  })
}
const orderChart = computed(() => {
  return {
    series: [
      {
        name: 'Orders Sales',
        data: props.orders.map((item) => item.amount)
      }
    ],
    chartOptions: {
      chart: {
        height: 350,
        type: 'area',
        toolbar: {
          show: false,
          autoSelected: 'pan'
        },
        zoom: {
          enabled: false
        }
      },
      plotOptions: {
        bar: {
          borderRadius: 1,
          columnWidth: '10%',
          dataLabels: {
            position: 'top' // top, center, bottom
          }
        }
      },
      dataLabels: {
        enabled: false
      },
      colors: ['#5E72E4'],
      xaxis: {
        type: 'date',
        categories: props.orders.map((item) => moment(item.created_at).format('DD-MM-Y'))
      },
      yaxis: {
        show: true
      }
    }
  }
})
const orderSalesChart = computed(() => {
  return {
    series: [
      {
        name: 'Commissions',
        data: props.orderSales.map((item) => item.commissions)
      }
    ],
    chartOptions: {
      chart: {
        height: 350,
        type: 'area',
        toolbar: {
          show: false,
          autoSelected: 'pan'
        },
        zoom: {
          enabled: false
        }
      },
      plotOptions: {
        bar: {
          borderRadius: 1,
          columnWidth: '10%',
          dataLabels: {
            position: 'top' // top, center, bottom
          }
        }
      },
      dataLabels: {
        enabled: false
      },
      colors: ['#5E72E4'],
      xaxis: {
        type: 'date',
        categories: props.orderSales.map((item) => moment(item.created_at).format('DD-MM-Y'))
      },
      yaxis: {
        show: true
      }
    }
  }
})
const creditChart = computed(() => {
  return {
    series: [
      {
        name: 'Credit',
        data: props.creditOrders.map((item) => item.price)
      }
    ],
    chartOptions: {
      chart: {
        type: 'area',
        height: 350,
        toolbar: {
          show: false,
          autoSelected: 'pan'
        },
        zoom: {
          enabled: false
        }
      },
      dataLabels: {
        enabled: true
      },
      stroke: {
        curve: 'smooth'
      },

      labels: props.creditOrders.map((item) => item.price),
      xaxis: {
        type: 'date',
        categories: props.creditOrders.map((item) => item.date)
      },
      colors: ['#5E72E4'],

      yaxis: {
        show: true
      }
    }
  }
})
const earningChart = computed(() => {
  return {
    series: props.earnings || [],
    chartOptions: {
      height: 160,
      chart: {
        type: 'donut'
      },
      labels: ['Commissions', 'Credits'],
      responsive: [
        {
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }
      ]
    }
  }
})
const creditOrderChart = computed(() => {
  return {
    series: [props.creditOrdersTotal.total_amount, props.creditOrdersTotal.total_credits],
    chartOptions: {
      chart: {
        type: 'donut'
      },
      height: 160,
      labels: ['Price', 'Credits'],
      responsive: [
        {
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }
      ]
    }
  }
})
</script>

<template>
  <HeaderSegment :title="trans('Dashboard')" :segments="segments" :buttons="buttons" />
  <div class="container-fluid mt--6">
    <div class="row">
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-1 text-uppercase font-weight-bold">
                    {{ trans("Today's Orders") }}
                  </p>

                  <h4>
                    {{ todaysOrder || 0 }}
                  </h4>
                </div>
              </div>
              <div class="col-4 text-end">
                <div
                  class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle"
                >
                  <i
                    class="fi fi-rs-boxes text-lg opacity-10 text-white mt-1"
                    aria-hidden="true"
                  ></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-1 text-uppercase font-weight-bold">
                    {{ trans('Pending Orders') }}
                  </p>

                  <h4>
                    {{ pendingOrder || 0 }}
                  </h4>
                </div>
              </div>
              <div class="col-4 text-end">
                <div
                  class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle"
                >
                  <i
                    class="fi fi-rs-calendar-clock text-lg opacity-10 text-white mt-1"
                    aria-hidden="true"
                  ></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-1 text-uppercase font-weight-bold">
                    {{ trans('Payout Requests') }}
                  </p>

                  <h4>
                    {{ payoutRequest || 0 }}
                  </h4>
                </div>
              </div>
              <div class="col-4 text-end">
                <div
                  class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle"
                >
                  <i
                    class="fi fi-rs-bank text-lg opacity-10 text-white mt-1"
                    aria-hidden="true"
                  ></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-1 text-uppercase font-weight-bold">
                    {{ trans('Prompt Requests') }}
                  </p>

                  <h4>
                    {{ promptRequest || 0 }}
                  </h4>
                </div>
              </div>
              <div class="col-4 text-end">
                <div
                  class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle"
                >
                  <i
                    class="fi-rs-magic-wand text-lg opacity-10 text-white mt-1"
                    aria-hidden="true"
                  ></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="card">
          <div class="card-header bg-transparent">
            <div class="col-12 d-flex align-items-center justify-content-between">
              <div class="col">
                <h6 class="text-muted text-uppercase ls-1 mb-1">
                  {{ trans('Overview') }}
                </h6>
                <h2 class="h3 mb-0">{{ trans('Sales') }}</h2>
              </div>
              <div class="navbar-nav align-items-center ml-md-auto">
                <div class="card-header-action dropdown">
                  <button
                    data-toggle="dropdown"
                    class="btn btn-neutral btn-sm dropdown-toggle overview-target"
                  >
                    {{
                      timelineLists.find((t) => t.value == filterForm.sales_timeline)?.text ||
                      timelineLists[0].text
                    }}
                  </button>
                  <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                    <li v-for="(timeline, i) in timelineLists" :key="i">
                      <button
                        @click="
                          () => {
                            filterForm.sales_timeline = timeline.value
                            filter()
                          }
                        "
                        class="dropdown-item overview-list btn-sm"
                      >
                        {{ timeline.text }}
                      </button>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <!-- Chart -->
            <div class="chart">
              <div id="orders">
                <VueApexCharts
                  height="350"
                  type="area"
                  :options="orderSalesChart.chartOptions"
                  :series="orderSalesChart.series"
                ></VueApexCharts>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="card">
          <div class="card-header bg-transparent">
            <div class="col-12 d-flex align-items-center justify-content-between">
              <div>
                <h6 class="text-uppercase text-muted ls-1 mb-1">
                  {{ trans('Performance') }}
                </h6>
                <h2 class="h3 mb-0">{{ trans('Total orders') }}</h2>
              </div>
              <div class="navbar-nav align-items-center ml-md-auto">
                <div class="card-header-action dropdown">
                  <button
                    data-toggle="dropdown"
                    class="btn btn-neutral btn-sm dropdown-toggle overview-target"
                  >
                    {{
                      timelineLists.find((t) => t.value == filterForm.order_timeline)?.text ||
                      timelineLists[0].text
                    }}
                  </button>
                  <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                    <li v-for="(timeline, i) in timelineLists" :key="i">
                      <button
                        @click="
                          () => {
                            filterForm.order_timeline = timeline.value
                            filter()
                          }
                        "
                        class="dropdown-item overview-list btn-sm"
                      >
                        {{ timeline.text }}
                      </button>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <!-- Chart -->
            <div class="chart">
              <div id="orders">
                <VueApexCharts
                  height="350"
                  type="area"
                  :options="orderChart.chartOptions"
                  :series="orderChart.series"
                ></VueApexCharts>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-8">
        <div class="card">
          <div class="card-header bg-transparent">
            <div class="col-12 d-flex align-items-center justify-content-between">
              <div class="col">
                <h6 class="text-uppercase text-muted ls-1 mb-1">
                  {{ trans('Overview') }}
                </h6>
                <h2 class="h3 mb-0">{{ trans('Credits orders') }}</h2>
              </div>
              <div class="navbar-nav align-items-center ml-md-auto">
                <div class="card-header-action dropdown">
                  <button
                    data-toggle="dropdown"
                    class="btn btn-neutral btn-sm dropdown-toggle overview-target"
                  >
                    {{
                      timelineLists.find((t) => t.value == filterForm.credit_timeline)?.text ||
                      timelineLists[0].text
                    }}
                  </button>
                  <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                    <li v-for="(timeline, i) in timelineLists" :key="i">
                      <button
                        @click="
                          () => {
                            filterForm.credit_timeline = timeline.value
                            filter()
                          }
                        "
                        class="dropdown-item overview-list btn-sm"
                      >
                        {{ timeline.text }}
                      </button>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <!-- Chart -->
            <div class="chart">
              <div id="credit">
                <VueApexCharts
                  height="350"
                  type="area"
                  :options="creditChart.chartOptions"
                  :series="creditChart.series"
                ></VueApexCharts>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card">
          <div class="card-header bg-transparent">
            <div class="col-8 d-flex align-items-center justify-content-between">
              <div>
                <h6 class="text-uppercase text-muted ls-1 mb-1">
                  {{ trans('Overview') }}
                </h6>
                <h2 class="h3 mb-0">{{ trans('Earnings (pie chart)') }}</h2>
              </div>
            </div>
            <div class="navbar-nav align-items-center ml-md-auto">
              <div class="card-header-action dropdown">
                <button
                  data-toggle="dropdown"
                  class="btn btn-neutral btn-sm dropdown-toggle overview-target"
                >
                  {{
                    timelineLists.find((t) => t.value == filterForm.earning_timeline)?.text ||
                    timelineLists[0].text
                  }}
                </button>
                <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                  <li v-for="(timeline, i) in timelineLists" :key="i">
                    <button
                      @click="
                        () => {
                          filterForm.earning_timeline = timeline.value
                          filter()
                        }
                      "
                      class="dropdown-item overview-list btn-sm"
                    >
                      {{ timeline.text }}
                    </button>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="card-body">
            <!-- Chart -->

            <VueApexCharts
              height="160"
              type="donut"
              :options="earningChart.chartOptions"
              :series="earningChart.series"
            ></VueApexCharts>

            <div class="mr-4">
              <VueApexCharts
                height="160"
                type="donut"
                :options="creditOrderChart.chartOptions"
                :series="creditOrderChart.series"
              ></VueApexCharts>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <!-- Title -->
            <h5 class="h3 mb-0">{{ trans('Top Customers') }}</h5>
          </div>
          <!-- Card body -->
          <div class="card-body">
            <!-- List group -->
            <ul class="list-group list-group-flush list my--3">
              <li class="list-group-item px-0" v-for="customer in topCustomer" :key="customer.id">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <!-- Avatar -->
                    <Link
                      target="_blank"
                      :href="route('admin.customer.show', customer.id)"
                      class="avatar rounded-circle"
                    >
                      <img
                        alt="Image"
                        :src="
                          customer.avatar || `https://ui-avatars.com/api/?name=${customer.name}`
                        "
                      />
                    </Link>
                  </div>
                  <div class="col ml--2">
                    <h4 class="mb-0">
                      <a target="_blank" :href="`/profile/${customer.username}`">
                        {{ customer.name }}
                      </a>
                    </h4>

                    <small>{{ trans('Total Orders') }}: {{ customer.orders_count }}</small>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <!-- Title -->
            <h5 class="h3 mb-0">{{ trans('Top Authors') }}</h5>
          </div>
          <!-- Card body -->
          <div class="card-body">
            <!-- List group -->
            <ul class="list-group list-group-flush list my--3">
              <li class="list-group-item px-0" v-for="seller in topSeller" :key="seller.id">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <!-- Avatar -->
                    <a
                      target="_blank"
                      :href="`/profile/${seller.username}`"
                      class="avatar rounded-circle"
                    >
                      <img
                        alt="Image"
                        :src="seller.avatar || `https://ui-avatars.com/api/?name=${seller.name}`"
                      />
                    </a>
                  </div>
                  <div class="col ml--2">
                    <h4 class="mb-0">
                      <a target="_blank" :href="`/profile/${seller.username}`">{{ seller.name }}</a>
                    </h4>
                    <small>{{ trans('Total Sold:') }} {{ seller.total_sold }}</small>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <!-- Title -->
            <h5 class="h3 mb-0">{{ trans('Popular Prompts') }}</h5>
          </div>
          <!-- Card body -->
          <div class="card-body">
            <!-- List group -->
            <ul class="list-group list-group-flush list my--3">
              <li class="list-group-item px-0" v-for="prompt in popularPrompts" :key="prompt.id">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <!-- Avatar -->
                    <a
                      target="_blank"
                      :href="route('prompt.show', prompt.slug)"
                      class="avatar rounded-circle"
                    >
                      <img
                        alt="preview "
                        :src="prompt.preview ? prompt.preview : JSON.parse(prompt.meta).preview"
                      />
                    </a>
                  </div>
                  <div class="col ml--2">
                    <h4 class="mb-0">
                      <a target="_blank" :href="route('prompt.show', prompt.slug)">
                        {{ prompt.title }}
                      </a>
                    </h4>

                    <small>{{ formatCurrency(prompt.price) }}</small>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card">
          <div class="card-header">
            <h4>
              <i class="fi fi-rs-shopping-bag text-primary"></i>
              <span class="ml-1">{{ trans('Recent Orders') }}</span>
            </h4>
          </div>
          <div class="card-body">
            <ul class="list-group list-group-flush list my--3 recent-order-list">
              <li class="list-group-item px-0" v-for="order in recentOrders" :key="order.id">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <!-- Avatar -->
                    <a target="_blank" :href="`/profile/${order.user.username}`">
                      <img
                        alt="Image"
                        :src="
                          order.user.avatar || `https://ui-avatars.com/api/?name=${order.user.name}`
                        "
                        height="45"
                      />
                    </a>
                  </div>
                  <div class="col ml--2">
                    <h4 class="mb-0">
                      <Link target="_blank" :href="route('admin.order.show', order.id)">
                        {{ order.invoice_no }}
                      </Link>
                    </h4>
                    <small class="text-muted">{{ order.name }}</small>
                  </div>
                  <div class="col-auto text-right">
                    <span class="text-right">{{ formatCurrency(order.amount) }}</span>
                    <br />
                    <span class="text-muted"
                      ><i class="fi fi-rs-clock mt-5"></i>
                      <span class="ml-1">{{ moment(order.created_at).fromNow() }}</span></span
                    >
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-8">
        <div class="card">
          <div class="card-header bg-transparent">
            <div class="row align-items-center">
              <div class="col">
                <h4>
                  <i class="fi fi-rs-megaphone text-primary mt-2"></i>
                  <span class="ml-1">{{ trans('Top Prompts') }}</span>
                </h4>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th class="col-4">{{ trans('Preview') }}</th>
                    <th class="col-4">{{ trans('Title') }}</th>
                    <th class="col-4">{{ trans('Price') }}</th>
                    <th class="col-4">{{ trans('Total Sold') }}</th>
                  </tr>
                </thead>
                <tbody class="list popular-list">
                  <tr v-for="prompt in topPrompts" :key="prompt.id">
                    <th scope="row">
                      <a
                        target="_blank"
                        :href="route('prompt.show', prompt.slug)"
                        class="avatar rounded-circle"
                      >
                        <img
                          :src="prompt.preview || JSON.parse(prompt.meta).preview"
                          alt="preview"
                        />
                      </a>
                    </th>
                    <td class="budget">
                      <a target="_blank" :href="route('prompt.show', prompt.slug)">
                        {{ prompt.title }}
                      </a>
                    </td>
                    <td>
                      {{ formatCurrency(prompt.price) }}
                    </td>
                    <td class="text-right">{{ prompt.total_sold }}</td>
                  </tr>
                </tbody>
              </table>
              <template v-if="topPrompts.length == 0">
                <div class="text-center mt-2">
                  <div class="alert bg-gradient-primary text-white">
                    <span class="text-left">{{ trans('!Opps no records found') }}</span>
                  </div>
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-4">
        <div class="card">
          <div class="card-header">
            <h4>
              <i class="fi fi-rs-shopping-bag text-primary"></i>
              <span class="ml-1">{{ trans('Pending Prompt Requests') }}</span>
            </h4>
          </div>
          <div class="card-body">
            <ul class="list-group list-group-flush list my--3 recent-order-list">
              <li class="list-group-item px-0" v-for="prompt in pendingPrompt" :key="prompt.id">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <!-- Avatar -->
                    <a target="_blank" :href="route('prompt.show', prompt.slug)">
                      <img
                        alt=""
                        width="60"
                        :src="prompt.preview || JSON.parse(prompt.meta).preview"
                      />
                    </a>
                  </div>
                  <div class="col ml--2">
                    <h4 class="mb-0">
                      <Link :href="route('admin.prompt.show', prompt.id)">
                        {{ prompt.title }}
                      </Link>
                    </h4>
                  </div>
                  <div class="col-auto text-right">
                    <span class="text-right">{{ formatCurrency(prompt.price) }}</span>
                    <br />
                    <span class="text-muted"
                      ><i class="fi fi-rs-clock pt-1"></i>
                      <span class="ml-1">{{ moment(prompt.created_at).fromNow() }}</span></span
                    >
                  </div>
                </div>
              </li>
              <template v-if="pendingPrompt.length == 0">
                <div class="text-center mt-2">
                  <div class="alert bg-gradient-primary text-white">
                    <span class="text-left">{{ trans('No prompt request available now') }}</span>
                  </div>
                </div>
              </template>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-8">
        <div class="card">
          <div class="card-header bg-transparent">
            <div class="row align-items-center">
              <div class="col">
                <h4>
                  <i class="fi-rs-hand-holding-box text-primary"></i>
                  <span class="ml-2">{{ trans('Recent Prompts') }}</span>
                </h4>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th class="col-4">{{ trans('Preview') }}</th>
                    <th class="col-4">{{ trans('Title') }}</th>
                    <th class="col-4">{{ trans('User') }}</th>
                    <th class="col-4">{{ trans('Price') }}</th>
                  </tr>
                </thead>
                <tbody class="list popular-list">
                  <tr v-for="prompt in recentPrompt" :key="prompt.id">
                    <th scope="row">
                      <a target="_blank" :href="route('prompt.show', prompt.slug)">
                        <img
                          width="60"
                          :src="prompt.preview || JSON.parse(prompt.meta).preview"
                          alt="preview"
                        />
                      </a>
                    </th>
                    <td class="budget">
                      <a target="_blank" :href="route('prompt.show', prompt.slug)">
                        {{ prompt.title }}
                      </a>
                    </td>
                    <td>
                      <Link :href="route('admin.customer.show', prompt.user_id)">
                        {{ prompt.user.name }}
                      </Link>
                    </td>
                    <td class="text-right">
                      {{ formatCurrency(prompt.price) }}
                    </td>
                  </tr>
                </tbody>
              </table>
              <template v-if="recentPrompt.length == 0">
                <div class="text-center mt-2">
                  <div class="alert bg-gradient-primary text-white">
                    <span class="text-left">{{ trans('!Opps no records found') }}</span>
                  </div>
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-4">
        <div class="card">
          <div class="card-header">
            <h4>
              <i class="fi fi-rs-shopping-bag text-primary"></i>
              <span class="ml-1">{{ trans('Top Collections') }}</span>
            </h4>
          </div>
          <div class="card-body">
            <ul class="list-group list-group-flush list my--3 recent-order-list">
              <li
                class="list-group-item px-0"
                v-for="collection in topCollection"
                :key="collection.id"
              >
                <div class="row align-items-center">
                  <div class="col-auto">
                    <a target="_blank" :href="route('collection.show', collection.slug)">
                      <img alt="" :src="collection.preview" width="60" />
                    </a>
                  </div>
                  <div class="col ml--2">
                    <h4 class="mb-0">
                      <a target="_blank" :href="route('collection.show', collection.slug)">
                        {{ collection.name }}
                      </a>
                    </h4>
                  </div>
                  <div class="col-auto text-right">
                    {{ trans('Items') }}: {{ collection.prompts_count }}
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-8">
        <div class="card">
          <div class="card-header bg-transparent">
            <div class="row align-items-center">
              <div class="col">
                <h2 class="h3 mb-0">
                  <i class="fi-rs-hand-holding-box text-primary"></i>
                  <span class="ml-2">{{ trans('Payout Requests') }}</span>
                </h2>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th class="col-3">{{ trans('Invoice') }}</th>
                    <th class="col-3">{{ trans('User') }}</th>
                    <th class="col-2">{{ trans('Method') }}</th>
                    <th class="col-2">{{ trans('Amount') }}</th>
                    <th class="col-2">{{ trans('Date') }}</th>
                  </tr>
                </thead>
                <tbody class="list popular-list">
                  <tr v-for="payout in recentPayoutRequest" :key="payout.id">
                    <th scope="row">
                      <Link :href="route('admin.payouts.show', payout.id)">{{
                        payout.invoice_no
                      }}</Link>
                    </th>
                    <td class="budget">
                      <Link :href="route('admin.customer.show', payout.user_id)">
                        {{ payout.user.name }}
                      </Link>
                    </td>
                    <td class="budget">
                      {{ payout.method?.name }}
                    </td>
                    <td>{{ formatCurrency(payout.amount) }}</td>
                    <td>
                      {{ moment(payout.created_at).fromNow() }}
                    </td>
                  </tr>
                </tbody>
              </table>
              <template v-if="recentPayoutRequest.length == 0">
                <div class="text-center mt-2">
                  <div class="alert bg-gradient-primary text-white">
                    <span class="text-left">{{ trans('!Opps no records found') }}</span>
                  </div>
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>