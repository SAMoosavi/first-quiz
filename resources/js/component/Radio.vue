<template>
    <input
        type="radio"
        @input="$emit('update:modelValue', $event.target.value)"
        :value="value"
        :name="name"
        class="p-2 text-indigo-700 bg-transparent border-indigo-700 rounded-full shadow-sm disabled:bg-gray-300 disabled:shadow-sm shadow-indigo-600 dark:shadow-indigo-300 dark:text-indigo-300 focus:bg-gray-400/30 dark:focus:bg-white/20 border-1 dark:border-2 dark:border-indigo-300 focus:ring-2 focus:ring-indigo-600/50 dark:focus:ring-indigo-100/50"
    />
</template>

<script>
export default {
    props: ["value", "name"],
};
</script>

<style></style>
