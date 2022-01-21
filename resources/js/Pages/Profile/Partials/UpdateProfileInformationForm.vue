<template>
    <form-section @submitted="updateProfileInformation">
        <template #title> مشخصات کاربری </template>

        <template #description>
            به روزرسانی مسخصات کاربری و آدرس ایمیل
        </template>

        <template #form>
            <!-- Profile Photo -->
            <div
                class="col-span-6 sm:col-span-4"
                v-if="$page.props.jetstream.managesProfilePhotos"
            >
                <!-- Profile Photo File Input -->
                <Input
                    type="file"
                    class="hidden"
                    ref="photo"
                    @change="updatePhotoPreview"
                />

                <Label for="photo" value="تصویر" />

                <!-- Current Profile Photo -->
                <div class="mt-2" v-show="!photoPreview">
                    <img
                        :src="user.profile_photo_url"
                        :alt="user.name"
                        class="object-cover w-20 h-20 rounded-full shadow shadow-indigo-600 dark:stroke-indigo-300"
                    />
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" v-show="photoPreview">
                    <span
                        class="block w-20 h-20 bg-center bg-no-repeat bg-cover rounded-full"
                        :class="`bg-[url('\'' + ${photoPreview} + '\'')]`"
                    >
                    </span>
                </div>

                <secondary-button
                    class="mt-2 mr-2"
                    type="button"
                    @click.prevent="selectNewPhoto"
                >
                    انتخاب تصویر جدید
                </secondary-button>

                <secondary-button
                    type="button"
                    class="mt-2"
                    @click.prevent="deletePhoto"
                    v-if="user.profile_photo_path"
                >
                    حذف تصویر
                </secondary-button>

                <Input-error :message="form.errors.photo" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <Label for="name" value="نام" />
                <Input
                    id="name"
                    type="text"
                    class="block w-full mt-1"
                    v-model="form.name"
                    autocomplete="name"
                />
                <Input-error :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <Label for="email" value="ایمیل" />
                <Input
                    id="email"
                    type="email"
                    class="block w-full mt-1"
                    v-model="form.email"
                />
                <Input-error :message="form.errors.email" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="ml-3">
                ذخیره.
            </jet-action-message>

            <Button class="mr-4" :loding="loding" :disabled="form.processing">
                ذخیره
            </Button>
        </template>
    </form-section>
</template>

<script>
import { defineComponent, ref } from "vue";
import Button from "@/component/Button.vue";
import FormSection from "@/component/FormSection.vue";
import Input from "@/component/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import Label from "@/component/Label.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import SecondaryButton from "@/component/SecondaryButton.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

export default defineComponent({
    components: {
        JetActionMessage,
        Button,
        FormSection,
        Input,
        JetInputError,
        Label,
        SecondaryButton,
    },

    props: ["user"],

    setup(props) {
        const form = useForm({
            _method: "PUT",
            name: props.user.name,
            email: props.user.email,
            photo: null,
        });
        const photoPreview = ref(null);
        const loding = ref(false);
        const photo = ref(null);

        function updateProfileInformation() {
            loding.value = true;
            if (photo.value) {
                form.photo = photo.value.files[0];
            }

            form.post(route("user-profile-information.update"), {
                errorBag: "updateProfileInformation",
                preserveScroll: true,
                onSuccess: () => this.clearPhotoFileInput(),
                onFinish: () => {
                    loding.value = false;
                },
            });
        }

        function selectNewPhoto() {
            photo.value.click();
        }

        function updatePhotoPreview() {
            const photo = photo.value.files[0];

            if (!photo) return;

            const reader = new FileReader();

            reader.onload = (e) => {
                photoPreview.value = e.target.result;
            };

            reader.readAsDataURL(photo);
        }

        function deletePhoto() {
            Inertia.delete(route("current-user-photo.destroy"), {
                preserveScroll: true,
                onSuccess: () => {
                    photoPreview.value = null;
                    this.clearPhotoFileInput();
                },
            });
        }

        function clearPhotoFileInput() {
            if (photo?.value) {
                photo.value = null;
            }
        }
        return {
            form,
            photoPreview,
            loding,
            photo,
            updateProfileInformation,
            selectNewPhoto,
            updatePhotoPreview,
            deletePhoto,
            clearPhotoFileInput,
        };
    },
});
</script>
