<template>
    <textarea
        :name="name"
        :id="id"
        @input="$emit('update:modelValue', $event.target.value)"
        class="w-full p-2 text-gray-900 bg-transparent border-transparent border-indigo-700 rounded-md shadow-sm shadow-indigo-600 dark:shadow-indigo-300 dark:text-white focus:bg-gray-400/30 dark:focus:bg-white/20 border-1 dark:border-2 dark:border-indigo-300 focus:ring-2 focus:ring-indigo-600/50 dark:focus:ring-indigo-100/50 disabled:bg-gray-300 disabled:shadow-sm"
        :rows="rows"
        :required="required"
        :disabled="disabled"
    ></textarea>
</template>

<script>
export default {
    props: {
        name: String,
        id: String,
        disabled: { disabled: Boolean, default: false },
        required: { required: Boolean, default: true },
        rows: { rows: Number, default: 1 },
    },
};
</script>

<style></style>
