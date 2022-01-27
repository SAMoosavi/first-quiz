<template>
    <div class="w-full p-4">
        <div class="my-2 font-medium">
            <h3>{{ question.questions }}</h3>
        </div>
        <div><Input class="w-full md:w-1/2 lg:w-1/3" v-model.lazy="ans.ans" /></div>
    </div>
</template>

<script>
import { reactive } from "@vue/reactivity";
import { onMounted, watch } from "@vue/runtime-core";
import { useStore } from "vuex";
import Input from "@/component/Input.vue";
export default {
    components: { Input },
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
