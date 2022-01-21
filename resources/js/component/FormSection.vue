<template>
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <section-title>
            <template #title><slot name="title"></slot></template>
            <template #description><slot name="description"></slot></template>
        </section-title>

        <div
            class="mt-5 bg-indigo-100 border border-indigo-300 rounded-lg shadow-md md:col-span-2 verflow-hidden dark:shadow-lg shadow-indigo-500/50 dark:shadow-indigo-300/50 dark:border-indigo-500 dark:bg-indigo-700"
        >
            <form @submit.prevent="$emit('submitted')">
                <div
                    class="px-4 py-5 sm:p-6"
                    :class="
                        hasActions
                            ? 'sm:rounded-tl-md sm:rounded-tr-md'
                            : 'sm:rounded-md'
                    "
                >
                    <div class="grid grid-cols-5 gap-6">
                        <slot name="form"></slot>
                    </div>
                </div>

                <div
                    class="flex items-center justify-end px-4 py-3 text-right b sm:px-6 sm:rounded-bl-md sm:rounded-br-md"
                    v-if="hasActions"
                >
                    <slot name="actions"></slot>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import SectionTitle from "@/component/SectionTitle.vue";

export default defineComponent({
    emits: ["submitted"],

    components: {
        SectionTitle,
    },

    computed: {
        hasActions() {
            return !!this.$slots.actions;
        },
    },
});
</script>
