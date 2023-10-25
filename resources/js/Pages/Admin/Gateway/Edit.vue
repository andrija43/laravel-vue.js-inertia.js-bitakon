<template>
  <HeaderSegment :title="trans('Edit Payment Gateway')" :segments="segments" :buttons="buttons" />
  <div class="container-fluid mt--6">
    <div class="row">
      <div class="col-lg-5 mt-5">
        <strong>{{ trans('Edit Payment Gateway') }}</strong>
        <p>{{ trans('Edit gateway information for accepting payment') }}</p>
      </div>
      <div class="col-lg-7 mt-5">
        <form @submit.prevent="updateGateway">
          <div class="card">
            <div class="card-body">
              <div class="form-group mb-4">
                <label class="col-form-label text-md-right required" for="name">{{
                  trans('Gateway Name')
                }}</label>
                <input
                  type="text"
                  class="form-control"
                  name="name"
                  id="name"
                  v-model="form.name"
                  required
                />
              </div>
              <div class="form-group mb-4">
                <label class="col-form-label text-md-right required" for="logo">{{
                  trans('Logo')
                }}</label>
                <input
                  type="file"
                  id="logo"
                  class="form-control"
                  name="logo"
                  @input="(e) => (form.logo = e.target.files[0])"
                />

                <img
                  v-if="gateway.logo != ''"
                  :src="gateway.logo"
                  height="30"
                  alt=""
                  class="image-thumbnail mt-2"
                />
              </div>
              <div class="form-group mb-4">
                <label class="col-form-label text-md-right required" for="currency">{{
                  trans('Currency')
                }}</label>
                <input
                  type="text"
                  class="form-control"
                  name="currency"
                  id="currency"
                  v-model="form.currency"
                  required
                />
              </div>

              <div class="form-group mb-4" v-if="gateway.is_auto == 1">
                <label class="col-form-label text-md-right required" for="sandbox">{{
                  trans('Sandbox Mode')
                }}</label>
                <select
                  class="form-control selectric"
                  name="test_mode"
                  id="sandbox"
                  v-model="form.test_mode"
                >
                  <option value="1">{{ trans('Enable') }}</option>
                  <option value="0">{{ trans('Disable') }}</option>
                </select>
              </div>

              <div class="form-group mb-4">
                <label class="col-form-label text-md-right required" for="min_amount">{{
                  trans('Minimum Amount')
                }}</label>
                <input
                  type="number"
                  name="min_amount"
                  id="min_amount"
                  step="any"
                  v-model="form.min_amount"
                  class="form-control"
                  required
                />
              </div>
              <div class="form-group mb-4">
                <label class="col-form-label text-md-right required" for="max_amount">{{
                  trans('Maximum Amount')
                }}</label>
                <input
                  type="number"
                  name="max_amount"
                  id="max_amount"
                  step="any"
                  v-model="form.max_amount"
                  class="form-control"
                  required
                />
              </div>
              <div class="form-group mb-4">
                <label class="col-form-label text-md-right required" for="charge">{{
                  trans('Charge')
                }}</label>
                <input
                  type="text"
                  class="form-control"
                  name="charge"
                  id="charge"
                  v-model="form.charge"
                  required
                />
              </div>
              <div class="form-group mb-4">
                <label class="col-form-label text-md-right required" for="multiply">{{
                  trans('Multiply from base currency')
                }}</label>
                <input
                  type="number"
                  step="any"
                  class="form-control"
                  v-model="form.multiply"
                  required
                />
              </div>

              <template v-if="gateway.is_auto == 1">
                <div
                  class="form-group mb-4"
                  v-for="(credential, key) in form.credentials"
                  :key="credential.key"
                >
                  <label class="col-form-label text-md-right required" for="status">{{
                    ucwords(str_replace('_', ' ', key))
                  }}</label>
                  <input type="text" class="form-control" v-model="form.credentials[key]" />
                </div>
              </template>

              <div class="form-group mb-4">
                <label class="col-form-label text-md-right required" for="status">{{
                  trans('Payment Instruction')
                }}</label>
                <textarea
                  class="form-control"
                  maxlength="1000"
                  name="comment"
                  v-model="form.comment"
                  >{{ gateway.comment }}</textarea
                >
              </div>
              <div class="form-group mb-4">
                <label class="col-form-label text-md-right required" for="status">{{
                  trans('Status')
                }}</label>
                <select
                  class="form-control selectric"
                  name="status"
                  id="status"
                  v-model="form.status"
                >
                  <option value="1">{{ trans('Active') }}</option>
                  <option value="0">{{ trans('Deactivate') }}</option>
                </select>
              </div>
              <div class="form-group mb-4">
                <button class="btn btn-neutral submit-button">
                  {{ trans('Update') }}
                </button>
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
import AdminLayout from '@/Pages/Admin/Layout/App.vue'
import HeaderSegment from '@/Pages/Admin/Layout/HeaderSegment.vue'
import { createToast } from "mosha-vue-toastify"
import { useForm } from '@inertiajs/vue3'
import { trans } from 'laravel-vue-i18n'
defineOptions({ layout: AdminLayout })
const props = defineProps(['segments', 'buttons', 'gateway', 'credentials'])
const form = useForm({
  _method: 'Patch',
  name: props.gateway.name,
  logo: '',
  currency: props.gateway.currency,
  test_mode: props.gateway.test_mode,
  min_amount: props.gateway.min_amount,
  max_amount: props.gateway.max_amount,
  charge: props.gateway.charge,
  multiply: props.gateway.multiply,
  credentials: props.credentials,
  comment: props.gateway.comment,
  status: props.gateway.status
})

function ucwords(word) {
  return word.charAt(0).toUpperCase() + word.slice(1)
}

function str_replace(search, replace, subject) {
  return subject.replace(search, replace)
}

function updateGateway() {
  form.post(route('admin.gateways.update', props.gateway.id), {onSuccess: () => {
            createToast({
                title: trans("Congratulations"),
                description: trans("Settings Updated")
            })
        }})
}
</script>
