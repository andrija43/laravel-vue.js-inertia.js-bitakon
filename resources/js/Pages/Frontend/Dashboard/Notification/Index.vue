<script setup>
"use strict";
import { Head, router } from "@inertiajs/vue3"
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue"
import DashboardLayout from "@/Pages/Frontend/Dashboard/Layout/App.vue"
import Paginate from "@/Components/Paginate.vue"
import moment from "moment"
import sharedComposable from "@/composables/sharedComposable"
import EmptyMessage from "@/Pages/Frontend/Layout/EmptyMessage.vue"
import { ref, computed } from "vue"
const props = defineProps(["notifications"])
defineOptions({ layout: [FrontendLayout, DashboardLayout] })
const { textExcerpt } = sharedComposable()

const notificationId = ref(null)
const findNotification = computed(() => {
  return (
    props.notifications.data.find((n) => n.id == notificationId.value) || []
  )
})
const view = (id) => {
  notificationId.value = id
  if (findNotification.value.seen !== 1) {
    setTimeout(() => {
      router.patch(route("user.notification.update", id))
    }, 500)
  }
}
</script>

<template>
  <Head title="Notifications" />
  <section class="upcoming__area pb-120">
    <div class="container">
      <div class="row">
        <div v-if="notifications.data.length > 0" class="col-xxl-12">
          <div class="upcoming__wrapper">
            <div class="upcoming__item">
              <div class="upcoming__table">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">{{ trans("Date") }}</th>
                      <th scope="col">{{ trans("Title") }}</th>
                      <th scope="col">{{ trans("Comment") }}</th>
                      <th scope="col">{{ trans("Seen") }}</th>
                      <th scope="col">{{ trans("Action") }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="notification in notifications.data"
                      :key="notification.id"
                    >
                      <td>
                        {{
                          moment(notification.created_at).format(
                            "DD MMM, YY h:m a"
                          )
                        }}
                      </td>
                      <td>
                        {{ textExcerpt(notification.title, 20) }}
                      </td>
                      <td>
                        {{ textExcerpt(notification.comment, 15) }}
                      </td>

                      <td>
                        <span
                          class="badge"
                          :class="
                            notification.seen == 1 ? 'bg-success' : 'bg-danger'
                          "
                        >
                          {{ notification.seen == 1 ? "Read" : "Unread" }}
                        </span>
                      </td>

                      <td>
                        <button
                          @click="view(notification.id)"
                          type="button"
                          data-bs-toggle="modal"
                          data-bs-target="#viewmodal"
                        >
                          <i class="fa-light fa-eye"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <br />
              <Paginate :links="notifications.links" />
            </div>
          </div>
        </div>
        <div v-else class="breadcrumb__title text-center">
          <EmptyMessage type="text" message="No record found" />
        </div>
      </div>
    </div>
  </section>
  <!-- view modal -->
  <div
    class="report__modal modal fade"
    id="viewmodal"
    tabindex="-1"
    aria-labelledby="viewmodal"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="report__close">
          <button
            type="button"
            class="report__close-btn"
            data-bs-dismiss="modal"
            aria-label="Close"
          >
            <i class="fa-regular fa-xmark"></i>
          </button>
        </div>
        <div class="report__wrapper">
          <h5 class="base-text">
            {{ trans("Date") }} :
            {{ moment(findNotification.created_at).format("DD MMM, YY h:m a") }}
          </h5>
          <h5 class="base-text mt-20">
            {{ trans("Title") }} :
            {{ findNotification.title }}
          </h5>
          <h5 class="base-text mt-20">
            {{ trans("Comment") }} :
            {{ findNotification.comment }}
          </h5>
          <h5 class="base-text mt-20">
            {{ trans("Seen") }} :
            <span
              class="badge"
              :class="findNotification.seen == 1 ? 'bg-success' : 'bg-danger'"
            >
              {{ findNotification.seen == 1 ? "Read" : "Unread" }}
            </span>
          </h5>
        </div>
      </div>
    </div>
  </div>
</template>
