"use strict";

import "./bootstrap"
import "../css/app.css"

import { createSSRApp, h } from "vue"
import { createInertiaApp } from "@inertiajs/vue3"
import Layout from "@/components/Layout.vue"
import Seo from "@/Pages/Frontend/Layout/Seo.vue"
import { i18nVue, trans } from "laravel-vue-i18n"
import "mosha-vue-toastify/dist/style.css"
import { Link } from "@inertiajs/vue3"
import VueCountdown from "@chenfengyuan/vue-countdown"
import VueLazyLoad from "vue3-lazyload"

createInertiaApp({
  progress: {
    color: "#9999f0",
    showSpinner: true
  },
  title: (title) => `${title}`,
  resolve: (name) => {
    const pages = import.meta.glob("./Pages/**/*.vue", { eager: true })
    const page = pages[`./Pages/${name}.vue`]
    page.default.layout = page.default.layout ?? Layout
    return page
  },
  setup({ el, App, props, plugin }) {
    return createSSRApp({ render: () => h(App, props) })
      .mixin({ methods: { trans, route: window.route } })
      .use(i18nVue, {
        resolve: async (lang) => {
          const langs = import.meta.glob("../../lang/*.json")
          return await langs[`../../lang/${lang}.json`]()
        }
      })
      .component("Link", Link)
      .component("Seo", Seo)
      .component(VueCountdown.name, VueCountdown)
      .use(VueLazyLoad)
      .use(plugin)
      .mount(el)
  }
})
