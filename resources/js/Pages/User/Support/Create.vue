<template>
  <HeaderSegment
    title="Create Support Ticket"
    :segments="segments"
    :buttons="buttons"
  />
  <div class="container-fluid mt--6">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>{{ trans("Create Ticket") }}</h4>
          </div>
          <div class="card-body">
            <form
              @submit.prevent="createTicket"
              method="POST"
              class="ajaxform_instant_reload"
            >
              <div class="form-group row mb-4">
                <label
                  class="col-form-label text-md-right col-12 col-md-3 col-lg-3"
                  >{{ trans("Subject") }}</label
                >
                <div class="col-sm-12 col-md-7">
                  <input
                    v-model="form.subject"
                    type="text"
                    name="subject"
                    maxlength="100"
                    required
                    class="form-control"
                  />
                </div>
              </div>
              <div class="form-group row mb-4">
                <label
                  class="col-form-label text-md-right col-12 col-md-3 col-lg-3"
                  >{{ trans("Message") }}</label
                >
                <div class="col-sm-12 col-md-7">
                  <textarea
                    v-model="form.message"
                    class="form-control h-200"
                    name="message"
                    required
                    maxlength="1000"
                  ></textarea>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label
                  class="col-form-label text-md-right col-12 col-md-3 col-lg-3"
                ></label>
                <div class="col-sm-12 col-md-7">
                  <button
                    type="submit"
                    class="btn btn-outline-primary submit-btn"
                  >
                    {{ trans("Create Now") }}
                  </button>
                </div>
                <ValidationErrors />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
"use strict";
import AdminLayout from "@/Pages/User/Layout/App.vue";
import HeaderSegment from "@/Pages/User/Layout/HeaderSegment.vue";
import ValidationErrors from '@/components/ValidationErrors.vue';
import { useForm } from '@inertiajs/vue3';
import { createToast } from "mosha-vue-toastify";

defineOptions({layout: AdminLayout})

const props = defineProps([
'buttons' ,
'segments' ,
]);
const form = useForm({
  subject:'',
  message:''
})
const createTicket = () => {
  form.post(route('user.support.store'),{
    onSuccess: () => {
        form.reset()
        createToast(
        {
            title: "Replied",
            description: "Replied Successfully",
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