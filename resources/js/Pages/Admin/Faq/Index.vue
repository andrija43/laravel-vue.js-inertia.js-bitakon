<template>
  <Head title="Faq" />
  <HeaderSegment
    :title="trans('Frequently asked questions')"
    :segments="segments"
    :buttons="buttons"
  />
  <div class="container-fluid mt--6">
    <div class="row">
      <div class="col">
        <div class="card">
          <!-- Card header -->
          <div class="card-header border-0">
            <h3 class="mb-0">{{ trans("FAQS") }}</h3>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th class="col-3">{{ trans("Question") }}</th>
                  <th class="col-6">{{ trans("Answer") }}</th>
                  <th class="col-1 text-right">{{ trans("Language") }}</th>
                  <th class="col-1 text-right">{{ trans("Action") }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="faq in faqs.data" :key="faq.id">
                  <td class="text-left">
                    {{ textExcerpt(faq.title, 20) }}
                  </td>
                  <td class="text-left">
                    {{ textExcerpt(faq.excerpt ? faq.excerpt.value : '', 70) }}
                  </td>
                  <td class="text-right">
                    {{ faq.lang }}
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
                        <a
                          class="dropdown-item has-icon edit-row"
                          href="#"
                          @click="faqOpenModal(faq)"
                          data-toggle="modal"
                          data-target="#editModal"
                        >
                          <i class="fi fi-rs-edit"></i>{{ trans("Edit") }}</a
                        >
                        <a
                          class="dropdown-item has-icon delete-confirm"
                          href="javascript:void(0)"
                          @click="
                            modal.initiate(route('admin.faq.destroy', faq.id))
                          "
                          ><i class="fas fa-trash"></i
                          >{{ trans("Remove faq") }}</a
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
              :links="faqs.links"
              :currentPage="faqs.current_page"
              :from="faqs.from"
              :lastPage="faqs.last_page"
              :lastPageUrl="faqs.last_page_url"
              :nextpageurl="faqs.next_page_url"
              :perPage="faqs.per_page"
              :prevPageUrl="faqs.prev_page_url"
              :to="faqs.to"
              :total="faqs.total"
            />
          </div>
        </div>
      </div>
    </div>
  </div>

  <div
    class="modal fade"
    id="addRecord"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <form @submit.prevent="createFrom.post(route('admin.faq.store'))">
          <div class="modal-header">
            <h3>{{ trans("Create FAQ") }}</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ trans("Question") }}</label>
              <input
                type="text"
                v-model="createFrom.question"
                maxlength="150"
                class="form-control"
                required=""
              />
            </div>
            <div class="form-group">
              <label>{{ trans("Answer") }}</label>
              <textarea
                class="form-control h-100"
                maxlength="500"
                v-model="createFrom.answer"
                required=""
              ></textarea>
            </div>

            <div class="form-group">
              <label>{{ trans("Select position") }}</label>
              <select
                class="form-control"
                name="position"
                v-model="createFrom.position"
                required=""
              >
                <option value="bottom">{{ trans("Regular") }}</option>
              </select>
            </div>
            <div class="form-group">
              <label>{{ trans("Select Language") }}</label>
              <select
                class="form-control"
                name="language"
                required=""
                v-model="createFrom.language"
              >
                <option
                  v-for="(language, languageKey) in languages"
                  :key="language.key"
                  :value="languageKey"
                >
                  {{ language }}
                </option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button
              :disabled="createFrom.processing"
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
        <form @submit.prevent="updateFaq">
          <div class="modal-header">
            <h3>{{ trans("Edit FAQ") }}</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ trans("Question") }}</label>
              <input
                type="text"
                name="question"
                v-model="editForm.question"
                maxlength="150"
                class="form-control"
                id="question"
                required=""
              />
            </div>
            <div class="form-group">
              <label>{{ trans("Answer") }}</label>
              <textarea
                class="form-control h-100"
                v-model="editForm.answer"
                maxlength="500"
                name="answer"
                required=""
                id="answer"
              ></textarea>
            </div>

            <div class="form-group">
              <label>{{ trans("Select position") }}</label>
              <select
                class="form-control"
                name="position"
                v-model="editForm.position"
                id="position"
                required=""
              >
               
                <option value="bottom">{{ trans("Bottom") }}</option>
              </select>
            </div>
            <div class="form-group">
              <label>{{ trans("Select Language") }}</label>
              <select
                class="form-control"
                name="language"
                required=""
                v-model="editForm.language"
              >
                <option
                  v-for="(language, languageKey) in languages"
                  :key="language.key"
                  :value="languageKey"
                >
                  {{ language }}
                </option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button
              :disabled="editForm.processing"
              type="submit"
              class="btn btn-outline-primary col-12 submit-button"
            >
              {{ trans("Update") }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
"use strict";
import AdminLayout from "@/Pages/Admin/Layout/App.vue"
export default {
  layout: AdminLayout
}
</script>

<script setup>
"use strict";
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue"
import { Head, useForm, router } from "@inertiajs/vue3"
import { trans } from "laravel-vue-i18n"
import Paginate from "@/Components/Paginate.vue"
import sharedComposable from "@/composables/sharedComposable"
import { createToast } from "mosha-vue-toastify"

const props = defineProps([
  "segments",
  "buttons",
  "faqs",
  "languages",
  "useForm"
])

const { textExcerpt, modal } = sharedComposable()

const createFrom = useForm({
  question: null,
  answer: null,
  position: "bottom",
  language: null
})

const editForm = useForm({
  question: null,
  answer: null,
  position: "bottom",
  language: null,
  id: null
})

function faqOpenModal(faq) {
  editForm.question = faq.title
  editForm.answer = faq.excerpt.value
  editForm.position = faq.slug
  editForm.language = faq.lang
  editForm.id = faq.id
}

const updateFaq = () => {
  router.patch(route("admin.faq.update", editForm.id), editForm, {
    onSuccess: () => {
      createToast(
        {
          title: "Congratulations",
          description: "Faq updated successfully"
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
