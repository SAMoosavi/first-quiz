<template>
    <Head title="منطقه امن" />

    <authentication-card>
        <template #img>
            <img
                :src="'../image/confirm-password.png'"
                class="w-full max-h-screen"
                alt="تصویر صفحه منطقه امن"
            />
        </template>

        <div
            class="my-4 text-sm font-medium text-justify text-gray-700 dark:text-gray-200"
        >
            این یک منطقه امن برنامه است. لطفاً قبل از ادامه رمز عبور خود را
            تأیید کنید.
        </div>

        <form @submit.prevent="submit" novalidate>
            <div>
                <Label for="password" value="رمز عبور" :required="true" />
                <Input
                    id="password"
                    type="password"
                    class="block w-full mt-1"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    autofocus
                />
            </div>

            <div class="flex justify-end mt-4">
                <Button
                    class="mr-4"
                    :loding="loding"
                    :disabled="form.processing"
                >
                    تایید
                </Button>
            </div>
        </form>
    </authentication-card>
</template>

<script>
import { ref } from "vue";
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

    setup() {
        const form = useForm({
            password: "",
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
            if (!form.password) {
                errorToast("لطفا تمام فیلد های ستاره دار را پر کنید");
            } else {
                form.post(this.route("password.confirm"), {
                    onError: (errors) => {
                        for (const property in errors) {
                            errorToast(errors[property]);
                        }
                    },
                    onSuccess: () => {
                        toast.success("هویت شما تایید", {
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
                        form.reset();
                    },
                });
            }
            setTimeout(() => {
                loding.value = false;
            }, 200);
        }

        return {
            form,
            submit,
            loding,
        };
    },
};
</script>
