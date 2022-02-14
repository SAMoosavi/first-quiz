<template>
    <Link
        class="p-1 py-4 my-2 transition-all justify-items-center duration-150 transform border-2 border-indigo-500 border-dotted shadow hover:scale-x-[1.02] dark:border-indigo-400 shadow-transparent hover:shadow-indigo-800 dark:hover:shadow-indigo-400 grid grid-cols-4 hover:border-solid"
        :href="route(`${thisRoute}.quiz`, { uuid: item.uuid })"
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
        <!-- time -->
        <div>
            <card-title> مدت آزمون : </card-title>
            <card-text>
                {{ item.time }}
            </card-text>
        </div>
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
    props: ["item", "thisRoute"],
};
</script>
