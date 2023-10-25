<template>
  <HeaderSegment title="Review" :segments="segments" :buttons="buttons" />
  <div class="container-fluid mt--6">
    <div class="row">
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
                      {{ totalReviews }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi-rs-stars mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Total Reviews") }}
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
                      {{ activeReviews }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi-rs-star-comment-alt mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Active Reviews") }}
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
                      {{ inactiveReviews }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-crossed-eye mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Inactive Reviews") }}
                </h5>
                <p></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <!-- Card header -->
          <div class="card-header border-0">
            <h3 class="mb-0">{{ trans("Reviews") }}</h3>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th class="col-3">
                    {{ trans("Reviewer Name") }}
                  </th>
                  <th class="col-3">{{ trans("Prompt") }}</th>
                  <th class="col-3">
                    {{ trans("Comment") }}
                  </th>
                  <th class="col-2">
                    {{ trans("Ratings") }}
                  </th>
                  <th class="col-2">
                    {{ trans("Status") }}
                  </th>
                  <th class="col-3 text-right">
                    {{ trans("Action") }}
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="review in reviews.data" :key="review.id">
                  <td class="text-left">
                    <Link
                      preserve-scroll
                      :href="route('admin.customer.show', review.user_id)"
                    >
                      {{ textExcerpt(review.user.name, 30) }}
                    </Link>
                  </td>
                  <td class="text-left">
                    <a target="_blank" :href="`/prompt/${review.prompt.slug}`">
                      {{ textExcerpt(review.prompt.title, 30) }}
                    </a>
                  </td>
                  <td class="text-left">
                    {{ textExcerpt(review.comment, 50) }}
                  </td>
                  <td>{{ review.star }} {{ trans("Star") }}</td>
                  <td>
                    <span
                      :class="
                        review.status == 1
                          ? 'badge badge-success'
                          : 'badge badge-danger'
                      "
                    >
                      {{ review.status == 1 ? "Active" : "Inactive" }}
                    </span>
                  </td>
                  <td class="text-right">
                    <div class="btn-group mb-2 float-right">
                      <button
                        @click="editReviewForm = review"
                        class="btn btn-neutral btn-sm dropdown-toggle"
                        type="button"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                      >
                        {{ trans("Action") }}
                      </button>
                      <div class="dropdown-menu">
                        <a
                          class="dropdown-item has-icon edit-row"
                          href="#"
                          data-toggle="modal"
                          data-target="#editModal"
                        >
                          <i class="fi fi-rs-edit"></i>{{ trans("Edit") }}</a
                        >
                        <a
                          class="dropdown-item has-icon delete-confirm"
                          href="javascript:void(0)"
                          @click="
                            modal.initiate(
                              route('admin.review.destroy', review.id)
                            )
                          "
                          ><i class="fas fa-trash"></i>{{ trans("Remove") }}
                        </a>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <template v-if="reviews.data.length == 0">
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
            <Paginate :links="reviews.links" />
          </div>
        </div>
      </div>
    </div>
  </div>
  <div
    class="modal fade"
    id="editModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <form
          @submit.prevent="editReview"
          method="POST"
          class="ajaxform_instant_reload edit-modal"
          enctype="multipart/form-data"
        >
          <div class="modal-header">
            <h3>{{ trans("Edit Review") }}</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ trans("Status") }}</label>
              <select v-model="editReviewForm.status" class="form-control">
                <option value="1" :selected="editReviewForm.status === 0">
                  {{ trans("Active") }}
                </option>
                <option value="0" :selected="editReviewForm.status === 1">
                  {{ trans("Inactive") }}
                </option>
              </select>
            </div>
            <div class="form-group">
              <label>{{ trans("Review Star") }}</label>
              <select
                v-model="editReviewForm.star"
                class="form-control"
                name="star"
              >
                <option value="5">{{ trans("5 Star") }}</option>
                <option value="4">{{ trans("4 Star") }}</option>
                <option value="3">{{ trans("3 Star") }}</option>
                <option value="2">{{ trans("2 Star") }}</option>
                <option value="1">{{ trans("1 Star") }}</option>
              </select>
            </div>
            <div class="form-group">
              <label>{{ trans("Comment") }}</label>
              <textarea
                v-model="editReviewForm.comment"
                class="form-control h-100"
                maxlength="500"
                name="comment"
                id="comment"
                required
              ></textarea>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-neutral submit-button">
                {{ trans("Update") }}
              </button>
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
import { router } from "@inertiajs/vue3"
import sharedComposable from "@/composables/sharedComposable"
import Paginate from "@/Components/Paginate.vue"
import { ref } from "vue"
defineOptions({ layout: AdminLayout })

const { textExcerpt, modal, ToastAlert } = sharedComposable()
const props = defineProps([
  "reviews",
  "buttons",
  "segments",
  "totalReviews",
  "activeReviews",
  "inactiveReviews"
])

const editReviewForm = ref({})

const editReview = () => {
  router.patch(
    route("admin.review.update", editReviewForm.value.id),
    editReviewForm.value,
    {
      onSuccess: () => {
        ToastAlert("Updated", "Review Updated successfully")
      }
    }
  )
}
</script>
