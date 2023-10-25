<template>
  <HeaderSegment
    :title="trans('Create Role')"
    :segments="segments"
    :buttons="buttons"
  />
  <div class="container-fluid mt--6">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h4>{{ trans("Add Role") }}</h4>
          </div>
          <div class="card-body">
            <div class="pt-20">
              <div class="form-group">
                <label>{{ trans("Role Name") }}</label>
                <input
                  type="text"
                  class="form-control"
                  required=""
                  name="name"
                  placeholder="sub admin"
                  v-model="form.name"
                />
              </div>
              <ValidationErrors />
              <div class="row">
                <div class="col-sm-12">
                  <div class="custom-control custom-checkbox">
                    <input
                      @change="selectAll"
                      type="checkbox"
                      class="custom-control-input checkAll"
                      id="customCheck12"
                      :checked="isAllSelected"
                    />
                    <label
                      class="custom-control-label checkAll"
                      for="customCheck12"
                      >{{ trans("Check All Permissions") }}</label
                    >
                  </div>
                  <hr />

                  <div class="row">
                    <div
                      class="col-sm-6"
                      v-for="(group, key) in permissions_groups"
                      :key="group.key"
                    >
                      <div class="row">
                        <div class="col-3">
                          <div class="custom-control custom-checkbox">
                            <input
                              @change="selectGroup(group.group_name)"
                              type="checkbox"
                              class="custom-control-input group-input"
                              :id="key + 'Management'"
                              :value="group.group_name"
                              :data-class="`role-${key}-management-checkbox`"
                            />
                            <label
                              class="custom-control-label"
                              :for="key + 'Management'"
                            >
                              {{ group.group_name }} name
                            </label>
                          </div>
                        </div>
                        <div :class="`col-9 role-${key}-management-checkbox`">
                          <div
                            class="custom-control custom-checkbox"
                            v-for="permission in group.permissions"
                            :key="permission.id"
                          >
                            <input
                              @change="selectPermission(permission.name)"
                              type="checkbox"
                              class="custom-control-input"
                              name="permissions[]"
                              :id="`checkPermission${permission.id}`"
                              :value="permission.name"
                            />
                            <label
                              class="custom-control-label"
                              :for="`checkPermission${permission.id}`"
                              >{{ permission.name }}</label
                            >
                          </div>

                          <br />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <button
              @click.prevent="submitRole"
              type="submit"
              class="btn btn-neutral submit-button"
            >
              <i class="fa fa-save"></i> {{ trans("Save") }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
"use strict";
import AdminLayout from "@/Pages/Admin/Layout/App.vue";
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue";
import ValidationErrors from '@/components/ValidationErrors.vue';
import { useForm } from '@inertiajs/vue3';
const props = defineProps(['segments','buttons','permissions_groups']);
import { createToast } from "mosha-vue-toastify";
import { ref, computed } from 'vue';
defineOptions({layout: AdminLayout})
const form = useForm({
  permissions: [],
  name: null
});
const selectedGroup = ref([])
const isAllSelected = computed(() => props.permissions_groups.length === selectedGroup.value.length)
const selectAll = () => {
   selectedGroup.value = []
   if (form.permissions.length < 1) {
      props.permissions_groups.forEach((group) => {
         selectedGroup.value.push(group.group_name)
         group.permissions.forEach((permission) => {
            form.permissions.push(permission.name)
         })
      })
      return
   }
   form.permissions = []
}
const selectGroup = (name) => {
   const index = selectedGroup.value.indexOf(name)
   if (index !== -1) {
      selectedGroup.value.splice(index,1)
   } else {
      selectedGroup.value.push(name)
   }
   if (selectedGroup.value.length >= 1) {
    const findGroup = props.permissions_groups.filter((groups) => {
     return selectedGroup.value.includes(groups.group_name)
    })
    form.permissions = []
    findGroup.forEach((group) => {
      group.permissions.forEach((permission) => {
         form.permissions.push(permission.name)
      })
   })
   }
}
const selectPermission = (name) => {
   const index = form.permissions.indexOf(name)
   if (index !== -1) {
      form.permissions.splice(index,1)
   } else {
      form.permissions.push(name)
   }
}
const submitRole = () => {
   form.post(route('admin.role.store'),{
      onSuccess: () => {
        form.reset()
        createToast(
        {
            title: "Created",
            description: "Role Created successfully",
        },
        {
            transition: "slide",
            position: "top-right",
        }
      )
    }
   })
}
</script>