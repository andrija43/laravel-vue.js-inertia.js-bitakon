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
                  {{ trans("Subject :") }} {{ support.subject ?? "" }}
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
                        {{ moment(reply.created_at).format("d M, Y - h:i A") }}
                        {{
                          reply.is_admin == 1 && reply.seen == 1 ? "Seen" : ""
                        }}
                      </small>
                      <h5 class="mt-3 mb-0">{{ reply.comment }}</h5>
                      <br />
                      <b class="text-sm tt-5">{{
                        reply.is_admin == 1 ? "You" : support.user?.name
                      }}</b>
                    </div>
                  </div>
                </template>
              </div>
            </div>
          </div>

          <div class="card shadow">
            <div class="card-body">
              <form @submit.prevent="updateSupport">
                <div class="form-group">
                  <label>{{ trans("Reply") }}</label>
                  <textarea
                    v-model="message"
                    class="form-control h-200"
                    required
                    name="message"
                    maxlength="1000"
                  ></textarea>
                </div>
                <div class="form-group">
                  <label>{{ trans("Support Status") }}</label>
                  <select
                    class="form-control"
                    name="status"
                    v-model="support.status"
                  >
                    <option value="1" :selected="support.status == 1">
                      {{ trans("Open") }}
                    </option>
                    <option value="2" :selected="support.status == 2">
                      {{ trans("Pending") }}
                    </option>
                    <option value="0" :selected="support.status == 0">
                      {{ trans("Closed") }}
                    </option>
                  </select>
                </div>
                <button type="submit" class="btn btn-neutral">
                  {{ trans("Reply") }}
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>



<script setup>
"use strict";
import AdminLayout from "@/Pages/Admin/Layout/App.vue";
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue";
import { router } from "@inertiajs/vue3";
import { trans } from "laravel-vue-i18n";
import moment from 'moment';
import { createToast } from "mosha-vue-toastify";

import { ref } from 'vue';
defineOptions({layout: AdminLayout})

const props = defineProps([
    "segments",
    "buttons",
    "support"
]);
const message = ref('')
const updateSupport = () => {
    router.patch(`/admin/support/${props.support.id}`, {
      status: props.support.status,
      message: message.value
    },
    {
      onSuccess: () => {
        message.value = ''
        createToast(
        {
            title: "Update",
            description: "Support updated successfully",
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
