<script setup>
"use strict";
import FrontendLayout from '@/Pages/Frontend/Layout/App.vue'
import Announcement from '@/Pages/Frontend/Home/Partials/Announcement.vue'
import BlogCard from '@/Pages/Frontend/Blog/Partials/BlogCard-1.vue'
import Paginate from '@/components/Paginate.vue'
import { Link, useForm } from '@inertiajs/vue3'
import sharedComposable from '@/composables/sharedComposable'
const { textExcerpt } = sharedComposable()

defineOptions({ layout: FrontendLayout })
const props = defineProps([
  'blogs',
  'request',
  'recent_blogs',
  'categories',
  'tags',
  'seo',
  'breadcrumb'
])

const filterData = useForm({
  search: props.request.search
})
</script>
<template>
  <Seo :metaData="seo" />

  <!-- breadcrumb area start -->
  <section class="breadcrumb__area breadcrumb__border pt-160 pb-85 p-relative">
    <div class="breadrumb__shape">
      <img class="breadcrumb__shape-1" v-lazy="props.breadcrumb" alt="" />
    </div>
    <div class="container">
      <div class="row">
        <div class="col-xxl-12">
          <div class="breadcrumb__content text-center">
            <h3 class="breadcrumb__title">{{ props.seo.site_name }}</h3>
            <div class="breadcrumb__list">
              <span
                ><Link href="/">{{ trans('Home') }}</Link></span
              >
              <span class="dvdr tp-dot"><i class="fa-solid fa-period"></i></span>
              <span>{{ trans('Blogs') }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- breadcrumb area end -->

  <!-- blog area start -->
  <section class="blog__area pt-80 pb-90">
    <div class="container">
      <div class="row">
        <div class="col-xxl-8 col-xl-8 col-lg-8">
          <div class="blog__wrapper">
            <div class="row">
              <template v-for="blog in props.blogs.data" :key="blog">
                <BlogCard :data="blog" />
              </template>
            </div>
            <div class="row">
              <div class="col-xxl-12">
                <Paginate :links="blogs.links" />
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-4 col-xl-4 col-lg-4">
          <div class="sidebar__wrapper">
            <div class="sidebar__widget mb-25">
              <h3 class="sidebar__widget-title">{{ trans('Recent Post') }}</h3>
              <div class="sidebar__widget-content">
                <div class="sidebar__search">
                  <form method="GET" @submit.prevent="filterData.get('/blogs')">
                    <div class="sidebar__search-input-2">
                      <input type="text" placeholder="Search" v-model="filterData.search" />
                      <button type="submit">
                        <i class="far fa-search"></i>
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="sidebar__widget mb-25" v-if="categories.length > 0">
              <h3 class="sidebar__widget-title">{{ trans('Category') }}</h3>
              <div class="sidebar__widget-content">
                <ul>
                  <li>
                    <template v-for="category in categories" :key="category.id">
                      <Link :href="`/category/${category.slug}/${category.id}`"
                        >{{ category.title
                        }}<span class="category-number"
                          >({{ category.postcategories_count }})</span
                        ></Link
                      >
                    </template>
                  </li>
                </ul>
              </div>
            </div>
            <div class="sidebar__widget mb-25" v-if="recent_blogs.length > 0">
              <h3 class="sidebar__widget-title">{{ trans('Recent Post') }}</h3>
              <div class="sidebar__widget-content">
                <div class="sidebar__post">
                  <div
                    class="rc__post d-flex align-items-center"
                    v-for="recentBlog in recent_blogs"
                    :key="recentBlog.posturl"
                  >
                    <div class="rc__post-thumb mr-20">
                      <Link :href="recentBlog.posturl">
                        <img lazy="loading" v-lazy="recentBlog.preview.value" alt="" />
                      </Link>
                    </div>
                    <div class="rc__post-content">
                      <h3 class="rc__post-title">
                        <Link :href="recentBlog.posturl">{{
                          textExcerpt(recentBlog.title, 30)
                        }}</Link>
                      </h3>
                      <div class="rc__meta">
                        <span
                          ><i class="fa-light fa-clock"></i> {{ recentBlog.created_at_date }}</span
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="sidebar__widget mb-25" v-if="tags.length > 0">
              <h3 class="sidebar__widget-title">{{ trans('Tags') }}</h3>
              <div class="sidebar__widget-content">
                <div class="tagcloud">
                  <template v-for="tag in tags" :key="tag.id">
                    <Link :href="`/tag/${tag.slug}/${tag.id}`">{{ tag.title }}</Link>
                  </template>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <Announcement />
  <!-- marque text area end -->
</template>
