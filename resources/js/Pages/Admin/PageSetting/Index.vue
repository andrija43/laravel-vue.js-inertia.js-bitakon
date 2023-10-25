<template>
  <HeaderSegment
    title="Page Settings"
    :segments="segments"
    :buttons="buttons"
  />

  <div class="row container-fluid mt--6">
    <div class="col-12 col-sm-12 col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4>{{ trans("Page settings") }}</h4>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-12 col-md-4">
              <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                <li class="nav-item">
                  <a
                    class="nav-link active"
                    id="home-tab4"
                    data-toggle="tab"
                    href="#home4"
                    role="tab"
                    aria-controls="home"
                    aria-selected="true"
                    >{{ trans("Primary Settings") }}</a
                  >
                </li>
                <li class="nav-item mt-2">
                  <a
                    class="nav-link"
                    id="theme-tab4"
                    data-toggle="tab"
                    href="#theme"
                    role="tab"
                    aria-controls="theme"
                    aria-selected="true"
                    >{{ trans("Theme") }}</a
                  >
                </li>
                <li class="nav-item mt-2">
                  <a
                    class="nav-link"
                    id="profile-tab4"
                    data-toggle="tab"
                    href="#header-footer"
                    role="tab"
                    aria-controls="profile"
                    aria-selected="false"
                    >{{ trans("Header Footer Settings") }}</a
                  >
                </li>

                <li class="nav-item mt-2">
                  <a
                    class="nav-link"
                    id="profile-tab4"
                    data-toggle="tab"
                    href="#home-page"
                    role="tab"
                    aria-controls="profile"
                    aria-selected="false"
                    >{{ trans("Home Page") }}</a
                  >
                </li>
                <li class="nav-item mt-2">
                  <a
                    class="nav-link"
                    id="profile-tab4"
                    data-toggle="tab"
                    href="#contact-page"
                    role="tab"
                    aria-controls="profile"
                    aria-selected="false"
                    >{{ trans("Contact Page") }}</a
                  >
                </li>

                <li class="nav-item mt-2 none">
                  <a
                    class="nav-link"
                    id="contact-tab4"
                    data-toggle="tab"
                    href="#contact4"
                    role="tab"
                    aria-controls="contact"
                    aria-selected="false"
                  ></a>
                </li>
              </ul>
            </div>

            <div class="col-12 col-sm-12 col-md-8">
              <div class="tab-content no-padding" id="myTab2Content">
                <!-- primary data -->

                <PrimaryData :primary_data="primary_data" />

                <!-- contact-page -->

                <ContactPage :contact_page="contact_page" />

                <!-- theme -->

                <ThemePath :theme_path="theme_path" />

                <!-- home-page  -->

                <HomePage :home="home" />

                <!-- header_footer  -->

                <HeaderFooter :headerFooter="headerFooter" />
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
import AdminLayout from "@/Pages/Admin/Layout/App.vue"
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue"
import HomePage from "./Partials/HomePage.vue"
import PrimaryData from "./Partials/PrimaryData.vue"
import ContactPage from "./Partials/ContactPage.vue"
import HeaderFooter from "./Partials/HeaderFooter.vue"
import ThemePath from "./Partials/ThemePath.vue"

defineOptions({ layout: AdminLayout })

const props = defineProps([
  "primary_data",
  "headerFooter",
  "contact_page",
  "home",
  "features_area",
  "brand_area",
  "account_area",
  "theme_path",
  "buttons",
  "segments"
])
</script>
