<template>
  <HeaderSegment title="Tags" :segments="segments" :buttons="buttons" />
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
                      {{ totalTags }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-tags mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Total Tags") }}
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
                      {{ activeTags }}
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
                  {{ trans("Active Tags") }}
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
                      {{ inActiveTags }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-ticket-alt mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Inactive Tags") }}
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
            <h3 class="mb-0">{{ trans("Tags") }}</h3>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th class="col-2">{{ trans("Name") }}</th>
                  <th class="col-2">{{ trans("Slug") }}</th>
                  <th class="col-2 text-center">
                    {{ trans("Uses for blog") }}
                  </th>
                  <th class="col-2">{{ trans("Status") }}</th>
                  <th class="col-2">{{ trans("Created At") }}</th>
                  <th class="col-2 text-right">{{ trans("Action") }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="tag in tags.data" :key="tag.id">
                  <td class="text-left">
                    {{ tag.title }}
                  </td>
                  <td class="text-left">
                    {{ tag.slug }}
                  </td>
                  <td class="text-center">
                    {{ tag.postcategories_count }}
                  </td>
                  <td class="text-left">
                    <span
                      class="badge badge-{{ tag.status == 1 ? 'success' : 'danger' }}"
                    >
                      {{ tag.status == 1 ? trans("Active") : trans("Draft") }}
                    </span>
                  </td>
                  <td>
                    {{ moment(tag.created_at).format("D-MMM-Y") }}
                  </td>
                  <td class="text-right">
                    <div class="btn-group mb-2 float-right">
                      <button
                        @click="editTagForm = tag"
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
                            modal.initiate(route('admin.tag.destroy', tag.id))
                          "
                          ><i class="fas fa-trash"></i>{{ trans("Remove") }}
                        </a>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>

            <template v-if="tags.data.length == 0">
              <div class="text-center mt-2">
                <div class="alert bg-gradient-primary text-white">
                  <span class="text-left">{{
                    trans("!Opps no records found")
                  }}</span>
                </div>
              </div>
            </template>

            <div class="card-footer py-4">
            <Paginate
              :links="tags.links"
              :currentPage="tags.current_page"
              :from="tags.from"
              :lastPage="tags.last_page"
              :lastPageUrl="tags.last_page_url"
              :nextpageurl="tags.next_page_url"
              :perPage="tags.per_page"
              :prevPageUrl="tags.prev_page_url"
              :to="tags.to"
              :total="tags.total"
            />
          </div>
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
          @submit.prevent="createTag"
          class="ajaxform_instant_reload"
        >
          <div class="modal-header">
            <h3>{{ trans("Create Tag") }}</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ trans("Title") }}</label>
              <input
                v-model="tagForm.title"
                type="text"
                name="title"
                class="form-control"
                required=""
              />
            </div>
            <div class="form-group">
              <label>{{ trans("Status") }}</label>
              <select
                v-model="tagForm.status"
                class="form-control"
                name="status"
              >
                <option value="1">{{ trans("Active") }}</option>
                <option value="0">{{ trans("InActive") }}</option>
              </select>
            </div>
            <div class="form-group">
              <label>{{ trans("Status") }}</label>
              <select
                v-model="tagForm.language"
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
        <form
          method="POST"
          @submit.prevent="editTag"
          class="ajaxform_instant_reload edit-form"
        >
          <div class="modal-header">
            <h3>{{ trans("Edit Tag") }}</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ trans("Title") }}</label>
              <input
                v-model="editTagForm.title"
                type="text"
                name="title"
                id="title"
                class="form-control"
                required
              />
            </div>

            <div class="form-group">
              <label>{{ trans("Status") }}</label>
              <select
                v-model="editTagForm.status"
                class="form-control"
                name="status"
                id="status"
              >
                <option value="1">{{ trans("Active") }}</option>
                <option value="0">{{ trans("InActive") }}</option>
              </select>
            </div>
            <div class="form-group">
              <label>{{ trans("Language") }}</label>
              <select
                v-model="editTagForm.lang"
                class="form-control"
                name="language"
                id="language"
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
  "tags",
  "totalTags",
  "activeTags",
  "inActiveTags",
  "languages",
  "buttons",
  "segments"
])
const tagForm = useForm({
  title: "",
  status: "active",
  language: ""
})
const editTagForm = ref({})
const createTag = () => {
  tagForm.post(route("admin.tag.store"), {
    onSuccess: () => {
      tagForm.reset()
      createToast(
        {
          title: "Created",
          description: "Tag Created successfully"
        },
        {
          transition: "slide",
          position: "top-right"
        }
      )
    }
  })
}
const editTag = () => {
  router.patch(
    route("admin.tag.update", editTagForm.value.id),
    editTagForm.value,
    {
      onSuccess: () => {
        editTagForm.value = {}
        createToast(
          {
            title: "Updated",
            description: "Tag Updated successfully"
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
