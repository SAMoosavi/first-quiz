<template>
    <div class="md:flex md:justify-between">
        <div class="w-full md:w-4/6 md:gap-2 lg:gap-4">
            <Label :required="true" :value="'سوال'" />
            <Textarea
                :name="'question'"
                :id="'question'"
                v-model.lazy="question.question"
            />
        </div>
        <div class="md:w-1/6">
            <Label :required="true" :value="'نوع سوال'" />
            <Select :name="'type'" :id="'type'" v-model="question.type">
                <Option :value="'test-answer'">پاسخ تستی</Option>
                <Option :value="'long-answer'">پاسخ طولانی</Option>
                <Option :value="'short-answer'">پاسخ کوتاه</Option>
            </Select>
        </div>
    </div>
    <component
        :is="question.type"
        @option="getOption"
        @answer="getAnswer"
        :index="$props.index"
    />
</template>
<script>
import { reactive } from "@vue/reactivity";
import Label from "@/component/Label.vue";
import LongAnswer from "@/Pages/Quiz/Type/LongAnswer.vue";
import ShortAnswer from "@/Pages/Quiz/Type/ShortAnswer.vue";
import TestAnswer from "@/Pages/Quiz/Type/TestAnswer.vue";
import { watch } from "@vue/runtime-core";
import { useStore } from "vuex";
import Textarea from "@/component/Textarea.vue";
import Select from "@/component/Select.vue";
import Option from "@/component/Option.vue";

export default {
    components: {
        Label,
        LongAnswer,
        ShortAnswer,
        TestAnswer,
        Textarea,
        Select,
        Option,
    },

    props: ["index"],

    setup(props) {
        const store = useStore();

        const question = reactive({
            type: "test-answer",
            question: null,
            option: {},
            answer: null,
        });

        const index = props.index;
        function getOption(val) {
            question.option = val;
            store.commit("editQuestions", { question, index });
        }

        function getAnswer(val) {
            question.answer = val;
            store.commit("editQuestions", { question, index });
        }

        watch(
            () => question.question,
            () => {
                store.commit("editQuestions", { question, index });
            }
        );
        watch(
            () => question.type,
            () => {
                store.commit("editQuestions", { question, index });
            }
        );

        return {
            getOption,
            getAnswer,
            question,
        };
    },
};
</script>

<style></style>
