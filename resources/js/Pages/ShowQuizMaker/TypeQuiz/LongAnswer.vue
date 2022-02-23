<template>
    <div v-if="!showEdit" class="flex justify-between">
        <h3>{{ thisQuestion.questions }}</h3>
        <h4>{{ thisQuestion.point }}</h4>
    </div>
    <div v-if="showEdit" class="md:flex items-center justify-between">
        <div class="md:basis-4/6">
            <my-label
                :required="true"
                name="questions"
                value="سوال"
                class="inline-block ml-2"
            />
            <my-textarea
                id="questions"
                v-model="editQuestion.questions"
                :value="editQuestion.questions"
                :required="true"
                class="inline-block"
            />
        </div>
        <div class="md:basis-1/6">
            <Label :required="true" value="نمره سوال" />
            <my-input v-model.lazy="editQuestion.point" />
        </div>
    </div>
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
import MyLabel from "@/component/Label.vue";
import MyInput from "@/component/Input.vue";

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
    point: thisQuestion.point,
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
        editQuestion.point = thisQuestion.point;
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
    if (!editQuestion.questions || !editQuestion.point) {
        errorToast("تمام فیلد های ستاره دار را پر کنید");
    } else {
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
                thisQuestion.questions = editQuestion.questions;
                thisQuestion.point = editQuestion.point;
            },
            onFinish: () => {
                showEdit.value = !showEdit.value;
            },
        });
    }
    setTimeout(() => {
        loding.value = false;
    }, 200);
}
</script>

<style></style>
