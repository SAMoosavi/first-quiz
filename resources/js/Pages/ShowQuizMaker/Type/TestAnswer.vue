<template>
    <h3 v-if="!showEdit">{{ editQuestion.questions }}</h3>
    <my-textarea
        v-if="showEdit"
        v-model="editQuestion.questions"
        :value="editQuestion.questions"
        :required="true"
    />
    <ul
        class="grid grid-cols-1 gap-2 my-3 mr-4 group-hover:list-decimal md:grid-cols-2 lg:grid-cols-4 sm:gap-3 md:gap-4 dark:text-gray-200"
    >
        <li v-for="(option, key) in editQuestion.option" :key="key">
            <div class="flex items-center">
                <my-label :required="true" class="inline-block ml-2" />
                <my-radio
                    v-model="num"
                    class="inline-block"
                    :value="key"
                    :name="index"
                    :checked="num == key ? true : false"
                    :disabled="!showEdit && num != key"
                />
                <my-input
                    class="inline-block w-3/4 mx-2"
                    v-model.lazy="editQuestion.option[key]"
                    :disabled="!showEdit"
                />
            </div>
        </li>
    </ul>
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
import MyInput from "@/component/Input.vue";
import MyButton from "@/component/Button.vue";
import MyButtonDanger from "@/component/ButtonDanger.vue";
import MyRadio from "@/component/Radio.vue";
import MyLabel from "@/component/Label.vue";

import { useForm } from "@inertiajs/inertia-vue3";
import { reactive, ref } from "@vue/reactivity";
import { useToast } from "vue-toastification";
import { watch } from "vue";

const props = defineProps(["question", "index"]);
const thisQuestion = reactive({
    uuid: props.question.uuid,
    questions: props.question.questions,
    option: JSON.parse(props.question.option),
    answer: JSON.parse(props.question.answer),
});

const pNum = ref(null);
for (const key in thisQuestion.option) {
    thisQuestion.answer == thisQuestion.option[key] ? (pNum.value = key) : "";
}
const num = ref(pNum.value);

const editQuestion = useForm({
    uuid: thisQuestion.uuid,
    questions: thisQuestion.questions,
    option: {
        ans1: thisQuestion.option.ans1,
        ans2: thisQuestion.option.ans2,
        ans3: thisQuestion.option.ans3,
        ans4: thisQuestion.option.ans4,
    },
    answer: thisQuestion.answer,
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

//check edite
for (const key in editQuestion.option) {
    watch(
        () => editQuestion.option[key],
        (newVal) => {
            if (key == num.value) {
                editQuestion.answer = newVal;
            }
        }
    );
}

watch(num, (newVal) => {
    editQuestion.answer = editQuestion.option[newVal];
});

function editCansel() {
    lodingCansel.value = true;
    setTimeout(() => {
        editQuestion.questions = thisQuestion.questions;
        editQuestion.answer = thisQuestion.answer;
        for (const key in thisQuestion.option) {
            editQuestion.option[key] = thisQuestion.option[key];
        }
        num.value = pNum.value;
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

    // editQuestion.put(this.route("edit.question"), {
    //     onError: (errors) => {
    //         for (const property in errors) {
    //             errorToast(errors[property]);
    //         }
    //     },
    //     onSuccess: () => {
    //         toast.success("سوال با موفقیت ویرایش شد", {
    //             position: "bottom-right",
    //             timeout: 5000,
    //             closeOnClick: true,
    //             pauseOnFocusLoss: true,
    //             pauseOnHover: true,
    //             draggable: true,
    //             draggablePercent: 0.6,
    //             showCloseButtonOnHover: false,
    //             hideProgressBar: false,
    //             closeButton: "button",
    //             icon: true,
    //             rtl: false,
    //         });
    //     },
    //     onFinish: () => {
    thisQuestion.questions = editQuestion.questions;
    for (const key in thisQuestion.option) {
        thisQuestion.option[key] = editQuestion.option[key];
    }
    thisQuestion.answer = editQuestion.answer;
    pNum.value = num.value;
    showEdit.value = !showEdit.value;
    loding.value = false;
    //     },
    // });
}
</script>

<style></style>
