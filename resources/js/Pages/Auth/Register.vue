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
        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <Label for="name" value="نام" />
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
                <Label for="email" value="ایمیل" />
                <Input
                    id="email"
                    type="email"
                    class="block w-full mt-1"
                    v-model="form.email"
                    required
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

            <!-- <div class="mt-4" v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature">
                <Label for="terms">
                    <div class="flex items-center">
                        <Checkbox name="terms" id="terms" v-model:checked="form.terms" />

                        <div class="ml-2">
                            I agree to the <a target="_blank" :href="route('terms.show')" class="text-sm text-gray-600 underline hover:text-gray-900">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="text-sm text-gray-600 underline hover:text-gray-900">Privacy Policy</a>
                        </div>
                    </div>
                </Label>
            </div> -->

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
import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo.vue";
import Button from "@/component/Button.vue";
import Input from "@/component/Input.vue";
import Checkbox from "@/component/Checkbox.vue";
import Label from "@/component/Label.vue";
import AuthLink from "@/component/AuthLink.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";

export default defineComponent({
    components: {
        Head,
        AuthenticationCard,
        JetAuthenticationCardLogo,
        Button,
        Input,
        Checkbox,
        Label,
        JetValidationErrors,
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

        function submit() {
            loding.value = true;
            form.post(this.route("register"), {
                onFinish: () => {
                    loding.value = false;
                    form.reset("password", "password_confirmation");
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
