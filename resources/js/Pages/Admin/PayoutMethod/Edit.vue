<template>
  <HeaderSegment
    title="Edit Payout Method"
    :segments="segments"
    :buttons="buttons"
  />
  <div class="container-fluid mt--6">
    <form
      @submit.prevent="updateMethod"
      class="ajaxform"
      enctype="multipart/form-data"
    >
      <div class="row justify-content-center">
        <div class="col-lg-9">
          <div class="card">
            <div class="card-body">
              <div class="form-group">
                <label>{{ trans("Method Name") }}</label>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Method Name"
                  v-model="payoutmethod.name"
                  required
                  name="name"
                />
              </div>
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="currency">{{
                      trans("Enter Currency Name")
                    }}</label>
                    <input
                      type="text"
                      class="form-control"
                      name="currency"
                      required
                      v-model="payoutmethod.currency_name"
                    />
                  </div>
                </div>
                <div class="transaction_fixed col-lg-6 col-md-6">
                  <div class="form-group">
                    <label>{{ trans("Delay (Processing Days)") }}</label>
                    <input
                      type="number"
                      class="form-control"
                      name="delay"
                      v-model="payoutmethod.delay"
                      :placeholder="trans('Delay')"
                    />
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <div class="form-group">
                    <label>{{ trans("Minimum Amount") }}</label>
                    <input
                      type="number"
                      class="form-control"
                      v-model="payoutmethod.min_limit"
                      placeholder="Minimum Amount"
                      required
                      name="min_limit"
                    />
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <div class="form-group">
                    <label>{{ trans("Maximum Amount") }}</label>
                    <input
                      type="number"
                      class="form-control"
                      v-model="payoutmethod.max_limit"
                      placeholder="Maximum Amount"
                      required
                      name="max_limit"
                    />
                  </div>
                </div>
              </div>
              <!--- Transaction Charge Fixed --->
              <div class="form-group">
                <label>{{ trans("Charge Type") }}</label>
                <select class="form-control" v-model="payoutmethod.charge_type">
                  <option value="" disabled>
                    {{ trans("Select charge type") }}
                  </option>
                  <option value="fixed">{{ trans("Fixed") }}</option>
                  <option value="percentage">{{ trans("Percentage") }}</option>
                </select>
              </div>
              <div class="form-row">
                <div
                  class="transaction_fixed col-sm-12"
                  v-if="payoutmethod.charge_type == 'fixed'"
                >
                  <div class="form-group">
                    <label>{{ trans("Fixed Amount") }}</label>
                    <input
                      type="number"
                      step="any"
                      class="form-control"
                      v-model="payoutmethod.fixed_charge"
                      name="fixed_charge"
                      :placeholder="trans('Fixed Amount')"
                    />
                  </div>
                </div>
                <!--- Transaction Charge percentage --->
                <div
                  class="transaction_percentage col-sm-12"
                  v-if="payoutmethod.charge_type == 'percentage'"
                >
                  <div class="form-group">
                    <label>{{ trans("Percentage Amount") }}</label>
                    <input
                      type="number"
                      step="any"
                      class="form-control"
                      v-model="payoutmethod.percent_charge"
                      name="percent_charge"
                      :placeholder="trans('Percentage Amount')"
                    />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-row">
                    <div class="col-lg-12 col-md-6 col-sm-12">
                      <div class="form-group">
                        <label>{{ trans("Method Logo") }}</label>
                        <input
                          type="file"
                          class="form-control"
                          name="image"
                          @input="
                            (e) => (payoutmethod.image = e.target.files[0])
                          "
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-row">
                <div class="col-lg-12 col-md-6 col-sm-12">
                  <div class="form-group">
                    <label>{{ trans("Instruction") }}</label>
                    <cke
                      tag-name="textarea"
                      :editor="ClassicEditor"
                      v-model="payoutmethod.instruction"
                    />
                  </div>
                </div>
              </div>

              <div class="form-group field_wrapper">
                <div class="row">
                  <div class="col-md-5">
                    <label for="">{{ trans("Label") }}</label> <br />
                  </div>
                  <div class="col-md-6">
                    <label for="">{{ trans("Input Type") }}</label>
                    <br />
                  </div>
                  <div class="col-md-1">
                    <button
                      type="button"
                      @click="newFields"
                      class="add_button text-xxs mr-2 btn btn-primary mb-0 btn-sm text-xxs"
                    >
                      <i class="fas fa-plus-circle"></i>
                    </button>
                  </div>
                </div>

                <template v-for="(input, i) in inputs" :key="i">
                  <div class="row">
                    <div class="col-md-5">
                      <br />
                      <input
                        type="text"
                        data-key="0"
                        class="form-control"
                        placeholder="Label here"
                        v-model="input.label"
                      />
                    </div>
                    <div class="col-md-6">
                      <br />
                      <select v-model="input.type" class="form-control">
                        <option :selected="input.type == 'text'" value="text">
                          {{ trans("Text") }}
                        </option>
                        <option
                          :selected="input.type == 'number'"
                          value="number"
                        >
                          {{ trans("Number") }}
                        </option>
                        <option
                          :selected="input.type == 'textarea'"
                          value="textarea"
                        >
                          {{ trans("Textarea") }}
                        </option>
                        <option :selected="input.type == 'email'" value="email">
                          {{ trans("Email") }}
                        </option>
                      </select>
                    </div>
                    <div class="col-md-1">
                      <button
                        type="button"
                        @click="deleteFields(i)"
                        class="remove_button text-xxs mr-2 btn btn-danger mb-0 btn-sm text-xxs mt-4"
                        title="Remove"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="16"
                          height="16"
                          fill="currentColor"
                          class="bi bi-x-circle"
                          viewBox="0 0 16 16"
                        >
                          <path
                            d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"
                          />
                          <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
                          />
                        </svg>
                      </button>
                    </div>
                  </div>
                </template>
              </div>
              <div class="form-group">
                <label>{{ trans("Status") }}</label>
                <select
                  name="status"
                  class="form-control"
                  v-model="payoutmethod.status"
                >
                  <option :selected="payoutmethod.status == 1" value="1">
                    {{ trans("Active") }}
                  </option>
                  <option :selected="payoutmethod.status == 0" value="0">
                    {{ trans("Inactive") }}
                  </option>
                </select>
              </div>
              <div class="btn-publish">
                <button type="submit" class="btn btn-neutral submit-button">
                  <i class="fa fa-save"></i> {{ trans("Update") }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script setup>
"use strict";
import AdminLayout from "@/Pages/Admin/Layout/App.vue"
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue"
import { router } from "@inertiajs/vue3"
import CKEditor from "@ckeditor/ckeditor5-vue"
import ClassicEditor from "@ckeditor/ckeditor5-build-classic"
import { createToast } from "mosha-vue-toastify"
import { ref, onMounted } from "vue"
defineOptions({ layout: AdminLayout })
const cke = CKEditor.component

const props = defineProps(["segments", "buttons", "payoutmethod"])
ClassicEditor.defaultConfig = {
  toolbar: {
    items: [
      "heading",
      "|",
      "bold",
      "italic",
      "|",
      "link",
      "bulletedList",
      "numberedList",
      "|",
      "insertTable",
      "|",
      "mediaEmbed",
      "|",
      "undo",
      "redo"
    ]
  },
  table: {
    contentToolbar: ["tableColumn", "tableRow", "mergeTableCells"]
  },
  language: "en"
}
const inputs = ref([])
onMounted(() => {
  inputs.value = JSON.parse(props.payoutmethod.data)
})

const newFields = () => {
  if (inputs.value.length >= 10) {
    createToast({
      title: "10 Max",
      description: "Limit Reached"
    })
    return
  }
  const fields = {
    type: "",
    label: ""
  }
  inputs.value.push(fields)
}

const deleteFields = (targetIndex) => {
  if (inputs.value.length <= 1) {
    createToast({
      title: "1 Min",
      description: "Limit Reached"
    })
    return
  }
  inputs.value = inputs.value.filter((_, index) => index !== targetIndex)
}
const updateMethod = () => {
  if (!(props.payoutmethod.image instanceof File)) {
    props.payoutmethod.image = null
  }
  props.payoutmethod.data = inputs.value
  router.post(
    route("admin.payout-methods.update", props.payoutmethod.id),
    {
      _method: "PATCH",
      payoutmethod: props.payoutmethod
    },
    {
      onSuccess: () => {
        createToast({
          title: "Updated",
          description: "Method Updated successfully"
        })
      }
    }
  )
}
</script>
