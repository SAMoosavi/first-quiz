<template>
    <div
        class="flex items-center min-h-screen pt-6 sm:justify-center sm:pt-0 bg-sky-200 dark:bg-gray-900"
    >
        <div
            class="w-full px-6 py-4 overflow-hidden sm:max-w-md bg-sky-50 dark:bg-sky-800 md:basis-1/2 lg:basis-1/3 md:mx-4"
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
