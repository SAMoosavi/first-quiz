<template>
  <button
    v-if="!loding"
    :type="type"
    class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white transition-all bg-red-800 border-2 border-red-500 rounded-md shadow dark:text-gray-900 dark:border-red-400 dark:bg-red-600 dark:hover:bg-red-400 hover:bg-red-600 active:bg-red-900 dark:active:bg-red-500 focus:outline-none focus:ring-2 dark:focus:ring-2 dark:focus:ring-red-400/50 focus:ring-red-700/50 active:pl-12 dark:active:pl-12 shadow-red-700/50 dark:shadow-red-200/50"
  >
    <slot></slot>
  </button>
  <button
    v-else
    disabled
    :type="type"
    class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white transition-all bg-red-900 border-2 border-red-500 rounded-md outline-none dark:text-gray-900 dark:border-red-400 dark:bg-red-500 ring-2 dark:ring-red-400/50 ring-red-700/50"
  >
    <slot></slot>
    <svg
      class="w-4 h-4 ml-1 mr-3 text-white dark:text-gray-900 animate-spin"
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 24 24"
    >
      <circle
        class="opacity-50"
        cx="12"
        cy="12"
        r="10"
        stroke="currentColor"
        stroke-width="4"
      ></circle>
      <path
        class="opacity-75"
        fill="currentColor"
        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
      ></path>
    </svg>
  </button>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  props: {
    type: {
      type: String,
      default: "submit",
    },
    loding: Boolean,
  },
});
</script>
