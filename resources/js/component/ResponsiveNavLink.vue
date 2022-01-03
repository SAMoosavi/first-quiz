<template>
    <div>
        <button v-if="button" :class="classes" class="w-full text-left">
            <slot />
        </button>

        <a v-else-if="a" :href="href" :class="classes">
            <slot />
        </a>

        <Link v-else :href="href" :class="classes">
            <slot />
        </Link>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
    components: {
        Link,
    },
    props: ["active", "href", "as"],

    setup(props) {
        const classes = props.active
            ? "block pl-3 pr-4 py-2 border-l-4 border-sky-400 dark:border-sky-50 text-base font-medium text-gray-200 dark:text-gray-700 bg-sky-800 dark:bg-sky-300 focus:outline-none focus:text-white dark:focus:text-black focus:bg-sky-800 dark:focus:bg-sky-100 focus:border-sky-700 dark:focus:border-sky-300 transition"
            : "block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-300 dark:text-gray-700 hover:text-gray-100 dark:hover:text-gray-900 hover:bg-sky-600 dark:hover:bg-sky-300 hover:border-sky-500 dark:hover:border-sky-100 focus:outline-none focus:text-white dark:focus:text-black focus:bg-sky-800 dark:focus:bg-sky-100 focus:border-sky-500 dark:focus:border-sky-50 transition";

        const button = props.as == "button" ? true : false;
        const a = props.as == "a" ? true : false;

        return {
            a,
            button,
            classes,
        };
    },
});
</script>
