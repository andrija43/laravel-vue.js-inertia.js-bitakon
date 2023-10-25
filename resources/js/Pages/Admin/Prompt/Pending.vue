<template>
  <HeaderSegment
     title="Pending Prompts"
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
                             {{ totalPrompts }}
                             </span>
                          </div>
                          <div class="col-auto">
                             <div
                                class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                                >
                                <i class="fi-rs-boxes mt-2"></i>
                             </div>
                          </div>
                       </div>
                       <p class="mt-3 mb-0 text-sm"></p>
                       <h5 class="card-title text-muted mb-0">
                          {{ trans("Total Prompts") }}
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
                             {{ todayPrompts }}
                             </span>
                          </div>
                          <div class="col-auto">
                             <div
                                class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                                >
                                <i class="fi-rs-calendar-arrow-down mt-2"></i>
                             </div>
                          </div>
                       </div>
                       <p class="mt-3 mb-0 text-sm"></p>
                       <h5 class="card-title text-muted mb-0">
                          {{ trans("Today's Requests") }}
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
                             {{ lastWeekPrompts }}
                             </span>
                          </div>
                          <div class="col-auto">
                             <div
                                class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                                >
                                <i class="fi-rs-calendar-clock mt-2"></i>
                             </div>
                          </div>
                       </div>
                       <p class="mt-3 mb-0 text-sm"></p>
                       <h5 class="card-title text-muted mb-0">
                          {{ trans("Requested 7 Days Ago") }}
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
                 <h3 class="mb-0">{{ trans("Pending Prompts") }}</h3>
                 <form
                    class="card-header-form"
                    method="GET"
                    @submit.prevent="filterData.get('/admin/prompt/pending')"
                    >
                    <div class="input-group">
                       <input
                          type="text"
                          name="search"
                          v-model="filterData.search"
                          class="form-control"
                          placeholder="Search......"
                          />
                       <select
                          class="form-control"
                          name="type"
                          v-model="filterData.type"
                          >
                          <option value="title">
                             {{ trans("Title") }}
                          </option>
                          <option value="email">
                             {{ trans("User Email") }}
                          </option>
                          <option value="name">
                             {{ trans("User Name") }}
                          </option>
                       </select>
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
                         
                          <th class="col-8">{{ trans("Title") }}</th>
                        
                          <th class="col-1 text-right">
                             {{ trans("Author") }}
                          </th>
                          <th class="col-2 text-right">
                             {{ trans("Created At") }}
                          </th>
                          <th class="col-2 text-right">
                             {{ trans("Action") }}
                          </th>
                       </tr>
                    </thead>
                    <tbody>
                       <tr v-for="prompt in prompts.data" :key="prompt.id">
                          <td class="text-left">
                             <Link
                                :href="route('admin.prompt.show', prompt.id)"
                                >
                             <img
                                :src="
                                prompt.preview
                                ? prompt.preview
                                : JSON.parse(prompt.meta).preview
                                "
                                class="avatar rounded-square mr-3"
                                />
                                {{ textExcerpt(prompt.title, 50) }}
                             </Link>
                          </td>
                         
                         
                          <td class="text-left">
                             <Link
                                :href="route('admin.customer.show', prompt.user_id)"
                                >
                             {{ textExcerpt(prompt.user.name, 50) }}
                             </Link>
                          </td>
                          <td class="text-right">
                            {{ moment(prompt.created_at).format("DD MMM YYYY") }}
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
                                <div class="dropdown-menu" @click="editForm = prompt">
                                   <Link
                                      class="dropdown-item has-icon delete-confirm"
                                      :href="route('admin.prompt.show', prompt.id)"
                                      >
                                   <i class="fas fa-eye"></i>{{ trans("View") }}
                                   </Link>
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
                                      route('admin.prompt.destroy', prompt.id)
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
                 <template v-if="prompts.data.length == 0">
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
                 <Paginate :links="prompts.links" />
              </div>
           </div>
        </div>
     </div>
  </div>
  <!-- modal -->
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
              @submit.prevent="update"
              method="POST"
              class="ajaxform_instant_reload edit-modal"
              enctype="multipart/form-data"
              >
              <div class="modal-header">
                 <h3>{{ trans("Edit Status") }}</h3>
              </div>
              <div class="modal-body">
                 <div class="form-group">
                    <label>{{ trans("Status") }}</label>
                    <select v-model="editForm.status" class="form-control">
                       <option value="0">{{ trans("Disabled") }}</option>
                       <option value="1">{{ trans("Active") }}</option>
                       <option value="2">{{ trans("Pending") }}</option>
                    </select>
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
  import sharedComposable from "@/composables/sharedComposable"
  import Paginate from "@/Components/Paginate.vue";
  import moment from 'moment';
  import { router, useForm } from "@inertiajs/vue3"
  import { ref } from "vue"
  defineOptions({ layout: AdminLayout })
  const editForm = ref({})
  const { textExcerpt, modal, ToastAlert } = sharedComposable()
  const props = defineProps([
    "prompts",
    "buttons",
    "segments",
    "totalPrompts",
    "lastWeekPrompts",
    "todayPrompts",
    "type",
    "request"
  ])
  const filterData = useForm({
    search: props.request.search,
    type: props.type
  })
  
  const update = () => {
    router.patch(
      route("admin.prompt.update", editForm.value.id),
      editForm.value,
      {
        onSuccess: () => {
          ToastAlert("Updated", "Updated successfully")
        }
      }
    )
  }
</script>