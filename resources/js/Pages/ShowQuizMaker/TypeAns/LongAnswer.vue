<template>
    <div class="md:flex md:justify-between md:items-start">
        <h3>{{ props.ans.questions }}</h3>
        <div class="lg:basis-1/12 sm:basis-3/12 flex items-center gap-2">
            <div class="flex items-center gap-2">
                <my-input v-model="point.point" />
                <span> /{{ props.ans.point }} </span>
            </div>
        </div>
    </div>
    <div class="mt-2">
        <my-textarea
            class="text-justify break-all"
            :value="props.ans.answerStudent"
            :required="false"
            :disabled="true"
        />
    </div>
</template>
<script setup>
import MyInput from "@/component/Input.vue";
import MyTextarea from "@/component/Textarea.vue";
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

point.point = props.ans.pointStudent
    ? props.ans.pointStudent
    : localStorage.getItem(`${point.studentId},${point.questionId}`)
    ? localStorage.getItem(`${point.studentId},${point.questionId}`)
    : !props.ans.answerStudent
    ? 0
    : "";

const store = useStore();
onMounted(() => {
    localStorage.setItem(`${point.studentId},${point.questionId}`, point.point);
    store.commit("addQuestionId", point);
});
watch(
    () => point.point,
    (val, pval) => {
        store.commit("pointQuestion", point);
        localStorage.setItem(
            `${point.studentId},${point.questionId}`,
            point.point
        );
        let points = parseFloat(localStorage.getItem(`${point.studentId},*`));
        let v = val && val != "-" ? parseFloat(val) : 0;
        let pv = pval && pval != "-" ? parseFloat(pval) : 0;
        if (val == ".") {
            point.point = "0.";
            v = 0;
        }
        if (pval == ".") pv = 0;
        points += -pv + v;
        points = points.toFixed(2);
        localStorage.setItem(`${point.studentId},*`, points);
        store.commit("pointStudents", {
            point: points,
            studentId: point.studentId,
        });
    }
);
</script>
