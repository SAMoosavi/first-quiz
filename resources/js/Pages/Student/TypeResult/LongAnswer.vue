<template>
    <div class="w-full p-4">
        <div class="my-2 font-medium">
            <h3>{{ question.questions }}</h3>
        </div>
        <div class="flex justify-between gap-2">
            <h3>{{ question.answerStudent }}</h3>
            <h3>{{ question.point }}/{{ question.pointStudent }}</h3>
        </div>
    </div>
</template>

<script setup>
defineProps(["question"]);
</script>
