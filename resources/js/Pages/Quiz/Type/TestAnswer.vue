<template>
    <ul
        class="grid grid-cols-1 gap-2 my-3 group-hover:list-decimal md:grid-cols-2 lg:grid-cols-4 sm:gap-3 md:gap-4"
    >
        <li v-for="(option, key) in options" :key="key">
            <Label :required="true" class="inline-block ml-2" />
            <Radio v-model="ans.num" :value="key" :name="index" />
            <Input class="w-3/4 mx-2" v-model.lazy="options[key]" required />
        </li>
    </ul>
</template>

<script>
import Input from "@/component/Input.vue";
import Label from "@/component/Label.vue";
import { reactive } from "@vue/reactivity";
import { watch } from "@vue/runtime-core";
import Radio from "@/component/Radio.vue";
export default {
    components: {
        Input,
        Label,
        Radio,
    },

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
