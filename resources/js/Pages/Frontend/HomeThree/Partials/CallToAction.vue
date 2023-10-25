<template>
  <section class="cta__area pt-40 pb-100">
    <div class="container">
      <div class="row">
        <div class="col-xxl-7 col-xl-7 col-lg-6">
          <div class="cta__box">
            <div class="cta__box-wrapper p-relative fix">
              <div
                class="cta__box-bg"
                :style="{
                  backgroundImage: `url(${
                    cta?.cta_thumbnail
                      ? cta.cta_thumbnail
                      : 'assets/img/cta/3/cta-bg.jpg'
                  })`
                }"
              ></div>
              <div class="cta__box-inner">
                <div class="cta__box-content text-center">
                  <span>
                    {{
                      cta?.title
                        ? cta.title
                        : trans("The future of the Internet")
                    }}
                  </span>
                  <h3 class="cta__box-title">
                    {{
                      cta?.subtitle
                        ? cta.subtitle
                        : trans("The future of the Internet")
                    }}
                  </h3>

                  <div class="cta__box-btn">
                    <a
                      target="_blank"
                      :href="cta.link || '/contact'"
                      class="tp-btn-square"
                    >
                      {{ trans("Let's Talk") }}
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-5 col-xl-5 col-lg-6">
          <div class="community__wrapper text-center">
            <div class="community__content">
              <h3>
                {{ trans("Join our") }} <br />
                {{ trans("Amazing community") }}
              </h3>
              <p>
                {{
                  trans(`Meet the known origin team, artists and collectors for platform
                updates.`)
                }}
              </p>
            </div>
            <div class="community__social">
              <a
                target="_blank"
                v-for="(social, key) in $page.props.primaryData['socials']"
                :href="social"
                :key="key"
              >
                <i class="fa-brands" :class="`fa-${key}`"> </i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script setup>
"use strict";
const props = defineProps(["cta"])
</script>
