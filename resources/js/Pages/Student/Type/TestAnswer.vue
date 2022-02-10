<template>
    <div class="w-full p-4">
        <div class="my-2 font-medium">
            <h3>{{ question.questions }}</h3>
        </div>

        <ul class="flex flex-col md:flex-row md:justify-between">
            <li v-for="answer in option" :key="answer">
                <my-radio
                    v-model="ans.ans"
                    class="inline-block"
                    :id="answer"
                    :value="answer"
                    :name="index"
                    :checked="answer == ans.ans ? true : false"
                />
                <my-label
                    :name="answer"
                    :value="answer"
                    class="inline-block mr-2"
                />
            </li>
        </ul>
    </div>
</template>

<script setup>
import MyInput from "@/component/Input.vue";
import MyLabel from "@/component/Label.vue";
import MyRadio from "@/component/Radio.vue";

import { reactive } from "@vue/reactivity";
import { onMounted, watch } from "@vue/runtime-core";
import { useStore } from "vuex";

const props = defineProps(["question", "in"]);
const index = props.in;
const ansLocalstoreeg = !!localStorage.getItem(props.question.id)
    ? localStorage.getItem(props.question.id)
    : null;

const ans = reactive({
    id: props.question.id,
    type: props.question.type,
    ans: ansLocalstoreeg,
});

const option = _.shuffle(JSON.parse(props.question.option));

const store = useStore();

onMounted(() => {
    store.commit("addAnswer", { index, ans });
});

watch(
    () => ans.ans,
    (value) => {
        localStorage.setItem(ans.id, value);
        store.commit("editAnswer", { index, ans });
    }
);
</script>
