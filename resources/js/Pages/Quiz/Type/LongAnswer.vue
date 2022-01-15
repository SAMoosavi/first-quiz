<template>
    <textarea  disabled rows="1" class="w-full my-3 bg-gray-300 border-transparent"></textarea>
</template>
<script>
import { onMounted } from "@vue/runtime-core";
export default {
    setup(props,{emit}) {
        onMounted(() => {
            emit('option',null);
            emit('answer',null);
        });
    },
};
</script>

<style></style>
