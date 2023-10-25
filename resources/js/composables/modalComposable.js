"use strict";

import { reactive } from "vue"
import { router } from "@inertiajs/vue3"
import { createToast } from "mosha-vue-toastify"

export const modal = reactive({
  state: false,
  link: null,
  method: "delete",
  data: null,
  message: "You want to delete this?",
  btnText: "Yes, delete it!",

  initiate(link, method, data) {
    this.link = link
    if (method && data) {
      this.message = "You want to proceed with this?"
      this.btnText = "Yes, do it!"
      this.method = method
      this.data = data
    }
    this.state = true
  },

  async accept() {
    const validMethods = ["post", "put", "patch"]
    const { method, link, data } = this

    if (validMethods.includes(method)) {
      await router[method](link, data, {
        onSuccess: () =>
          this.showToast("Congratulations", "Submitted Successfully")
      })
    } else {
      await router.delete(link, {
        onSuccess: () => this.showToast("Success", "Deleted Successfully")
      })
    }

    this.state = false
  },

  reset() {
    Object.assign(this, {
      link: null,
      state: false,
      method: "delete",
      data: null,
      message: "You want to delete this?",
      btnText: "Yes, delete it!"
    })
  },

  showToast(title, description) {
    createToast({ title, description })
  }
})
