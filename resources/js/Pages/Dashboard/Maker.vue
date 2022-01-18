<template>
    <Title> آزمون هایی که ساختید </Title>
    <div>
        <Link :href="route('create.quiz')">
            <div
                class="p-1 py-4 my-2 transition-all transform border-2 border-indigo-500 border-dotted shadow hover:scale-x-[1.02] dark:border-indigo-400 hover:border-solid shadow-transparent hover:shadow-indigo-800 dark:hover:shadow-indigo-400"
            >
                <Title v-if="makers.length == 0" class="py-3">
                    آزمونی وجود ندارد برای ساخت آزمون کلیک کنید
                </Title>
                <Title v-else class="py-3"> ساخت آزمون جدید </Title>
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
