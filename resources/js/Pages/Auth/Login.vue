<template>
    <Head title="ورود" />

    <!-- <Toast v-if="!!msg" :msg="msg" :type="type" /> -->

    <authentication-card>
        <template #img>
            <img
                :src="'../image/login.png'"
                class="w-full max-h-screen"
                alt="تصویر صفحه ورود"
            />
        </template>

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
                    autocomplete="email"
                />
            </div>

            <div class="mt-4">
                <Label for="password" value="رمز ورود" :required="true" />
                <Input
                    id="password"
                    type="password"
                    class="block w-full mt-1"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span
                        class="mr-2 text-sm font-medium text-gray-700 dark:text-gray-200"
                        >من را به خاطر بسپار</span
                    >
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <auth-link :href="route('register')">
                    ساخت حساب جدید
                </auth-link>

                <Button
                    class="mr-4"
                    :loding="loding"
                    :disabled="form.processing"
                >
                    ورود
                </Button>
            </div>
            <auth-link :href="route('password.request')">
                فراموشی رمز عبور!
            </auth-link>
        </form>
    </authentication-card>
</template>

<script>
import { defineComponent, ref } from "vue";
import AuthenticationCard from "@/component/AuthenticationCard.vue";
import Button from "@/component/Button.vue";
import Input from "@/component/Input.vue";
import Checkbox from "@/component/Checkbox.vue";
import Label from "@/component/Label.vue";
import AuthLink from "@/component/AuthLink.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import { useToast } from "vue-toastification";
// import Toast from "@/component/Toast.vue";

export default defineComponent({
    components: {
        Head,
        AuthenticationCard,
        Button,
        Input,
        Checkbox,
        Label,
        AuthLink,
        // Toast,
    },

    props: {
        status: String,
    },

    setup() {
        const form = useForm({
            email: "",
            password: "",
            remember: false,
        });

        // const msg = ref(null);
        // const type = ref(null);

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

        function validEmail(email) {
            return String(email)
                .toLowerCase()
                .match(
                    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                );
        }

        function submit() {
            loding.value = true;

            if (!form.email || !form.password) {
                errorToast("لطفا تمام فیلد های ستاره دار را پر کنید");
            } else if (!validEmail(form.email)) {
                errorToast("ایمیل وارد شده صحیح نمی باشد");
            } else {
                form.transform((data) => ({
                    ...data,
                    remember: form.remember ? "on" : "",
                })).post(this.route("login"), {
                    onError: (errors) => {
                        for (const property in errors) {
                            errorToast(errors[property]);
                        }
                    },
                    onSuccess: () => {
                        toast.success("شما با موفقیت وارد شدید", {
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
                        form.reset("password");
                    },
                });
            }
            setTimeout(() => {
                loding.value = false;
            }, 100);
        }

        return {
            form,
            submit,
            loding,
            // msg,
            // type,
        };
    },
});
</script>
