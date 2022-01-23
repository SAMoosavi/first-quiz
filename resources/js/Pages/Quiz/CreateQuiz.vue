<template>
    <app-layout title="ساخت آزمون">
        <template #header> ساخت آزمون </template>
        <div class="pt-12">
            <div class="mx-auto lg:max-w-7xl lg:px-8">
                <div
                    class="min-h-full gap-2 p-2 overflow-hidden bg-indigo-200 shadow-md dark:bg-indigo-700 sm:rounded-md"
                >
                    <form
                        class="grid grid-cols-1 gap-4 md:grid-cols-3"
                        @submit.prevent="submit"
                        novalidate
                    >
                        <div class="col-span-full md:w-1/2 lg:w-1/3">
                            <Label
                                for="name"
                                value="نام آزمون"
                                :required="true"
                            />
                            <Input
                                id="name"
                                type="text"
                                class="block w-full mt-1"
                                v-model="form.name"
                                required
                                autocomplete="current-name"
                            />
                        </div>
                        <div>
                            <Label for="start" value="زمان شروع" />
                            <Input
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
                            </Input>
                            <date-picker
                                v-model="form.start"
                                type="datetime"
                                :min="new Date()"
                                custom-input="#start"
                            />
                        </div>
                        <div>
                            <Label
                                for="end"
                                value="زمان پایان"
                                :required="!!form.start"
                            />
                            <Input
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
                            </Input>
                            <date-picker
                                v-model="form.end"
                                :disabled="!!!form.start"
                                :min="form.start"
                                type="datetime"
                                custom-input="#end"
                            />
                        </div>
                        <div>
                            <Label
                                for="time"
                                value="مدت زمان آزمون"
                                :required="true"
                            />
                            <Input
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
                            </Input>
                            <date-picker
                                v-model="form.time"
                                :max="form.start - form.end"
                                type="time"
                                custom-input="#time"
                            />
                        </div>

                        <section class="m-6 col-span-full">
                            <question />
                            <div class="flex items-center justify-start gap-2">
                                <Button
                                    class="mr-4"
                                    :loding="loding"
                                    :disabled="form.processing"
                                >
                                    ساخت آزمون
                                </Button>
                                <div>
                                    <p class="text-gray-800 dark:text-gray-300">
                                        آزمون دارای
                                        <span>
                                            {{
                                                $store.getters.getSizeQuestions
                                            }}
                                        </span>
                                        سوال است
                                    </p>
                                </div>
                            </div>
                        </section>
                    </form>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { useToast } from "vue-toastification";
import { ref } from "@vue/reactivity";
import Label from "@/component/Label.vue";
import Input from "@/component/Input.vue";
import DatePicker from "vue3-persian-datetime-picker";
import Question from "./Question.vue";
import Button from "@/component/Button.vue";
import { useStore } from "vuex";

export default {
    components: {
        AppLayout,
        Label,
        Input,
        DatePicker,
        Question,
        Button,
    },
    setup() {
        const form = useForm({
            name: "",
            start: "",
            end: "",
            time: "",
            questions: {},
        });

        //validation
        function validForm(question) {
            //required question
            if (!question.question) return false;
            // if test check required
            if (question.type == "test-answer") {
                if (!question.answer) return false;
                for (const key in question.option) {
                    if (!question.option[key]) return false;
                }
            }

            //if valid return true
            return true;
        }

        //show tost error
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

        // Submit
        const loding = ref(false);
        const store = useStore();
        function submit() {
            loding.value = true;
            if (!!form.start && !form.end) {
                errorToast("لطفا تمامی فیلد های ستاره دار را پر کنید");
            } else if (!form.time) {
                errorToast("لطفا تمامی فیلد های ستاره دار را پر کنید");
            } else if (!form.name) {
                errorToast("لطفا تمامی فیلد های ستاره دار را پر کنید");
            } else {
                form.questions = store.getters.getQuestions;
                let required = true;
                console.log(form.questions);
                for (const key in form.questions) {
                    console.log(form.questions[key]);
                    required = validForm(form.questions[key]);
                    if (!required) {
                        errorToast("لطفا تمامی فیلد های ستاره دار را پر کنید");
                        break;
                    }
                }
                if (required) {
                    form
                        // first get questions
                        .transform((data) => ({
                            ...data,
                            questions: store.getters.getQuestions,
                        }))
                        //second send to backend
                        .post(route("store.quiz"), {
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
            }
            setTimeout(() => (loding.value = false), 200);
        }

        return {
            form,
            submit,
            loding,
        };
    },
};
</script>
