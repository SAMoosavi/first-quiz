<template>
    <app-layout title="مشاهده نتیجه آزمون">
        <template #header> مشاهده نتیجه آزمون </template>
        <div class="pt-12">
            <div class="mx-auto lg:max-w-7xl lg:px-8">
                <div
                    class="flex flex-col items-center justify-center min-h-full gap-2 p-6 overflow-hidden bg-indigo-200 shadow-md dark:bg-indigo-700 sm:rounded-md"
                >
                    <div class="flex justify-between w-full gap-2">
                        <div>
                            <h3>نام آزمون : {{ props.quiz.name }}</h3>
                        </div>
                        <div v-if="props.quiz.start">
                            <h3>شروع آزمون : {{ props.quiz.start }}</h3>
                        </div>
                        <div v-if="props.quiz.end">
                            <h3>پایان آزمون : {{ props.quiz.end }}</h3>
                        </div>
                        <div>
                            <h3>مدت آزمون : {{ props.quiz.time }}</h3>
                        </div>
                        <div>
                            <h3>مدت پاسخگویی: {{ time }}</h3>
                        </div>
                        <div>
                            <h3 v-if="props.studentQuiz.point">
                                نمره: {{ props.studentQuiz.point }}
                            </h3>
                            <h3 v-else>
                                هنوز نمره ای ثبت نشده است لطفا شکیبا باشید
                            </h3>
                        </div>
                    </div>
                    <div class="flex flex-col w-full">
                        <div
                            class="flex flex-col items-center justify-between w-full p-1 py-4 my-2 transition-all duration-200 transform border-2 border-indigo-500 border-dotted divide-indigo-500 shadow lg:flex-row group hover:scale-x-[1.03] dark:border-indigo-400 hover:border-solid shadow-transparent hover:shadow-indigo-800 dark:hover:shadow-indigo-400"
                            v-for="(question, index) in props.questions"
                            :key="index"
                        >
                            <component
                                :is="components[question.type]"
                                :question="question"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

import LongAnswer from "@/Pages/Student/TypeResult/LongAnswer.vue";
import ShortAnswer from "@/Pages/Student/TypeResult/ShortAnswer.vue";
import TestAnswer from "@/Pages/Student/TypeResult/TestAnswer.vue";


const props = defineProps(["quiz", "questions", "studentQuiz"]);

let time =
    (new Date(props.studentQuiz.end) - new Date(props.studentQuiz.start)) /
    1000;
let seconds = time % 60;
time = Math.floor(time / 60);
let minutes = time % 60;
time = Math.floor(time / 60);
let hours = time;
time = `${hours}:${minutes}:${seconds}`;

const components = {
    "long-answer": LongAnswer,
    "short-answer": ShortAnswer,
    "test-answer": TestAnswer,
};
</script>
