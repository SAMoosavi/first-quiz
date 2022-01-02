<template>
    <Head title="فراموشی رمز عبور" />

    <authentication-card>
        <template #img>
            <img
                :src="'../image/Forgot-Password.png'"
                class="w-full max-h-screen"
                alt="تصویر صفحه فراموشی رمز عبور"
            />
        </template>

        <div class="my-4 text-sm font-medium text-justify text-gray-700 dark:text-gray-200">
            رمز عبور خود را فراموش کرده اید؟ مشکلی نیست فقط آدرس ایمیل خود را به
            ما بگویید تا ما یک پیوند بازنشانی رمز عبور را برای شما ایمیل می کنیم
            که به شما امکان می دهد رمز جدیدی را انتخاب کنید.
        </div>

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <Label for="email" value="ایمیل" />
                <Input
                    id="email"
                    type="email"
                    class="block w-full mt-1"
                    v-model="form.email"
                    required
                    autofocus
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Button
                    class="mr-4"
                    :loding="loding"
                    :disabled="form.processing"
                >
                    ارسال ایمیل
                </Button>
            </div>
        </form>
    </authentication-card>
</template>

<script>
import {  ref } from "vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import AuthenticationCard from "@/component/AuthenticationCard.vue";
import Button from "@/component/Button.vue";
import Input from "@/component/Input.vue";
import Label from "@/component/Label.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";

export default {
    components: {
        Head,
        AuthenticationCard,
        Button,
        Input,
        Label,
        JetValidationErrors,
    },

    props: {
        status: String,
    },

    setup() {
        const form = useForm({
            email: "",
        });

        const loding = ref(false);

        function submit() {
            loding.value = true;
            this.form.post(this.route("password.email"), {
                onFinish: () => {
                    loding.value = false;
                },
            });
        }

        return {
            form,
            submit,
            loding,
        };
    },
};
</script>
