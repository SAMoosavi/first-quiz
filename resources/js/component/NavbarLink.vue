<template>
    <Link :href="href" class="mx-4 text-gray-200 dark:text-gray-700">
        <slot></slot>
    </Link>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
export default {
    components: {
        Link,
    },
    props: ["href"],
};
</script>

<style></style>
