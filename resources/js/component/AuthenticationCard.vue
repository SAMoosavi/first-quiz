<template>
    <div
        class="flex items-center min-h-screen pt-6 bg-indigo-200 sm:justify-center sm:pt-0 dark:bg-slate-900"
    >
        <div
            class="w-full px-6 py-4 overflow-hidden bg-indigo-100 border border-indigo-300 rounded-lg shadow-md dark:shadow-lg shadow-indigo-500/50 dark:shadow-indigo-300/50 dark:border-indigo-500 sm:max-w-md dark:bg-indigo-700 md:basis-1/2 lg:basis-1/3 md:mx-4"
        >
            <div class="flex justify-end">
                <on-off-dark-mode class="inline-block" />
            </div>
            <slot />
        </div>
        <div
            class="items-center hidden w-full md:flex md:basis-1/2 lg:basis-2/3 sm:justify-center"
        >
            <slot name="img" />
        </div>
    </div>
</template>

<script>
import OnOffDarkMode from "@/component/OnOffDarkMode.vue";
export default {
    components: {
        OnOffDarkMode,
    },
};
</script>
