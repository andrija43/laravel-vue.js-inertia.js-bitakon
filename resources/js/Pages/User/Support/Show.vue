<template>
  <HeaderSegment title="Support" :segments="segments" :buttons="buttons" />
  <div class="container-fluid mt--6">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12">
          <div class="card shadow">
            <div class="card-header">
              <div class="row">
                <h3 class="mb-0 font-weight-bolder">
                  {{ trans("Subject :") }} {{ support.subject }}
                </h3>
              </div>
            </div>
            <div class="card-body">
              <div
                class="timeline timeline-one-side"
                data-timeline-content="axis"
                data-timeline-axis-style="dashed"
              >
                <template
                  v-for="reply in support.conversations"
                  :key="reply.id"
                >
                  <div class="timeline-block">
                    <span class="timeline-step badge-primary">
                      <i
                        :class="
                          reply.is_admin == 0
                            ? 'fi fi-rs-paper-plane'
                            : 'fi  fi-rs-headset'
                        "
                      ></i>
                    </span>
                    <div class="timeline-content">
                      <small class="text-xs">
                        {{ moment(reply.created_at).format("D M, Y - h:i A") }}
                        {{
                          reply.is_admin == 0 && reply.seen == 1 ? "(Seen)" : ""
                        }}
                      </small>
                      <h5 class="mt-3 mb-0">{{ reply.comment }}</h5>
                      <br />
                      <b class="text-sm tt-5">{{
                        reply.is_admin == 0 ? "You" : "Support Agent"
                      }}</b>
                    </div>
                  </div>
                </template>
              </div>
            </div>
          </div>

          <template v-if="support.status == 1">
            <div class="card shadow">
              <div class="card-body">
                <form
                  method="POST"
                  class="ajaxform_instant_reload"
                  @submit.prevent="updateTicket"
                >
                  <div class="form-group">
                    <label>{{ trans("Reply") }}</label>
                    <textarea
                      v-model="form.message"
                      class="form-control h-200"
                      required
                      name="message"
                      maxlength="1000"
                    ></textarea>
                  </div>
                  <button
                    class="btn btn-outline-primary submit-btn"
                    type="submit"
                    :disabled="support.status != 1"
                  >
                    {{ trans("Submit") }}
                  </button>
                </form>
              </div>
              <ValidationErrors />
            </div>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
"use strict";

import AdminLayout from "@/Pages/User/Layout/App.vue";
import ValidationErrors from '@/components/ValidationErrors.vue';
import HeaderSegment from "@/Pages/User/Layout/HeaderSegment.vue";
import { createToast } from "mosha-vue-toastify";
import { useForm } from '@inertiajs/vue3';
import moment from 'moment';
defineOptions({layout: AdminLayout})

const props = defineProps([
  'support' ,
  'buttons' ,
  'segments' ,
]);
const form = useForm({
	message: ''
})
const updateTicket = () => {
form.patch(route('user.support.update', props.support.id),{
	onSuccess: () => {
        form.reset()
        createToast(
        {
            title: "Created",
            description: "Ticket Generated Successfully",
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
