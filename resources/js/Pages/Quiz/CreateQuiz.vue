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
                        <!-- <div class="col-span-full md:w-1/2 lg:w-1/3">
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
                                :initial-value="a"
                                :max="form.start - form.end"
                                type="time"
                            />
                        </div> -->
                        <section class="col-span-full">
                            <ol class="list-decimal m-4" >
                                <question />
                            </ol>
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
import { watch } from "@vue/runtime-core";
import Question from "./Question.vue";

export default {
    components: {
        AppLayout,
        Label,
        Input,
        DatePicker,
        Question,
    },
    setup() {
        const a = ref("00:00");
        const form = useForm({
            name: "",
            start: "",
            end: 0,
            time: a.value,
            questions: [],
        });
        const loding = ref(false);
        function submit() {
            loding.value = true;
            form.post(route("store.quiz"), {
                onError: (errors) => {
                    for (const property in errors) {
                        useToast().error(errors[property], {
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
                    useToast().success("آزمون با موفقیت ساخته شد", {
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

        const start = ref("");
        const end = ref("");
        watch(
            () => form.start,
            (time) => {
                start.value = Math.abs(new Date(time).getTime());
            }
        );
        watch(
            () => form.end,
            (time) => {
                end.value = Math.abs(new Date(time).getTime());
            }
        );

        watch([start, end], ([startTime, endTime]) => {
            if (endTime > 0) {
                a.value = startTime - endTime;
                a.value /= 60000;
                const min = a.value % 60;
                const hour = (a.value - min) / 60;
                if (hour < 24) {
                    a.value =
                        `${hour}`.padStart(2, "0") +
                        `:` +
                        `${min}`.padStart(2, "0");
                }
            }
        });
        return {
            form,
            submit,
            loding,
            a,
        };
    },
};
</script>
