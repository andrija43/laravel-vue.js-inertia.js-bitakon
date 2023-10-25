<template>
  <Head title="About Settings" />
  <HeaderSegment
    :title="trans('Edit About Page')"
    :segments="segments"
    :buttons="buttons"
  />
  <div class="container-fluid mt--6">
    <div class="row justify-content-center">
      <div class="col-9 col-sm-9 col-lg-9">
        <div class="card">
          <div class="card-header">
            <h4>{{ trans("About Us") }}</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-12 col-sm-12 col-md-12">
                <form
                  @submit.prevent="update"
                  class="ajaxform_instant_reload"
                  enctype="multipart/form-data"
                >
                  <div class="form-group">
                    <label>{{ trans("Breadcrumb Title:") }}</label>
                    <input
                      type="text"
                      name="breadcrumb_title"
                      required=""
                      class="form-control"
                      v-model="form.breadcrumb_title"
                      placeholder="About Us"
                    />
                  </div>
                  <div class="form-group">
                    <label>{{ trans("Breadcrumb description:") }}</label>
                    <input
                      type="text"
                      name="breadcrumb_description"
                      required
                      class="form-control"
                      v-model="form.breadcrumb_description"
                      placeholder="Over 12 years of experience in the IT Industry & Tech service"
                    />
                  </div>
                  <div class="form-group">
                    <label>{{ trans("Marquee:") }}</label>
                    <input
                      type="text"
                      name="marquee"
                      required
                      class="form-control"
                      v-model="form.marquee"
                      placeholder="marquee"
                    />
                  </div>

                  <div class="form-group">
                    <label>{{ trans("About Images: (max 7)") }}</label>
                    <input
                      maxlength="6"
                      multiple
                      type="file"
                      name="about_images"
                      accept="image/*"
                      @input="(e) => (form.about_images = e.target.files)"
                      class="form-control"
                    />
                    <div
                      class="invalid-feedback text-danger d-block"
                      v-if="form.errors.about_images"
                    >
                      {{ form.errors.about_images }}
                    </div>
                  </div>

                  <div class="form-group">
                    <label>{{ trans("About Description:") }}</label>
                    <textarea
                      class="form-control"
                      required=""
                      name="description"
                      v-model="form.description"
                    ></textarea>
                  </div>
                  <div class="form-group">
                    <label>{{ trans("Since Launching") }}</label>
                    <input
                      type="text"
                      name="button_title"
                      class="form-control"
                      v-model="form.launching"
                      placeholder="2020"
                    />
                  </div>
                  <div class="form-group">
                    <label>{{ trans("Total User") }}</label>
                    <input
                      type="text"
                      name="button_title"
                      class="form-control"
                      v-model="form.users"
                      placeholder="1k"
                    />
                  </div>
                  <div class="form-group">
                    <label>{{ trans("Total Employees") }}</label>
                    <input
                      type="text"
                      name="button_title"
                      class="form-control"
                      v-model="form.employees"
                      placeholder="1k"
                    />
                  </div>
                  <div class="form-group">
                    <label>{{ trans("Total Collections") }}</label>
                    <input
                      type="text"
                      name="button_title"
                      class="form-control"
                      v-model="form.collections"
                      placeholder="1k"
                    />
                  </div>
                  <div class="form-group">
                    <label>{{ trans("Total Prompts") }}</label>
                    <input
                      type="text"
                      name="button_title"
                      class="form-control"
                      v-model="form.prompts"
                      placeholder="1k"
                    />
                  </div>
                  <div class="form-group">
                    <label>{{ trans("Trading Volume") }}</label>
                    <input
                      type="text"
                      name="button_title"
                      class="form-control"
                      v-model="form.volume"
                      placeholder="1m"
                    />
                  </div>
                  <div class="form-group">
                    <label>{{ trans("Section Button Name:") }}</label>
                    <input
                      type="text"
                      name="button_title"
                      class="form-control"
                      v-model="form.button_title"
                      placeholder="Check our work"
                    />
                  </div>
                  <div class="form-group">
                    <label>{{ trans("Section Button Link:") }}</label>
                    <input
                      type="text"
                      name="button_link"
                      class="form-control"
                      v-model="form.button_link"
                      placeholder=""
                    />
                  </div>
                  <div class="form-group">
                    <label>
                      {{ trans("Introducing video link (youtube)") }}
                    </label>
                    <input
                      type="text"
                      name="introducing_video"
                      class="form-control"
                      v-model="form.introducing_video"
                      placeholder="https://www.youtube.com/watch?v=Fu3MIwF-LJw"
                    />
                  </div>
                  <div class="form-group">
                    <label>{{ trans("Facilities:") }}</label>
                    <textarea
                      class="form-control"
                      name="facilities"
                      placeholder="example1, example2"
                      v-model="form.facilities"
                    ></textarea>
                    <small>{{ trans("use comma (,) for line break") }}</small>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-neutral submit-button" type="submit">
                      {{ trans("Update") }}
                    </button>
                  </div>
                </form>
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
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import { trans } from "laravel-vue-i18n";
import { createToast } from "mosha-vue-toastify";
defineOptions({ layout: AdminLayout });
const props = defineProps([
  "languages",
  "segments",
  "buttons",
  "about",
  "current_lang",
]);

const form = useForm({
  breadcrumb_title: props.about.breadcrumb_title,
  breadcrumb_description: props.about.breadcrumb_description,
  marquee: props.about.marquee,
  about_images: "",
  description: props.about.description,
  launching: props.about.launching,
  users: props.about.users,
  employees: props.about.employees,
  collections: props.about.collections,
  prompts: props.about.prompts,
  volume: props.about.volume,
  button_title: props.about.button_title,
  button_link: props.about.button_link,
  introducing_video: props.about.introducing_video,
  facilities: props.about.facilities,
  lang: props.current_lang,
});

const update = () => {
  const url = route("admin.about.store");
  router.post(url, form, {
    onSuccess: () => {
      createToast(
        {
          title: "Congratulations",
          description: "Settings updated successfully",
        },
        {
          transition: "slide",
          position: "top-right",
        }
      );
    },
  });
};
</script>
