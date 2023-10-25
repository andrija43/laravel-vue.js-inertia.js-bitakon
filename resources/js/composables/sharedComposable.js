"use strict";

import { usePage, router } from "@inertiajs/vue3"
import { computed } from "vue"
import { createToast } from "mosha-vue-toastify"
import { modal } from "@/composables/modalComposable"

export default () => {
  //return string with limit
  const textExcerpt = (text, length) => {
    if(text == '' || text == null){
      return '';
    }
    return text.length > length ? text.substring(0, length) + "..." : text
  }

  //get current route
  const currentRoute = (route) => {
    return usePage().component === route
  }

  const currentRouteGroup = (route) => {
    return usePage().component.startsWith(route)
  }

  //get auth user information's
  const authUser = computed(() => {
    return usePage().props.user
  })

  //sent logout request
  const logout = () => {
    router.post("/logout")
  }

  //copy text
  function copyToClipboard(text) {
    navigator.clipboard.writeText(text)
  }

  const pickBy = (obj) => {
    const result = {}

    for (const key in obj) {
      const value = obj[key]

      if (value !== undefined && value !== null && value !== "") {
        if (Array.isArray(value) && value.length === 0) {
          continue // Skip empty arrays
        } else if (
          typeof value === "object" &&
          Object.keys(value).length === 0
        ) {
          continue // Skip empty objects
        }

        result[key] = value
      }
    }

    return result
  }

  //return formatted currency amount
  const formatCurrency = (amount = 0, iconType = "name") => {
    let formattedCurrency = ""
    const currency = usePage().props.currency
    if (iconType === "name") {
      formattedCurrency =
        currency.position === "right"
          ? currency.name + " " + amount.toFixed(2)
          : currency.icon + " " + amount.toFixed(2)
    } else if (iconType === "both") {
      formattedCurrency =
        currency.icon + amount.toFixed(2) + " " + currency.name
    } else {
      formattedCurrency =
        currency.position === "right"
          ? amount.toFixed(2) + currency.icon
          : currency.icon + amount.toFixed(2)
    }

    return formattedCurrency
  }

  //return toast alert message
  const ToastAlert = (
    title = "Congratulations",
    description = "Operation Success",
    alertType = "default"
  ) => {
    createToast(
      {
        title: title,
        description: description
      },
      {
        transition: "slide",
        position: "top-right",
        type: alertType
      }
    )
  }
  return {
    authUser,
    textExcerpt,
    currentRoute,
    currentRouteGroup,
    logout,
    copyToClipboard,
    pickBy,
    formatCurrency,
    ToastAlert,
    modal
  }
}
