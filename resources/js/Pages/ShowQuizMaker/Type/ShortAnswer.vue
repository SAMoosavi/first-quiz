<template>
<h3>{{question.questions}}</h3>
    <Input :disabled="true" :required="false" class="w-1/2 my-3 md:w-1/3" />
</template>
<script>
import Input from "@/component/Input.vue";
export default {
    components: { Input },
    props:['question']
};
</script>

<style></style>
