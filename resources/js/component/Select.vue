<template>
    <select
        :name="name"
        :id="id"
        class="w-full text-gray-900 bg-transparent border-indigo-700 rounded-md shadow-sm shadow-indigo-600 dark:shadow-indigo-300 dark:text-white focus:bg-gray-400/30 dark:focus:bg-white/20 border-1 dark:border-2 dark:border-indigo-300 focus:ring-2 focus:ring-indigo-600/50 dark:focus:ring-indigo-100/50"
        @input="$emit('update:modelValue', $event.target.value)"
        :required="required"
    >
        <slot />
    </select>
</template>

<script>
export default {
    props: {
        name: String,
        id: String,
        required: { required: Boolean, default: true },
    },
};
</script>

<style></style>
