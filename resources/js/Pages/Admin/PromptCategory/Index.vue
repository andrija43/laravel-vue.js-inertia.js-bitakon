<template>
  <HeaderSegment
    title="Prompt Category"
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
                      {{ totalCategory }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class=" fi-rs-boxes mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Total Category") }}
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
                      {{ totalActiveCategory }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi-rs-box-open-full mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Active Category") }}
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
                      {{ totalInactiveCategory }}
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
                  {{ trans("Inactive Category") }}
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
            <h3 class="mb-0">{{ trans("Prompt Category") }}</h3>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th class="col-6">{{ trans("Name") }}</th>
                  <th class="col-1">{{ trans("Prompts") }}</th>
                  <th class="col-1">{{ trans("Model") }}</th>
                  <th class="col-1">{{ trans("Filterable") }}</th>
                  <th class="col-1 text-right">{{ trans("Status") }}</th>
                  <th class="col-2 text-center">{{ trans("Action") }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="category in promptcategory.data" :key="category.id">
                  <td class="text-left">
                    <img
                      :src="category.preview"
                      class="avatar rounded-square mr-3"
                    />
                    {{ textExcerpt(category.name, 50) }}
                  </td>
                  <td class="text-center">
                    {{ category.prompts_count }}
                  </td>
                  <td class="text-left">
                    {{ category.promptmodel.title || "" }}
                  </td>
                  <td>
                    <span
                      class="badge"
                      :class="
                        category.is_filterable == 1
                          ? 'badge-success'
                          : 'badge-danger'
                      "
                    >
                      {{
                        category.is_filterable == 1
                          ? trans("Active")
                          : trans("Draft")
                      }}
                    </span>
                  </td>
                  <td class="text-right">
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

                  <td class="text-center">
                    <div class="btn-group mb-2 text-center">
                      <button
                        class="btn btn-neutral btn-sm dropdown-toggle"
                        type="button"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                      >
                        {{ trans("Action") }}
                      </button>
                      <div class="dropdown-menu">
                        <Link
                          class="dropdown-item has-icon"
                          :href="
                            route('admin.prompt-category.edit', category.id)
                          "
                          ><i class="fi fi-rs-edit"></i>{{ trans("Edit") }}
                        </Link>
                        <Link
                          class="dropdown-item has-icon"
                          :href="
                            route('admin.prompt-category.show', category.id)
                          "
                          ><i class="fas fa-image"></i>{{ trans("Images") }}
                        </Link>
                        <a
                          v-if="category.prompts_count == 0"
                          class="dropdown-item has-icon delete-confirm"
                          href="javascript:void(0)"
                          @click="
                            modal.initiate(
                              route(
                                'admin.prompt-category.destroy',
                                category.id
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
            </table>
            <template v-if="promptcategory.data.length == 0">
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
              :links="promptcategory.links"
              :currentPage="promptcategory.current_page"
              :from="promptcategory.from"
              :lastPage="promptcategory.last_page"
              :lastPageUrl="promptcategory.last_page_url"
              :nextpageurl="promptcategory.next_page_url"
              :perPage="promptcategory.per_page"
              :prevPageUrl="promptcategory.prev_page_url"
              :to="promptcategory.to"
              :total="promptcategory.total"
            />
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
import Paginate from "@/Components/Paginate.vue"
defineOptions({ layout: AdminLayout })

const { textExcerpt, modal } = sharedComposable()
const props = defineProps([
  "promptcategory",
  "buttons",
  "segments",
  "totalCategory",
  "totalInactiveCategory",
  "totalActiveCategory"
])
</script>
