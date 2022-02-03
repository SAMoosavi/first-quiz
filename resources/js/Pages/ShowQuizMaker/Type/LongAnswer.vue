<template>
    <h3 v-if="!showEdit">{{ thisQuestion.questions }}</h3>
    <my-textarea
        v-if="showEdit"
        v-model="editQuestion.questions"
        :value="editQuestion.questions"
        :required="true"
    />
    <my-textarea :required="false" :disabled="true" />
    <my-button
        v-if="!showEdit"
        @click="edit"
        class="mr-4"
        type="button"
        :loding="loding"
        :disabled="editQuestion.processing"
    >
        ویرایش
    </my-button>
    <my-button
        v-if="showEdit"
        @click="editing"
        class="mr-4"
        type="button"
        :loding="loding"
        :disabled="editQuestion.processing"
    >
        تغییر
    </my-button>
    <my-button-danger
        v-if="showEdit"
        @click="editCansel"
        class="mr-4"
        type="button"
        :loding="lodingCansel"
        :disabled="editQuestion.processing"
    >
        کنسل
    </my-button-danger>
</template>
<script setup>
import MyTextarea from "@/component/Textarea.vue";
import MyButton from "@/component/Button.vue";
import MyButtonDanger from "@/component/ButtonDanger.vue";

import { useForm } from "@inertiajs/inertia-vue3";
import { reactive, ref } from "@vue/reactivity";
import { useToast } from "vue-toastification";

const props = defineProps(["question", "index"]);
const thisQuestion = reactive(props.question);
const editQuestion = useForm({
    id: thisQuestion.id,
    questions: thisQuestion.questions,
    uuid: thisQuestion.uuid,
    Option: null,
    answer: null,
});

const showEdit = ref(false);
const loding = ref(false);
const lodingCansel = ref(false);

function edit() {
    loding.value = true;
    setTimeout(() => {
        showEdit.value = true;
        loding.value = false;
    }, 200);
}
function editCansel() {
    lodingCansel.value = true;
    setTimeout(() => {
        editQuestion.questions = thisQuestion.questions;
        showEdit.value = !showEdit.value;
        lodingCansel.value = false;
    }, 200);
}

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
function editing() {
    loding.value = true;

    editQuestion.put(route("edit.question", { id: editQuestion.id }), {
        onError: (errors) => {
            for (const property in errors) {
                errorToast(errors[property]);
            }
        },
        onSuccess: () => {
            toast.success("سوال با موفقیت ویرایش شد", {
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
            thisQuestion.questions = editQuestion.questions;
            showEdit.value = !showEdit.value;
            loding.value = false;
        },
    });
}
</script>

<style></style>
