<template>
    <h3 v-if="!showEdit">{{ question.questions }}</h3>
    <my-textarea
        v-if="showEdit"
        v-model="editQuestion.questions"
        :value="editQuestion.questions"
        :required="true"
    />
    <ul
        class="grid grid-cols-1 gap-2 my-3 mr-4 group-hover:list-decimal md:grid-cols-2 lg:grid-cols-4 sm:gap-3 md:gap-4 dark:text-gray-200"
    >
        <li v-for="(option, key) in options" :key="key">
            <div class="flex items-center">
                <my-label :required="true" class="inline-block ml-2" />
                <my-radio
                    v-model="ans.num"
                    class="inline-block"
                    :value="key"
                    :name="index"
                    :checked="ans.answer == option ? true : false"
                    :disabled="!showEdit"
                />
                <my-input
                    class="inline-block w-3/4 mx-2"
                    v-model.lazy="options[key]"
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
// const emit = defineEmits([])

//decode Json and creat ans object
const options = reactive(JSON.parse(props.question.option));
const ans = reactive({ num: null, answer: JSON.parse(props.question.answer) });
for (const key in options) {
    ans.answer == options[key] ? (ans.num = key) : "";
}

const editQuestion = useForm({
    questions: props.question.questions,
    option: options,
    answer: ans.answer,
    uuid: props.question.uuid,
});

const showEdit = ref(false);
const loding = ref(false);
const lodingCansel = ref(false);

function edit() {
    loding.value = true;
    showEdit.value = true;
    loding.value = false;
}
function editCansel() {
    lodingCansel.value = true;
    editQuestion.questions = props.question.questions;
    showEdit.value = !showEdit.value;
    lodingCansel.value = false;
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

//check edite
for (const key in options) {
    watch(
        () => options[key],
        (newVal) => {
            if (key == ans.num) {
                ans.answer = newVal;
            }
        }
    );
}
watch(
    () => ans.num,
    (val) => {
        ans.answer = options[val];
    }
);

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
    //         editQuestion.questions = props.question.questions;
    //         showEdit.value = !showEdit.value;
    //         loding.value = false;
    //     },
    // });
}
</script>

<style></style>
