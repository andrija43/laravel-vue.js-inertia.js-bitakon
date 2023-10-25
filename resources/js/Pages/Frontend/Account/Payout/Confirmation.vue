<script setup>
"use strict";
import { Head, useForm, router } from "@inertiajs/vue3";
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue";
import AccountLayout from "@/Pages/Frontend/Account/Layout/App.vue";
import sharedComposable from "@/composables/sharedComposable";

const { authUser } = sharedComposable();
const props = defineProps([
  "method",
  "wallet",
  "payout_amount",
  "userPayoutInfo",
]);

defineOptions({ layout: [FrontendLayout, AccountLayout] });
const form = useForm({
  otp: null,
});

const charge =
  props.method.charge_type == "fixed"
    ? props.method.fixed_charge
    : (props.method.percent_charge / 100) * props.payout_amount;
const payout_after_charge = props.payout_amount - charge;

const validateOtp = () => {
  form.post(route("user.payout.otp.verify"), {
    onSuccess: () => {
      ToastAlert(
        trans("Congratulations"),
        trans(
          "Your Payout Request Successfully Sent Our Financial Team Will Processed For It"
        )
      );

      setTimeout(router.visit(route("user.payout.logs")), 2000);
    },
  });
};
const options = {
  responsive: true,
  maintainAspectRatio: false,
};
</script>

<template>
  <Head :title="trans('Payout Confirmation')" />
  <div class="creator__item-wrapper pt-40 pb-120">
    <section class="upcoming__area pb-120">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-sm-8">
            <div class="upcoming__wrapper">
              <div class="upcoming__item" v-if="wallet > 0">
                <h3 class="upcoming__title">
                  <img src="/uploads/money-bag.png" height="30" alt="" />
                  {{ trans("Enter Confirmation OTP") }}
                </h3>
                <div class="">
                  <div class="sidebar__widget-content">
                    <div class="sidebar__search">
                      <form method="POST" @submit.prevent="validateOtp">
                        <div class="sidebar__search-input-2">
                          <input
                            required
                            :disabled="form.processing"
                            type="number"
                            v-model="form.otp"
                            :placeholder="trans('Enter Otp')"
                          />
                          <button type="submit" :disabled="form.processing">
                            <i class="fa-sharp fa-regular fa-arrow-right"></i>
                          </button>
                        </div>
                        <small class="text-danger" v-if="form.errors.otp">{{
                          form.errors.otp
                        }}</small>
                      </form>
                    </div>
                  </div>
                </div>
                <br />
                <div
                  class="alert alert-success header__wallet-btn fade show"
                  role="alert"
                >
                  <strong>{{ trans("Hello ") + authUser.name }}</strong
                  >{{
                    trans(
                      ", We have sent you an confirmation OTP code to your email."
                    )
                  }}
                </div>
              </div>

              <br />

              <div class="upcoming__item mt-5 pt-5">
                <h3 class="upcoming__title">
                  <i class="fa-sharp fa-light fa-building-columns"></i>
                  {{ trans("Payment Details") }}
                </h3>
                <div class="upcoming__table">
                  <table class="table">
                    <tbody>
                      <tr>
                        <th>{{ trans("Method name") }}</th>
                        <td colspan="4">{{ method.name }}</td>
                      </tr>
                      <tr>
                        <th>{{ trans("Payout Amount") }}</th>
                        <td colspan="4">{{ payout_amount }}</td>
                      </tr>
                      <tr>
                        <th>{{ trans("Payout Charge") }}</th>
                        <td colspan="4">{{ charge }}</td>
                      </tr>
                      <tr>
                        <th>{{ trans("You Will Receive") }}</th>
                        <td colspan="4">{{ payout_after_charge }}</td>
                      </tr>
                      <tr v-for="(field, index) in userPayoutInfo" :key="index">
                        <th>{{ index }}</th>
                        <td colspan="4">{{ field }}</td>
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
