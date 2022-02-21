<template>
    <div
        class="flex flex-col gap-3 px-2 py-3 border border-indigo-600 shadow-md shadow-indigo-500"
    >
        <button class="flex items-center gap-4" @click="showAns = !showAns">
            <div class="w-12 overflow-hidden rounded-full">
                <img
                    :src="student.student.profile_photo_url"
                    alt="image user"
                />
            </div>
            <div class="flex flex-col items-start">
                <h3>{{ student.student.name }}</h3>
                <h3>{{ student.student.email }}</h3>
            </div>
        </button>

        <transition
            enter-active-class="transition duration-200 ease-out origin-top "
            enter-from-class="origin-top transform scale-y-0 opacity-0 "
            enter-to-class="origin-top transform scale-y-100 opacity-100 "
            leave-active-class="transition duration-200 ease-in origin-top "
            leave-from-class="origin-top transform scale-y-100 opacity-100 "
            leave-to-class="origin-top transform scale-y-0 opacity-0 "
        >
            <div v-if="showAns" class="flex flex-col gap-3">
                <div
                    v-for="(ans, index) in student.ans"
                    :key="index"
                    class="p-4 border border-indigo-300"
                >
                    <component :is="components[ans.type]" :ans="ans" />
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
// Type
import LongAnswer from "@/Pages/ShowQuizMaker/TypeAns/LongAnswer.vue";
import ShortAnswer from "@/Pages/ShowQuizMaker/TypeAns/ShortAnswer.vue";
import TestAnswer from "@/Pages/ShowQuizMaker/TypeAns/TestAnswer.vue";

import { ref } from "@vue/reactivity";

defineProps(["student"]);

// Type
const components = {
    "long-answer": LongAnswer,
    "short-answer": ShortAnswer,
    "test-answer": TestAnswer,
};

const showAns = ref(false);
</script>
