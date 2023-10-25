<template>
  <HeaderSegment
    :title="trans('Menu')"
    :segments="segments"
    :buttons="buttons"
  />
  <div class="container-fluid mt--6">
    <div class="row">
      <div class="col-lg-8">
        <div class="card mb-3">
          <div class="card-body">
            <div class="row mb-10">
              <div class="col-sm-10">
                <h4>{{ trans("Menu Items") }}</h4>
              </div>
              <div class="col-sm-2">
                <button
                  type="button"
                  id="form-button"
                  class="btn btn-neutral submit-button float-right"
                  @click.prevent="updateData"
                >
                  {{ trans("Save") }}
                </button>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <template v-if="props.contents">
                  <NestedDraggable :tasks="menu.contents" />
                </template>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h4 class="mb-5">{{ trans("Create Menu Items") }}</h4>
            <div class="row">
              <div class="col-lg-12">
                <div class="alert alert-danger none">
                  <ul id="errors"></ul>
                </div>
                <form id="frmEdit" class="ajaxform">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="text">{{ trans("Text") }}</label>
                      <div class="input-group">
                        <input
                          type="text"
                          class="form-control item-menu"
                          name="text"
                          id="text"
                          placeholder="Text"
                          autocomplete="off"
                          v-model="menu.newItem.text"
                        />
                        <div class="input-group-append">
                          <button
                            type="button"
                            id="myEditor_icon"
                            class="btn btn-neutral btn-sm"
                          ></button>
                        </div>
                      </div>
                      <input type="hidden" name="icon" class="item-menu" />
                    </div>
                    <div class="form-group">
                      <label for="href">{{ trans("URL") }}</label>
                      <input
                        type="text"
                        class="form-control item-menu"
                        id="href"
                        name="href"
                        placeholder="URL"
                        required
                        autocomplete="off"
                        v-model="menu.newItem.href"
                      />
                    </div>
                    <div class="form-group">
                      <label for="target">{{ trans("Target") }}</label>
                      <select
                        name="target"
                        id="target"
                        class="form-control mr-sm-2 item-menu"
                        v-model="menu.newItem.target"
                      >
                        <option value="_self">
                          {{ trans("Self") }}
                        </option>
                        <option value="_blank">
                          {{ trans("Blank") }}
                        </option>
                        <option value="_top">
                          {{ trans("Top") }}
                        </option>
                      </select>
                    </div>
                    <div class="form-group none">
                      <label for="title">{{ trans("Tooltip") }}</label>
                      <input
                        type="text"
                        name="title"
                        class="form-control item-menu"
                        id="title"
                        placeholder="Tooltip"
                        v-model="menu.newItem.title"
                      />
                    </div>
                  </div>
                </form>
                <div class="menu-add-update d-flex">
                  <button
                    type="button"
                    id="btnUpdate"
                    class="btn btn-update btn-warning text-white col-6 mr-2"
                    @click.prevent="menu.updateItem"
                    :disabled="!menu.isEdit"
                  >
                    <i class="fas fa-sync-alt"></i>
                    {{ trans("Update") }}
                  </button>
                  <button
                    type="button"
                    id="btnAdd"
                    @click.prevent="menu.addNewItem"
                    class="btn btn-neutral col-6"
                    :disabled="menu.isEdit"
                  >
                    <i class="fas fa-plus"></i>
                    {{ trans("Add") }}
                  </button>
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
import AdminLayout from "@/Pages/Admin/Layout/App.vue";
import NestedDraggable from "@/components/NestedDraggable.vue";
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue";
import { onMounted } from "vue";
import axios from "axios";
defineOptions({ layout: AdminLayout });
const props = defineProps(["info", "contents", "segments", "buttons"]);
import { menu } from "@/composables/menuComposable";

onMounted(() => {
    menu.contents = props.contents;
});

const updateData = () => {
    axios
        .patch(route("admin.menu.data.update", props.info.id), {
            data: menu.contents,
        })
        .then(() => {
            window.location.replace("/admin/menu")
        });
};
</script>
