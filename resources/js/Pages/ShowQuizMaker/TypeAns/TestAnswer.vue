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
    <ul
        class="grid grid-cols-1 gap-2 my-3 mr-4 group-hover:list-decimal md:grid-cols-2 lg:grid-cols-4 sm:gap-3 md:gap-4 dark:text-gray-200"
    >
        <li v-for="(option, key) in props.ans.option" :key="key">
            <div class="flex items-center">
                <my-radio
                    class="inline-block"
                    :value="key"
                    :checked="option == props.ans.answerStudent ? true : false"
                    :disabled="true"
                />
                <my-label
                    class="inline-block mr-2"
                    :class="{
                        'text-green-700':
                            option == JSON.parse(props.ans.answer),
                    }"
                    :value="option"
                />
            </div>
        </li>
    </ul>
</template>
<script setup>
import MyInput from "@/component/Input.vue";
import MyLabel from "@/component/Label.vue";
import MyRadio from "@/component/Radio.vue";

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
        : props.ans.answerStudent != props.ans.answer
        ? 0
        : props.ans.point;
const store = useStore();

onMounted(() => {
    store.commit("addQuestionId", point);
});

watch(
    () => point.point,
    () => store.commit("pointQuestion", point)
);
</script>
