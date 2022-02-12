<template>
    <app-layout title="زمان شروع آزمون">
        <template #header> زمان شروع آزمون </template>
        <div class="pt-12">
            <div class="mx-auto lg:max-w-7xl lg:px-8">
                <div
                    class="min-h-full gap-2 p-6 overflow-hidden bg-indigo-200 shadow-md dark:bg-indigo-700 sm:rounded-md flex justify-center items-center"
                >
                    <div
                        class="bg-red-300 p-4 border border-red-500 rounded-md shadow-md shadow-red-300/50"
                    >
                        <h1 class="text-red-700 text-center font-medium">
                            آزمون هنوز شروع نشده است
                        </h1>
                        <p class="text-center text-red-500 font-light mx-10">
                            زمان مانده تا شروع آزمون
                            <countdown-timer
                                @finish="finish"
                                :now="now"
                                :start="start"
                            />
                        </p>
                    </div>
                    <a :href="route('ans.quiz', [uuid])" ref="tagA"></a>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import CountdownTimer from "@/component/CountdownTimer.vue";
import { ref } from "@vue/reactivity";

const props = defineProps(["start", "now", "uuid"]);
let tagA = ref();
function finish() {
    tagA.value.click();
}
</script>
