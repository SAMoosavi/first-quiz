<template>
    <Head title="ثبت نام" />

    <authentication-card>
        <template #img>
            <img
                :src="'../image/register-light.png'"
                class="block w-full max-h-screen dark:hidden"
                alt="تصویر صفحه ثبت نام"
            />
            <img
                :src="'../image/register-dark.png'"
                class="hidden w-full max-h-screen dark:block"
                alt="تصویر صفحه ثبت نام"
            />
        </template>

        <form @submit.prevent="submit" novalidate>
            <div>
                <Label for="name" value="نام" :required="true" />
                <Input
                    id="name"
                    type="text"
                    class="block w-full mt-1"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />
            </div>

            <div class="mt-4">
                <Label for="email" value="ایمیل" :required="true" />
                <Input
                    id="email"
                    type="email"
                    class="block w-full mt-1"
                    v-model="form.email"
                    required
                />
            </div>

            <div class="mt-4">
                <Label for="password" value="رمز عبور" :required="true" />
                <Input
                    id="password"
                    type="password"
                    class="block w-full mt-1"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />
            </div>

            <div class="mt-4">
                <Label
                    for="password_confirmation"
                    value="تکرار رمز عبور"
                    :required="true"
                />
                <Input
                    id="password_confirmation"
                    type="password"
                    class="block w-full mt-1"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <auth-link :href="route('login')"> حسابی دارید! </auth-link>

                <Button
                    class="mr-4"
                    :loding="loding"
                    :disabled="form.processing"
                >
                    ثبت نام
                </Button>
            </div>
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

export default defineComponent({
    components: {
        Head,
        AuthenticationCard,
        Button,
        Input,
        Checkbox,
        Label,
        AuthLink,
    },

    setup() {
        const form = useForm({
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            terms: false,
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

        function validEmail(email) {
            return String(email)
                .toLowerCase()
                .match(
                    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                );
        }

        function submit() {
            loding.value = true;
            let valid = true;

            if (
                !form.email ||
                !form.password ||
                !form.name ||
                !form.password ||
                !form.password_confirmation
            ) {
                valid = false;
                errorToast("لطفا تمام فیلد های ستاره دار را پر کنید");
            }
            if (form.email && !validEmail(form.email)) {
                valid = false;
                errorToast("ایمیل وارد شده صحیح نمی باشد");
            }
            if (
                form.password &&
                form.password_confirmation &&
                form.password != form.password_confirmation
            ) {
                valid = false;
                errorToast("رمز عبور و تکرار رمز عبور یکسان نیست");
            }
            if (valid) {
                form.post(this.route("register"), {
                    onError: (errors) => {
                        for (const property in errors) {
                            errorToast(errors[property]);
                        }
                    },
                    onSuccess: () => {
                        toast.success("شما با موفقیت ثبت نام شدید", {
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
                        form.reset("password", "password_confirmation");
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
});
</script>
