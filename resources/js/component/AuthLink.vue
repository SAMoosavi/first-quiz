<template>
    <Link
        :href="href"
        class="
            text-sm
            font-medium
            text-gray-400
            underline
            dark:text-gray-400
            hover:text-gray-900
            dark:hover:text-white
        "
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
