<template>
  <section class="cta__area p-relative z-index-1">
    <div class="container">
      <div class="cta__wrapper-2 p-relative">
        <div class="cta__shape">
          <img class="cta__shape-1" src="assets/img/cta/2/cta-shape-1.png" alt="cta__shape" />
          <img class="cta__shape-2" src="assets/img/cta/2/cta-shape-2.png" alt="cta__shape" />
          <img class="cta__shape-3" src="assets/img/cta/2/cta-shape-3.png" alt="cta__shape" />
        </div>
        <div class="row align-items-center">
          <div class="col-xxl-6 col-lg-6">
            <div class="cta__thumb-2">
              <img
                v-lazy="cta?.cta_thumbnail ? cta.cta_thumbnail : 'assets/img/cta/2/cta-graph.png'"
                alt="cta_thumbnail"
              />
            </div>
          </div>
          <div class="col-xxl-6 col-lg-6">
            <div class="cta__content-2">
              <h3>
                {{ cta?.title ? cta.title : trans('Explore and discover Top trending Prompts') }}
              </h3>
              <p>
                {{
                  cta?.subtitle
                    ? cta.subtitle
                    : trans(`Raroin is a shared liquidity prompt commands  which is
                used by multiple websites to provide the users.`)
                }}
              </p>

              <Link :href="cta.link || route('user.prompt.create')" class="tp-btn-gradient active">
                {{ trans(`upload work`) }}
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script setup>
"use strict";
const props = defineProps(['cta'])
</script>
