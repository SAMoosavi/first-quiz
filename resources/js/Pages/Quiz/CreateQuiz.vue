<template>
    <app-layout title="ساخت آزمون">
        <template #header> ساخت آزمون </template>
        <div class="pt-12">
            <div class="mx-auto lg:max-w-7xl lg:px-8">
                <div
                    class="min-h-full gap-2 p-2 overflow-hidden shadow-none bg-sky-200 dark:bg-sky-700 sm:rounded-none"
                >
                    <form
                        class="grid grid-cols-1 gap-4 md:grid-cols-3"
                        @submit.prevent="submit"
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
                            <date-picker
                                id="start"
                                v-model="form.start"
                                type="datetime"
                                :min="new Date()"
                            />
                        </div>
                        <div>
                            <Label
                                for="end"
                                value="زمان پایان"
                                :required="!!form.start"
                            />
                            <date-picker
                                id="end"
                                v-model="form.end"
                                :disabled="!!!form.start"
                                :min="form.start"
                                type="datetime"
                            />
                        </div>
                        <div>
                            <Label
                                for="time"
                                value="مدت زمان آزمون"
                                :required="true"
                            />
                            <date-picker
                                id="time"
                                v-model="form.time"
                                :max="form.start - form.end"
                                type="time"
                            />
                        </div>

                        <section class="col-span-full">
                            <ul class="m-6 list-decimal">
                                <question />
                            </ul>

                            <Button
                                class="mr-4"
                                :loding="loding"
                                :disabled="form.processing"
                            >
                                ساخت آزمون
                            </Button>
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

        // Submit
        const loding = ref(false);
        const store = useStore();
        const toast = useToast();
        function submit() {
            if (!!form.start && !form.end) {
                toast.error("فیلد زمان پایان الزامی است", {
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
            } else if (!form.time) {
                toast.error("فیلد مدت زمان آزمون الزامی است", {
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
            } else {
                loding.value = true;
                form
                    // first get questions
                    .transform((data) => ({
                        ...data,
                        questions: store.getters.getQuestions,
                    }))
                    //second send to backend
                    .post(route("store.quiz"), {
                        onError: (errors) => {
                            for (const property of errors) {
                                toast.error(property, {
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

        return {
            form,
            submit,
            loding,
        };
    },
};
</script>
