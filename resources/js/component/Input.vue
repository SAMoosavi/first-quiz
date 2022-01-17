<template>
    <input
        class="box-content h-6 p-2 text-gray-900 bg-transparent border-indigo-700 rounded-md shadow-sm shadow-indigo-600 dark:shadow-indigo-300 dark:text-white focus:bg-gray-400/30 dark:focus:bg-white/20 border-1 dark:border-2 dark:border-indigo-300 focus:ring-2 focus:ring-indigo-600/50 dark:focus:ring-indigo-100/50"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :type="TYPE"
    />
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
    props: ["modelValue", "type"],
    emits: ["update:modelValue"],
    setup(props) {
        const TYPE = props.type ? props.type : "text";
        return {
            TYPE,
        };
    },
});
</script>
