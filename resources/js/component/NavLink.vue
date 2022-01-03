<template>
    <Link :href="href" :class="classe">
        <slot />
    </Link>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Link,
    },
    props: ["href", "active"],

    setup(props) {
        const classe = props.active
            ? "inline-flex items-center px-1 pt-1 border-b-2 border-white dark:border-black text-sm font-medium leading-5 text-white dark:text-black focus:outline-none transition"
            : "inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 dark:text-gray-700 text-gray-300 dark:hover:text-gray-900 hover:text-gray-100 dark:hover:border-gray-700 hover:border-gray-200 focus:outline-none dark:focus:text-black focus:text-white dark:focus:border-black focus:border-white transition";

        return { classe };
    },
};
</script>
