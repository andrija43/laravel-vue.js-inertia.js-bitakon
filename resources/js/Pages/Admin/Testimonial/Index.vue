<template>
  <HeaderSegment title="Testimonial" :segments="segments" :buttons="buttons" />
  <div class="container-fluid mt--6">
    <div class="row">
      <div class="col">
        <div class="card">
          <!-- Card header -->
          <div class="card-header border-0">
            <h3 class="mb-0">{{ trans("Testimonials") }}</h3>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th class="col-3">{{ trans("Reviewer Name") }}</th>
                  <th class="col-2">{{ trans("Reviewer Position") }}</th>
                  <th class="col-4">{{ trans("Comment") }}</th>
                  <th class="col-1 text-right">{{ trans("Ratings") }}</th>
                  <th class="col-1 text-right">{{ trans("Action") }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="post in posts.data" :key="post.id">
                  <td class="text-left">
                    <img
                      :src="post.preview.value"
                      class="avatar rounded-square mr-3"
                    />
                    {{ textExcerpt(post.title, 30) }}
                  </td>
                  <td class="text-left">
                    {{ textExcerpt(post.slug, 30) }}
                  </td>
                  <td class="text-left">
                    {{ textExcerpt(post.excerpt.value ?? "", 50) }}
                  </td>
                  <td class="text-right">
                    {{ post.lang }} {{ trans("Star") }}
                  </td>
                  <td class="text-right">
                    <div class="btn-group mb-2 float-right">
                      <button
                        @click="editTestimonialForm = post"
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
                              route('admin.testimonials.destroy', post.id)
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
          </div>

          <div class="card-footer py-4">
            <Paginate
              :links="posts.links"
              :currentPage="posts.current_page"
              :from="posts.from"
              :lastPage="posts.last_page"
              :lastPageUrl="posts.last_page_url"
              :nextpageurl="posts.next_page_url"
              :perPage="posts.per_page"
              :prevPageUrl="posts.prev_page_url"
              :to="posts.to"
              :total="posts.total"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- modal -->
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
          @submit.prevent="createTestimonial"
          class="ajaxform_instant_reload"
          enctype="multipart/form-data"
        >
          <div class="modal-header">
            <h3>{{ trans("Create Testimonial") }}</h3>

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
              <label>{{ trans("Reviewer Name") }}</label>
              <input
                v-model="form.reviewer_name"
                type="text"
                name="reviewer_name"
                maxlength="150"
                class="form-control"
                required
              />
            </div>
            <div class="form-group">
              <label>{{ trans("Reviewer Position") }}</label>
              <input
                v-model="form.reviewer_position"
                type="text"
                name="reviewer_position"
                class="form-control"
                required
                placeholder="CEO of Google"
                maxlength="50"
              />
            </div>
            <div class="form-group">
              <label>{{ trans("Reviewer Avatar") }}</label>
              <input
                @input="(e) => (form.reviewer_avatar = e.target.files[0])"
                type="file"
                name="reviewer_avatar"
                accept="image/*"
                class="form-control"
                required=""
              />
            </div>
            <div class="form-group">
              <label>{{ trans("Review Star") }}</label>
              <select v-model="form.star" class="form-control" name="star">
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
                v-model="form.comment"
                class="form-control h-100"
                maxlength="500"
                name="comment"
                required
              ></textarea>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-neutral submit-button">
                {{ trans("Create Now") }}
              </button>
            </div>
          </div>
        </form>
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
          @submit.prevent="editTestimonial"
          method="POST"
          class="ajaxform_instant_reload edit-modal"
          enctype="multipart/form-data"
        >
          <div class="modal-header">
            <h3>{{ trans("Edit Testimonial") }}</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ trans("Reviewer Name") }}</label>
              <input
                v-model="editTestimonialForm.title"
                type="text"
                name="reviewer_name"
                id="reviewer_name"
                maxlength="150"
                class="form-control"
                required
              />
            </div>
            <div class="form-group">
              <label>{{ trans("Reviewer Position") }}</label>
              <input
                v-model="editTestimonialForm.slug"
                type="text"
                name="reviewer_position"
                id="reviewer_position"
                class="form-control"
                required=""
                placeholder="CEO of Google"
                maxlength="50"
              />
            </div>
            <div class="form-group">
              <label>{{ trans("Reviewer Avatar") }}</label>
              <input
                @input="
                  (e) => (editTestimonialForm.preview.value = e.target.files[0])
                "
                type="file"
                name="reviewer_avatar"
                accept="image/*"
                class="form-control"
              />
            </div>
            <div class="form-group">
              <label>{{ trans("Review Star") }}</label>
              <select
                v-model="editTestimonialForm.lang"
                class="form-control"
                name="star"
                id="star"
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
                :value="editTestimonialForm?.excerpt?.value ?? ''"
                @input="
                  (e) => (editTestimonialForm.excerpt.value = e.target.value)
                "
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
import { useForm, router } from "@inertiajs/vue3"
import sharedComposable from "@/composables/sharedComposable"
import { createToast } from "mosha-vue-toastify"
import Paginate from "@/Components/Paginate.vue"
import { ref } from "vue"
defineOptions({ layout: AdminLayout })

const { textExcerpt, modal } = sharedComposable()
const props = defineProps(["posts", "buttons", "segments"])
const form = useForm({
  reviewer_name: "",
  reviewer_position: "",
  reviewer_avatar: "",
  star: 0,
  comment: ""
})
const editTestimonialForm = ref({})
const createTestimonial = () => {
  form.post(route("admin.testimonials.store"), {
    onSuccess: () => {
      form.reset()
      createToast(
        {
          title: "Created",
          description: "Testimonial Created successfully"
        },
        {
          transition: "slide",
          position: "top-right"
        }
      )
    }
  })
}
const editTestimonial = () => {
  if (!(editTestimonialForm.value.preview.value instanceof File)) {
    editTestimonialForm.value.preview.value = null
  }

  router.post(
    route("admin.testimonials.update", editTestimonialForm.value.id),
    {
      _method: "patch",
      testimonial: editTestimonialForm.value
    },
    {
      onSuccess: () => {
        createToast(
          {
            title: "Updated",
            description: "Testimonial Updated successfully"
          },
          {
            transition: "slide",
            position: "top-right"
          }
        )
      }
    }
  )
}
</script>
