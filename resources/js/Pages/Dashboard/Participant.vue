<template>
    <Title> آزمون هایی که شرکت کردید </Title>
    <div
        v-for="participant in participants"
        :key="participant.id"
        class="text-black"
    >
        <Card :item="participant" />
    </div>
    <div v-if="participants.length == 0">
        <div
            class="p-1 py-4 my-2 transition-all transform border-2 border-indigo-500 border-dotted shadow hover:scale-x-[1.02] dark:border-indigo-400 hover:border-solid shadow-transparent hover:shadow-indigo-800 dark:hover:shadow-indigo-400"
        >
            <Title class="py-3"> آزمونی وجود ندارد </Title>
        </div>
    </div>
</template>

<script>
import Title from "@/component/Title.vue";
import Card from "@/component/Card.vue";
export default {
    components: {
        Title,
        Card,
    },
    props: ["participants"],
};
</script>

<style></style>
