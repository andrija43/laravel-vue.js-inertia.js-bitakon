<template>
  <HeaderSegment title="Custom Page" :segments="segments" :buttons="buttons" />
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
                      {{ totalPosts }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-document-signed mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Total Pages") }}
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
                      {{ totalActivePosts }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-assept-document mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Active Pages") }}
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
                      {{ totalInActivePosts }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-delete-document mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Inactive Pages") }}
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
            <h3 class="mb-0">{{ trans("Pages") }}</h3>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th class="col-2">{{ trans("Title") }}</th>
                  <th class="col-4">{{ trans("Url") }}</th>
                  <th class="col-1">{{ trans("Status") }}</th>
                  <th class="col-2">{{ trans("Created At") }}</th>
                  <th class="col-1 text-right">{{ trans("Action") }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="page in pages.data" :key="page.id">
                  <td class="text-left">
                    {{ textExcerpt(page.title, 50) }}
                  </td>
                  <td class="text-left">
                    <a :href="page.posturl" target="_blank">{{
                      textExcerpt(page.posturl, 100)
                    }}</a>
                  </td>

                  <td class="text-left">
                    <span
                      class="badge"
                      :class="
                        page.status == 1 ? 'badge-success' : 'badge-danger'
                      "
                    >
                      {{ page.status == 1 ? trans("Active") : trans("Draft") }}
                    </span>
                  </td>
                  <td>
                    {{ page.created_at_diff }}
                  </td>
                  <td class="text-right">
                    <div class="btn-group mb-2 float-right">
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
                          :href="route('admin.page.edit', page.id)"
                          ><i class="fi fi-rs-edit"></i>{{ trans("Edit") }}
                        </Link>

                        <a
                          class="dropdown-item has-icon delete-confirm"
                          href="javascript:void(0)"
                          @click="
                            modal.initiate(route('admin.page.destroy', page.id))
                          "
                          ><i class="fas fa-trash"></i
                          >{{ trans("Remove Page") }}</a
                        >
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <template v-if="pages.data.length == 0">
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
              :links="pages.links"
              :currentPage="pages.current_page"
              :from="pages.from"
              :lastPage="pages.last_page"
              :lastPageUrl="pages.last_page_url"
              :nextpageurl="pages.next_page_url"
              :perPage="pages.per_page"
              :prevPageUrl="pages.prev_page_url"
              :to="pages.to"
              :total="pages.total"
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
import { Link } from "@inertiajs/vue3"
import sharedComposable from "@/composables/sharedComposable"
import Paginate from "@/Components/Paginate.vue"

defineOptions({ layout: AdminLayout })

const { textExcerpt, modal } = sharedComposable()
const props = defineProps([
  "pages",
  "totalActivePosts",
  "totalInActivePosts",
  "totalPosts",
  "buttons",
  "segments"
])
</script>
