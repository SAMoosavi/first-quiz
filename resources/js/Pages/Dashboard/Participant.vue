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
            class="border-2 border-sky-300 dark:border-sky-600 hover:border-solid border-dotted p-1 py-4 my-2"
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
