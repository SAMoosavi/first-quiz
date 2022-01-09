<template>
    <label
        :class="`block text-sm font-medium text-gray-700 dark:text-gray-200 ${required}`"
    >
        <span v-if="value">{{ value }}</span>
        <span v-else><slot></slot></span>
    </label>
</template>

<script>
import { defineComponent, ref, watch } from "vue";

export default defineComponent({
    props: ["value", "required"],
    setup(props) {
        let required = ref("");
        if (!!props.required) {
            required.value =
                "after:content-['*'] after:mr-0.5 after:text-red-500";
        }
        watch(
            () => props.required,
            () => {
                if (!!props.required) {
                    required.value =
                        "after:content-['*'] after:mr-0.5 after:text-red-500";
                }
            }
        );
        return {
            required,
        };
    },
});
</script>
