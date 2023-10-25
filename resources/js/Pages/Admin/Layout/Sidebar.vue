<template>
  <nav
    class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white"
    id="sidenav-main"
  >
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header d-flex align-items-center">
        <a href="/" :class="'navbar-brand'">
          <img :src="$page.props.primaryData?.logo_dark" alt="logo" />
        </a>
        <div class="ml-auto">
          <!-- Sidenav toggler -->
          <div
            class="sidenav-toggler d-none d-xl-block"
            data-action="sidenav-unpin"
            data-target="#sidenav-main"
          >
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <Link
                class="nav-link"
                :class="{ active: $page.url.startsWith('/admin/dashboard') }"
                :href="route('admin.dashboard.index')"
              >
                <i class="fi fi-rs-dashboard"></i>
                <span class="nav-link-text">{{ trans("Dashboard") }}</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link
                class="nav-link"
                :class="{ active: currentRouteGroup('Admin/Order') }"
                :href="route('admin.order.index')"
              >
                <i class="fi fi-rs-boxes"></i>
                <span class="nav-link-text">{{ trans("Orders") }}</span>
              </Link>
            </li>

            <li class="nav-item">
              <Link
                class="nav-link"
                :href="route('admin.customer.index')"
                :class="{ active: currentRouteGroup('Admin/Customers') }"
              >
                <i class="fi fi-rs-users-alt"></i>
                <span class="nav-link-text">{{ trans("Customers") }}</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link
                class="nav-link"
                :href="route('admin.gateways.index')"
                :class="{ active: currentRouteGroup('Admin/Gateway') }"
              >
                <i class="fi fi-rs-bank"></i>
                <span class="nav-link-text">{{
                  trans("Payment Gateways")
                }}</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link class="nav-link" :class="{ active: $page.url.startsWith('/admin/cron-job') }" href="/admin/cron-job">
                <i class="fi fi-rs-calendar-clock"></i>
                <span class="nav-link-text">{{ trans("Cron Jobs") }}</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link
                class="nav-link"
                :class="{ active: $page.url.startsWith('/admin/payout-methods') }"
                :href="route('admin.payout-methods.index')"
              >
                <i class="fi fi-rs-search-dollar"></i>
                <span class="nav-link-text">{{ trans("Payout Methods") }}</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link 
               class="nav-link"
               :class="{ active: $page.url.startsWith('/admin/payouts') }"
               :href="route('admin.payouts.index')">
                <i class="fi  fi-rs-envelope-open-dollar"></i>
                <span class="nav-link-text">{{
                  trans("Payout Requests")
                }}</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link
                class="nav-link"
                :class="{
                  active: currentRoute('Admin/Credits/Index')
                }"
                :href="route('admin.credit-logs.index')"
              >
                <i class="fi fi-rs-money"></i>
                <span class="nav-link-text mb-1">{{
                  trans("Credit Logs")
                }}</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link
                class="nav-link"
                :class="{ active: currentRouteGroup('Admin/Review') }"
                :href="route('admin.review.index')"
              >
                <i class="fi-rs-stars"></i>
                <span class="nav-link-text">{{ trans("Reviews & Ratings") }}</span>
              </Link>
            </li>
          </ul>
          <!-- Divider -->
          <h6 class="navbar-heading p-0 text-muted mt-4">
            {{ trans("Marketplace") }}
          </h6>

          <!-- Navigation -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <Link
                class="nav-link"
                
                :class="{ active: $page.url.startsWith('/admin/prompt-model') }"
                :href="route('admin.prompt-model.index')"
              >
                <i class="fi fi-rs-puzzle-piece"></i>
                <span class="nav-link-text">{{ trans("Prompt Models") }}</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link
                class="nav-link"
                :class="{ active: $page.url.startsWith('/admin/prompt-category') }"
                :href="route('admin.prompt-category.index')"
              >
                <i class="fi fi-rs-envelope-bulk"></i>
                <span class="nav-link-text">{{ trans("Prompt Categories") }}</span>
              </Link>
            </li>
            <!-- prompts -->
            <li class="nav-item">
              <a
                class="nav-link"
                :class="{
                  active:
                    $page.url.startsWith('/admin/prompt') ||
                    $page.url.startsWith('/admin/prompt/pending') ||
                    $page.url.startsWith('/admin/prompt/disable') || 
                    $page.url.startsWith('/admin/reports')
                }"
                href="#navbar-prompts"
                data-toggle="collapse"
                role="button"
                aria-expanded="false"
                aria-controls="navbar-prompts"
              >
                <i class="fi fi-rs-blog-text"></i>
                <span class="nav-link-text">{{ trans("Prompts") }}</span>
              </a>
              <div class="collapse" id="navbar-prompts">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <Link 
                    :href="route('admin.prompt.index')" 
                   
                    class="nav-link">
                      {{ trans("Prompts") }}
                    </Link>
                  </li>
                  <li class="nav-item">
                    <Link href="/admin/prompt/pending" class="nav-link">
                      {{ trans("Pending Prompts") }}
                    </Link>
                  </li>
                  <li class="nav-item">
                    <Link href="/admin/prompt/disable" class="nav-link">{{
                      trans("Request For Remove")
                    }}</Link>
                  </li>
                  <li class="nav-item">
                    <Link href="/admin/reports" class="nav-link">{{
                      trans("Reports")
                    }}</Link>
                  </li>
                </ul>
              </div>
            </li>
            <!-- collection -->
            <li class="nav-item">
              <Link
                class="nav-link"
               
                :class="{ active: $page.url.startsWith('/admin/collection') }"
                :href="route('admin.collection.index')"
              >
                <i class="fi fi-rs-images"></i>
                <span class="nav-link-text">{{ trans("Prompt Collections") }}</span>
              </Link>
            </li>
          </ul>

          <!-- Heading -->
          <h6 class="navbar-heading p-0 text-muted mt-4">
            {{ trans("User Logs") }}
          </h6>
          <!-- Navigation -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <Link
                class="nav-link"
                :class="{
                  active: currentRoute('Admin/Logs/Notification/Index')
                }"
                :href="route('admin.notification.index')"
              >
                <i class="fi fi-rs-envelope-bulk"></i>
                <span class="nav-link-text">{{ trans("Notifications") }}</span>
              </Link>
            </li>
          </ul>
          <!-- Heading -->
          <h6 class="navbar-heading p-0 text-muted mt-4">
            {{ trans("Appearance") }}
          </h6>
          <!-- Navigation -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a
                class="nav-link"
                :class="{
                  active:
                    currentRouteGroup('Admin/Blog') ||
                    currentRouteGroup('Admin/Category') ||
                    currentRouteGroup('Admin/Tag')
                }"
                href="#navbar-forms"
                data-toggle="collapse"
                role="button"
                aria-expanded="false"
                aria-controls="navbar-forms"
              >
                <i class="fi fi-rs-blog-text"></i>
                <span class="nav-link-text">{{ trans("Blogs") }}</span>
              </a>
              <div class="collapse" id="navbar-forms">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <Link :href="route('admin.blog.index')" class="nav-link">{{
                      trans("Blogs")
                    }}</Link>
                  </li>
                  <li class="nav-item">
                    <Link
                      :href="route('admin.category.index')"
                      class="nav-link"
                      >{{ trans("Category") }}</Link
                    >
                  </li>
                  <li class="nav-item">
                    <Link :href="route('admin.tag.index')" class="nav-link">{{
                      trans("Tags")
                    }}</Link>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <Link
                class="nav-link"
                :class="{ active: currentRouteGroup('Admin/Faq') }"
                :href="route('admin.faq.index')"
              >
                <i class="fi fi-rs-comments-question-check"></i>
                <span class="nav-link-text">{{ trans("Faq") }}</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link
                class="nav-link"
                :class="{ active: currentRouteGroup('Admin/Feature') }"
                :href="route('admin.features.index')"
              >
                <i class="fi fi-rs-dice-alt"></i>
                <span class="nav-link-text">{{ trans("Steps") }}</span>
              </Link>
            </li>
          

            <li class="nav-item">
              <Link
                class="nav-link"
                :class="{ active: currentRouteGroup('Admin/Team') }"
                :href="route('admin.team.index')"
              >
                <i class="fi fi-rs-users-alt"></i>
                <span class="nav-link-text">{{ trans("Team") }}</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link
                class="nav-link"
                :class="{ active: currentRouteGroup('Admin/About') }"
                :href="route('admin.about.index')"
              >
                <i class="fi fi-rs-comment-question"></i>
                <span class="nav-link-text">{{ trans("About Us") }}</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link
                class="nav-link"
                :class="{ active: currentRouteGroup('Admin/Brand') }"
                :href="route('admin.partner.index')"
              >
                <i class="fi fi-rs-animated-icon"></i>
                <span class="nav-link-text">{{ trans("Partners") }}</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link
                class="nav-link"
                :class="{ active: currentRouteGroup('Admin/Language') }"
                :href="route('admin.language.index')"
              >
                <i class="fi fi-rs-globe"></i>
                <span class="nav-link-text">{{ trans("Language") }}</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link
                class="nav-link"
                :class="{ active: currentRouteGroup('Admin/Menu') }"
                :href="route('admin.menu.index')"
              >
                <i class="fi fi-rs-chart-tree"></i>
                <span class="nav-link-text">{{ trans("Menu") }}</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link
                class="nav-link"
                :class="{ active: currentRouteGroup('Admin/Slider') }"
                :href="route('admin.slider.index')"
              >
                <i class="fi  fi-rs-code-simple"></i>
                <span class="nav-link-text">{{ trans("Slider") }}</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link
                class="nav-link"
                :class="{ active: $page.url.startsWith('/admin/page') }"
                :href="route('admin.page.index')"
              >
                <i class="fi fi-rs-desktop-wallpaper"></i>
                <span class="nav-link-text">{{ trans("Custom Pages") }}</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link
                class="nav-link"
                :class="{ active: currentRouteGroup('Admin/Seo') }"
                :href="route('admin.seo.index')"
              >
                <i class="fi fi-rs-chart-line-up"></i>
                <span class="nav-link-text">{{ trans("Seo Settings") }}</span>
              </Link>
            </li>
          </ul>

          <h6 class="navbar-heading p-0 text-muted mt-4">
            {{ trans("Site Settings") }}
          </h6>
          <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
              <Link 
              class="nav-link" 
              :class="{ active: $page.url.startsWith('/admin/page-settings') }"
              :href="route('admin.page-settings.index')">
                <i class="fi fi-rs-magic-wand"></i>
                <span class="nav-link-text">{{ trans("Page Settings") }}</span>
              </Link>
            </li>

            <li class="nav-item">
              <a
                class="nav-link"
                :class="{
                  active:
                    currentRouteGroup('Admin/Admin') ||
                    currentRouteGroup('Admin/Role')
                }"
                href="#admin-roles"
                data-toggle="collapse"
                role="button"
                aria-expanded="false"
                aria-controls="navbar-forms"
              >
                <i class="fi fi-rs-shield-check"></i>
                <span class="nav-link-text">{{ trans("Admin and Role") }}</span>
              </a>
              <div class="collapse" id="admin-roles">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <Link :href="route('admin.admin.index')" class="nav-link">{{
                      trans("Admin")
                    }}</Link>
                  </li>
                  <li class="nav-item">
                    <Link :href="route('admin.role.index')" class="nav-link"
                      >{{ trans("Roles") }}
                    </Link>
                  </li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a
                class="nav-link"
                :class="{
                  active:
                    $page.url.startsWith('/admin/developer-settings')
                }"
                href="#dev-settings"
                data-toggle="collapse"
                role="button"
                aria-expanded="false"
                aria-controls="navbar-forms"
              >
                <i class="fi fi-rs-settings"></i>
                <span class="nav-link-text">{{
                  trans("Developer Settings")
                }}</span>
              </a>
              <div class="collapse" id="dev-settings">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <Link
                      :href="
                        route('admin.developer-settings.show', 'app-settings')
                      "
                      class="nav-link"
                    >
                      {{ trans("App Settings") }}
                    </Link>
                  </li>

                  <li class="nav-item">
                    <Link
                      :href="
                        route('admin.developer-settings.show', 'mail-settings')
                      "
                      class="nav-link"
                      >{{ trans("SMTP Settings") }}
                    </Link>
                  </li>
                  <li class="nav-item">
                    <Link
                      :href="
                        route('admin.developer-settings.show', 'social-login')
                      "
                      class="nav-link"
                      >{{ trans("Social Login Settings") }}
                    </Link>
                  </li>
                  <li class="nav-item">
                    <Link
                      :href="
                        route('admin.developer-settings.show', 'open-ai')
                      "
                      class="nav-link"
                      >{{ trans("Open Ai API") }}
                    </Link>
                  </li>
                  <li class="nav-item">
                    <Link
                      :href="
                        route('admin.developer-settings.show', 'mailchimp')
                      "
                      class="nav-link"
                      >{{ trans("Mailchimp API Settings") }}
                    </Link>
                  </li>
                  

                  <li class="nav-item">
                    <Link
                      :href="
                        route(
                          'admin.developer-settings.show',
                          'storage-settings'
                        )
                      "
                      class="nav-link"
                      >{{ trans("Storage Settings") }}
                    </Link>
                  </li>
                </ul>
              </div>
            </li>

            
          </ul>

          <h6 class="navbar-heading p-0 text-muted mt-2">
            {{ trans("My Settings") }}
          </h6>
          <!-- Navigation -->
          <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
              <Link
                class="nav-link"
                :class="{ active: currentRouteGroup('Admin/Profile') }"
                :href="route('admin.profile.setting')"
              >
                <i class="fi fi fi-rs-comment-user"></i>
                <span class="nav-link-text">{{
                  trans("Profile Settings")
                }}</span>
              </Link>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="javascript:void(0)" @click="logout">
                <i class="ni ni-button-power"></i>
                <span class="nav-link-text">{{ trans("Logout") }}</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
"use strict";
import { Link } from "@inertiajs/vue3";
import sharedComposable from "@/composables/sharedComposable";
import { trans } from "laravel-vue-i18n";
const { currentRoute, currentRouteGroup, logout } = sharedComposable()
</script>
