<template>
    <div class="w-full p-4">
        <div class="my-2 font-medium">
            <h3>{{ question.questions }}</h3>
        </div>
        <div><Textarea class="w-full" v-model.lazy="ans.ans" /></div>
    </div>
</template>

<script>
import Textarea from "@/component/Textarea.vue";
import { reactive } from "@vue/reactivity";
import { onMounted, watch } from "@vue/runtime-core";
import { useStore } from "vuex";
export default {
    components: { Textarea },
    props: ["question", "index"],
    setup(props) {
        const ans = reactive({
            uuid: props.question.uuid,
            ans: null,
        });
        const store = useStore();
        onMounted(() => {
            store.commit("addAnswer", { index, ans });
        });

        watch(
            () => ans.ans,
            () => {
                store.commit("editAnswer", { index, ans });
            }
        );
        return { ans };
    },
};
</script>

<style></style>
