<template>
    <div class="w-full p-4">
        <div class="my-2 font-medium">
            <h3>{{ question.questions }}</h3>
        </div>
        <div class="flex gap-3">
            <ul class="flex flex-col w-full md:flex-row md:justify-between">
                <li v-for="answer in question.option" :key="answer">
                    <my-radio
                        class="inline-block"
                        :disabled="true"
                        :checked="
                            answer == question.answerStudent ? true : false
                        "
                    />
                    <my-label
                        :value="answer"
                        class="inline-block mr-2"
                        :class="{
                            'text-green-600': question.answer == answer,
                        }"
                    />
                </li>
            </ul>
            <h3>{{ question.point }}/{{ question.pointStudent }}</h3>
        </div>
    </div>
</template>

<script setup>
import MyLabel from "@/component/Label.vue";
import MyRadio from "@/component/Radio.vue";

defineProps(["question"]);
</script>
