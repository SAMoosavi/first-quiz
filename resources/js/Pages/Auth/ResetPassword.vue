<template>
    <Head title="بازیابی رمز عبور" />

    <authentication-card>
        <template #img>
            <img
                :src="'../image/reset-password.png'"
                class="w-full max-h-screen"
                alt="تصویر صفحه بازیابی رمز عبور"
            />
        </template>

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

            <div class="mt-4">
                <Label for="password" value="رمز عبور" />
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
                <Label for="password_confirmation" value="تکرار رمز عبور" />
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
                <Button
                    class="mr-4"
                    :loding="loding"
                    :disabled="form.processing"
                >
                    بازیابی رمز عبور
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

    props: {
        email: String,
        token: String,
    },
    setup(props) {
        const form = useForm({
            token: props.token,
            email: props.email,
            password: "",
            password_confirmation: "",
        });
        const loding = ref(false);

        function submit() {
            loding.value = true;
            form.post(this.route("password.update"), { onError: (errors) => {
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
                onFinish: () => {
                    form.reset("password", "password_confirmation"),
                        (loding.value = false);
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
