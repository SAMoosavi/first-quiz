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
    id: props.question.id,
    uuid: props.question.uuid,
    questions: props.question.questions,
    option: JSON.parse(props.question.option),
    answer: props.question.answer,
    point: props.question.point,
});

const pNum = ref(null);
for (const key in thisQuestion.option) {
    thisQuestion.answer == thisQuestion.option[key] ? (pNum.value = key) : "";
}
const num = ref(pNum.value);

const editQuestion = useForm({
    id: thisQuestion.id,
    uuid: thisQuestion.uuid,
    questions: thisQuestion.questions,
    option: {
        ans1: thisQuestion.option.ans1,
        ans2: thisQuestion.option.ans2,
        ans3: thisQuestion.option.ans3,
        ans4: thisQuestion.option.ans4,
    },
    answer: thisQuestion.answer,
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
        editQuestion.point = thisQuestion.point;
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
function validation() {
    for (const key in editQuestion.option) {
        if (!editQuestion.option[key]) return false;
    }
    return true;
}

function editing() {
    loding.value = true;
    if (
        !editQuestion.questions ||
        !editQuestion.answer ||
        !validation() ||
        !editQuestion.point
    ) {
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
                for (const key in thisQuestion.option) {
                    thisQuestion.option[key] = editQuestion.option[key];
                }
                thisQuestion.answer = editQuestion.answer;
                pNum.value = num.value;
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
