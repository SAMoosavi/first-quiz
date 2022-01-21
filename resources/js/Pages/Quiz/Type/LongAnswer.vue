<template>
    <Textarea :required="false" :disabled="true" />
</template>
<script>
import { onMounted } from "@vue/runtime-core";
import Textarea from "@/component/Textarea.vue";
export default {
    components: { Textarea },
    setup(props, { emit }) {
        onMounted(() => {
            emit("option", null);
            emit("answer", null);
        });
    },
};
</script>

<style></style>
