<script setup>
"use strict";
import { Head, useForm } from "@inertiajs/vue3";
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue";
import AccountLayout from "@/Pages/Frontend/Account/Layout/App.vue";
import sharedComposable from "@/composables/sharedComposable";
import { trans } from "laravel-vue-i18n";
const { authUser, ToastAlert } = sharedComposable();
defineOptions({ layout: [FrontendLayout, AccountLayout] });
const props = defineProps(["method", "userPayoutInfo", "wallet"]);
const options = {
  responsive: true,
  maintainAspectRatio: false,
};
const form = useForm({
  amount: props.wallet,
});

function sendOtp() {
  if (form.amount > props.wallet) {
    ToastAlert(
      "!Opps",
      trans("You cant sent payout request greater then ") + props.wallet,
      "danger"
    );
    return false;
  } else if (form.amount < props.method.min_limit) {
    ToastAlert(
      "!Opps",
      trans("You cant sent payout request less then ") + props.method.min_limit,
      "danger"
    );
    return false;
  } else if (form.amount > props.method.max_limit) {
    ToastAlert(
      "!Opps",
      trans("You cant sent payout request greater then ") +
        props.method.min_limit +
        " using this method",
      "danger"
    );
    return false;
  }

  form.post(route("user.payout.otp", props.method.id), {
    onSuccess: () => {
      ToastAlert(
        "Congratulations",
        trans("a confirmation otp has sent to your email")
      );
    },
  });
}
</script>
<template>
  <Head :title="`${method.name} - Payout Method`" />
  <div class="creator__item-wrapper pt-40 pb-120">
    <section class="upcoming__area pb-120">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-sm-8">
            <div class="upcoming__wrapper">
              <div class="upcoming__item" v-if="wallet > 0">
                <h3 class="upcoming__title">
                  <img src="/uploads/money-bag.png" height="30" alt="" />
                  {{ trans("Enter Amount") }}
                </h3>
                <div class="">
                  <div class="sidebar__widget-content">
                    <div class="sidebar__search">
                      <form method="POST" @submit.prevent="sendOtp">
                        <div class="sidebar__search-input-2">
                          <input
                            :disabled="form.processing"
                            type="number"
                            step="any"
                            v-model="form.amount"
                            :max="authUser.wallet"
                            
                            :placeholder="trans('Enter Amount')"
                          />
                          <button :disabled="form.processing" type="submit">
                            <i class="fa-sharp fa-regular fa-arrow-right"></i>
                          </button>
                        </div>
                        <small
                          class="text-danger"
                          v-if="form.errors.amount"
                          :disabled="form.processing"
                          >{{ form.errors.amount }}</small
                        >
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="postbox__author d-md-flex align-items-center mb-40 mt-20"
                v-if="wallet < method.min_limit"
              >
                <div class="postbox__author-thumb mr-20">
                  <a href="javascript:void(0)">
                    <img
                      src="/assets/frontend/img/components/sorry.png"
                      alt=""
                    />
                  </a>
                </div>
                <div class="postbox__author-content">
                  <h4>
                    <a href="#">{{ trans("I am sorry") }}</a>
                  </h4>
                  <p>
                    {{
                      trans(
                        "You don't have enough balance for use this payout method."
                      )
                    }}
                  </p>
                </div>
              </div>

              <br />
              <br />
              <div class="upcoming__item">
                <h3 class="upcoming__title">
                  <img :src="method.image" height="30" alt="" />
                  {{ trans("Payout method information") }}
                </h3>
                <div class="upcoming__table">
                  <table class="table">
                    <tbody>
                      <tr>
                        <th>{{ trans("Method name") }}</th>
                        <td>{{ method.name }}</td>
                        <th>{{ trans("Currency") }}</th>
                        <td>{{ method.currency_name }}</td>
                      </tr>
                      <tr>
                        <th>{{ trans("Minimum limit") }}</th>
                        <td>{{ method.min_limit }}</td>
                        <th>{{ trans("Maximum limit") }}</th>
                        <td>{{ method.max_limit }}</td>
                      </tr>
                      <tr>
                        <th>{{ trans("Charge type") }}</th>
                        <td>{{ method.charge_type }}</td>
                        <th>{{ trans("Charge") }}</th>
                        <td>
                          {{
                            method.charge_type == "percentage"
                              ? method.percent_charge + "%"
                              : method.fixed_charge + " " + method.currency_name
                          }}
                        </td>
                      </tr>
                      <tr>
                        <th>{{ trans("Maximum Processing Time") }}</th>
                        <td colspan="4">
                          {{ method.delay }} {{ trans("Days") }}
                        </td>
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
