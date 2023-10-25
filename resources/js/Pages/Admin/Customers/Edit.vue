<template>
  <HeaderSegment
    :title="trans('Edit Customers')"
    :segments="segments"
    :buttons="buttons"
  />
  <div class="container-fluid mt--6">
    <div class="row">
      <div class="col-lg-5 mt-5">
        <strong>{{ trans("Edit Customer") }}</strong>
        <p>{{ trans("Edit Customer profile information") }}</p>
      </div>
      <div class="col-lg-7 mt-5">
        <form  @submit.prevent="update" method="post">
          <div class="card">
            <div class="card-body">
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{ trans("Name") }}</label>
                <div class="col-lg-12">
                  <input
                    type="text"
                    name="name"
                    required=""
                    class="form-control"
                    v-model="userInfo.name"
                  />
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{ trans("Email") }}</label>
                <div class="col-lg-12">
                  <input
                    type="email"
                    name="email"
                    required=""
                    class="form-control"
                    v-model="userInfo.email"
                  />
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{ trans("Credit") }}</label>
                <div class="col-lg-12">
                  <input
                    type="number"
                    step="any"
                    class="form-control"
                    v-model="userInfo.credits"
                  />
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{ trans("Wallet") }}</label>
                <div class="col-lg-12">
                  <input
                    type="number"
                    class="form-control"
                    step="any"
                    v-model="userInfo.wallet"
                  />
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{ trans("Phone") }}</label>
                <div class="col-lg-12">
                  <input
                    type="text"
                    name="phone"
                    class="form-control"
                    v-model="userInfo.phone"
                  />
                </div>
              </div>
           
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{ trans("New Password") }}</label>
                <div class="col-lg-12">
                  <input type="text" v-model="userInfo.password" name="password" class="form-control" />
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{ trans("Status") }}</label>
                <div class="col-lg-12">
                  <select class="form-control" name="status" v-model="userInfo.status">
                    <option value="1" :selected="customer.status == 1">
                      {{ trans("Active") }}
                    </option>
                    <option value="0" :selected="customer.status == 0">
                      {{ trans("Deactivate") }}
                    </option>
                  </select>
                </div>
              </div>
              <div class="from-group row mt-3">
                <div class="col-lg-12">
                  <button
                    class="btn btn-neutral submit-button btn-sm float-left"
                  >
                    {{ trans("Update") }}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
"use strict";

import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue";
import AdminLayout from "@/Pages/Admin/Layout/App.vue";
import { useForm } from "@inertiajs/vue3"
import { createToast } from "mosha-vue-toastify"
const props = defineProps(['customer','segments','buttons']);
defineOptions({layout: AdminLayout});

const userInfo = useForm({
  name: props.customer.name,
  email: props.customer.email,
  credits: props.customer.credits,
  wallet: props.customer.wallet,
  phone: props.customer.phone,
  status: props.customer.status,
  password: ''
})

const update = () => {
  userInfo.put(
    route('admin.customer.update',props.customer.id),
    {
      onSuccess: () => {
        createToast({
          title: "Congratulations",
          description: "User Profile Updated successfully"
        })
      }
    }
  )
}
</script>