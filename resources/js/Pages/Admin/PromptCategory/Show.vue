<template>
  <HeaderSegment
    title="Prompt Category Images"
    :segments="segments"
    :buttons="buttons"
  />
  <div class="container-fluid mt--6">
    <div class="row">
      <div class="col">
        <div class="card">
          <!-- Card header -->
          <div class="card-header border-0">
            <h3 class="mb-0">{{ trans("Prompt Category Images") }}</h3>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th class="col-10">{{ trans("Name") }}</th>

                  <th class="col-2 text-right">{{ trans("Action") }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="image in promptcategoryimages.data" :key="image.id">
                  <td class="text-left">
                    <img :src="image.url" class="avatar rounded-square mr-3" />
                    {{ textExcerpt(image.name, 30) }}
                  </td>

                  <td>
                    <div class="btn-group mb-2 float-right">
                      <button
                        @click="editImageForm = image"
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
                          data-toggle="modal"
                          data-target="#editModal"
                        >
                          <i class="fi fi-rs-edit"></i>{{ trans("Edit") }}</a
                        >
                        <a
                          class="dropdown-item has-icon delete-confirm"
                          href="javascript:void(0)"
                          @click="
                            modal.initiate(
                              route(
                                'admin.prompt-category-image.destroy',
                                image.id
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
            <template v-if="promptcategoryimages.data.length == 0">
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
              :links="promptcategoryimages.links"
              :currentPage="promptcategoryimages.current_page"
              :from="promptcategoryimages.from"
              :lastPage="promptcategoryimages.last_page"
              :lastPageUrl="promptcategoryimages.last_page_url"
              :nextpageurl="promptcategoryimages.next_page_url"
              :perPage="promptcategoryimages.per_page"
              :prevPageUrl="promptcategoryimages.prev_page_url"
              :to="promptcategoryimages.to"
              :total="promptcategoryimages.total"
            />
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
          @submit.prevent="createImage"
          class="ajaxform_instant_reload"
          enctype="multipart/form-data"
        >
          <div class="modal-header">
            <h3>{{ trans("Add Image") }}</h3>

            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ trans("Name") }}</label>
              <input
                v-model="form.name"
                type="text"
                maxlength="100"
                class="form-control"
                required
              />
            </div>

            <div class="form-group">
              <label>{{ trans("Image") }}</label>
              <input
                @input="(e) => (form.url = e.target.files[0])"
                type="file"
                accept="image/*"
                class="form-control"
                required
              />
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-neutral submit-button">
                {{ trans("Create") }}
              </button>
            </div>
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
          @submit.prevent="editImage"
          method="POST"
          class="ajaxform_instant_reload edit-modal"
          enctype="multipart/form-data"
        >
          <div class="modal-header">
            <h3>{{ trans("Edit Testimonial") }}</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ trans("Name") }}</label>
              <input
                v-model="editImageForm.name"
                type="text"
                name="reviewer_name"
                id="reviewer_name"
                maxlength="150"
                class="form-control"
                required
              />
            </div>

            <div class="form-group">
              <label>{{ trans("Reviewer Avatar") }}</label>
              <input
                @input="(e) => (editImageForm.url = e.target.files[0])"
                type="file"
                name="reviewer_avatar"
                accept="image/*"
                class="form-control"
              />
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-neutral submit-button">
                {{ trans("Update") }}
              </button>
            </div>
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
import sharedComposable from "@/composables/sharedComposable"
import { createToast } from "mosha-vue-toastify"
import Paginate from "@/Components/Paginate.vue"
import { ref } from "vue"
defineOptions({ layout: AdminLayout })

const { textExcerpt, modal } = sharedComposable()
const props = defineProps([
  "promptcategory",
  "buttons",
  "segments",
  "promptcategoryimages"
])
const form = useForm({
  category_image: true,
  name: "",
  url: "",
  promptcategory_id: props.promptcategory.id
})

const editImageForm = ref({})
const createImage = () => {
  form.post(route("admin.prompt-category-image.store"), {
    onSuccess: () => {
      form.reset()
      createToast({
        title: "Created",
        description: "Image Created successfully"
      })
    }
  })
}
const editImage = () => {
  if (!(editImageForm.value.url instanceof File)) {
    editImageForm.value.url = null
  }

  router.post(
    route("admin.prompt-category-image.update", editImageForm.value.id),
    {
      _method: "patch",
      categoryImage: editImageForm.value
    },
    {
      onSuccess: () => {
        createToast({
          title: "Updated",
          description: "Updated successfully"
        })
      }
    }
  )
}
</script>
