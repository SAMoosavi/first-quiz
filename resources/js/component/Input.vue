<template>
    <div
        class="relative p-0 m-0 overflow-hidden text-gray-900 bg-transparent border border-indigo-700 rounded-lg shadow-sm shadow-indigo-600 dark:shadow-indigo-300 disabled:bg-gray-300 dark:text-white focus:bg-gray-400/30 dark:focus:bg-white/20 dark:border-2 dark:border-indigo-300 focus:ring-2 focus:ring-indigo-600/50 dark:focus:ring-indigo-100/50"
    >
        <input
            class="w-full p-2 text-gray-900 bg-transparent disabled:bg-gray-300 dark:text-white focus:bg-gray-400/30 dark:focus:bg-white/20 focus:ring-2 focus:ring-indigo-600/50 dark:focus:ring-indigo-100/50"
            :class="{ 'pr-12': icon }"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            :type="type"
            :required="required"
            :disabled="disabled"
        />
        <div
            v-if="icon"
            class="absolute top-0 right-0 p-2 pb-3 text-white bg-indigo-700 dark:text-black dark:bg-indigo-300"
        >
            <slot />
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
    props: {
        modelValue: String,
        type: { default: "text", type: String },
        disabled: { disabled: Boolean, default: false },
        required: { required: Boolean, default: true },
        icon: { icon: Boolean, default: false },
    },
    emits: ["update:modelValue"],
});
</script>
