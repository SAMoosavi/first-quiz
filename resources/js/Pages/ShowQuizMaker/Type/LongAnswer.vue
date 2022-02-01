<template>
  <h3 v-if="!showEdit">{{ question.questions }}</h3>
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
import { ref } from "@vue/reactivity";
import { useToast } from "vue-toastification";

const props = defineProps(["question", "index"]);
// const emit = defineEmits([])

const editQuestion = useForm({
  questions: props.question.questions,
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
