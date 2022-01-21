<template>
    <Input :disabled="true" :required="false" class="w-1/2 my-3 md:w-1/3" />
</template>
<script>
import { onMounted } from "@vue/runtime-core";
import Input from "@/component/Input.vue";
export default {
    components: { Input },
    setup(props, { emit }) {
        onMounted(() => {
            emit("option", null);
            emit("answer", null);
        });
    },
};
</script>

<style></style>
