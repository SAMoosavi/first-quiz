<template>
    <Title> آزمون هایی که شرکت کردید </Title>
    <div v-if="makers.length == 0">
        <Link :href="route('create.quiz')">
            <div
                class="border-2 border-sky-300 dark:border-sky-600 hover:border-solid border-dotted p-1 py-4 my-2"
            >
                <Title class="py-3">
                    آزمونی وجود ندارد برای ساخت آزمون کلیک کنید
                </Title>
            </div>
        </Link>
    </div>
    <div v-else>
        <Link :href="route('create.quiz')">
            <div
                class="border-2 border-sky-300 dark:border-sky-600 hover:border-solid border-dotted p-1 py-4 my-2"
            >
                <Title class="py-3"> ساخت آزمون جدید </Title>
            </div>
        </Link>
    </div>
    <div v-for="maker in makers" :key="maker.id" class="text-black">
        <Card :item="maker" />
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import Title from "@/component/Title.vue";
import Card from "@/component/Card.vue";
export default {
    components: {
        Link,
        Title,
        Card,
    },
    props: ["makers"],
};
</script>

<style></style>
