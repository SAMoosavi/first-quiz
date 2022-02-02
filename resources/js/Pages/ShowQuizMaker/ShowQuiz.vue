<template>
    <app-layout title="ساخت آزمون">
        <template #header> مشاهده آزمون </template>
        <div class="relative pt-12">
            <div class="mx-auto lg:max-w-7xl lg:px-8">
                <div
                    class="min-h-full p-6 bg-indigo-200 shadow-md dark:bg-indigo-700 sm:rounded-md"
                >
                    <div class="flex items-center justify-between">
                        <h2>نام آرمون: {{ quiz.name }}</h2>
                        <h3 v-if="quiz.start">
                            زمان شروع آزمون: {{ quiz.start }}
                        </h3>
                        <h3 v-if="quiz.end">
                            زمان پایان آزمون: {{ quiz.end }}
                        </h3>
                        <h3>مدت زمان آزمون: {{ quiz.time }}</h3>
                    </div>
                    <div class="mt-4">
                        <my-button
                            :loding="loding"
                            type="button"
                            @click="showQuiztions"
                        >
                            <span v-if="!show">مشاهده کردن</span>
                            <span v-else>مخفی کردن</span>
                            سوالات
                        </my-button>
                    </div>
                    <template v-if="show">
                        <div
                            class="flex-col items-center justify-between w-full p-1 py-4 my-2 transition-all duration-200 transform border-2 border-indigo-500 border-dotted divide-indigo-500 shadow lg:flex-row group hover:scale-x-[1.03] dark:border-indigo-400 hover:border-solid shadow-transparent hover:shadow-indigo-800 dark:hover:shadow-indigo-400"
                            v-for="(question, index) in quiz.questions"
                            :key="index"
                        >
                            <component
                                :is="components[question.type]"
                                :question="question"
                                :index="index"
                            />
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import LongAnswer from "@/Pages/ShowQuizMaker/Type/LongAnswer.vue";
import ShortAnswer from "@/Pages/ShowQuizMaker/Type/ShortAnswer.vue";
import TestAnswer from "@/Pages/ShowQuizMaker/Type/TestAnswer.vue";
import MyButton from "@/component/Button.vue";
import { ref } from "@vue/reactivity";

defineProps(["quiz"]);

const components = {
    "long-answer": LongAnswer,
    "short-answer": ShortAnswer,
    "test-answer": TestAnswer,
};

const loding = ref(false);
const show = ref(1);
function showQuiztions() {
    loding.value = true;
    setTimeout(() => {
        show.value = !show.value;
        loding.value = false;
    }, 300);
}
</script>
