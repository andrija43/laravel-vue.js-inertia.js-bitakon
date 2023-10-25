<template>
  <div v-if="type == 'icon'" class="breadcrumb__title text-center">
    <img width="200" src="/assets/img/empty.png" alt="image" />
    <h4 class="wallet__title mt-10">
      {{ trans(message) }}
    </h4>

    <Link
      :href="href"
      class="tp-btn-2 w-25 text-center header__wallet-btn mb-20"
    >
      {{ trans(btnText) }}
    </Link>
  </div>
  <div v-if="type == 'text'" class="text-center mt-10 pb-5">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      version="1.1"
      xmlns:xlink="http://www.w3.org/1999/xlink"
      xmlns:svgjs="http://svgjs.com/svgjs"
      width="150"
      height="100"
      x="0"
      y="0"
      viewBox="0 0 48 48"
      style="enable-background: new 0 0 512 512"
      xml:space="preserve"
      class=""
    >
      <g>
        <linearGradient
          id="a"
          x1="28.5"
          x2="28.5"
          y1="25"
          y2="20"
          gradientUnits="userSpaceOnUse"
        >
          <stop offset="0" stop-color="#54a5ff"></stop>
          <stop offset="1" stop-color="#8ad3fe"></stop>
        </linearGradient>
        <linearGradient
          id="b"
          x1="34"
          x2="30"
          y1="4"
          y2="4"
          gradientUnits="userSpaceOnUse"
        >
          <stop offset="0" stop-color="#fe9661"></stop>
          <stop offset="1" stop-color="#ffb369"></stop>
        </linearGradient>
        <linearGradient
          xlink:href="#a"
          id="c"
          x1="10"
          x2="10"
          y1="31"
        ></linearGradient>
        <linearGradient
          xlink:href="#a"
          id="d"
          x1="18.5"
          x2="18.5"
          y1="47"
          y2="25"
        ></linearGradient>
        <linearGradient
          xlink:href="#a"
          id="e"
          x1="32"
          x2="42"
          y1="33.5"
          y2="33.5"
        ></linearGradient>
        <linearGradient
          xlink:href="#b"
          id="f"
          x1="8"
          x2="14"
          y1="42"
          y2="42"
        ></linearGradient>
        <g data-name="Empty Box">
          <path
            fill="url(#a)"
            d="M15 20h27v5H15z"
            data-original="url(#a)"
          ></path>
          <path
            fill="#d7e9f7"
            d="M35.53 2.71C34.63 1.64 33 .84 32 1.78c-.95-.93-2.6-.16-3.53.93-1.07 1.29-1.25 2.87-.41 3.58s2.4.27 3.47-1c.78-.93.16-.93.94 0 1.07 1.27 2.62 1.71 3.47 1s.66-2.29-.41-3.58z"
            data-original="#d7e9f7"
            class=""
          ></path>
          <ellipse
            cx="32"
            cy="4"
            fill="url(#b)"
            rx="2"
            ry="3"
            data-original="url(#b)"
          ></ellipse>
          <path
            fill="url(#c)"
            d="M15 26 5 31v-6l10-5z"
            data-original="url(#c)"
          ></path>
          <path
            fill="url(#d)"
            d="M5 25h27v22H7a2 2 0 0 1-2-2V25z"
            data-original="url(#d)"
          ></path>
          <path
            fill="url(#e)"
            d="M40.89 42.55 32 47V25l10-5v20.76a2 2 0 0 1-1.11 1.79z"
            data-original="url(#e)"
          ></path>
          <path
            fill="#8ad3fe"
            d="m32 25-2.76 7.35a1 1 0 0 1-.93.65H3.44a1 1 0 0 1-.93-1.35L5 25zM45.11 28.45l-8.22 4.1a1 1 0 0 1-1.34-.44L32 25l10-5 3.55 7.11a1 1 0 0 1-.44 1.34z"
            data-original="#8ad3fe"
          ></path>
          <path
            fill="#d7e9f7"
            d="M20 23a1 1 0 0 1-1-1v-7a3 3 0 0 1 3-3h8a1 1 0 0 0 1-1v-1a1 1 0 0 1 2 0v1a3 3 0 0 1-3 3h-5.17A3 3 0 0 1 21 17.83V22a1 1 0 0 1-1 1zm1-8a1 1 0 1 0 1-1 1 1 0 0 0-1 1z"
            data-original="#d7e9f7"
            class=""
          ></path>
          <g fill="#ffb369">
            <path
              d="M14 13a1 1 0 1 1 1-1 1 1 0 0 1-1 1zM34 18a1 1 0 1 1 1-1 1 1 0 0 1-1 1zM39 10a1 1 0 1 1 1-1 1 1 0 0 1-1 1z"
              fill="#ffb369"
              data-original="#ffb369"
            ></path>
          </g>
          <rect
            width="6"
            height="4"
            x="8"
            y="40"
            fill="url(#f)"
            rx="1"
            data-original="url(#f)"
          ></rect>
          <path
            fill="#f0f7fc"
            d="M11 38H9a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2z"
            data-original="#f0f7fc"
          ></path>
        </g>
      </g>
    </svg>
    <h5 class="base-text text-center mt-3">
      {{ trans(message) }}
    </h5>
  </div>
</template>

<script setup>
"use strict";
defineProps({
  type: {
    default: "icon"
  },
  href: {
    default: "/"
  },
  btnText: {
    default: "Lets Fill It Up!"
  },
  message: {
    default: "Basket Is Feeling Lonely"
  }
})
</script>
