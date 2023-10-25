<script setup>
"use strict";
import FrontendLayout from "@/Pages/Frontend/Layout/App.vue";
import Announcement from "@/Pages/Frontend/Home/Partials/Announcement.vue";
import { Link, useForm } from "@inertiajs/vue3";
import sharedComposable from "@/composables/sharedComposable";
const { textExcerpt } = sharedComposable();

defineOptions({ layout: FrontendLayout });
const props = defineProps([
  "blog",
  "recent_blogs",
  "categories",
  "tags",
  "seo",
  "nextBlog",
  "lastBlog",
]);

const filterData = useForm({
  search: null,
});
</script>
<template>
  <Seo :metaData="seo" />

  <!-- blog area start -->
  <section class="blog__area pt-80 pb-100">
    <div class="container">
      <div class="row">
        <div class="col-xxl-8 col-xl-8 col-lg-8">
          <div class="blog__wrapper">
            <article class="postbox__item format-image mb-40 transition-3">
              <div class="blog__grid-tag">
                <template
                  v-for="category in blog.categories"
                  :key="category.id"
                >
                  <Link
                    :href="'/category/' + category.slug + '/' + category.id"
                    >{{ category.title }}</Link
                  >
                  &nbsp;
                </template>
              </div>
              <h3 class="postbox__title">
                {{ blog.title }}
              </h3>
              <div class="blog__grid-author d-flex align-items-center mb-40">
                <div class="blog__grid-author-info">
                  <p>{{ blog.created_at_date }}</p>
                </div>
              </div>
              <div class="postbox__thumb m-img mb-30">
                <img :src="blog.preview.value" alt="" class="w-100" />
              </div>
              <div class="postbox__content">
                <div class="postbox__text text-justify base-text">
                  <p>{{ blog.short_description.value }}</p>
                </div>
                <div
                  class="postbox__text text-justify base-text blog-description-text"
                  v-html="blog.long_description.value"
                ></div>

                <div
                  class="postbox__tag-wrapper d-md-flex align-items-center justify-content-between mb-10 mt-2"
                >
                  <div class="postbox__tag tagcloud mb-30">
                    <span>{{ trans("Tags :") }}</span>

                    <template v-for="tag in blog.tags" :key="tag.id">
                      <Link :href="`/tag/${tag.slug}/${tag.id}`">{{
                        tag.title
                      }}</Link>
                    </template>
                  </div>
                  <div class="postbox__share mb-30">
                    <span>{{ trans("Share :") }}</span>
                    <a
                      :href="`https://www.facebook.com/sharer/sharer.php?u=${blog.posturl}`"
                      target="_blank"
                      ><i class="fa-brands fa-facebook-f"></i
                    ></a>
                    <a
                      :href="`https://twitter.com/intent/tweet?url=${blog.posturl}`"
                      target="_blank"
                      ><i class="fa-brands fa-twitter"></i
                    ></a>
                    <a
                      :href="`https://www.linkedin.com/sharing/share-offsite/?url=${blog.posturl}`"
                      target="_blank"
                      ><i class="fa-brands fa-linkedin-in"></i
                    ></a>
                  </div>
                </div>

                <div class="postbox__more mb-70 d-none d-md-block">
                  <div class="row">
                    <div
                      class="col-xxl-6 col-xl-6 col-md-6"
                      v-if="lastBlog != null"
                    >
                      <div
                        class="postbox__more-item d-flex align-items-center mb-35"
                      >
                        <div class="postbox__more-icon mr-15">
                          <Link :href="lastBlog.posturl"
                            ><i class="fa-regular fa-arrow-left"></i
                          ></Link>
                        </div>
                        <div class="postbox__more-content">
                          <span>{{ trans("Previous") }}</span>
                          <h3 class="postbox__more-title">
                            <Link :href="lastBlog.posturl">{{
                              textExcerpt(lastBlog.title, 28)
                            }}</Link>
                          </h3>
                        </div>
                      </div>
                    </div>

                    <div
                      :class="lastBlog != null ? 'col-xxl-6 col-xl-6 col-md-6' : 'col-xxl-12 col-xl-12 col-md-12'"
                      v-if="nextBlog != null"
                    >
                      <div
                        class="postbox__more-item next d-flex align-items-center justify-content-md-end mb-35"
                      >
                        <div class="postbox__more-content text-end mr-15">
                          <span>{{ trans("Next") }}</span>
                          <h3 class="postbox__more-title">
                            <Link :href="nextBlog.posturl">{{
                              textExcerpt(nextBlog.title, 28)
                            }}</Link>
                          </h3>
                        </div>
                        <div class="postbox__more-icon">
                          <Link :href="nextBlog.posturl"
                            ><i class="fa-regular fa-arrow-right"></i
                          ></Link>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </article>
          </div>
        </div>
        <div class="col-xxl-4 col-xl-4 col-lg-4">
          <div class="sidebar__wrapper">
            <div class="sidebar__widget mb-25">
              <h3 class="sidebar__widget-title">{{ trans("Recent Post") }}</h3>
              <div class="sidebar__widget-content">
                <div class="sidebar__search">
                  <form method="GET" @submit.prevent="filterData.get('/blogs')">
                    <div class="sidebar__search-input-2">
                      <input
                        type="text"
                        placeholder="Search"
                        v-model="filterData.search"
                      />
                      <button type="submit">
                        <i class="far fa-search"></i>
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="sidebar__widget mb-25" v-if="categories.length > 0">
              <h3 class="sidebar__widget-title">{{ trans("Category") }}</h3>
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
              <h3 class="sidebar__widget-title">{{ trans("Recent Post") }}</h3>
              <div class="sidebar__widget-content">
                <div class="sidebar__post">
                  <div
                    class="rc__post d-flex align-items-center"
                    v-for="recentBlog in recent_blogs"
                    :key="recentBlog.id"
                  >
                    <div class="rc__post-thumb mr-20">
                      <Link :href="recentBlog.posturl">
                        <img :src="recentBlog.preview.value" alt="" />
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
                          ><i class="fa-light fa-clock"></i>
                          {{ recentBlog.created_at_date }}</span
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="sidebar__widget mb-25" v-if="tags.length > 0">
              <h3 class="sidebar__widget-title">{{ trans("Tags") }}</h3>
              <div class="sidebar__widget-content">
                <div class="tagcloud">
                  <template v-for="tag in tags" :key="tag.id">
                    <Link :href="`/tag/${tag.slug}/${tag.id}`">{{
                      tag.title
                    }}</Link>
                  </template>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- marque text area start -->
  <Announcement />
  <!-- marque text area end -->
</template>
