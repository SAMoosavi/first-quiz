<template>
    <Link
        class="border-2 border-sky-300 dark:border-sky-600 hover:border-solid border-dotted p-1 my-2 grid grid-cols-4"
        :href="route('show.quiz', { uuid: item.id })"
    >
        <!-- name quiz -->
        <div>
            <card-title> نام آزمون : </card-title>
            <card-text>
                {{ item.name }}
            </card-text>
        </div>
        <!-- maker
         <div>
            <card-title> سازنده آزمون : </card-title>
            <card-text
            >
                <slot name="maker" />
            </card-text>
        </div> -->
        <!-- start time -->
        <div v-if="item.start">
            <card-title> شروع آزمون : </card-title>
            <card-text>
                {{ item.start }}
            </card-text>
        </div>
        <!-- end time -->
        <div v-if="item.end">
            <card-title> پایان آزمون : </card-title>
            <card-text>
                {{ item.end }}
            </card-text>
        </div>
        <!-- time -->
        <div v-if="item.time">
            <card-title> مدت آزمون : </card-title>
            <card-text>
                {{ item.time }}
            </card-text>
        </div>
    </Link>
</template>
<script>
import { Link } from "@inertiajs/inertia-vue3";
import CardTitle from "@/component/CardTitle.vue";
import CardText from "@/component/CardText.vue";
export default {
    components: {
        Link,
        CardTitle,
        CardText,
    },
    props: ["item"],
};
</script>
