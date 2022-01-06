<template>
    <app-layout title="داشبورد">
        <template #header> داشبورد </template>

        <div class="pt-12 ">
            <div class="lg:max-w-7xl mx-auto lg:px-8 ">
                <div
                    class="bg-sky-200 dark:bg-sky-700 overflow-hidden shadow-none sm:rounded-none grid grid-cols-1 md:grid-cols-2 p-2 gap-2 min-h-full"
                >
                    <div class="border-2 border-sky-400 dark:border-sky-600  border-dashed  group  hover:border-sky-500  hover:border-solid p-2">
                        <Participant :participants="participants" />
                    </div>
                    <div class="border-2 border-sky-400 dark:border-sky-600  border-dashed  group  hover:border-sky-500  hover:border-solid p-2">
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
