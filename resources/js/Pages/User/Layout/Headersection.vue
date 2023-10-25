<template>
  <!-- Top nav -->
  <nav
    class="navbar navbar-top navbar-expand navbar-light bg-secondary border-bottom"
  >
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Search form -->
        <!-- Navbar links -->
        <ul class="navbar-nav align-items-center ml-md-auto">
          <li class="nav-item d-xl-none">
            <!-- Sidenav toggler -->
            <div
              class="pr-3 sidenav-toggler sidenav-toggler-light"
              data-action="sidenav-pin"
              data-target="#sidenav-main"
            >
              <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
              </div>
            </div>
          </li>
          <template
            v-if="
              currentRouteGroup('User') &&
              $page.props.notifications.list.length > 0
            "
          >
            <li class="nav-item dropdown notifications-icon">
              <a
                class="nav-link"
                href="#"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="ni ni-bell-55"></i>
              </a>
              <div
                class="dropdown-menu dropdown-menu-xl dropdown-menu-right py-0 overflow-hidden"
              >
                <!-- Dropdown header -->
                <div class="px-3 py-3">
                  <h6 class="text-sm text-muted m-0">
                    {{ trans("You have") }}
                    <strong class="text-primary notification-count">
                      {{ $page.props.notifications.unread }}
                    </strong>
                    {{ trans("notifications.") }}
                  </h6>
                </div>
                <!-- List group -->
                <div class="list-group list-group-flush notifications-list">
                  <template
                    v-for="list in $page.props.notifications.list"
                    :key="list"
                  >
                    <Link
                      method="put"
                      as="button"
                      :href="list.url"
                      class="list-group-item list-group-item-action"
                    >
                      <div class="row align-items-center">
                        <div class="col ml-2">
                          <div
                            class="d-flex justify-content-between align-items-center"
                          >
                            <div>
                              <h4 class="mb-0 text-sm">{{ list.title }}</h4>
                            </div>
                            <div class="text-right text-muted">
                              <small>{{ list.created_at }}</small>
                            </div>
                          </div>
                          <p class="text-sm mb-0">
                            {{ list.comment != null ? list.comment : "" }}
                          </p>
                        </div>
                      </div>
                    </Link>
                  </template>
                </div>
                <!-- View all -->
              </div>
            </li>
          </template>
          <!-- start -->
          <div class="navbar-nav align-items-center ml-md-auto">
            <div class="card-header-action dropdown">
              <button
                data-toggle="dropdown"
                class="btn btn-neutral btn-sm dropdown-toggle overview-target"
              >
                {{ $page.props.languages[$page.props.locale] }}
              </button>
              <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                <li v-for="(language, key) in $page.props.languages" :key="key">
                  <Link
                    as="button"
                    :href="route('set-locale', key)"
                    method="patch"
                    class="dropdown-item overview-list"
                    data-type="Weekly"
                  >
                    {{ trans(language) }}
                  </Link>
                </li>
              </ul>
            </div>
          </div>
        </ul>

        <!-- finish -->
        <ul class="navbar-nav align-items-center ml-auto ml-md-0">
          <li class="nav-item dropdown">
            <a
              class="nav-link pr-0"
              href="#"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <img
                    alt="avatar"
                    :src="
                      authUser.avatar == null
                        ? `https://ui-avatars.com/api/?name=${authUser.name}`
                        : `${authUser.avatar}`
                    "
                  />
                </span>
                <div class="media-body ml-2 d-none d-lg-block">
                  <span class="mb-0 text-sm font-weight-bold">{{
                    authUser.name
                  }}</span>
                </div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-header noti-title">
                <h6 class="text-overflow m-0">{{ trans("Welcome!") }}</h6>
              </div>
              <Link href="/user/profile" class="dropdown-item">
                <i class="ni ni-single-02"></i>
                <span>{{ trans("My profile") }}</span>
              </Link>

              <template v-if="currentRouteGroup('User')">
                <Link href="/user/subscription" class="dropdown-item">
                  <i class="ni ni-settings-gear-65"></i>
                  <span>{{ trans("Subscription") }}</span>
                </Link>
                <Link href="/user/auth-key" class="dropdown-item">
                  <i class="fas fa-code"></i>
                  <span>{{ trans("Auth Key") }}</span>
                </Link>
              </template>

              <Link href="/user/support" class="dropdown-item">
                <i class="ni ni-support-16"></i>
                <span>{{ trans("Support") }}</span>
              </Link>
              <div class="dropdown-divider"></div>
              <a
                class="dropdown-item logout-button"
                href="javascript:void(0)"
                @click="logout"
              >
                <i class="ni ni-user-run"></i>
                <span>{{ trans("Logout") }}</span>
              </a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script setup>
"use strict";
import sharedComposable from '@/composables/sharedComposable';

const { currentRouteGroup, authUser,logout } = sharedComposable()
</script>