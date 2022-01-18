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
            ? "block pl-3 pr-4 py-2 border-l-4 border-indigo-800 dark:border-indigo-200 text-base font-medium text-gray-200 dark:text-gray-700 bg-indigo-400 dark:bg-indigo-500 focus:outline-none focus:text-white dark:focus:text-black focus:bg-indigo-800 dark:focus:bg-indigo-100 focus:border-indigo-700 dark:focus:border-indigo-300 transition"
            : "block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-400 dark:text-gray-800 hover:text-gray-100 dark:hover:text-gray-900 hover:bg-indigo-400 dark:hover:bg-indigo-500 hover:border-indigo-800 dark:hover:border-indigo-200 focus:outline-none focus:text-white dark:focus:text-black focus:bg-indigo-800 dark:focus:bg-indigo-300 focus:border-indigo-800 dark:focus:border-indigo-100 transition";

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
