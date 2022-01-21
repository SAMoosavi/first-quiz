<template>
    <span>{{ error }}</span>
</template>

<script>
import { computed } from "@vue/reactivity";
import { useToast } from "vue-toastification";

export default {
    props: ["message"],
    setup(props) {
        const error = computed(() => {
            if (props.message) {
                useToast().error(props.message, {
                    position: "bottom-right",
                    timeout: 5000,
                    closeOnClick: true,
                    pauseOnFocusLoss: true,
                    pauseOnHover: true,
                    draggable: true,
                    draggablePercent: 0.6,
                    showCloseButtonOnHover: false,
                    hideProgressBar: false,
                    closeButton: "button",
                    icon: true,
                    rtl: false,
                });
            }
        });
        return { error };
    },
};
</script>
