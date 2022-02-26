<template>
    <div class="md:flex md:justify-between md:items-start">
        <h3>{{ props.ans.questions }}</h3>
        <div class="flex items-center gap-2 lg:basis-1/12 sm:basis-3/12">
            <div class="flex items-center gap-2">
                <my-input v-model="point.point" />
                <span> /{{ props.ans.point }} </span>
            </div>
        </div>
    </div>
    <div class="mt-2">
        <my-input
            class="text-justify break-all"
            v-model="props.ans.answerStudent"
            :required="false"
            :disabled="true"
        />
    </div>
</template>
<script setup>
import MyInput from "@/component/Input.vue";
import MyLabel from "@/component/Label.vue";

import { reactive } from "@vue/reactivity";
import { onMounted, watch } from "@vue/runtime-core";

import { useStore } from "vuex";

const props = defineProps(["ans", "studentId"]);

const point = reactive({
    studentId: props.studentId,
    questionId: props.ans.id,
    point: "",
});

point.point =
    props.ans.pointStudent != null || props.ans.pointStudent === 0
        ? props.ans.pointStudent
        : localStorage.getItem(`${point.studentId},${point.questionId}`)
        ? localStorage.getItem(`${point.studentId},${point.questionId}`)
        : props.ans.answerStudent == null && props.ans.pointStudent !== 0
        ? 0
        : "";

const store = useStore();
onMounted(() => {
    store.commit("addQuestionId", point);
});
watch(
    () => point.point,
    () => store.commit("pointQuestion", point)
);
</script>
