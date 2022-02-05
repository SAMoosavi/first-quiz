<template>
    <app-layout title="ساخت آزمون">
        <template #header> مشاهده آزمون </template>
        <div class="relative pt-12">
            <div class="mx-auto transition lg:max-w-7xl lg:px-8">
                <div
                    class="p-6 bg-indigo-200 shadow-md dark:bg-indigo-700 sm:rounded-md"
                >
                    <template v-if="!showEdite">
                        <div class="flex items-center justify-between">
                            <h2>نام آرمون: {{ form.name }}</h2>
                            <h3 v-if="form.start">
                                زمان شروع آزمون: {{ form.start }}
                            </h3>
                            <h3 v-if="form.end">
                                زمان پایان آزمون: {{ form.end }}
                            </h3>
                            <h3>مدت زمان آزمون: {{ form.time }}</h3>
                        </div>
                        <div class="my-4">
                            <my-button
                                :loding="lodingEdite"
                                type="button"
                                @click="showEditeQuize"
                            >
                                ویرایش مشخصات آزمون
                            </my-button>
                        </div>
                    </template>
                    <template v-if="showEdite">
                        <div class="col-span-full md:w-1/2 lg:w-1/3">
                            <my-label
                                for="name"
                                value="نام آزمون"
                                :required="true"
                            />
                            <my-input
                                id="name"
                                type="text"
                                class="block w-full mt-1"
                                v-model="form.name"
                                required
                                autocomplete="current-name"
                            />
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <div>
                                <my-label for="start" value="زمان شروع" />
                                <my-input
                                    id="start"
                                    class="w-full"
                                    v-model="form.start"
                                    :icon="true"
                                >
                                    <svg
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
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                </my-input>
                                <date-picker
                                    v-model="form.start"
                                    type="datetime"
                                    :min="new Date()"
                                    custom-input="#start"
                                />
                            </div>
                            <div>
                                <my-label
                                    for="end"
                                    value="زمان پایان"
                                    :required="!!form.start"
                                />
                                <my-input
                                    id="end"
                                    class="w-full"
                                    v-model="form.end"
                                    :icon="true"
                                >
                                    <svg
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
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                </my-input>
                                <date-picker
                                    v-model="form.end"
                                    :disabled="!!!form.start"
                                    :min="form.start"
                                    type="datetime"
                                    custom-input="#end"
                                />
                            </div>
                            <div>
                                <my-label
                                    for="time"
                                    value="مدت زمان آزمون"
                                    :required="true"
                                />
                                <my-input
                                    id="time"
                                    class="w-full"
                                    v-model="form.time"
                                    :icon="true"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                </my-input>
                                <date-picker
                                    v-model="form.time"
                                    :max="form.start - form.end"
                                    type="time"
                                    custom-input="#time"
                                />
                            </div>
                        </div>
                        <my-button-danger
                            :loding="lodingEdite"
                            type="button"
                            @click="canselEditeQuize"
                        >
                            کنسل
                        </my-button-danger>
                        <my-button
                            :loding="lodingEditing"
                            type="button"
                            @click="editEditeQuize"
                        >
                            تغییر
                        </my-button>
                    </template>
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
                    <transition
                        enter-active-class="transition duration-200 ease-out origin-top "
                        enter-from-class="origin-top transform scale-y-0 opacity-0 "
                        enter-to-class="origin-top transform scale-y-100 opacity-100 "
                        leave-active-class="transition duration-200 ease-in origin-top "
                        leave-from-class="origin-top transform scale-y-100 opacity-100 "
                        leave-to-class="origin-top transform scale-y-0 opacity-0 "
                    >
                        <section v-if="show">
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
                        </section>
                    </transition>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import MyButton from "@/component/Button.vue";
import MyButtonDanger from "@/component/ButtonDanger.vue";
import myInput from "@/component/Input.vue";
import myLabel from "@/component/Label.vue";

import LongAnswer from "@/Pages/ShowQuizMaker/Type/LongAnswer.vue";
import ShortAnswer from "@/Pages/ShowQuizMaker/Type/ShortAnswer.vue";
import TestAnswer from "@/Pages/ShowQuizMaker/Type/TestAnswer.vue";
import DatePicker from "vue3-persian-datetime-picker";

import { reactive, ref } from "@vue/reactivity";
import { useForm } from "@inertiajs/inertia-vue3";
import { useToast } from "vue-toastification";

const props = defineProps(["quiz"]);

const components = {
    "long-answer": LongAnswer,
    "short-answer": ShortAnswer,
    "test-answer": TestAnswer,
};

const thisQuiz = reactive({
    name: props.quiz.name,
    start: props.quiz.start,
    end: props.quiz.end,
    time: props.quiz.time,
});

const form = useForm({
    name: thisQuiz.name,
    start: thisQuiz.start,
    end: thisQuiz.end,
    time: thisQuiz.time,
});

const loding = ref(false);
const lodingEdite = ref(false);
const show = ref(false);
const showEdite = ref(false);
const lodingEditing = ref(false);

function showQuiztions() {
    loding.value = true;
    setTimeout(() => {
        show.value = true;
        loding.value = false;
    }, 300);
}

function showEditeQuize() {
    lodingEdite.value = true;
    setTimeout(() => {
        showEdite.value = !showEdite.value;
        lodingEdite.value = false;
    }, 300);
}

function canselEditeQuize() {
    lodingEdite.value = true;
    form.name = thisQuiz.name;
    form.start = thisQuiz.start;
    form.end = thisQuiz.end;
    form.time = thisQuiz.time;
    setTimeout(() => {
        lodingEdite.value = false;
        showEdite.value = false;
    }, 300);
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

function editEditeQuize() {
    lodingEditing.value = true;

    if (!form.name || !form.time || (form.start && !form.end)) {
        errorToast("تمام فیلد های ستاره دار را پر کنید");
    } else {
        form.put(route("edit.quize", { id: props.quiz.id }), {
            onError: (errors) => {
                for (const property in errors) {
                    errorToast(errors[property]);
                }
            },
            onSuccess: () => {
                toast.success("آزمون با موفقیت ویرایش شد", {
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
                thisQuiz.name = form.name;
                thisQuiz.start = form.start;
                thisQuiz.end = form.end;
                thisQuiz.time = form.time;
            },
            onFinish: () => {
                showEdite.value = !showEdite.value;
            },
        });
    }
    setTimeout(() => {
        lodingEditing.value = false;
    }, 300);
}
</script>
