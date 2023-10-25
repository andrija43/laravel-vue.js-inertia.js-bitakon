<template>
  <HeaderSegment title="Edit Profile" :segments="segments" :buttons="buttons" />
  <div class="container-fluid mt--6">
    <div class="row">
      <div class="col-lg-5 mt-5">
        <strong>{{ trans("General Settings") }}</strong>
        <p>{{ trans("Edit you basic credentials") }}</p>
      </div>
      <div class="col-lg-7 mt-5">
        <form
          class="ajaxform"
          @submit.prevent="updateGeneral"
          enctype="multipart/form-data"
        >
          <div class="card">
            <div class="card-body">
              <div class="from-group row">
                <label class="col-lg-12">{{ trans("Name") }}</label>
                <div class="col-lg-12">
                  <input
                    type="text"
                    name="name"
                    required
                    class="form-control"
                    v-model="user.name"
                  />
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{ trans("Email") }}</label>
                <div class="col-lg-12">
                  <input
                    type="email"
                    name="email"
                    required
                    class="form-control"
                    v-model="user.email"
                  />
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{ trans("Phone") }}</label>
                <div class="col-lg-12">
                  <input
                    type="text"
                    name="phone"
                    required
                    class="form-control"
                    v-model="user.phone"
                  />
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{
                  trans("Address (will used for invoice)")
                }}</label>
                <div class="col-lg-12">
                  <input
                    type="text"
                    name="address"
                    required
                    class="form-control"
                    v-model="user.country"
                  />
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{ trans("Avatar") }}</label>
                <div class="col-lg-12">
                  <input
                    @input="(e) => (user.avatar = e.target.files[0])"
                    type="file"
                    name="avatar"
                    class="form-control"
                    accept="image/*"
                  />
                </div>
              </div>
              <div class="from-group row mt-3">
                <div class="col-lg-12">
                  <button
                    class="btn btn-neutral submit-button btn-sm float-left"
                  >
                    {{ trans("Update Settings") }}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- password -->
    <div class="row">
      <div class="col-lg-5">
        <strong>{{ trans("Password") }}</strong>
        <p>{{ trans("Change Your Password") }}</p>
      </div>
      <div class="col-lg-7">
        <form class="ajaxform_reset_form" @submit.prevent="updatePassword">
          <div class="card">
            <div class="card-body">
              <div class="from-group row">
                <label class="col-lg-12">{{ trans("Old Password") }}</label>
                <div class="col-lg-12">
                  <input
                    v-model="form.oldpassword"
                    type="password"
                    required
                    class="form-control"
                  />
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{ trans("New Password") }}</label>
                <div class="col-lg-12">
                  <input
                    v-model="form.password"
                    type="password"
                    name="password"
                    required
                    class="form-control"
                  />
                </div>
              </div>
              <div class="from-group row mt-2">
                <label class="col-lg-12">{{ trans("Confirm Password") }}</label>
                <div class="col-lg-12">
                  <input
                    v-model="form.password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    class="form-control"
                  />
                </div>
              </div>
              <div class="from-group row mt-3">
                <div class="col-lg-12">
                  <button
                    class="btn btn-neutral submit-button btn-sm float-left"
                  >
                    {{ trans("Update Password") }}
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

import AdminLayout from "@/Pages/Admin/Layout/App.vue"
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue"
import { useForm, router } from "@inertiajs/vue3"
import { createToast } from "mosha-vue-toastify"
defineOptions({ layout: AdminLayout })

const props = defineProps(["user", "buttons", "segments"])
const form = useForm({
  oldpassword: null,
  password: "",
  password_confirmation: ""
})
const updatePassword = () => {
  form.put(route("admin.profile.update", "password"), {
    onSuccess: () => {
      createToast({
        title: "Updated",
        description: "Password Updated Successfully"
      })
    }
  })
}
const updateGeneral = () => {
  if (!(props.user.avatar instanceof File)) {
    props.user.avatar = null
  }

  router.post(
    route("admin.profile.update", "general"),
    {
      _method: "put",
      user: props.user
    },
    {
      onSuccess: () => {
        createToast({
          title: "Updated",
          description: "General Settings Updated Successfully"
        })
      }
    }
  )
}
</script>
