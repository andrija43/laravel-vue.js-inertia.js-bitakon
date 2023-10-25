<template>
  <HeaderSegment title="Categories" :segments="segments" :buttons="buttons" />
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
                      {{ totalCategories }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-notes mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Total Categories") }}
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
                      {{ activeCategories }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-note mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Active Categories") }}
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
                      {{ inActiveCategories }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-page-break mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Inactive Categories") }}
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
            <h3 class="mb-0">{{ trans("Categories") }}</h3>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th class="col-2">{{ trans("Name") }}</th>
                  <th class="col-2">{{ trans("Slug") }}</th>
                  <th class="col-2 text-center">{{ trans("Language") }}</th>
                  <th class="col-2">{{ trans("Status") }}</th>
                  <th class="col-2">{{ trans("Created At") }}</th>
                  <th class="col-2 text-right">{{ trans("Action") }}</th>
                </tr>
              </thead>

              <tbody>
                <tr v-for="category in categories.data" :key="category.id">
                  <td class="text-left">
                    {{ category.title }}
                  </td>
                  <td class="text-left">
                    {{ category.slug }}
                  </td>
                  <td class="text-center">
                    {{ category.lang }}
                  </td>
                  <td class="text-left">
                    <span
                      class="badge"
                      :class="
                        category.status == 1 ? 'badge-success' : 'badge-danger'
                      "
                    >
                      {{
                        category.status == 1 ? trans("Active") : trans("Draft")
                      }}
                    </span>
                  </td>
                  <td>
                    {{ moment(category.created_at).format("D-MMM-Y") }}
                  </td>
                  <td class="text-right">
                    <div class="btn-group mb-2 float-right">
                      <button
                        @click="editCategoryForm = category"
                        class="btn btn-neutral btn-sm dropdown-toggle"
                        type="button"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                      >
                        {{ trans("Action") }}
                      </button>
                      <div class="dropdown-menu">
                        <button
                          class="dropdown-item has-icon edit-row"
                          data-toggle="modal"
                          data-target="#editModal"
                        >
                          <i class="fi fi-rs-edit"></i>{{ trans("Edit") }}
                        </button>
                        <a
                          class="dropdown-item has-icon delete-confirm"
                          href="javascript:void(0)"
                          @click="
                            modal.initiate(
                              route('admin.category.destroy', category.id)
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
            <Paginate
              :links="categories.links"
              :currentPage="categories.current_page"
              :from="categories.from"
              :lastPage="categories.last_page"
              :lastPageUrl="categories.last_page_url"
              :nextpageurl="categories.next_page_url"
              :perPage="categories.per_page"
              :prevPageUrl="categories.prev_page_url"
              :to="categories.to"
              :total="categories.total"
            />
            <template v-if="categories.data.length == 0">
              <div class="text-center mt-2">
                <div class="alert bg-gradient-primary text-white">
                  <span class="text-left">{{
                    trans("!Opps no records found")
                  }}</span>
                </div>
              </div>
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- model -->
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
          @submit.prevent="createCategory"
          class="ajaxform_instant_reload"
        >
          <div class="modal-header">
            <h3>{{ trans("Create Category") }}</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ trans("Title") }}</label>
              <input
                v-model="categoryForm.title"
                type="text"
                name="title"
                class="form-control"
                required
              />
            </div>
            <div class="form-group">
              <label>{{ trans("Status") }}</label>
              <select
                required
                v-model="categoryForm.status"
                class="form-control"
                name="status"
              >
                <option value="1">{{ trans("Active") }}</option>
                <option value="0">{{ trans("InActive") }}</option>
              </select>
            </div>
            <div class="form-group">
              <label>{{ trans("Language") }}</label>
              <select
                required
                v-model="categoryForm.language"
                class="form-control"
                name="language"
              >
                <template v-for="(language, key) in languages" :key="key">
                  <option :value="key">{{ language }}</option>
                </template>
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
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" @submit.prevent="editCategory" class="edit-form">
          <div class="modal-header">
            <h3>{{ trans("Edit Category") }}</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ trans("Title") }}</label>
              <input
                v-model="editCategoryForm.title"
                type="text"
                name="title"
                class="form-control"
                required
              />
            </div>

            <div class="form-group">
              <label>{{ trans("Status") }}</label>
              <select
                v-model="editCategoryForm.status"
                class="form-control"
                name="status"
              >
                <option value="1">{{ trans("Active") }}</option>
                <option value="0">{{ trans("InActive") }}</option>
              </select>
            </div>
            <div class="form-group">
              <label>{{ trans("Language") }}</label>
              <select
                v-model="editCategoryForm.lang"
                class="form-control"
                name="language"
              >
                <template v-for="(language, key) in languages" :key="key">
                  <option :value="key">{{ language }}</option>
                </template>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="submit"
              class="btn btn-outline-primary col-12 submit-button"
            >
              {{ trans("Update Now") }}
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
import { useForm, router } from "@inertiajs/vue3"
import { createToast } from "mosha-vue-toastify"
import Paginate from "@/Components/Paginate.vue"
import moment from "moment"
import { ref } from "vue"
import sharedComposable from "@/composables/sharedComposable"

defineOptions({ layout: AdminLayout })
const { modal } = sharedComposable()
const props = defineProps([
  "categories",
  "totalCategories",
  "activeCategories",
  "inActiveCategories",
  "languages",
  "buttons",
  "segments"
])
const categoryForm = useForm({
  title: "",
  status: "active",
  language: ""
})
const editCategoryForm = ref({})
const createCategory = () => {
  categoryForm.post(route("admin.category.store"), {
    onSuccess: () => {
      categoryForm.reset()
      createToast({
        title: "Created",
        description: "Category Created successfully"
      })
    }
  })
}
const editCategory = () => {
  router.patch(
    route("admin.category.update", editCategoryForm.value.id),
    editCategoryForm.value,
    {
      onSuccess: () => {
        editCategoryForm.value = {}
        createToast({
          title: "Updated",
          description: "Category Updated successfully"
        })
      }
    }
  )
}
</script>
