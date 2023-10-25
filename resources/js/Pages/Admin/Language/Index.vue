<template>
  <HeaderSegment
    title="Create a language"
    :segments="segments"
    :buttons="buttons"
  />
  <div class="container-fluid mt--6">
    <div class="row">
      <div class="col">
        <div class="card">
          <!-- Card header -->
          <div class="card-header border-0">
            <h3 class="mb-0">{{ trans("Languages") }}</h3>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th class="col-2">{{ trans("Language Name") }}</th>
                  <th class="col-2">{{ trans("Language Key") }}</th>
                  <th class="col-8 text-right">{{ trans("Action") }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(language, key) in languages" :key="key">
                  <td class="text-left">
                    {{ language }}
                  </td>
                  <td class="text-left">
                    {{ key }}
                  </td>
                  <td class="text-right">
                    <Link
                      :href="route('admin.language.show', key)"
                      class="btn btn-neutral btn-sm"
                      ><i class="fas fa-edit"></i>
                    </Link>
                    <a
                      href="javascript:void(0)"
                      class="delete-confirm btn btn-sm btn-neutral"
                      @click="
                        modal.initiate(route('admin.language.destroy', key))
                      "
                      ><i class="fas fa-trash"></i
                    ></a>
                  </td>
                </tr>
              </tbody>
            </table>
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
          @submit.prevent="createLanguage"
          class="ajaxform_reset_form"
        >
          <div class="modal-header">
            <h3>{{ trans("Create Language") }}</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ trans("Language Name") }}</label>
              <input
                v-model="form.name"
                type="text"
                name="name"
                class="form-control"
                required
                placeholder="English"
              />
            </div>
            <div class="form-group">
              <label>{{ trans("Select Language") }}</label>
              <select
                v-model="form.language_code"
                class="form-control"
                name="language_code"
              >
                <option
                  v-for="country in countries"
                  :key="country"
                  :value="country.code"
                >
                  {{ country.name }}
                </option>
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
</template>

<script setup>
"use strict";
import AdminLayout from "@/Pages/Admin/Layout/App.vue"
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue"
import { Link, useForm } from "@inertiajs/vue3"
import sharedComposable from "@/composables/sharedComposable"
import { createToast } from "mosha-vue-toastify"
defineOptions({ layout: AdminLayout })

const { modal } = sharedComposable()
const props = defineProps(["languages", "countries", "buttons", "segments"])
const form = useForm({
  name: "",
  language_code: ""
})
const createLanguage = () => {
  form.post(route("admin.language.store"), {
    onSuccess: () => {
      form.reset()
      createToast(
        {
          title: "Created",
          description: "Language Created successfully"
        },
        {
          transition: "slide",
          position: "top-right"
        }
      )
    }
  })
}
</script>
