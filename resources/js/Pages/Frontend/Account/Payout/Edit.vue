<script setup>
"use strict";
import { Head, useForm } from "@inertiajs/vue3";
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue";
import AccountLayout from "@/Pages/Frontend/Account/Layout/App.vue";
import sharedComposable from "@/composables/sharedComposable";
import { createToast } from "mosha-vue-toastify";
const { authUser } = sharedComposable();
defineOptions({ layout: [FrontendLayout, AccountLayout] });
const props = defineProps(["method", "userPayoutInfo", "fields"]);
const options = {
  responsive: true,
  maintainAspectRatio: false,
};
const form = useForm({
  inputs: props.userPayoutInfo.length != 0 ? props.userPayoutInfo : {},
});

function updatePayoutInfo() {
  form.put(route("user.payout.update", props.method.id), {
    onSuccess: () => {
      createToast({
        title: "Congratulations",
        description: "Payout Information Updated successfully",
      });
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
              <div class="upcoming__item">
                <div class="upcoming__table">
                  <form method="POST" @submit.prevent="updatePayoutInfo">
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
                                : method.fixed_charge +
                                  " " +
                                  method.currency_name
                            }}
                          </td>
                        </tr>
                        <tr>
                          <th>{{ trans("Maximum Processing Time") }}</th>
                          <td>{{ method.delay }} {{ trans("Days") }}</td>
                        </tr>
                        <tr>
                          <td colspan="4" v-html="method.instruction"></td>
                        </tr>

                        <tr v-for="(field, index) in fields" :key="index">
                          <td colspan="5">
                            <div class="create__input-box pt-2">
                              <h4>
                                {{ field.label }}
                                <span class="text-danger">*</span>
                              </h4>
                              <div class="create__input mt-3">
                                <input
                                  v-model="form.inputs[field.label]"
                                  v-if="field.type != 'textarea'"
                                  :type="field.type"
                                  required
                                />
                                <textarea
                                  v-else
                                  required
                                  v-model="form.inputs[field.label]"
                                ></textarea>
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="4">
                            <button
                              :disabled="form.processing"
                              type="submit"
                              class="header__wallet-btn"
                            >
                              {{
                                form.processing
                                  ? trans("Processing...")
                                  : trans("Save Information")
                              }}
                            </button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
