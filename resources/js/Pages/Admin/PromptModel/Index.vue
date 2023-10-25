<template>
  <Head title="Prompt Model" />
  <HeaderSegment
    :title="trans('Prompt Models')"
    :segments="segments"
    :buttons="buttons"
  />
  <div class="container-fluid mt--6">
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
                  {{ totalModels }}
                </span>
              </div>
              <div class="col-auto">
                <div
                  class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                >
                  <i class="fi-rs-palette mt-2"></i>
                </div>
              </div>
            </div>
            <p class="mt-3 mb-0 text-sm"></p>
            <h5 class="card-title text-muted mb-0">
              {{ trans("Total Main Models") }}
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
                  {{ totalGroupModels }}
                </span>
              </div>
              <div class="col-auto">
                <div
                  class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                >
                  <i class="fi-rs-gallery-thumbnails mt-2"></i>
                </div>
              </div>
            </div>
            <p class="mt-3 mb-0 text-sm"></p>
            <h5 class="card-title text-muted mb-0">{{ "Total Model Groups" }}</h5>
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
                  {{ totalSubModels }}
                </span>
              </div>
              <div class="col-auto">
                <div
                  class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                >
                  <i class="fi-rs-chart-tree mt-2"></i>
                </div>
              </div>
            </div>
            <p class="mt-3 mb-0 text-sm"></p>
            <h5 class="card-title text-muted mb-0">
              {{ trans("Sub Models") }}
            </h5>
            <p></p>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <div class="card">
          <!-- Card header -->
          <div class="card-header border-0">
            <h3 class="mb-0">{{ trans("Parent Models") }}</h3>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th scope="col" class="sort col-3">{{ trans("Name") }}</th>
                  <th scope="col" class="sort col-3">{{ trans("Url") }}</th>
                  <th scope="col" class="sort text-center col-3">
                    {{ trans("Total Used") }}
                  </th>
                  <th scope="col" class="sort col-3">{{ trans("Status") }}</th>
                  <th scope="col" class="sort col-2 text-right">
                    {{ trans("Action") }}
                  </th>
                </tr>
              </thead>
              <tbody class="list">
                <tr v-for="model in models" :key="model.id">
                  <th scope="row">
                    <div class="media align-items-center">
                      <Link
                        v-if="model.preview != null"
                        :href="model.posturl"
                        class="avatar rounded-square mr-3"
                      >
                        <img alt="" :src="model.preview" />
                      </Link>

                      <div class="media-body">
                        <span class="name mb-0 text-sm">{{ model.title }}</span>
                      </div>
                    </div>
                  </th>

                  <td class="text-left">
                    <a
                      target="_blank"
                      v-if="model.preview != null"
                      :href="model.posturl"
                    >
                      {{ model.posturl }}
                    </a>
                  </td>
                  <td class="text-center">
                    {{ model.prompts_count }}
                  </td>

                  <td class="text-left">
                    <span class="badge badge-dot text-right">
                      <i
                        :class="model.status == 1 ? 'bg-success' : 'bg-danger'"
                      ></i>
                      <span class="status">{{
                        model.status == 1 ? "Active" : "Disabled"
                      }}</span>
                    </span>
                  </td>

                  <td class="text-right">
                    <div class="btn-group dropleft">
                      <button
                        type="button"
                        class="btn btn-neutral btn-sm dropdown-toggle"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                      >
                        {{ trans("Actions") }}
                      </button>
                      <div class="dropdown-menu">
                        <Link
                          class="dropdown-item"
                          :href="route('admin.prompt-model.edit', model.id)"
                          >{{ trans("Edit Model") }}</Link
                        >
                        <Link
                          v-if="model.has_submodel == 1"
                          class="dropdown-item"
                          :href="route('admin.prompt-model.show', model.id)"
                          >{{ trans("Sub Models Groups") }}</Link
                        >
                        <a
                          class="dropdown-item"
                          v-if="model.prompts_count == 0"
                          href="javascript:void(0)"
                          @click="
                            modal.initiate(
                              route('admin.prompt-model.destroy', model.id)
                            )
                          "
                          >{{ trans("Remove") }}</a
                        >
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
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
import { Head, Link } from "@inertiajs/vue3"
import sharedComposable from "@/composables/sharedComposable"
defineOptions({ layout: AdminLayout })
const { modal } = sharedComposable()
const props = defineProps(["models", "segments", "buttons","totalModels","totalGroupModels","totalSubModels"])
</script>
