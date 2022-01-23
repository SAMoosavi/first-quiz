<template>
    <form-section @submitted="updatePassword">
        <template #title> بروزرسانی رمز عبور </template>

        <template #description>
            اطمینان حاصل کنید که حساب شما از یک رمز عبور طولانی و تصادفی برای
            حفظ امنیت استفاده می کند.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <Label for="current_password" value="رمز عبور فعلی" />
                <Input
                    id="current_password"
                    type="password"
                    class="block w-full mt-1"
                    v-model="form.current_password"
                    ref="current_password"
                    autocomplete="current-password"
                />
                <Input-error
                    :message="form.errors.current_password"
                    class="mt-2"
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <Label for="password" value="رمز عبور جدید" />
                <Input
                    id="password"
                    type="password"
                    class="block w-full mt-1"
                    v-model="form.password"
                    ref="password"
                    autocomplete="new-password"
                />
                <Input-error :message="form.errors.password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <Label for="password_confirmation" value="تکرار رمز عبور " />
                <Input
                    id="password_confirmation"
                    type="password"
                    class="block w-full mt-1"
                    v-model="form.password_confirmation"
                    autocomplete="new-password"
                />
                <Input-error
                    :message="form.errors.password_confirmation"
                    class="mt-2"
                />
            </div>
        </template>

        <template #actions>
            <action-message :on="form.recentlySuccessful" class="ml-3">
                ذخیره.
            </action-message>

            <Button class="mr-4" :loding="loding" :disabled="form.processing">
                ذخیره
            </Button>
        </template>
    </form-section>
</template>

<script>
import { defineComponent, ref } from "vue";
import ActionMessage from "@/component/ActionMessage.vue";
import Button from "@/component/Button.vue";
import FormSection from "@/component/FormSection.vue";
import Input from "@/component/Input.vue";
import InputError from "@/component/InputError.vue";
import Label from "@/component/Label.vue";
import { useForm } from "@inertiajs/inertia-vue3";

export default defineComponent({
    components: {
        ActionMessage,
        Button,
        FormSection,
        Input,
        InputError,
        Label,
    },

    setup() {
        const form = useForm({
            current_password: "",
            password: "",
            password_confirmation: "",
        });
        const loding = ref(false);

        const toast = useToast();

        function toastSuccess(text) {
            toast.success(text, {
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

        function updatePassword() {
            loding.value = true;
            if (
                !form.current_password ||
                !form.password ||
                !form.password_confirmation
            ) {
                errorToast("تمامی فیلد های ستاره دار را پر کنید");
            } else if (form.password_confirmation != form.password) {
                errorToast("رمز عبور جدید و تکرار آن یکسان نیست");
            } else {
                form.put(route("user-password.update"), {
                    errorBag: "updatePassword",
                    preserveScroll: true,
                    onSuccess: () => {
                        toastSuccess("رمز عبور با موفقیت تغییر کرد");
                    },
                    onError: (errors) => {
                        for (const property in errors) {
                            errorToast(errors[property]);
                        }
                    },
                    onFinish: () => {
                        form.reset();
                    },
                });
            }
            setTimeout(() => (loding.value = false), 200);
        }

        return {
            form,
            updatePassword,
            loding,
        };
    },
});
</script>
