<template>
  <HeaderSegment
    title="Blogs"
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
                      {{ totalPosts }}
                    </span>
                  </div>
                  <div class="col-auto">
                    <div
                      class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                    >
                      <i class="fi fi-rs-blog-text mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Total Blogs") }}
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
                      <i class="fi fi-rs-circle-book-open mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Active Blogs") }}
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
                      <i class="fi fi-rs-comment-exclamation mt-2"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-sm"></p>
                <h5 class="card-title text-muted mb-0">
                  {{ trans("Inactive Blogs") }}
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
            <h3 class="mb-0">{{ trans("Blogs") }}</h3>
            <form
              @submit.prevent="filterData.get(route('admin.blog.index'))"
              class="card-header-form"
            >
              <div class="input-group">
                <input
                  type="text"
                  name="search"
                  v-model="filterData.search"
                  class="form-control"
                  placeholder="title......"
                />

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
                  <th class="col-3">{{ trans("Url") }}</th>
                  <th class="col-1">{{ trans("Status") }}</th>
                  <th class="col-2">{{ trans("Created At") }}</th>
                  <th class="col-1 text-right">{{ trans("Action") }}</th>
                </tr>
              </thead>
              <tbody>
                <template v-if="posts.data.length != 0">
                  <tr v-for="post in posts.data" :key="post.id">
                    <td class="text-left">
                      <img
                        :src="post.preview.value"
                        class="avatar rounded-square mr-3"
                      />
                      {{ textExcerpt(post.title, 20) }}
                    </td>
                    <td class="text-left">
                      <a :href="`/blog/${post.slug}`" target="_blank"
                        >{{ textExcerpt(post.posturl, 50) }}
                      </a>
                    </td>

                    <td class="text-left">
                      <span
                        class="badge"
                        :class="
                          post.status == 1 ? 'badge-success' : 'badge-danger'
                        "
                      >
                        {{
                          post.status == 1 ? trans("Active") : trans("Draft")
                        }}
                      </span>
                    </td>
                    <td>
                      {{ moment(post.created_at).format("D-MMM-Y") }}
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
                            :href="route('admin.blog.edit', post.id)"
                            ><i class="fi fi-rs-edit"></i
                            >{{ trans("Edit Blog") }}
                          </Link>
                          <a
                            class="dropdown-item has-icon delete-confirm"
                            href="javascript:void(0)"
                            @click="
                              modal.initiate(
                                route('admin.blog.destroy', post.id)
                              )
                            "
                            ><i class="fas fa-trash"></i>{{ trans("Remove") }}
                          </a>
                        </div>
                      </div>
                    </td>
                  </tr>
                </template>
              </tbody>
            </table>

            <template v-if="posts.data.length == 0">
              <div class="text-center mt-2">
                <div class="alert bg-gradient-primary text-white">
                  <span class="text-left">{{
                    trans("!Opps no records found")
                  }}</span>
                </div>
              </div>
            </template>
          </div>

          <div class="card-footer">
            <Paginate :links="posts.links" />
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
import { Link, useForm } from "@inertiajs/vue3"
import sharedComposable from "@/composables/sharedComposable"
import Paginate from "@/components/Paginate.vue"
import moment from "moment"
defineOptions({ layout: AdminLayout })
const { textExcerpt, modal } = sharedComposable()
const props = defineProps([
  "posts",
  "totalPosts",
  "totalActivePosts",
  "totalInActivePosts",
  "buttons",
  "segments",
  "type",
  "request"
])

const filterData = useForm({
  search: props.request.search
})
</script>
