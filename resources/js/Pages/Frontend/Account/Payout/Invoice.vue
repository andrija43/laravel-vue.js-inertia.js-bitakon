<script setup>
"use strict";
import { Head } from "@inertiajs/vue3";
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue";
import AccountLayout from "@/Pages/Frontend/Account/Layout/App.vue";
import sharedComposable from "@/composables/sharedComposable";

const props = defineProps(["payout", "userPayoutInfo", "method"]);
const { authUser } = sharedComposable();
defineOptions({ layout: [FrontendLayout, AccountLayout] });

const options = {
  responsive: true,
  maintainAspectRatio: false,
};
</script>

<template>
  <Head :title="`${method.name} - Payout Method`" />
  <div class="creator__item-wrapper pt-40 pb-120">
    <section class="upcoming__area pb-120">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-sm-8">
            <div class="upcoming__wrapper">
              <div class="upcoming__item">
                <h3 class="upcoming__title">
                  <i class="fa-sharp fa-light fa-building-columns"></i>
                  {{ trans("Payment Details") }}
                </h3>
                <div class="upcoming__table">
                  <table class="table">
                    <tbody>
                      <tr>
                        <th>{{ trans("Invoice No") }}</th>
                        <td colspan="4">{{ payout.invoice_no }}</td>
                      </tr>
                      <tr>
                        <th>{{ trans("Payout Method") }}</th>
                        <td colspan="4" v-if="method != null">
                          {{ method.name }}
                        </td>
                      </tr>
                      <tr>
                        <th>{{ trans("Payout Requested Amount") }}</th>
                        <td colspan="4">{{ payout.amount }}</td>
                      </tr>
                      <tr>
                        <th>{{ trans("Payout Gateway Charge") }}</th>
                        <td colspan="4">{{ payout.charge }}</td>
                      </tr>
                      <tr>
                        <th>{{ trans("Conversion Currency") }}</th>
                        <td colspan="4">{{ payout.currency }}</td>
                      </tr>
                      <tr>
                        <th>{{ trans("Processing Status") }}</th>
                        <td colspan="4">{{ payout.status }}</td>
                      </tr>
                      <tr v-for="(field, index) in userPayoutInfo" :key="index">
                        <th>{{ index }}</th>
                        <td colspan="4">{{ field }}</td>
                      </tr>
                      <tr>
                        <th>{{ trans("Requested Date") }}</th>
                        <td colspan="4">{{ payout.created_at_date }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
