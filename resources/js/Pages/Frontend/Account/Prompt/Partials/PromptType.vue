<script setup>
"use strict";
import { router } from '@inertiajs/vue3'

const emit = defineEmits(['update:modelValue'])
const props = defineProps({
    modelValue: { default: null },
    promptmodel:{ default: [] }
})
const selectType = (id) => {
    emit('update:modelValue', id)
    router.get(route('user.prompt.create'),{prompt_id: id},{
      preserveState: true
    })
}

</script>

<template>
  <section class="breadcrumb__area breadcrumb__border pt-60 pb-60 p-relative">
    <div class="breadrumb__shape">
      <img
        class="breadcrumb__shape-1"
        src="/assets/img/breadcrumb/breadcrumb-shape-1.png"
        alt="breadcrumb"
      />
    </div>
    <div class="container">
      <div class="row">
        <div class="col-xxl-12">
          <div class="breadcrumb__content text-center">
            <h3 class="breadcrumb__title">{{ trans('Create Prompt') }}</h3>
            <div class="breadcrumb__list">
              <span><Link href="/">{{ trans('Home') }}</Link></span>
              <span class="dvdr tp-dot"
                ><i class="fa-solid fa-period"></i
              ></span>
              <span>{{ trans('Create Prompt') }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="create__area pt-60 pb-90">
    <div class="container">
      <div class="row justify-content-center">
        <template v-for="model in promptmodel" :key="model">
          <button
            class="col-xxl-4 col-xl-4 col-lg-5 col-md-6"
            @click="selectType(model.id)"
          >
            <div class="create__item mb-30">
              <div class="create__item-inner text-center">
                <div class="create__content">
                  <h4 class="create__title">
                    <a href="javascript:void(0)">{{ model.title }}</a>
                  </h4>
                  <p v-if="model.meta">{{ model.meta.frontend_description }}</p>
                </div>

                <div class="create__thumb m-img">
                  <img :src="model.preview" alt="preview" height="200" />
                </div>
              </div>
            </div>
          </button>
        </template>
      </div>
    </div>
  </section>
</template>

