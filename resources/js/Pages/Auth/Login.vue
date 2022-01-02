<template>
    <Head title="ورود" />

    <authentication-card>
        <template #img>
            <img
                :src="'../image/login.png'"
                class="w-full max-h-screen"
                alt="تصویر صفحه ورود"
            />
        </template>
        <jet-validation-errors class="mb-4" />

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

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
                <Label for="password" value="رمز ورود" />
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
                <Link
                    :href="route('register')"
                    class="text-sm font-medium text-gray-400 underline dark:text-gray-400 hover:text-gray-900 dark:hover:text-white"
                >
                    ساخت حساب جدید
                </Link>

                <Button
                    class="mr-4"
                    :loding="loding"
                    :disabled="form.processing"
                >
                    ورود
                </Button>
            </div>
            <Link
                :href="route('password.request')"
                class="text-sm font-medium text-gray-400 underline dark:text-gray-400 hover:text-gray-900 dark:hover:text-white"
            >
                فراموشی رمز عبور!
            </Link>
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
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

export default defineComponent({
    components: {
        Head,
        AuthenticationCard,
        Button,
        Input,
        Checkbox,
        Label,
        JetValidationErrors,
        Link,
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

        const loding = ref(false);

        function submit() {
            loding.value = true;
            form.transform((data) => ({
                ...data,
                remember: form.remember ? "on" : "",
            })).post(this.route("login"), {
                onFinish: () => {
                    form.reset("password");
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
});
</script>
