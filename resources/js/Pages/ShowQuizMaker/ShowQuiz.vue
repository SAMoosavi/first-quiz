<template>
    <app-layout title="ساخت آزمون">
        <template #header> مشاهده آزمون </template>
        <div class="relative pt-12">
            <div class="mx-auto transition lg:max-w-7xl lg:px-8">
                <div
                    class="p-6 bg-indigo-200 shadow-md dark:bg-indigo-700 sm:rounded-md"
                >
                    <!-- Show Quiz And Edition -->
                    <quiz :quiz="quiz" />
                    
                    <!-- Show Link Of Quiz -->
                    <div>
                        <a :href="route('ans.quiz', { uuid: quiz.uuid })">
                            <p>
                                لینک آزمون:
                                <br />
                                <span>{{
                                    route("ans.quiz", { uuid: quiz.uuid })
                                }}</span>
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Quiz from "@/Pages/ShowQuizMaker/Quiz.vue";

import { reactive, ref } from "@vue/reactivity";
import { useForm } from "@inertiajs/inertia-vue3";
import { useToast } from "vue-toastification";

const props = defineProps(["quiz"]);
</script>
