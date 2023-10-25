<script setup>
"use strict";
import FrontendLayout from '@/Pages/Frontend/Layout/App.vue'
import { trans } from 'laravel-vue-i18n'
defineOptions({ layout: FrontendLayout })
defineProps(['about', 'teams', 'brands', 'primary_data', 'seo', 'marquee'])
</script>
<template>
  <Seo :metaData="seo" />

  <!-- breadcrumb area start -->
  <section class="breadcrumb__area pt-60 pb-40 p-relative">
    <div class="breadrumb__shape">
      <img
        class="breadcrumb__shape-1"
        src="/assets/img/breadcrumb/breadcrumb-shape-1.png"
        alt="breadcrumb__shape"
      />
    </div>
  </section>
  <!-- breadcrumb area end -->

  <!-- about area start -->
  <section class="about__area p-relative">
    <div class="about__shape">
      <img
        class="about__shape-1"
        src="/assets/img/about/shape/about-shape-1.png"
        alt="about__shape"
      />
      <img
        class="about__shape-2"
        src="/assets/img/about/shape/about-shape-2.png"
        alt="about__shape"
      />
      <img
        class="about__shape-3"
        src="/assets/img/about/shape/about-shape-3.png"
        alt="about__shape"
      />
      <img
        class="about__shape-4"
        src="/assets/img/about/shape/about-shape-4.png"
        alt="about__shape"
      />
    </div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xxl-10 col-md-10">
          <div class="about__wrapper">
            <div class="about__content">
              <div class="about__title-wrapper text-center mb-60">
                <span class="about__title-pre">{{ about.breadcrumb_title }}</span>
                <h3 class="about__title">
                  {{ about.breadcrumb_description }}
                </h3>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xxl-3 col-xl-3 col-lg-4">
          <div class="about__thumb-wrapper">
            <div class="about__thumb w-img">
              <img
                lazy="loading"
                v-lazy="
                  about.about_images
                    ? JSON.parse(about.about_images)[0]
                    : 'assets/img/about/about-1.jpg'
                "
                alt=""
              />
            </div>
          </div>
        </div>
        <div class="col-xxl-9 col-xl-9 col-lg-8">
          <div class="row align-items-end">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6">
              <div class="about__thumb-wrapper">
                <div class="about__thumb w-img">
                  <img
                    lazy="loading"
                    v-lazy="
                      about.about_images
                        ? JSON.parse(about.about_images)[1]
                        : 'assets/img/about/about-2.jpg'
                    "
                    alt=""
                  />
                </div>
              </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-6">
              <div class="about__thumb-wrapper">
                <div class="about__thumb w-img">
                  <img
                    lazy="loading"
                    v-lazy="
                      about.about_images
                        ? JSON.parse(about.about_images)[2]
                        : 'assets/img/about/about-3.jpg'
                    "
                    alt=""
                  />
                </div>
              </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-6">
              <div class="about__thumb-wrapper">
                <div class="about__thumb w-img">
                  <img
                    lazy="loading"
                    v-lazy="
                      about.about_images
                        ? JSON.parse(about.about_images)[3]
                        : 'assets/img/about/about-4.jpg'
                    "
                    alt=""
                  />
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xxl-4 col-xl-4 col-lg-4">
              <div class="about__thumb-wrapper">
                <div class="about__thumb w-img">
                  <img
                    lazy="loading"
                    v-lazy="
                      about.about_images
                        ? JSON.parse(about.about_images)[4]
                        : 'assets/img/about/about-5.jpg'
                    "
                    alt=""
                  />
                </div>
              </div>
            </div>
            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-6 col-sm-6">
              <div class="about__thumb-wrapper">
                <div class="about__thumb w-img">
                  <img
                    lazy="loading"
                    v-lazy="
                      about.about_images
                        ? JSON.parse(about.about_images)[5]
                        : 'assets/img/about/about-6.jpg'
                    "
                    alt=""
                  />
                </div>
              </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6">
              <div class="about__thumb-wrapper">
                <div class="about__thumb w-img">
                  <img
                    lazy="loading"
                    v-lazy="
                      about.about_images
                        ? JSON.parse(about.about_images)[6]
                        : 'assets/img/about/about-7.jpg'
                    "
                    alt=""
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- about area end -->

  <!-- about marquee area start -->
  <section class="about__marque">
    <div class="container-fluid p-0">
      <div class="about__marque-inner">
        <div class="row gx-0">
          <div class="col-xxl-12">
            <div class="about__marque-wrapper">
              <div class="about__marque-slider">
                <div class="about__marque-item" v-for="marque in marquee" :key="marque.key">
                  <p>
                    {{ marque }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- about marquee area end -->

  <!-- mission area start -->
  <section class="mission__area pb-50">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xxl-8 col-xl-8 col-lg-10">
          <div class="mission__wrapper">
            <div class="mission__title-wrapper">
              <span class="mission__title-pre">{{ trans('Our Mission') }}</span>
              <p v-html="about.description"></p>
            </div>

            <div class="mission__counter p-relative">
              <span class="mission__counter-vr-br"></span>
              <span class="mission__counter-vr-br mission__counter-vr-br-2"></span>
              <span class="mission__counter-hr-br"></span>
              <div class="row">
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-6">
                  <div class="mission__counter-item d-flex align-items-start">
                    <div class="mission__counter-icon mr-10">
                      <img src="/assets/img/icon/counter/counter-1.png" alt="" />
                    </div>
                    <div class="mission__counter-content">
                      <h4>
                        <span class="counter">
                          {{ about.launching || 2020 }}
                        </span>
                      </h4>
                      <p>{{ trans('Since Launching') }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-6">
                  <div
                    class="mission__counter-item d-flex align-items-start justify-content-md-center"
                  >
                    <div class="mission__counter-icon mr-10">
                      <img src="/assets/img/icon/counter/counter-2.png" alt="" />
                    </div>
                    <div class="mission__counter-content">
                      <h4>{{ about.users || '1m+' }}</h4>
                      <p>{{ trans('Total User') }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-6">
                  <div
                    class="mission__counter-item d-flex align-items-start justify-content-md-end"
                  >
                    <div class="mission__counter-icon mr-10">
                      <img src="/assets/img/icon/counter/counter-3.png" alt="" />
                    </div>
                    <div class="mission__counter-content">
                      <h4>{{ about.employees || '122+' }}</h4>
                      <p>{{ trans('Total Employees') }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-6">
                  <div class="mission__counter-item d-flex align-items-start">
                    <div class="mission__counter-icon mr-10">
                      <img src="/assets/img/icon/counter/counter-4.png" alt="" />
                    </div>
                    <div class="mission__counter-content">
                      <h4>{{ about.collections || '12k' }}</h4>
                      <p>{{ trans('Total Collections') }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-6">
                  <div
                    class="mission__counter-item d-flex align-items-start justify-content-md-center"
                  >
                    <div class="mission__counter-icon mr-10">
                      <img src="/assets/img/icon/counter/counter-5.png" alt="" />
                    </div>
                    <div class="mission__counter-content">
                      <h4>{{ about.prompts || '2k' }}</h4>
                      <p>{{ trans('Prompt Created') }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-6">
                  <div
                    class="mission__counter-item d-flex align-items-start justify-content-md-end"
                  >
                    <div class="mission__counter-icon mr-10">
                      <img src="/assets/img/icon/counter/counter-6.png" alt="" />
                    </div>
                    <div class="mission__counter-content">
                      <h4>{{ about.volume || '2m' }}</h4>
                      <p>{{ trans('Trading Volume') }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- mission area end -->

  <!-- video area start -->
  <section class="video__area pb-110">
    <div class="container">
      <div class="row">
        <div class="col-xxl-12">
          <div class="video__content">
            <div class="video__thumb w-img">
              <img src="/assets/img/video/video-bg.jpg" alt="" />
              <div class="video__play">
                <a
                  target="_blank"
                  :href="about.introducing_video"
                  class="video__play-btn popup-video"
                >
                  <i class="fa-solid fa-play"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- video area end -->

  <!-- team area start -->
  <section class="team__area">
    <div class="container">
      <div class="row">
        <div class="col-xxl-12">
          <div class="section__title-wrapper text-center mb-35">
            <span class="section__title-pre-4">{{ trans('Team Member') }}</span>
            <h3 class="section__title-4">
              {{ trans('Meet our team member') }}
            </h3>
          </div>
        </div>
      </div>
      <div class="row row-cols-xxl-5 row-cols-xl-5 row-cols-lg-4 row-cols-md-2">
        <div class="col" v-for="team in teams" :key="team.id">
          <div class="team__item text-center mb-30 transition-3">
            <div class="team__thumb">
              <img lazy="loading" v-lazy="team.preview.value" alt="preview" />
            </div>
            <div class="team__content">
              <h3 class="team__title">
                <a href="javascript:void(0)">{{ team.title }}</a>
              </h3>
              <p class="team__position">{{ team.slug }}</p>

              <div class="team__social">
                <a
                  target="_blank"
                  v-for="(link, key) in JSON.parse(team.excerpt.value)"
                  :key="key"
                  :href="link"
                >
                  <i class="fa-brands" :class="`fa-${key}`"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="team__line mt-55 mb-90"></div>
    </div>
  </section>
  <!-- team area end -->

  <!-- brand area start -->
  <section class="brand__area pb-80" v-if="brands.length > 0">
    <div class="container">
      <div
        class="row row-cols-xxl-5 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 justify-content-center"
      >
        <div class="col" v-for="brand in brands" :key="brand.id">
          <div class="brand__item-2 mb-30 text-center">
            <img v-lazy="brand.slug" alt="logo" />
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- brand area end -->

  <!-- join area start -->
  <section class="join__area pb-90">
    <div class="container">
      <div class="row">
        <div class="col-xxl-12">
          <div class="section__title-wrapper text-center mb-55">
            <h3 class="section__title-4 section__title-5">
              {{ trans('Interested in joining us?') }}
            </h3>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
          <div class="join__item text-center mb-30">
            <div class="join__thumb mb-25">
              <img src="/assets/img/icon/join/join-1.png" alt="" />
            </div>
            <div class="join__content">
              <h3 class="join__title">
                {{ trans('Join our') }} <span>{{ trans('Community') }}</span>
              </h3>

              <div class="join__social">
                <a
                  target="_blank"
                  v-for="(social, key) in primary_data.socials"
                  :href="social"
                  :key="key"
                >
                  <i class="fa-brands" :class="`fa-${key}`"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6">
          <div class="join__item text-center mb-30">
            <div class="join__thumb mb-25">
              <img src="/assets/img/icon/join/join-2.png" alt="" />
            </div>
            <div class="join__content">
              <h3 class="join__title">
                {{ trans('Become a') }} <span> {{ trans('Creator') }}</span>
              </h3>

              <div class="join__btn">
                <Link href="/register" class="tp-btn-4">{{ trans('Sign up') }}</Link>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6">
          <div class="join__item text-center mb-30">
            <div class="join__thumb mb-25">
              <img src="/assets/img/icon/join/join-3.png" alt="" />
            </div>
            <div class="join__content">
              <h3 class="join__title">
                {{ trans('Reach out to') }} <span>{{ trans('our team') }}</span>
              </h3>

              <div class="join__btn-gradient">
                <a :href="`mailto:${primary_data.contact_email}`" class="tp-btn-4">
                  {{ primary_data.contact_email }}
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- join area end -->
</template>
