<template>
    <option
        :value="value"
        class="bg-indigo-200 dark:bg-indigo-700 text-gray-900 dark:text-gray-200 hover:bg-indigo-400 dark:hover:bg-indigo-500"
    >
        <slot />
    </option>
</template>

<script>
export default {
    props: ["value"],
};
</script>

<style></style>
