<script setup>
import { useForm } from '@inertiajs/vue3'
import FrontendLayout from '@/Pages/Frontend/Layout/App.vue'
import sharedComposable from '@/composables/sharedComposable'
defineOptions({ layout: FrontendLayout })
defineProps(['contact_page', 'seo'])
const { ToastAlert } = sharedComposable()
const form = useForm({
  email: '',
  phone: '',
  name: '',
  subject: '',
  message: '',
  terms: false
})

const submit = () => {
  form.post(route('send.mail'), {
    onSuccess: () => {
      ToastAlert('Success', 'Thanks for contact with us we will contact you soon')
    }
  })
}
</script>

<template>
  <Seo :metaData="seo" />

  <section class="breadcrumb__area pt-60 pb-40 p-relative">
    <div class="breadrumb__shape">
      <img
        class="breadcrumb__shape-1"
        src="/assets/img/breadcrumb/breadcrumb-shape-1.png"
        alt="shape"
      />
    </div>
  </section>
  <!-- contact__area start -->
  <section class="contact__area pb-60">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xxl-10 col-xl-10">
          <div class="contact__wrapper">
            <div class="contact__shape">
              <img
                class="contact__shape-1"
                src="/assets/img/icon/contact/contact-shape-1.png"
                alt="contact__shape"
              />
              <img
                class="contact__shape-2"
                src="/assets/img/icon/contact/contact-shape-2.png"
                alt="contact__shape"
              />
              <img
                class="contact__shape-3"
                src="/assets/img/icon/contact/contact-shape-3.png"
                alt="contact__shape"
              />
              <img
                class="contact__shape-4"
                src="/assets/img/icon/contact/contact-shape-4.png"
                alt="contact__shape"
              />
              <img
                class="contact__shape-5"
                src="/assets/img/icon/contact/contact-shape-5.png"
                alt="contact__shape"
              />
            </div>
            <div class="contact__content text-center mb-40">
              <h3>{{ trans('Get in Touch') }}</h3>
              <p>
                {{
                  trans(`Need support, have feature requests, looking for partnerships ?
                We respond within 24 hours during business days.`)
                }}
              </p>
            </div>
            <div class="contact__form">
              <form @submit.prevent="submit">
                <div class="row">
                  <div class="col-xxl-12">
                    <div class="contact__input-box">
                      <h4>{{ trans('Your name') }} <span>*</span></h4>
                      <div class="contact__input">
                        <input
                          v-model="form.name"
                          type="text"
                          placeholder="Enter your name"
                          required
                        />
                      </div>
                    </div>
                  </div>
                  <div class="col-xxl-12">
                    <div class="contact__input-box">
                      <h4>{{ trans('Your email') }} <span>*</span></h4>
                      <div class="contact__input">
                        <input
                          v-model="form.email"
                          type="email"
                          placeholder="Enter your email"
                          required
                        />
                      </div>
                    </div>
                  </div>
                  <div class="col-xxl-12">
                    <div class="contact__input-box">
                      <h4>{{ trans('Your Phone') }} <span>*</span></h4>
                      <div class="contact__input">
                        <input
                          v-model="form.phone"
                          type="tel"
                          placeholder="Enter your phone number"
                          required
                        />
                      </div>
                    </div>
                  </div>
                  <div class="col-xxl-12 col-md-6">
                    <div class="contact__input-box">
                      <h4>{{ trans('Subject') }} <span>*</span></h4>
                      <div class="contact__input">
                        <input
                          v-model="form.subject"
                          type="text"
                          placeholder="Subject of query"
                          required
                        />
                      </div>
                    </div>
                  </div>
                  <div class="col-xxl-12">
                    <div class="contact__input-box">
                      <h4>{{ trans('Message') }} <span>*</span></h4>
                      <div class="contact__input">
                        <textarea
                          required
                          v-model="form.message"
                          placeholder="How we can help you?"
                        ></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="col-xxl-12">
                    <div
                      class="contact__bottom d-sm-flex align-items-center justify-content-between"
                    >
                      <div class="contact__agree d-flex align-items-center">
                        <input
                          required
                          v-model="form.terms"
                          class="m-check-input"
                          type="checkbox"
                          id="m-lock"
                        />
                        <label class="m-check-label" for="m-lock">
                          {{ trans('Allow to all teams & condition') }}
                        </label>
                      </div>
                      <div class="contact__btn">
                        <button
                          :class="{ 'cursor-disable': !form.terms || form.processing }"
                          :disabled="!form.terms || form.processing"
                          type="submit"
                          class="tp-btn-4"
                        >
                          {{ form.processing ? trans('Processing...') : trans('send message') }}
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- contact__area info -->
  <section class="contact__info pb-70">
    <div class="container">
      <div class="contact__info-wrapper">
        <div class="row justify-content-center">
          <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
            <div class="contact__info-item d-flex align-items-center mb-50">
              <div class="contact__icon mr-15">
                <span>
                  <img src="assets/img/icon/contact/contact-1.png" alt="" />
                </span>
              </div>
              <div class="contact__text">
                <p>{{ trans('Mail') }}</p>
                <h4>
                  <a :href="`mailto:${contact_page.email1}`">{{ contact_page.email1 }}</a>
                </h4>
              </div>
            </div>
          </div>
          <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
            <div class="contact__info-item d-flex align-items-center mb-50">
              <div class="contact__icon mr-15 contact-discord">
                <span>
                  <img src="assets/img/icon/contact/contact-2.png" alt="" />
                </span>
              </div>
              <div class="contact__text">
                <p>{{ trans('Support') }}</p>

                <h4>
                  <a :href="`tel:+${contact_page.contact1}`">{{ contact_page.contact1 }}</a>
                </h4>
              </div>
            </div>
          </div>
          <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
            <div class="contact__info-item d-flex align-items-center mb-50">
              <div class="contact__icon mr-15 contact-location">
                <span>
                  <img src="assets/img/icon/contact/contact-3.png" alt="" />
                </span>
              </div>
              <div class="contact__text">
                <p>{{ trans('Office') }}</p>
                <h4>
                  <a :href="contact_page.map_link" target="_blank">{{ contact_page.address }}</a>
                </h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>