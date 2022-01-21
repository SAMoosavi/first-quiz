<template>
    <button
        :type="type"
        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white transition-all bg-indigo-800 border-2 border-indigo-500 rounded-md shadow dark:text-gray-900 dark:border-indigo-400 dark:bg-indigo-600 dark:hover:bg-indigo-400 hover:bg-indigo-600 active:bg-indigo-900 dark:active:bg-indigo-500 focus:outline-none focus:ring-2 dark:focus:ring-2 dark:focus:ring-indigo-400/50 focus:ring-indigo-700/50 shadow-indigo-700/50 dark:shadow-indigo-200/50"
    >
        <slot></slot>
    </button>
</template>

<script>
export default {
    props: {
        type: {
            type: String,
            default: "button",
        },
    },
};
</script>
