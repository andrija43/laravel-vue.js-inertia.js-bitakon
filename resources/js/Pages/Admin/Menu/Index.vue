<template>
  <Head title="Menu" />
  <HeaderSegment
    :title="trans('Menu')"
    :segments="segments"
    :buttons="buttons"
  />
  <div class="container-fluid mt--6">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="row d-flex justify-content-between flex-wrap">
          <div class="col">
            <div class="card card-stats">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <span
                      class="h2 font-weight-bold mb-0 total-transfers"
                      id="total-device"
                    >
                      {{ totalMenus }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-chart-tree mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Total Menus") }}
                </h5>
                <p></p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card card-stats">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <span
                      class="h2 font-weight-bold mb-0 total-transfers"
                      id="total-active"
                    >
                      {{ totalActiveMenus }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-badge-check mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Active Menus") }}
                </h5>
                <p></p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card card-stats">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <span
                      class="h2 font-weight-bold mb-0 completed-transfers"
                      id="total-inactive"
                    >
                      {{ totalDraftMenus }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-box mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Draft Menu") }}
                </h5>
                <p></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <div class="card">
          <!-- Card header -->
          <div class="card-header border-0">
            <h3 class="mb-0">{{ trans("Menu List") }}</h3>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th class="col-2">{{ trans("Menu Name") }}</th>
                  <th class="col-2">{{ trans("Position") }}</th>
                  <th class="col-2 text-center">{{ trans("Language") }}</th>
                  <th class="col-2">{{ trans("Status") }}</th>
                  <th class="col-2">{{ trans("Last Update") }}</th>
                  <th class="col-2 text-right">{{ trans("Action") }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="menu in menus" :key="menu.id">
                  <td class="text-left">
                    <Link :href="route('admin.menu.show', menu.id)">{{
                      menu.name
                    }}</Link>
                  </td>
                  <td class="text-left">
                    {{ menu.position }}
                  </td>
                  <td class="text-center">
                    {{ menu.lang }}
                  </td>
                  <td class="text-left">
                    <span
                      :class="
                        menu.status == 1
                          ? 'badge badge-success'
                          : 'badge badge-danger'
                      "
                    >
                      {{ menu.status == 1 ? trans("Active") : trans("Draft") }}
                    </span>
                  </td>
                  <td>
                    {{ menu.created_at_diff }}
                  </td>
                  <td class="text-right">
                    <Link
                      :href="route('admin.menu.show', menu.id)"
                      class="btn btn-neutral btn-sm"
                      data-toggle="tooltip"
                      data-placement="top"
                      :title="trans('Customize Menu Items')"
                    >
                      <i class="fi fi-rs-diagram-project mt-3 pt-3"></i>
                    </Link>

                    <a
                      href="javascript:void(0)"
                      class="edit-contact btn btn-sm btn-primary"
                      data-target="#editModal"
                      data-toggle="modal"
                      data-placement="top"
                      :title="trans('Customize Menu Items')"
                      @click="openModal(menu)"
                    >
                      <i class="fi fi-rs-edit"></i>
                    </a>

                    <a
                      class="delete-confirm btn btn-sm btn-danger"
                      href="javascript:void(0)"
                      @click="
                        modal.initiate(route('admin.menu.destroy', menu.id))
                      "
                      data-toggle="tooltip"
                      data-placement="top"
                      :title="trans('Delete Menu')"
                    >
                      <i class="fas fa-trash"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div
      class="modal fade"
      id="addRecord"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <form
            method="POST"
            action="{{ route('admin.menu.store') }}"
            @submit.prevent="create"
          >
            <div class="modal-header">
              <h3>{{ trans("Create Menu") }}</h3>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>{{ trans("Menu Name") }}</label>
                <input
                  type="text"
                  v-model="form.name"
                  name="name"
                  class="form-control"
                  required=""
                  placeholder="Example"
                />
              </div>
              <div class="form-group">
                <label>{{ trans("Select Menu Position") }}</label>
                <select
                  class="form-control"
                  name="position"
                  v-model="form.position"
                >
                  <option value="main-menu">{{ trans("Main Menu") }}</option>
                  <option value="footer-left">
                    {{ trans("Footer Left") }}
                  </option>
                  <option value="footer-right">
                    {{ trans("Footer right") }}
                  </option>
                  <option value="footer-center">
                    {{ trans("Footer Center") }}
                  </option>
                </select>
              </div>
              <div class="form-group">
                <label>{{ trans("Select Language") }}</label>
                <select
                  class="form-control"
                  name="language"
                  v-model="form.language"
                >
                  <option
                    v-for="(language, languageKey) in languages"
                    :key="language.id"
                    :value="languageKey"
                  >
                    {{ language }}
                  </option>
                </select>
              </div>
              <div class="form-group">
                <label>{{ trans("Menu Status") }}</label>
                <select
                  class="form-control"
                  name="status"
                  v-model="form.status"
                >
                  <option value="1">{{ trans("Active") }}</option>
                  <option value="0">{{ trans("Draft") }}</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="submit"
                class="btn btn-outline-primary col-12 submit-button"
              >
                {{ trans("Create Now") }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div
      class="modal fade"
      id="editModal"
      tabindex="-1"
      aria-labelledby="editModal"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <form
            type="POST"
            action=""
            class="edit-modal ajaxform_instant_reload"
            @submit.prevent="update"
          >
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                {{ trans("Edit Menu") }}
              </h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>{{ trans("Menu Name") }}</label>
                <input
                  v-model="edit.name"
                  type="text"
                  id="name"
                  name="name"
                  class="form-control"
                  required=""
                  placeholder="Example"
                />
              </div>
              <div class="form-group">
                <label>{{ trans("Select Menu Position") }}</label>
                <select
                  class="form-control"
                  name="position"
                  id="position"
                  v-model="edit.position"
                >
                  <option value="main-menu">{{ trans("Main Menu") }}</option>
                  <option value="footer-left">
                    {{ trans("Footer Left") }}
                  </option>
                  <option value="footer-right">
                    {{ trans("Footer right") }}
                  </option>
                  <option value="footer-center">
                    {{ trans("Footer Center") }}
                  </option>
                </select>
              </div>
              <div class="form-group">
                <label>{{ trans("Select Language") }}</label>
                <select
                  class="form-control"
                  name="language"
                  id="language"
                  v-model="edit.language"
                  required
                >
                  <option
                    v-for="(language, languageKey) in languages"
                    :key="language.id"
                    :value="languageKey"
                  >
                    {{ language }}
                  </option>
                </select>
              </div>
              <div class="form-group">
                <label>{{ trans("Menu Status") }}</label>
                <select
                  class="form-control"
                  name="status"
                  id="status"
                  v-model="edit.status"
                >
                  <option value="1">{{ trans("Active") }}</option>
                  <option value="0">{{ trans("Draft") }}</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-dismiss="modal"
              >
                {{ trans("Close") }}
              </button>
              <button type="submit" class="btn btn-primary submit-btn">
                {{ trans("Save changes") }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
"use strict";
import AdminLayout from "@/Pages/Admin/Layout/App.vue"
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue"
import { Head, Link, useForm, router } from "@inertiajs/vue3"
import { trans } from "laravel-vue-i18n"
import sharedComposable from "@/composables/sharedComposable"
import { createToast } from "mosha-vue-toastify"
const props = defineProps([
  "menus",
  "languages",
  "totalMenus",
  "totalActiveMenus",
  "totalDraftMenus",
  "segments",
  "buttons"
])
const { modal } = sharedComposable()
defineOptions({ layout: AdminLayout })

const form = useForm({
  name: null,
  position: null,
  language: "en",
  status: 0
})

const edit = useForm({
  name: null,
  position: null,
  language: "en",
  status: null,
  id: null
})

function openModal(row) {
  edit.name = row.name
  edit.position = row.position
  edit.language = row.lang
  edit.status = row.status
  edit.id = row.id
}

function create() {
  const url = route("admin.menu.store")
  router.post(url, form, {
    onSuccess: () => {
      form.reset()
      document.getElementsByClassName("close").click
      createToast(
        {
          title: "Congratulations",
          description: "Menu Updated successfully"
        },
        {
          transition: "slide",
          position: "top-right"
        }
      )
    }
  })
}

function update() {
  const url = route("admin.menu.update", edit.id)

  router.patch(url, edit, {
    onSuccess: () => {
      createToast(
        {
          title: "Congratulations",
          description: "Menu Updated successfully"
        },
        {
          transition: "slide",
          position: "top-right"
        }
      )
    }
  })
}
</script>
