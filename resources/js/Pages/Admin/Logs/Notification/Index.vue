<template>
  <HeaderSegment
    title="Notifications"
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
                      {{ totalNotifications }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-envelope-bulk mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Total Notifications") }}
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
                      {{ readNotifications }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-envelope-open mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Read Notifications") }}
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
                      {{ unreadNotifications }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-envelope-ban mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Unread Notifications") }}
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
            <h3 class="mb-0">{{ trans("Notifications") }}</h3>
            <form
              class="card-header-form"
              method="GET"
              @submit.prevent="
                filterData.get(route('admin.notification.index'))
              "
            >
              <div class="input-group">
                <input
                  type="text"
                  name="search"
                  v-model="filterData.search"
                  class="form-control"
                  placeholder="Search......"
                />
                <select
                  v-model="filterData.type"
                  class="form-control"
                  name="type"
                >
                  <option value="email">{{ trans("User Email") }}</option>
                  <option value="title">{{ trans("title") }}</option>
                </select>
                <div class="input-group-btn">
                  <button class="btn btn-neutral btn-icon">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th class="col-3">{{ trans("Title") }}</th>
                  <th class="col-5">{{ trans("Comment") }}</th>
                  <th class="col-1">{{ trans("User") }}</th>
                  <th class="col-1">{{ trans("Seen") }}</th>
                  <th class="col-1 text-left">{{ trans("Created At") }}</th>
                  <th class="col-1 text-left">{{ trans("Action") }}</th>
                </tr>
              </thead>

              <template v-if="notifications.data.length != 0">
                <tbody class="list">
                  <tr
                    v-for="notification in notifications.data"
                    :key="notification.id"
                  >
                    <td class="text-left">
                      {{ textExcerpt(notification.title, 80) }}
                    </td>
                    <td>
                      {{ textExcerpt(notification.comment, 50) }}
                    </td>
                    <td>
                      <Link
                        class="text-dark"
                        :href="
                          route('admin.customer.show', notification.user_id)
                        "
                      >
                        {{ textExcerpt(notification.user.name, 15) }}
                      </Link>
                    </td>

                    <td>
                      <span
                        class="badge"
                        :class="
                          notification.seen == 1
                            ? 'badge-success'
                            : 'badge-danger'
                        "
                      >
                        {{ notification.seen == 1 ? "Read" : "Unread" }}
                      </span>
                    </td>

                    <td class="text-center">
                      {{ moment(notification.created_at).format("d-F-Y") }}
                    </td>
                    <td>
                      <div class="dropdown">
                        <a
                          class="btn btn-sm btn-icon-only text-light"
                          href="#"
                          role="button"
                          data-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false"
                        >
                          <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div
                          class="dropdown-menu dropdown-menu-right dropdown-menu-arrow"
                        >
                          <a
                            class="dropdown-item has-icon delete-confirm"
                            href="javascript:void(0)"
                            @click="
                              modal.initiate(
                                route(
                                  'admin.notification.destroy',
                                  notification.id
                                )
                              )
                            "
                            ><i class="fas fa-trash"></i>{{ trans("Remove") }}
                          </a>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </template>
            </table>
            <template v-if="notifications.data.length == 0">
              <div class="text-center mt-2">
                <div class="alert bg-gradient-primary text-white">
                  <span class="text-left">{{
                    trans("!Opps no records found")
                  }}</span>
                </div>
              </div>
            </template>
          </div>
          <div class="card-footer py-4">
            <Paginate
              :links="notifications.links"
              :currentPage="notifications.current_page"
              :from="notifications.from"
              :lastPage="notifications.last_page"
              :lastPageUrl="notifications.last_page_url"
              :nextpageurl="notifications.next_page_url"
              :perPage="notifications.per_page"
              :prevPageUrl="notifications.prev_page_url"
              :to="notifications.to"
              :total="notifications.total"
            />
          </div>
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
          @submit.prevent="createNotification"
          class="ajaxform_instant_reload"
        >
          <div class="modal-header">
            <h3>{{ trans("Send Notification") }}</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ trans("Receive Email") }}</label>
              <input
                v-model="form.email"
                type="email"
                name="email"
                class="form-control"
                required
              />
            </div>
            <div class="form-group">
              <label>{{ trans("Title") }}</label>
              <input
                v-model="form.title"
                type="text"
                name="title"
                class="form-control"
                required
                maxlength="100"
              />
            </div>
            <div class="form-group">
              <label>{{ trans("Description") }}</label>
              <textarea
                v-model="form.description"
                class="form-control"
                required
                name="description"
                maxlength="200"
              ></textarea>
            </div>
            <div class="form-group">
              <label>{{ trans("Action Link") }}</label>
              <input
                v-model="form.url"
                type="url"
                name="url"
                class="form-control"
                required
                maxlength="100"
              />
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-outline-primary col-12">
              {{ trans("Create Now") }}
            </button>
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
import { Link, useForm, router } from "@inertiajs/vue3"
import sharedComposable from "@/composables/sharedComposable"
import { createToast } from "mosha-vue-toastify"
import Paginate from "@/Components/Paginate.vue"
import moment from "moment"
defineOptions({ layout: AdminLayout })
const { textExcerpt, modal } = sharedComposable()

const props = defineProps([
  "segments",
  "buttons",
  "request",
  "notifications",
  "totalNotifications",
  "readNotifications",
  "unreadNotifications",
  "type"
])

const filterData = useForm({
  search: props.request.search,
  type: props.type
})

const form = useForm({
  email: "",
  title: "",
  description: "",
  url: ""
})

const createNotification = () => {
  form.post(route("admin.notification.store"), {
    onSuccess: () => {
      form.reset()
      createToast(
        {
          title: "Created",
          description: "SNotification created successfully"
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
