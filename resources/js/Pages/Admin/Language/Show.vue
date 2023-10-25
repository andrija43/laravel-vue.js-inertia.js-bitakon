<template>
  <HeaderSegment
    title="Edit Language"
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
          <form class="ajaxform" @submit.prevent="updateLanguage" method="post">
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th class="col-6">{{ trans("Translation Key") }}</th>
                    <th class="col-6">{{ trans("Translated Value") }}</th>
                  </tr>
                </thead>

                <tbody>
                  <tr v-for="(value, key) in posts" :key="key">
                    <td>
                      {{ key }}
                    </td>
                    <td>
                      <input
                        type="text"
                        class="form-control"
                        v-model="posts[key]"
                      />
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="card-footer">
              <button
                type="submit"
                class="btn btn-outline-primary submit-button float-right mb-3"
              >
                {{ trans("Update Changes") }}
              </button>
            </div>
          </form>
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
        <form method="POST" @submit.prevent="createKey" >
          <div class="modal-header">
            <h3>{{ trans("Add Key") }}</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ trans("Key") }}</label>
              <input
                type="text"
                name="key"
                v-model="form.key"
                class="form-control"
                required
              />
            </div>
            <div class="form-group">
              <label>{{ trans("Value") }}</label>
              <input
                type="text"
                name="value"
                v-model="form.value"
                class="form-control"
                required
              />
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
import AdminLayout from "@/Pages/Admin/Layout/App.vue";
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue";
import { useForm, router } from "@inertiajs/vue3";
import { createToast } from "mosha-vue-toastify";
defineOptions({layout: AdminLayout})

const props = defineProps([
    'posts' ,
    'id' ,
    'buttons' ,
    'segments' ,
]);
const form = useForm({
 key:'',
 value: '',
 id: props.id
})
const createKey = () => {
    form.post('/admin/language/addkey',{
    onSuccess: () => {
        form.reset()
        createToast(
        {
            title: "Created",
            description: "Language Created successfully",
        },
        {
            transition: "slide",
            position: "top-right",
        }
      )
    }
    })
}
const updateLanguage = () => {
router.patch(route('admin.language.update',props.id), {
    values: props.posts
},{
    onSuccess: () => {
        form.reset()
        createToast(
        {
            title: "Created",
            description: "Language Created successfully",
        },
        {
            transition: "slide",
            position: "top-right",
        }
      )
    }
})
}
</script>
