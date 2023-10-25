<template>
  <HeaderSegment
    title="Create Team Member"
    :segments="segments"
    :buttons="buttons"
  />
  <div class="container-fluid mt--6">
    <form
      class="ajaxform_reset_form"
      method="post"
      @submit.prevent="createTeam"
      enctype="multipart/form-data"
    >
      <div class="row">
        <div class="col-lg-5">
          <strong>{{ trans("Create a team member") }}</strong>
          <p>
            {{
              trans(
                "Add your team member details and necessary information from here"
              )
            }}
          </p>
        </div>
        <div class="col-lg-7 card-wrapper">
          <!-- Alerts -->
          <div class="card">
            <div class="card-header">
              <h3 class="mb-0">{{ trans("Create Team Member") }}</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label>{{ trans("Member Name") }}</label>
                <input
                  v-model="form.member_name"
                  type="text"
                  name="member_name"
                  required
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label>{{ trans("Member Position") }}</label>
                <input
                  v-model="form.member_position"
                  type="text"
                  name="member_position"
                  required
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label>{{ trans("Profile Picture") }}</label>
                <input
                  @input="(e) => (form.profile_picture = e.target.files[0])"
                  type="file"
                  accept="image/*"
                  name="profile_picture"
                  required
                  class="form-control"
                />
              </div>

              <div class="form-group">
                <label>{{ trans("Profile Description") }}</label>
                <textarea
                  v-model="form.about"
                  class="form-control h-200"
                  name="about"
                  maxlength="1000"
                  required
                ></textarea>
              </div>
              <div class="form-group">
                <label>{{ trans("Facebook profile link") }}</label>
                <input
                  v-model="form.socials.facebook"
                  type="url"
                  name="socials[facebook]"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label>{{ trans("Twitter profile link") }}</label>
                <input
                  v-model="form.socials.twitter"
                  type="url"
                  name="socials[twitter]"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label>{{ trans("Linkedin profile link") }}</label>
                <input
                  v-model="form.socials.linkedin"
                  type="url"
                  name="socials[linkedin]"
                  class="form-control"
                />
              </div>

              <div class="d-flex">
                <label class="custom-toggle custom-toggle-primary">
                  <input
                    type="checkbox"
                    name="status"
                    value="1"
                    id="plain-text-with-button"
                    data-target=".plain-title-with-button"
                    class="save-template"
                    v-model="form.status"
                  />
                  <span
                    class="custom-toggle-slider rounded-circle"
                    data-label-off="No"
                    data-label-on="Yes"
                  ></span>
                </label>
                <label class="mt-1 ml-1" for="plain-text-with-button"
                  ><h4>{{ trans("Make it publish?") }}</h4></label
                >
              </div>
              <div class="from-group row mt-3">
                <div class="col-lg-12">
                  <button class="btn btn-neutral submit-button">
                    {{ trans("Submit") }}
                  </button>
                </div>
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
import { useForm } from "@inertiajs/vue3"
import { createToast } from "mosha-vue-toastify"
defineOptions({ layout: AdminLayout })

const props = defineProps(["buttons", "segments"])
const form = useForm({
  member_name: "",
  member_position: "",
  profile_picture: "",
  about: "",
  status: true,
  socials: {
    facebook: null,
    twitter: null,
    linkedin: null
  }
})
const createTeam = () => {
  form.post(route("admin.team.store"), {
    onSuccess: () => {
      form.reset()
      createToast(
        {
          title: "Created",
          description: "Team Created successfully"
        },
        {
          transition: "slide",
          position: "top-right"
        }
      )
    }
  })
}
</script>
