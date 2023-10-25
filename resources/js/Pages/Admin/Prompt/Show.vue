<template>
  <HeaderSegment
    :title="prompt.title"
    :segments="segments"
    :buttons="buttons"
  />
  <div class="container-fluid mt--6">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="invoice-title">
                  <span
                    :class="
                      prompt.status === 0
                        ? 'float-right badge badge-warning'
                        : prompt.status == 1
                        ? 'float-right badge badge-success'
                        : 'float-right badge badge-danger'
                    "
                  >
                    {{
                      prompt.status === 0
                        ? trans("Disabled")
                        : prompt.status === 1
                        ? trans("Active")
                        : prompt.status === 2
                        ? trans("Pending")
                        : ""
                    }}
                  </span>
                  <h2>{{ trans("Title") }} : {{ prompt.title }}</h2>
                  <h4>
                    {{ trans("Price") }} : {{ formatCurrency(prompt.price) }}
                  </h4>
                  <div class="invoice-number">
                    {{ trans("Id") }} : {{ prompt.id }}
                  </div>
                  <div class="invoice-number">
                    {{ trans("Date") }} :
                    {{ moment(prompt.created_at).format("DD MMM, YYYY") }}
                  </div>
                </div>

                <hr />
                <div class="row">
                  <div class="col-md-6">
                    <address>
                      <strong>{{ trans("User Details") }}</strong
                      ><br />
                      {{ trans("Name") }}: {{ prompt.user.name }}<br />
                      {{ trans("Address") }}: {{ prompt.user.address }}<br />
                      {{ trans("Email") }}: {{ prompt.user.email }}<br />
                      {{ trans("Phone") }}: {{ prompt.user?.phone || "None"
                      }}<br />
                    </address>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    <h3>{{ trans("Prompt Details") }}</h3>

                    <div v-html="JSON.parse(prompt.meta).description"></div>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-8">
                    <h3>{{ trans("Prompt Instructions") }}</h3>

                    <template
                      v-for="(file, key, i) in JSON.parse(promptFiles.files)"
                      :key="i"
                    >
                      <strong class="text-capitalize">{{ key }} :</strong>
                      <p class="base-text mb-1">{{ file }}</p>
                    </template>
                  </div>
                </div>

                <div class="row mt-4">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-md">
                        <tbody>
                          <tr>
                            <td class="col-9 font-weight-bold">
                              {{ trans("Category Name") }}
                            </td>
                            <td class="col-3 text-right">
                              {{ trans("Preview") }}
                            </td>
                          </tr>
                          <tr>
                            <td>{{ promptCategory.name }}</td>
                            <td class="text-right">
                              <img
                                v-if="promptCategory.preview"
                                class="w-50 rounded"
                                :src="promptCategory.preview"
                                alt="preview"
                              />
                              <span v-else>None</span>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="row mt-4">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-md">
                        <tbody>
                          <tr>
                            <td class="col-9 font-weight-bold">
                              {{ trans("Model Name") }}
                            </td>
                            <td class="col-3 text-right">
                              {{ trans("Preview") }}
                            </td>
                          </tr>
                          <tr>
                            <td>{{ promptmodel.title }}</td>
                            <td class="text-right">
                              <img
                                v-if="promptmodel.preview"
                                class="w-50 rounded"
                                :src="promptmodel.preview"
                                alt="preview"
                              />
                              <span v-else>None</span>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="row mt-4" v-if="promptGroups.length > 1">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-md">
                        <tbody>
                          <tr>
                            <td class="col-12 font-weight-bold">
                              {{ trans("Submodel Name") }}
                            </td>
                           
                          </tr>
                          <tr v-for="group in promptGroups" :key="group.id">
                            <td>
                              {{ group.title }} |
                              {{
                                group.submodels.find((sub) =>
                                  promptModelRelation.includes(sub.id)
                                )?.title || group.submodels[0].title
                              }}
                            </td>
                           
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="row mt-4">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-md">
                        <tbody>
                          <tr>
                            <td class="col-9 font-weight-bold">
                              {{ trans("Prompt Preview") }}
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <img
                                class="w-25 rounded"
                                height="150"
                                :src="
                                  prompt.preview ||
                                  JSON.parse(prompt.meta).preview
                                "
                                alt="preview"
                              />
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="row mt-4" v-if="props.prompt.gallery">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-md">
                        <tbody>
                          <tr>
                            <td class="col-9 font-weight-bold">
                              {{ trans("Prompt Images") }}
                            </td>
                          </tr>
                          <tr>
                            <td class="d-flex flex-wrap">
                              <img
                                v-for="image in promptImages"
                                :key="image"
                                class="col-2 rounded"
                                :src="image"
                                alt="preview"
                              />
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
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
import moment from "moment"
import { computed } from "vue"
const props = defineProps([
  "prompt",
  "promptmodel",
  "promptGroups",
  "promptCategory",
  "promptFiles",
  "promptcategoryimages",
  "promptModelRelation",
  "buttons",
  "segments"
])
defineOptions({ layout: AdminLayout })
const { formatCurrency } = sharedComposable()

const promptImages = computed(() => {
  if (props.prompt.gallery) {
    return JSON.parse(props.prompt.gallery)
  }
})
</script>
