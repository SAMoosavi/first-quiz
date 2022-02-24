<template>
    <div
        class="flex flex-col gap-3 px-2 py-3 border border-indigo-600 shadow-md shadow-indigo-500"
    >
        <button class="flex items-center gap-4" @click="showAns = !showAns">
            <div class="w-12 overflow-hidden rounded-full">
                <img
                    :src="props.student.student.profile_photo_url"
                    alt="image user"
                />
            </div>
            <div class="flex flex-col items-start">
                <h3>{{ props.student.student.name }}</h3>
                <h3>{{ props.student.student.email }}</h3>
            </div>
            {{ studentPoint }}
            <!-- <my-button
                :loding="loding"
                type="button"
                @click="send"
                class="w-full md:w-24 mr-auto z-10"
            >
                ثبت نمره
            </my-button> -->
        </button>

        <transition
            enter-active-class="transition duration-200 ease-out origin-top "
            enter-from-class="origin-top transform scale-y-0 opacity-0 "
            enter-to-class="origin-top transform scale-y-100 opacity-100 "
            leave-active-class="transition duration-200 ease-in origin-top "
            leave-from-class="origin-top transform scale-y-100 opacity-100 "
            leave-to-class="origin-top transform scale-y-0 opacity-0 "
        >
            <div v-if="showAns" class="flex flex-col gap-3">
                <div
                    v-for="(ans, index) in props.student.ans"
                    :key="index"
                    class="p-4 border border-indigo-300"
                >
                    <component
                        :is="components[ans.type]"
                        :ans="ans"
                        :studentId="studentId"
                    />
                </div>
                <my-button
                    :loding="loding"
                    type="button"
                    @click="send"
                    class="w-full md:w-24"
                >
                    ثبت نمره
                </my-button>
            </div>
        </transition>
    </div>
</template>

<script setup>
// Type
import LongAnswer from "@/Pages/ShowQuizMaker/TypeAns/LongAnswer.vue";
import ShortAnswer from "@/Pages/ShowQuizMaker/TypeAns/ShortAnswer.vue";
import TestAnswer from "@/Pages/ShowQuizMaker/TypeAns/TestAnswer.vue";

import MyButton from "@/component/Button.vue";

import { ref } from "@vue/reactivity";
import { computed, onMounted, watch } from "@vue/runtime-core";
import { useStore } from "vuex";
import { useToast } from "vue-toastification";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps(["student", "quizId", "status"]);

// Type
const components = {
    "long-answer": LongAnswer,
    "short-answer": ShortAnswer,
    "test-answer": TestAnswer,
};
const studentId = props.student.student.id;

const form = useForm({
    id: props.quizId,
    points: {
        [studentId]: {},
    },
});

watch(
    () => props.status,
    (val) => {
        showAns.value = val;
        console.log(val);
    }
);

const showAns = ref(false);
const store = useStore();
onMounted(() => {
    store.commit("addStudent", studentId);
    if (!localStorage.getItem(`${studentId},*`))
        localStorage.setItem(`${studentId},*`, studentPoint.value);
});

let studentPoint = computed(() =>
    store.getters.getSumPointOfStudents[studentId]
        ? store.getters.getSumPointOfStudents[studentId]
        : localStorage.getItem(`${studentId},*`)
        ? localStorage.getItem(`${studentId},*`)
        : props.student.point
        ? props.student.point
        : "هنوز نمره ای ثبت نشده است"
);

const loding = ref(false);

function validation(v) {
    for (const key in v) {
        const ans = v[key];
        if (ans === "") return false;
    }
    return true;
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

function send() {
    loding.value = true;

    if (!validation(store.getters.getPointOfStudents[studentId])) {
        errorToast("نمره تمامی سوالات را وارد نمایید");
    } else {
        form.points[studentId] = store.getters.getPointOfStudents[studentId];
        form.post(route("send.point"), {
            onError: (errors) => {
                for (const property in errors) {
                    errorToast(errors[property]);
                }
            },
            onSuccess: () => {
                toast.success("نمره با موفقیت ثبت شد", {
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

                for (const key in form[studentId].points) {
                    localStorage.removeItem(studentId + "," + key);
                }
                localStorage.removeItem(studentId + ",*");
                store.commit("removePoint", studentId);
            },
            onFinish: () => {
                showAns.value = !showAns.value;
            },
        });
    }
    setTimeout(() => {
        loding.value = false;
    }, 300);
}
</script>
