<template>
  <HeaderSegment
    :title="trans('Admin Roles')"
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
                <h4>{{ trans("Roles") }}</h4>
              </div>
              <div class="col-lg-6"></div>
            </div>
            <br />
            <div class="table-responsive custom-table">
              <table class="table">
                <thead>
                  <tr>
                    <th width="10%">{{ trans("Name") }}</th>
                    <th width="80%">{{ trans("Permissions") }}</th>
                    <th width="10%" class="text-right">
                      {{ trans("Action") }}
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="role in roles" :key="role.id">
                    <td>
                      {{ role.name }}
                    </td>
                    <td>
                      <span
                        class="badge badge-primary mr-1 mb-2"
                        v-for="perm in role.permissions"
                        :key="perm.name"
                      >
                        {{ perm.name }}
                      </span>
                    </td>
                    <td>
                      <div class="hover">
                        <a
                          href="javascript:void(0)"
                          @click="
                            modal.initiate(route('admin.role.destroy', role.id))
                          "
                          class="btn btn-neutral con btn-sm delete-confirm"
                          >{{ trans("Delete") }}</a
                        >
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="text-center mt-2" v-if="roles.length == 0">
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
</template>

<script setup>
"use strict";
import AdminLayout from "@/Pages/Admin/Layout/App.vue"
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue"
import sharedComposable from "@/composables/sharedComposable"
const props = defineProps(["segments", "buttons", "roles"])
defineOptions({ layout: AdminLayout })
const { modal } = sharedComposable()
</script>
