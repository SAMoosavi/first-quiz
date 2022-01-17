<template>
    <input type="checkbox" :value="value" v-model="proxyChecked"
           class="bg-transparent border-2 border-indigo-800 rounded-md shadow-sm shadow-indigo-700 dark:shadow-indigo-300 dark:border-indigo-400 accent-indigo-700 dark:accent-indigo-300 focus:ring-2 focus:ring-indigo-600/50 dark:focus:ring-indigo-100/50">
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    emits: ['update:checked'],

    props: {
        checked: {
            type: [Array, Boolean],
            default: false,
        },
        value: {
            default: null,
        },
    },

    computed: {
        proxyChecked: {
            get() {
                return this.checked;
            },

            set(val) {
                this.$emit("update:checked", val);
            },
        },
    },
})
</script>
