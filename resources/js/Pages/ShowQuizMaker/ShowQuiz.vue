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
                    <div class="mt-3">
                        لینک آزمون:
                        <button
                            @click="copy"
                            class="flex p-2 bg-gray-300 border border-gray-700 rounded-md"
                        >
                            <!-- Copy Icon -->
                            <span class="ml-2">
                                <transition
                                    mode="out-in"
                                    enter-active-class="transition duration-200 ease-out"
                                    enter-from-class="transform scale-x-0 "
                                    enter-to-class="transform scale-x-100 "
                                    leave-active-class="transition duration-200 ease-in "
                                    leave-from-class="transform scale-x-100 opacity-100"
                                    leave-to-class="transform scale-x-0 opacity-0"
                                    move-class="transition transform"
                                >
                                    <svg
                                        key="1"
                                        v-if="!copied"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-6 h-6"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"
                                        />
                                    </svg>
                                    <svg
                                        key="2"
                                        v-else
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-6 h-6"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
                                        />
                                    </svg>
                                </transition>
                            </span>
                            <!-- URL -->
                            {{ url }}
                        </button>
                    </div>

                    <div class="flex flex-col gap-2 mt-3">
                        <student
                            v-for="(student, index) in props.student"
                            :key="index"
                            :student="student"
                            :quizId="props.quiz.id"
                            :status="status"
                        />
                        <my-button
                            :loding="loding"
                            type="button"
                            @click="send"
                            class="w-full"
                        >
                            ثبت نمره همگی
                        </my-button>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Quiz from "@/Pages/ShowQuizMaker/Quiz.vue";
import Student from "@/Pages/ShowQuizMaker/Student.vue";

import MyButton from "@/component/Button.vue";

import { ref } from "@vue/reactivity";

import { useForm } from "@inertiajs/inertia-vue3";
import { useToast } from "vue-toastification";
import { useStore } from "vuex";

const props = defineProps(["quiz", "student"]);
// Create URL For Quiz Student
const copied = ref(false);
const url = route("ans.quiz", [props.quiz.uuid]);
function copy() {
    navigator.clipboard.writeText(url);
    copied.value = true;
}

const loding = ref(false);

const form = useForm({
    id: props.quiz.id,
    points: {},
});

function validation(v) {
    for (const key1 in v) {
        for (const key2 in v[key1]) {
            if (v[key1][key2] === "") return false;
        }
    }
    return true;
}

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
const store = useStore();
const status = ref(false);
function send() {
    loding.value = true;

    if (!validation(store.getters.getPointOfStudents)) {
        errorToast("نمره تمامی سوالات را وارد نمایید");
    } else {
        form.points = store.getters.getPointOfStudents;
        form.post(route("send.point"), {
            onError: (errors) => {
                for (const property in errors) {
                    errorToast(errors[property]);
                }
            },
            onSuccess: () => {
                toast.success("نمره با موفقیت ثبت شد", {
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

                for (const studentId in form.points) {
                    for (const key in form.points[studentId]) {
                        localStorage.removeItem(studentId + "," + key);
                    }
                    localStorage.removeItem(studentId + ",*");
                    store.commit("removePoint", studentId);
                }
                status.value = true;
                setTimeout(() => {
                    status.value = false;
                }, 100);
            },
            onFinish: () => {},
        });
    }
    setTimeout(() => {
        loding.value = false;
    }, 300);
}
</script>
