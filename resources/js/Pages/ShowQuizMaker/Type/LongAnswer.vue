<template>
    <h3>{{ question.questions }}</h3>
    <Textarea :required="false" :disabled="true" />
</template>
<script>
import Textarea from "@/component/Textarea.vue";
export default {
    components: { Textarea },
    props: ["question"],
};
</script>

<style></style>
