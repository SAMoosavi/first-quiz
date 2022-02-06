<template>
    <div class="w-full p-4">
        <div class="my-2 font-medium">
            <h3>{{ question.questions }}</h3>
        </div>
        <div><my-textarea class="w-full" v-model.lazy="ans.ans" /></div>
    </div>
</template>

<script setup>
import MyTextarea from "@/component/Textarea.vue";
import { reactive } from "@vue/reactivity";
import { onMounted, watch } from "@vue/runtime-core";
import { useStore } from "vuex";

const props = defineProps(["question", "in"]);
const index = props.in;

const ans = reactive({
    id: props.question.id,
    ans: null,
});
const store = useStore();
onMounted(() => {
    store.commit("addAnswer", { index, ans });
});

watch(
    () => ans.ans,
    (value) => {
        store.commit("editAnswer", { index, ans });
    }
);
</script>
