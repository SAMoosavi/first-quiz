<template>
    <ul
        class="grid grid-cols-1 gap-2 my-3 list-decimal md:grid-cols-2 lg:grid-cols-4 sm:gap-3 md:gap-4"
    >
        <li>
            <input type="radio" v-model="ans" id="ans1" :value="ans1" />
            <Input class="w-3/4 mx-2" for="ans1" v-model.lazy="ans1" />
        </li>
        <li>
            <input type="radio" v-model="ans" id="ans2" :value="ans2" />
            <Input class="w-3/4 mx-2" for="ans2" v-model.lazy="ans2" />
        </li>
        <li>
            <input type="radio" v-model="ans" id="ans3" :value="ans3" />
            <Input class="w-3/4 mx-2" for="ans3" v-model.lazy="ans3" />
        </li>
        <li>
            <input type="radio" v-model="ans" id="ans4" :value="ans4" />
            <Input class="w-3/4 mx-2" for="ans4" v-model.lazy="ans4" />
        </li>
    </ul>
</template>

<script>
import Input from "@/component/Input.vue";
import { reactive, ref } from "@vue/reactivity";
import { watch } from "@vue/runtime-core";
export default {
    components: { Input },
    
    props: ["index"],

    setup(props, { emit }) {
        const ans1 = ref("");
        const ans2 = ref("");
        const ans3 = ref("");
        const ans4 = ref("");
        const ans = ref(null);

        const option = reactive({
            ans1: ans1.value,
            ans2: ans2.value,
            ans3: ans3.value,
            ans4: ans4.value,
        });

        watch(ans1, (newVal, prevVal) => {
            option.ans1 = newVal;
            emit("option", option);
            if (prevVal == ans.value) {
                ans.value = newVal;
                emit("answer", ans.value);
            }
        });

        watch(ans2, (newVal, prevVal) => {
            option.ans2 = newVal;
            emit("option", option);
            if (prevVal == ans.value) {
                ans.value = newVal;
                emit("answer", ans.value);
            }
        });

        watch(ans3, (newVal, prevVal) => {
            option.ans3 = newVal;
            emit("option", option);
            if (prevVal == ans.value) {
                ans.value = newVal;
                emit("answer", ans.value);
            }
        });

        watch(ans4, (newVal, prevVal) => {
            option.ans4 = newVal;
            emit("option", option);
            if (prevVal == ans.value) {
                ans.value = newVal;
                emit("answer", ans.value);
            }
        });

        watch(ans, (val) => {
            emit("answer", val);
        });


        return {
            ans1,
            ans2,
            ans3,
            ans4,
            ans,
        };
    },
};
</script>

<style></style>
