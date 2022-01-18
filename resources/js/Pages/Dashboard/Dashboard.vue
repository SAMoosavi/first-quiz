<template>
    <app-layout title="داشبورد">
        <template #header> داشبورد </template>

        <div class="md:pt-8">
            <div class="mx-auto lg:max-w-7xl lg:px-8">
                <div
                    class="grid min-h-full grid-cols-1 gap-2 p-2 overflow-hidden border-indigo-500 shadow-lg md:border bg-indigo-300/70 dark:bg-indigo-500/70 sm:rounded-none lg:rounded-xl md:grid-cols-2 shadow-indigo-800 dark:shadow-indigo-400 dark:border-indigo-500"
                >
                    <div
                        class="p-2 border-2 border-indigo-400 border-dashed shadow-lg shadow-transparent dark:border-indigo-400 group hover:border-indigo-500 hover:border-solid hover:shadow-indigo-600 dark:hover:shadow-indigo-500"
                    >
                        <Participant :participants="participants" />
                    </div>
                    <div
                        class="p-2 border-2 border-indigo-400 border-dashed shadow-lg shadow-transparent dark:border-indigo-400 group hover:border-indigo-500 hover:border-solid hover:shadow-indigo-600 dark:hover:shadow-indigo-500"
                    >
                        <Maker :makers="makers" />
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Participant from "@/Pages/Dashboard/Participant.vue";
import Maker from "@/Pages/Dashboard/Maker.vue";

export default defineComponent({
    components: {
        AppLayout,
        Participant,
        Maker,
    },
    props: ["makers", "participants"],
});
</script>
