<script setup>
"use strict";

import { Head, router } from '@inertiajs/vue3'
import VueApexCharts from 'vue3-apexcharts'
import FrontendLayout from '@/Pages/Frontend/Layout/App.vue'
import AccountLayout from '@/Pages/Frontend/Account/Layout/App.vue'
import sharedComposable from '@/composables/sharedComposable'
import Paginate from '@/components/Paginate.vue'
import EmptyMessage from '@/Pages/Frontend/Layout/EmptyMessage.vue'
import { computed, ref } from 'vue'
defineOptions({ layout: [FrontendLayout, AccountLayout] })
const props = defineProps([
  'topSold',
  'monthTotal',
  'totalSales',
  'dailySales',
  'itemSales',
  'requestType',
  'salesCount'
])
const { authUser, textExcerpt, formatCurrency, pickBy } = sharedComposable()
const filterForm = ref({
  type: null
})

const filter = () => {
  router.get('/account/sales', pickBy(filterForm.value), {
    preserveState: true,
    preserveScroll: true
  })
}

const chart = computed(() => {
  return {
    series: [
      {
        name: 'Sales',
        data: props.itemSales.data.map((item) => item.total_items)
      }
    ],
    chartOptions: {
      chart: {
        height: 300,
        type: 'area',
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
      colors: ['#E64018'],
      stroke: {
        curve: 'smooth'
      },
      yaxis: {
        show: false,
        opposite: true,
        labels: {
          formatter: function (val) {
            return val.toFixed(0)
          }
        }
      },

      xaxis: {
        categories: props.itemSales.data.map((item) => item.date)
      }
    }
  }
})
</script>

<template>
  <Head title="Prompt" />
  <div class="creator__item-wrapper pt-40 pb-120">
    <div class="container">
      <div class="row">
        <div class="row justify-content-center">
          <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <div class="wallet__item wallet-purple-bg mb-30">
              <div class="wallet__item-fix">
                <div class="wallet__item-inner text-center">
                  <p class="base-text">
                    {{
                      trans(`Sales earnings this month (July), after associated author
                    fees, & before taxes:`)
                    }}
                  </p>
                  <div class="wallet__content">
                    <h3 class="wallet__title">
                      {{ formatCurrency(Number(monthTotal.month_total || 0)) }}
                    </h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <div class="wallet__item wallet-orange-bg mb-30">
              <div class="wallet__item-fix">
                <div class="wallet__item-inner text-center">
                  <p class="base-text pb-30">{{ trans('Your balance:') }}</p>

                  <div class="wallet__content">
                    <h3 class="wallet__title">
                      {{ formatCurrency(authUser.wallet || 0) }}
                    </h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <div class="wallet__item wallet-navy-bg mb-30">
              <div class="wallet__item-fix">
                <div class="wallet__item-inner text-center">
                  <p class="base-text">
                    {{ trans("Total value of your sales, before taxes:'") }}
                  </p>
                  <div class="wallet__content">
                    <h3 class="wallet__title">
                      {{ formatCurrency(totalSales.total_sales || 0) }}
                    </h3>
                  </div>
                  <p>{{ trans('based on list price') }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xxl-8">
            <div class="features__item mb-30 yellow-bg theme-bg-dark">
              <div class="features__item-inner">
                <div class="d-flex align-items-center justify-content-between">
                  <span class="text-muted"> {{ trans('Item Sales') }}</span>
                  <div class="dropdown tt-tb-dropdown fs-sm">
                    <a
                      class="dropdown-toggle text-muted"
                      href="#"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                      {{
                        requestType === 'monthly'
                          ? trans('This Year')
                          : requestType === 'yearly'
                          ? trans('Yearly')
                          : trans('This Month')
                      }}
                    </a>
                    <div class="dropdown-menu fs-6 dropdown-menu-end shadow" style="">
                      <button
                        class="dropdown-item"
                        type="button"
                        @click="
                          () => {
                            filterForm.type = 'month'
                            filter()
                          }
                        "
                      >
                        {{ trans('This Month') }}
                      </button>
                      <button
                        class="dropdown-item"
                        type="button"
                        @click="
                          () => {
                            filterForm.type = 'monthly'
                            filter()
                          }
                        "
                      >
                        {{ trans('This Year') }}
                      </button>
                      <button
                        class="dropdown-item"
                        type="button"
                        @click="
                          () => {
                            filterForm.type = 'yearly'
                            filter()
                          }
                        "
                      >
                        {{ trans('Yearly') }}
                      </button>
                    </div>
                  </div>
                </div>

                <div class="features__content">
                  <VueApexCharts
                    type="area"
                    height="300"
                    :options="chart.chartOptions"
                    :series="chart.series"
                  ></VueApexCharts>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-4">
            <div
              class="creator__item transition-3 d-flex align-items-center justify-content-between mb-25"
            >
              <div class="creator__item-inner d-flex align-items-center">
                <div class="creator__content">
                  <h3 class="creator__title">
                    {{ trans('Sales Count') }}
                  </h3>
                  <div class="creator__revenue d-flex align-items-center">
                    <div class="creator__revenue-icon mr-10">
                      <i class="fa-regular fa-clipboard-list-check"></i>
                    </div>
                    <div class="creator__revenue-text">
                      <p>{{ salesCount }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <h5 class="base-text">{{ trans('Top Selling') }}</h5>
            <div class="">
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
                      <div class="bid__list-right pl-10">
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
                              <p>
                                {{ prompt.model_title }}
                              </p>
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
          <div class="col-xxl-12">
            <div class="upcoming__wrapper">
              <div class="upcoming__item">
                <div class="upcoming__table">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">
                          {{ trans('Date') }}
                        </th>
                        <th scope="col">
                          {{ trans('Item Sales Count') }}
                        </th>
                        <th scope="col">
                          {{ trans('Earnings') }}
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="sale in itemSales.data" :key="sale.id">
                        <td>
                          {{ sale.date }}
                        </td>

                        <td>{{ sale.total_items }}</td>
                        <td class="color-red">
                          {{ formatCurrency(sale.total_sales) }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <EmptyMessage
                    type="text"
                    message="No sales record found"
                    v-if="itemSales.data.length < 1"
                  />
                </div>
                <br />
                <Paginate :links="itemSales.links" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>