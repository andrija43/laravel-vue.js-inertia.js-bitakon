<script setup>
"use strict";

import { Head, router } from '@inertiajs/vue3'
import FrontendLayout from '@/Pages/Frontend/Layout/App.vue'
import AccountLayout from '@/Pages/Frontend/Account/Layout/App.vue'
import EmptyMessage from '@/Pages/Frontend/Layout/EmptyMessage.vue'
import sharedComposable from '@/composables/sharedComposable'
import VueApexCharts from 'vue3-apexcharts'
import moment from 'moment'
import { computed, ref } from 'vue'
const props = defineProps([
  'totalEarnings',
  'dailyEarnings',
  'dailyEarningSales',
  'dailyEarningDates',
  'monthlyOrders',
  'monthlyOrdersTotal',
  'recentOrders',
  'topSold',
  'timeline'
])
const { pickBy, formatCurrency, textExcerpt } = sharedComposable()
defineOptions({ layout: [FrontendLayout, AccountLayout] })
const filterForm = ref({
  timeline: props.timeline
})
const filter = () => {
  router.get('/account', pickBy(filterForm.value), {
    preserveState: true,
    preserveScroll: true
  })
}
const earningChart = computed(() => {
  return {
    series: [
      {
        name: 'Earning',
        data: props.dailyEarningSales
      }
    ],
    chartOptions: {
      chart: {
        type: 'area',
        height: 200,
        toolbar: {
          show: false,
          autoSelected: 'pan'
        },
        zoom: {
          enabled: false
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth'
      },

      labels: props.dailyEarningSales,
      xaxis: {
        type: 'date',
        categories: props.dailyEarningDates
      },
      colors: ['#F5841B'],
      tooltip: {
        x: {
          format: 'dd MMM'
        }
      },
      yaxis: {
        show: false,
        opposite: true,
        labels: {
          formatter: function (val) {
            return val.toFixed(2)
          }
        }
      },
      legend: {
        horizontalAlign: 'right'
      }
    }
  }
})
const salesChart = computed(() => {
  return {
    series: [
      {
        name: 'Sales Amount',
        data: props.monthlyOrders.map((item) => item.amount)
      }
    ],
    chartOptions: {
      chart: {
        type: 'area',
        height: 300,
        toolbar: {
          show: false,
          autoSelected: 'pan'
        },
        zoom: {
          enabled: false
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth'
      },
      colors: ['#64BE44'],
      labels: props.monthlyOrders.map((item) => item.amount),
      xaxis: {
        type: 'date',
        categories: props.monthlyOrders.map((item) => item.date)
      },
      yaxis: {
        show: false,
        opposite: true,
        labels: {
          formatter: function (val) {
            return val.toFixed(2)
          }
        }
      },
      legend: {
        horizontalAlign: 'right'
      }
    }
  }
})

const orderChart = computed(() => {
  return {
    series: [
      {
        name: 'Orders',
        data: props.monthlyOrders.map((item) => item.total_orders)
      }
    ],
    chartOptions: {
      chart: {
        height: 200,
        type: 'bar',
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
      colors: ['#C0234A'],
      xaxis: {
        type: 'date',
        categories: props.monthlyOrders.map((item) => item.date)
      },
      yaxis: {
        show: false,
        opposite: true,
        labels: {
          formatter: function (val) {
            return val.toFixed(0)
          }
        }
      }
    }
  }
})
</script>

<template>
  <Head title="Account" />
  <div class="creator__item-wrapper pt-40 pb-120">
    <div class="container">
      <div class="row mb-4">
        <div class="product__details-info-bottom rounded pt-3 pb-3">
          <div class="product__details-bid d-sm-flex align-items-center justify-content-between">
            <div class="tt-page-title">
              <h3 class="base-text mt-2">{{ trans('Dashboard') }}</h3>
            </div>
            <div class="tt-action">
              <Link href="/account/sales" class="tp-btn-2 base-text">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                {{ trans('Manage Sales') }}
              </Link>

              <Link href="/account/prompt/create" class="header__wallet-btn ms-2">
                <i class="fa fa-plus" aria-hidden="true"></i>

                {{ trans('Add Prompt') }}
              </Link>
            </div>
          </div>
        </div>
      </div>
      <div class="row g-3 mb-3">
        <div class="col-xl-8">
          <div class="row g-3">
            <!-- total sales chart -->
            <div class="col-sm-6">
              <div class="wallet__item">
                <div class="wallet__item-fix">
                  <div class="wallet__item-inner">
                    <div class="d-flex align-items-center justify-content-between">
                      <span class="text-muted"> {{ trans('Total Earning') }}</span>
                      <div class="dropdown tt-tb-dropdown fs-sm">
                        <a
                          class="dropdown-toggle text-muted"
                          href="#"
                          data-bs-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false"
                        >
                          {{
                            filterForm.timeline == 30
                              ? trans('Last 30 days')
                              : filterForm.timeline == 90
                              ? trans('Last 3 months')
                              : trans('Last 7 days')
                          }}
                        </a>
                        <div class="dropdown-menu fs-6 dropdown-menu-end shadow">
                          <button
                            class="dropdown-item"
                            type="button"
                            @click="
                              () => {
                                filterForm.timeline = 7
                                filter()
                              }
                            "
                          >
                            {{ trans('Last 7 days') }}
                          </button>
                          <button
                            class="dropdown-item"
                            type="button"
                            @click="
                              () => {
                                filterForm.timeline = 30
                                filter()
                              }
                            "
                          >
                            {{ trans('Last 30 days') }}
                          </button>
                          <button
                            class="dropdown-item"
                            type="button"
                            @click="
                              () => {
                                filterForm.timeline = 90
                                filter()
                              }
                            "
                          >
                            {{ trans('Last 3 months') }}
                          </button>
                        </div>
                      </div>
                    </div>
                    <h4 class="fw-bold base-text">
                      {{ formatCurrency(totalEarnings.total_earning || 0) }}
                    </h4>
                  </div>
                  <div id="totalSales" style="min-height: 225px">
                    <VueApexCharts
                      height="200"
                      type="area"
                      :options="earningChart.chartOptions"
                      :series="earningChart.series"
                    ></VueApexCharts>
                  </div>
                </div>
              </div>
            </div>

            <!-- total order this month chart -->
            <div class="col-sm-6">
              <div class="wallet__item wallet-red-bg">
                <div class="wallet__item-fix">
                  <div class="wallet__item-inner">
                    <p class="text-muted">{{ trans('Last 30 Days Orders') }}</p>
                    <h4 class="fw-bold base-text">
                      {{ monthlyOrders.length }}
                    </h4>

                    <div id="last30DaysOrders" style="min-height: 225px">
                      <VueApexCharts
                        height="200"
                        type="bar"
                        :options="orderChart.chartOptions"
                        :series="orderChart.series"
                      ></VueApexCharts>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-l2">
              <div class="features__item green-bg theme-bg-dark">
                <div class="features__item-inner">
                  <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted"> {{ trans('Last 30 Day Sales') }}</span>
                  </div>
                  <h4 class="fw-bold base-text">
                    {{ formatCurrency(monthlyOrdersTotal) }}
                  </h4>
                  <div class="features__content">
                    <div id="thisMonthChart">
                      <VueApexCharts
                        height="300"
                        type="area"
                        :options="salesChart.chartOptions"
                        :series="salesChart.series"
                      ></VueApexCharts>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-4">
          <!-- top selling Prompts -->

          <h5 class="fw-bold mb-1 base-text">
            {{ trans('Top Selling Prompts') }}
          </h5>
          <span class="text-muted" v-if="topSold.length != 0">
            {{ trans('We have listed 5 total Prompts.') }}</span
          >
          <div class="mt-10">
            <template v-for="prompt in topSold" :key="prompt.id">
              <div class="bid__item mb-10 theme-bg-dark">
                <div class="bid__item-wrapper">
                  <div class="bid__list-wrapper d-sm-flex align-items-center">
                    <div class="bid__list-left">
                      <div class="bid__thumb m-img mb-15">
                        <img
                          height="80"
                          width="80"
                          :src="prompt.preview ? prompt.preview : JSON.parse(prompt.meta).preview"
                          alt="preview"
                        />
                      </div>
                    </div>
                    <div class="bid__list-right pl-5">
                      <div class="bid__content border-0">
                        <div
                          class="bid__content-top d-flex align-items-center justify-content-between"
                        >
                          <h5 class="base-text">
                            {{ textExcerpt(prompt.title, 20) }}
                          </h5>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                          <div class="bid__highest">
                            <p>
                              <span>{{ formatCurrency(prompt.price) }}</span>
                            </p>
                          </div>
                          <div class="bid__stock">
                            <p>{{ prompt.model_title }}</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </template>
            <EmptyMessage type="text" message="No record found" v-if="topSold.length < 1" />
          </div>
        </div>
      </div>
      <div class="row">
        <div class="p-3">
          <div class="row align-items-center justify-content-between g-3">
            <div class="col-auto flex-grow-1">
              <h5 class="mb-1 base-text">{{ trans('Recent Orders') }}</h5>
              <span class="text-muted"> {{ trans('Your 10 Most Recent Orders') }}</span>
            </div>

            <div class="col-auto">
              <Link href="/account/sales" class="btn btn-primary btn-sm rounded">
                {{ trans('View All') }}
              </Link>
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
                      <th scope="col">{{ trans('ID') }}</th>
                      <th scope="col">{{ trans('Customer') }}</th>
                      <th scope="col">{{ trans('Date') }}</th>
                      <th scope="col">{{ trans('Items') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="order in recentOrders" :key="order.invoice_no">
                      <td>{{ order.invoice_no }}</td>

                      <td>{{ order.name }}</td>
                      <td>
                        {{ moment(order.created_at).format('DD/MM/YYYY') }}
                      </td>
                      <td class="color-red">
                        {{ order.total_items }}
                      </td>
                    </tr>
                  </tbody>
                </table>
                <EmptyMessage
                  type="text"
                  message="No sales record found"
                  v-if="recentOrders.length < 1"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>