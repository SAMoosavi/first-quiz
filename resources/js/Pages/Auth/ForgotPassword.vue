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

        <div
            class="my-4 text-sm font-medium text-justify text-gray-700 dark:text-gray-200"
        >
            رمز عبور خود را فراموش کرده اید؟ مشکلی نیست فقط آدرس ایمیل خود را به
            ما بگویید تا ما یک پیوند بازنشانی رمز عبور را برای شما ایمیل می کنیم
            که به شما امکان می دهد رمز جدیدی را انتخاب کنید.
        </div>

        <form @submit.prevent="submit" novalidate>
            <div>
                <Label for="email" value="ایمیل" :required="true" />
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
import { ref, watch } from "vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import AuthenticationCard from "@/component/AuthenticationCard.vue";
import Button from "@/component/Button.vue";
import Input from "@/component/Input.vue";
import Label from "@/component/Label.vue";
import { useToast } from "vue-toastification";

export default {
    components: {
        Head,
        AuthenticationCard,
        Button,
        Input,
        Label,
    },

    props: {
        status: String,
    },

    setup() {
        const form = useForm({
            email: "",
        });

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
        function submit() {
            loding.value = true;
            if (!form.email) {
                errorToast("لطفا تمام فیلد های ستاره دار را پر کنید");
            } else {
                this.form.post(this.route("password.email"), {
                    onError: (errors) => {
                        for (const property in errors) {
                            errorToast(errors[property]);
                        }
                    },
                });
            }
            setTimeout(() => {
                loding.value = false;
            }, 200);
        }
        watch(
            () => props.status,
            (val) => {
                toast.success(val, {
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
        );

        return {
            form,
            submit,
            loding,
        };
    },
};
</script>
