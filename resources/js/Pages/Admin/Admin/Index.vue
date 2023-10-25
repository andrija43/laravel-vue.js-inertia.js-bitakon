<template>
  <Head title="Sub Admins" />
  <HeaderSegment
    :title="trans('Sub Admins')"
    :segments="segments"
    :buttons="buttons"
  />
  <div class="container-fluid mt--6">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <div class="row mb-30">
              <div class="col-lg-6">
                <h4>{{ trans("Admins") }}</h4>
              </div>
              <div class="col-lg-6"></div>
            </div>
            <br />
            <div class="card-action-filter">
              <div class="table-responsive custom-table">
                <table class="table">
                  <thead>
                    <tr>
                      <th>{{ trans("Name") }}</th>
                      <th>{{ trans("Email") }}</th>
                      <th>{{ trans("Status") }}</th>
                      <th>{{ trans("Role") }}</th>
                      <th class="text-right">{{ trans("Action") }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="row in users" :key="row.id">
                      <td>
                        {{ row.name }}
                      </td>
                      <td>
                        {{ row.email }}
                      </td>
                      <td>
                        <span
                          :class="
                            row.status == 1
                              ? 'badge badge-success'
                              : 'badge badge-danger'
                          "
                        >
                          {{
                            row.status == 1
                              ? trans("Active")
                              : trans("Deactive")
                          }}
                        </span>
                      </td>
                      <td>
                        <span
                          class="badge badge-primary"
                          v-for="r in row.roles"
                          >{{ r.name }}</span
                        >
                      </td>
                      <td class="text-right">
                        <Link
                          :href="route('admin.admin.edit', row.id)"
                          class="btn btn-neutral btn-sm"
                          >{{ trans("Edit") }}</Link
                        >
                        <a
                          href="javascript:void(0)"
                          @click="
                            modal.initiate(route('admin.admin.destroy', row.id))
                          "
                          class="btn btn-neutral btn-sm delete-confirm"
                          >{{ trans("Delete") }}</a
                        >
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="text-center mt-2" v-if="users.length == 0">
                  <div class="alert bg-gradient-primary text-white">
                    <span class="text-left">{{
                      trans("!Opps no records found")
                    }}</span>
                  </div>
                </div>
              </div>
            </div>
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
import { Head, Link } from "@inertiajs/vue3"
import { trans } from "laravel-vue-i18n"
import sharedComposable from "@/composables/sharedComposable"
const props = defineProps(["segments", "buttons", "users"])
defineOptions({ layout: AdminLayout })
const { modal } = sharedComposable()
</script>
