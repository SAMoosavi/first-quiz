<template>
    <ul
        class="grid grid-cols-1 gap-2 my-3 list-decimal md:grid-cols-2 lg:grid-cols-4 sm:gap-3 md:gap-4"
    >
        <li v-for="(option, index) in options" :key="index">
            <input type="radio" v-model="ans.num" :value="index" />
            <Input
                class="w-3/4 mx-2"
                v-model.lazy="options[index]"
            />
        </li>
    </ul>
</template>

<script>
import Input from "@/component/Input.vue";
import { reactive } from "@vue/reactivity";
import { watch } from "@vue/runtime-core";
export default {
    components: { Input },

    props: ["index"],

    setup(props, { emit }) {
        const options = reactive({
            ans1: null,
            ans2: null,
            ans3: null,
            ans4: null,
        });
        const ans = reactive({
            num: null,
            ans: null,
        });

        for (const key in options) {
            watch(
                () => options[key],
                (newVal) => {
                    emit("option", options);
                    if (key == ans.num) {
                        ans.ans = newVal;
                    }
                }
            );
        }

        watch(
            () => ans.ans,
            (val) => {
                emit("answer", val);
            }
        );

        watch(
            () => ans.num,
            (val) => {
                ans.ans = options[val];
                emit("answer", ans.ans);
            }
        );

        return {
            options,
            ans,
        };
    },
};
</script>

<style></style>
