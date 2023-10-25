<template>
  <Head title="Features" />
  <HeaderSegment
    :title="trans('Features')"
    :segments="segments"
    :buttons="buttons"
  />
  <div class="container-fluid mt--6">
    <div class="row">
      <div class="col">
        <div class="card">
          <!-- Card header -->
          <div class="card-header border-0">
            <h3 class="mb-0">{{ trans("How its works") }}</h3>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th class="col-3">{{ trans("Title") }}</th>
                  <th class="col-6">{{ trans("Description") }}</th>
                  <th class="col-1 text-right">{{ trans("Language") }}</th>
                  <th class="col-1 text-right">{{ trans("Action") }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="post in posts.data" :key="post.id">
                  <td class="text-left">
                    <img
                      :src="post.preview.value"
                      class="avatar rounded-circle mr-3"
                    />
                    {{ textExcerpt(post.title, 30) }}
                  </td>
                  <td class="text-left">
                    {{ textExcerpt(post.excerpt.value, 50) }}
                  </td>
                  <td class="text-right">
                    {{ post.lang }}
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
                          :href="route('admin.features.edit', post.id)"
                        >
                          <i class="fi fi-rs-edit"></i>{{ trans("Edit") }}
                      </Link>
                        <a
                          class="dropdown-item has-icon delete-confirm"
                          href="javascript:void(0)"
                          @click="
                            modal.initiate(
                              route('admin.features.destroy', post.id)
                            )
                          "
                          ><i class="fas fa-trash"></i>{{ trans("Remove") }}</a
                        >
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
</template>

<script setup>
"use strict";
import AdminLayout from "@/Pages/Admin/Layout/App.vue"
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue"
import { Head } from "@inertiajs/vue3"
import { trans } from "laravel-vue-i18n"
import sharedComposable from "@/composables/sharedComposable"
const props = defineProps(["posts", "segments", "buttons"])
const { textExcerpt, modal } = sharedComposable()
defineOptions({ layout: AdminLayout })
</script>
