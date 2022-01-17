<template>
    <Link
        :method="method"
        :href="href"
        class="text-sm font-medium text-gray-400 underline decoration-dashed hover:decoration-solid focus:decoration-solid underline-offset-4 dark:text-gray-400 hover:text-gray-900 focus:text-gray-900 dark:focus:text-white dark:hover:text-white hover:decoration-purple-700 focus:decoration-purple-700 dark:hover:decoration-purple-400 dark:focus:decoration-purple-400"
    >
        <slot />
    </Link>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
export default {
    components: {
        Link,
    },
    props: {
        href: String,
        method: {
            method: String,
            default: "get",
        },
    },
};
</script>

<style></style>
