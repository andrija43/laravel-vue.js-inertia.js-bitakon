<template>
  <Head title="Prompt Model" />
  <HeaderSegment
    :title="trans('Prompt Models')"
    :segments="segments"
    :buttons="buttons"
  />
  <div class="container-fluid mt--6">
    <div class="row">
      <div class="col">
        <div class="card">
          <!-- Card header -->
          <div class="card-header border-0">
            <h3 class="mb-0">{{ trans("Sub Models") }}</h3>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th scope="col" class="sort col-6">{{ trans("Name") }}</th>
                 
                  <th scope="col" class="sort col-1 text-right">
                    {{ trans("Prompts") }}
                  </th>
                  <th scope="col" class="sort col-3 text-right">{{ trans("Status") }}</th>
                  <th scope="col" class="sort col-2 text-right">
                    {{ trans("Action") }}
                  </th>
                </tr>
              </thead>
              <tbody class="list">
                <tr v-for="model in models" :key="model.id">
                  <th scope="row">
                    <div class="media align-items-center">
                      <div class="media-body">
                        <span class="name mb-0 text-sm">{{ model.title }}</span>
                      </div>
                    </div>
                  </th>

                 
                  <td class="text-center">
                    {{ model.promptsrelation_count }}
                  </td>

                  <td class="text-right">
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
                          :href="
                            route('admin.prompt-sub-models.edit', model.id)
                          "
                          >{{ trans("Edit Model") }}</Link
                        >

                        <a
                          class="dropdown-item"
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
const props = defineProps(["models", "segments", "buttons"])
</script>
