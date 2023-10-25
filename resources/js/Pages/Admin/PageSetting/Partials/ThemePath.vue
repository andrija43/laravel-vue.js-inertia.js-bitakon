<template>
  <div
    class="tab-pane fade"
    id="theme"
    role="tabpanel"
    aria-labelledby="profile-tab4"
  >
   
      <div class="row">
        <div class="col-4">
          <div class="card">
            <div class="card-body">
              <img
                class="w-100 rounded"
                src="/assets/img/home.jpeg"
                alt="img"
              />
            </div>
            <div class="card-footer">
              <button
                type="button"
                @click="updateThemePath('Home')"
                class="btn btn-sm btn-neutral col-12"
                :class="{ active: theme_path === 'Home' }"
              >
                {{ theme_path === "Home" ? "Installed" : "Activate" }}
              </button>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card">
            <div class="card-body">
              <img
                class="w-100 rounded"
                src="/assets/img/home_two.jpeg"
                alt="img"
              />
            </div>
            <div class="card-footer">
              <button
                type="button"
                @click="updateThemePath('HomeTwo')"
                class="btn btn-sm btn-neutral col-12"
                :class="{ active: theme_path === 'HomeTwo' }"
              >
                {{ theme_path === "HomeTwo" ? "Installed" : "Activate" }}
              </button>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card">
            <div class="card-body">
              <img
                class="w-100 rounded"
                src="/assets/img/home_three.jpeg"
                alt="img"
              />
            </div>
            <div class="card-footer">
              <button
                type="button"
                @click="updateThemePath('HomeThree')"
                class="btn btn-sm btn-neutral col-12"
                :class="{ active: theme_path === 'HomeThree' }"
              >
                {{ theme_path === "HomeThree" ? "Installed" : "Activate" }}
              </button>
            </div>
          </div>
        </div>
      </div>
    
  </div>
</template>

<script setup>
"use strict";
import { router } from "@inertiajs/vue3"
import { createToast } from "mosha-vue-toastify"
const props = defineProps(["theme_path"])
const updateThemePath = (path) => {
  router.put(
    route("admin.page-settings.update", "theme"),
    { path: path },
    {
      onSuccess: () => {
        createToast({
          title: "Updated",
          description: "Theme Updated successfully"
        })
      }
    }
  )
}
</script>
