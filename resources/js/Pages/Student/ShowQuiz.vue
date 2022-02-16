<template>
    <app-layout title="ساخت آزمون">
        <template #header> ساخت آزمون </template>
        <div class="pt-12">
            <div class="mx-auto lg:max-w-7xl lg:px-8">
                <div
                    class="min-h-full gap-2 p-6 overflow-hidden bg-indigo-200 shadow-md dark:bg-indigo-700 sm:rounded-md"
                >
                    <div class="flex items-center justify-between">
                        <h2>نام آرمون: {{ quiz.name }}</h2>

                        <countdown-timer
                            :time="quiz.time"
                            @finish="finish"
                            :now="now"
                            :start="start"
                        />
                    </div>
                    <div
                        class="flex flex-col items-center justify-between w-full p-1 py-4 my-2 transition-all duration-200 transform border-2 border-indigo-500 border-dotted divide-indigo-500 shadow lg:flex-row group hover:scale-x-[1.03] dark:border-indigo-400 hover:border-solid shadow-transparent hover:shadow-indigo-800 dark:hover:shadow-indigo-400"
                        v-for="(question, index) in questions"
                        :key="index"
                    >
                        <component
                            :is="components[question.type]"
                            :question="question"
                            :in="index"
                        />
                    </div>
                    <div>
                        <my-button
                            class="mr-4"
                            :disabled="form.processing"
                            @click="sendOk = true"
                        >
                            ارسال
                        </my-button>
                    </div>
                    <div
                        v-if="sendOk"
                        class="absolute top-0 right-0 flex items-center justify-center w-screen h-screen bg-gray-400/40"
                    >
                        <div
                            class="p-8 bg-indigo-500 border border-indigo-600 rounded-md dark:bg-indigo-800"
                        >
                            <p class="mb-4">
                                آیا از ارسال جواب خود مطمعن هستید؟
                                <br />
                                {{
                                    noanswer == 0
                                        ? "شما به تمامی سوالات پاسخ داده اید."
                                        : `شما به ${noanswer} سوال پاسخ نداده اید`
                                }}
                            </p>
                            <my-button
                                class="mr-4"
                                :loding="loding"
                                :disabled="form.processing"
                                @click="send"
                            >
                                ارسال
                            </my-button>
                            <my-button-danger
                                class="mr-4"
                                @click="sendOk = false"
                            >
                                کنسل
                            </my-button-danger>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import CountdownTimer from "@/component/CountdownTimer.vue";
import MyButton from "@/component/Button.vue";
import MyButtonDanger from "@/component/ButtonDanger.vue";

import LongAnswer from "@/Pages/Student/Type/LongAnswer.vue";
import ShortAnswer from "@/Pages/Student/Type/ShortAnswer.vue";
import TestAnswer from "@/Pages/Student/Type/TestAnswer.vue";

import { ref } from "@vue/reactivity";
import { useStore } from "vuex";
import { useForm } from "@inertiajs/inertia-vue3";
import { useToast } from "vue-toastification";
import { computed } from "@vue/runtime-core";

const components = {
    "long-answer": LongAnswer,
    "short-answer": ShortAnswer,
    "test-answer": TestAnswer,
};

const props = defineProps(["quiz", "start", "now"]);
const questions = _.shuffle(props.quiz.questions);

const loding = ref(false);

const toast = useToast();
function errorToast(text) {
    toast.error(text, {
        position: "bottom-right",
        timeout: 5000,
        closeOnClick: true,
        pauseOnFocusLoss: true,
        pauseOnHover: true,
        draggable: true,
        draggablePercent: 0.6,
        showCloseButtonOnHover: false,
        hideProgressBar: false,
        closeButton: "button",
        icon: true,
        rtl: false,
    });
}

const sendOk = ref(false);

const store = useStore();
const form = useForm({ answer: null });
const noanswer = computed(() => store.getters.getNoAnswer);
function send() {
    loding.value = true;
    form.answer = store.getters.getAnswer;

    for (const index in form.answer) {
        const answer = form.answer[index];
        localStorage.removeItem(answer.id);
    }

    form.post(route("send.answer"), {
        onError: (errors) => {
            for (const key in errors) {
                errorToast(errors[key]);
            }
        },
        onSuccess: () => {
            toast.success("آزمون با موفقیت ساخته شد", {
                position: "bottom-right",
                timeout: 5000,
                closeOnClick: true,
                pauseOnFocusLoss: true,
                pauseOnHover: true,
                draggable: true,
                draggablePercent: 0.6,
                showCloseButtonOnHover: false,
                hideProgressBar: false,
                closeButton: "button",
                icon: true,
                rtl: false,
            });
        },
        onFinish: () => {
            loding.value = false;
        },
    });
}
function finish() {
    send();
}
</script>
