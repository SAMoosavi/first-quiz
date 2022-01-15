<template>
    <input
        class="box-content h-6 p-2 border-none focus:ring focus:ring-sky-400 dark:focus:ring-sky-300 focus:ring-opacity-30 dark:focus:ring-opacity-80"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"
    />
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
    props: ["modelValue"],

    emits: ["update:modelValue"],

    methods: {
        focus() {
            this.$refs.input.focus();
        },
    },
});
</script>
