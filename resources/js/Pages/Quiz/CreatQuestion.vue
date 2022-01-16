<template>
    <div class="md:flex md:justify-between">
        <div class="w-full md:w-4/6 md:gap-2 lg:gap-4">
            <Label :required="true" :value="'سوال'" />
            <textarea
                name="question"
                id="question"
                v-model.lazy="question.question"
                class="w-full border-transparent"
                rows="1"
                required
            ></textarea>
        </div>
        <div class="md:w-1/6">
            <Label :required="true" :value="'نوع سوال'" />
            <select
                name="type"
                id="type"
                class="w-full border-transparent"
                v-model="question.type"
                required
            >
                <option value="test-answer">پاسخ تستی</option>
                <option value="long-answer">پاسخ طولانی</option>
                <option value="short-answer">پاسخ کوتاه</option>
            </select>
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

export default {
    components: {
        Label,
        LongAnswer,
        ShortAnswer,
        TestAnswer,
    },

    props: ["index"],

    setup(props) {
        const store = useStore();

        const question = reactive({
            type: "test-answer",
            question: null,
            option: {},
            answer: {},
        });

            const index = props.index;
        function getOption(val) {
            question.option = val;
            store.commit("editQuestions", {question, index});
        }

        function getAnswer(val) {
            question.answer = val;
            store.commit("editQuestions", {question, index});
        }

        watch(
            () => question.question,
            () => {
                store.commit("editQuestions", {question, index});
            }
        );
        watch(
            () => question.type,
            () => {
                store.commit("editQuestions", {question, index});
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
