<template>
    <Head title="Email Verification" />

    <authentication-card>
        <template #img>
            <img
                :src="'../image/verify-email.png'"
                class="w-full max-h-screen"
                alt="تصویر صفحه تایید ایمیل"
            />
        </template>

        <div
            class="my-4 text-sm font-medium text-justify text-gray-700 dark:text-gray-200"
        >
            از ثبت نام شما سپاسگزاریم! قبل از شروع، آیا می توانید آدرس ایمیل خود
            را با کلیک بر روی پیوندی که به تازگی برای شما ایمیل کرده ایم تأیید
            کنید؟ اگر ایمیلی را دریافت نکردید، با کمال میل یک ایمیل دیگر برای
            شما ارسال خواهیم کرد.
        </div>

        <form @submit.prevent="submit" novalidate>
            <div class="flex items-center justify-between mt-4">
                <Button
                    class="mr-4"
                    :loding="loding"
                    :disabled="form.processing"
                >
                    ایمیل تایید را دوباره بفرست
                </Button>
                <auth-link :href="route('logout')" :method="'post'" as="button">
                    خروج
                </auth-link>
            </div>
        </form>
    </authentication-card>
</template>

<script>
import { ref } from "vue";
import AuthenticationCard from "@/component/AuthenticationCard.vue";
import Button from "@/component/Button.vue";
import AuthLink from "@/component/AuthLink.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { useToast } from "vue-toastification";

export default {
    components: {
        Head,
        AuthenticationCard,
        Button,
        Link,
        AuthLink,
    },

    setup() {
        const form = useForm();
        const loding = ref(false);
        const toast = useToast();
        
        function submit() {
            loding.value = true;
            form.post(this.route("verification.send"), {
                onError: (errors) => {
                    for (const property in errors) {
                        toast.error(errors[property], {
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
                    toast.success(
                        `یک پیوند تأیید جدید به آدرس ایمیلی که در هنگام ثبت نام ارائه کرده اید ارسال شده است.`,
                        {
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
                        }
                    );
                },
                onFinish: () => {
                    loding.value = false;
                },
            });
        }

        return {
            submit,
            loding,
        };
    },
};
</script>
