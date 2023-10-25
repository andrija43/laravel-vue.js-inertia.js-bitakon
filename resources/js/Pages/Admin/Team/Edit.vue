<template>
  <HeaderSegment title="Edit Team Member" :segments="segments" :buttons="buttons" />
  <div class="container-fluid mt--6">
    <form class="ajaxform" method="post" @submit.prevent="editTeam" enctype="multipart/form-data">
      <div class="row">
        <div class="col-lg-5">
          <strong>{{ trans('Edit team member') }}</strong>
          <p>
            {{ trans('Edit your team member details and necessary information from here') }}
          </p>
        </div>
        <div class="col-lg-7 card-wrapper">
          <!-- Alerts -->
          <div class="card">
            <div class="card-header">
              <h3 class="mb-0">{{ trans('Edit Team Member bio') }}</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label>{{ trans('Member Name') }}</label>
                <input
                  type="text"
                  name="member_name"
                  v-model="info.title"
                  required
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label>{{ trans('Member Position') }}</label>
                <input
                  type="text"
                  name="member_position"
                  v-model="info.slug"
                  required
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label>{{ trans('Profile Picture') }}</label>
                <input
                  @input="(e) => (info.preview.value = e.target.files[0])"
                  type="file"
                  accept="image/*"
                  name="profile_picture"
                  class="form-control"
                />
              </div>

              <div class="form-group">
                <label>{{ trans('Profile Description') }}</label>
                <textarea
                  class="form-control h-200"
                  name="about"
                  maxlength="1000"
                  required
                  v-model="info.description.value"
                ></textarea>
              </div>
              <div class="form-group">
                <label>{{ trans('Facebook profile link') }}</label>
                <input
                  type="url"
                  name="socials[facebook]"
                  v-model="socials.facebook"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label>{{ trans('Twitter profile link') }}</label>
                <input
                  type="url"
                  name="socials[twitter]"
                  v-model="socials.twitter"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label>{{ trans('Linkedin profile link') }}</label>
                <input
                  type="url"
                  name="socials[linkedin]"
                  v-model="socials.linkedin"
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
                    v-model="info.status"
                  />
                  <span
                    class="custom-toggle-slider rounded-circle"
                    data-label-off="No"
                    data-label-on="Yes"
                  ></span>
                </label>
                <label class="mt-1 ml-1" for="plain-text-with-button"
                  ><h4>{{ trans('Make it publish?') }}</h4></label
                >
              </div>

              <div class="from-group row mt-3">
                <div class="col-lg-12">
                  <button class="btn btn-neutral submit-button">
                    {{ trans('Submit') }}
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
import AdminLayout from '@/Pages/Admin/Layout/App.vue'
import HeaderSegment from '@/Pages/Admin/Layout/HeaderSegment.vue'
import { router } from '@inertiajs/vue3'
import { createToast } from 'mosha-vue-toastify'
import { onMounted } from 'vue'
defineOptions({ layout: AdminLayout })

const props = defineProps(['buttons', 'segments', 'info', 'socials'])
onMounted(() => {
  props.info.status = props.info.status == 1 ? true : false
})
const editTeam = () => {
  if (!(props.info.preview.value instanceof File)) {
    props.info.preview.value = null
  }

  router.post(
    route('admin.team.update', props.info.id),
    {
      _method: 'patch',
      team: props.info,
      socials: props.socials
    },
    {
      onSuccess: () => {
        createToast({
          title: 'Updated',
          description: 'Team Updated successfully'
        })
      }
    }
  )
}
</script>
