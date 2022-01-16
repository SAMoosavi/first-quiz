<template>
    <template v-if="showTopOf">
        <question :showChilder="showChilder" />
    </template>
    <li v-if="showInOf" class="flex flex-col items-start justify-start w-full">
        <div class="w-full">
            <creat-question :index="index" />
        </div>
        <div>
            <button
                type="button"
                @click="add"
                class="px-5 m-3 text-center bg-white"
            >
                +
            </button>
            <button
                type="button"
                @click="remove"
                class="px-5 m-3 text-center bg-white"
            >
                -
            </button>
        </div>
    </li>

    <template v-if="showBottomOf">
        <question :showChilder="showChilder" />
    </template>
</template>
<script>
import { ref } from "@vue/reactivity";
import { watch } from "@vue/runtime-core";
import CreatQuestion from "./CreatQuestion.vue";
import { useStore } from "vuex";
import { useToast } from "vue-toastification";

export default {
    components: { CreatQuestion },
    name: "Question",
    props: {
        showChilder: Number,
    },
    setup(props) {
        const showTopOf = ref(false);
        const showInOf = ref(true);
        const showBottomOf = ref(false);
        const showChilder = ref(0);
        const index = new Date().getTime();
        const toast = useToast();
        const store = useStore();
        watch(
            () => props.showChilder,
            (newVall) => {
                /*
                 *اگر خانه‌ی بالا ساخته نشده بود آن را می سازد
                 *در غیر این صورت مقدار ارسالی رو تغییر می دهد تا به فرزند ارسال شود
                 *که او بسازد اگر او هم بالا را ساخته بود
                 *دو باره به فرزند و به صورت بازگشتی ادامه دارد این روند
                 */
                if (!showTopOf.value) {
                    showTopOf.value = true;
                } else {
                    showChilder.value = newVall;
                }
            }
        );

        store.commit("addQuestions", index);
        
        function add() {
            /*
             *خانه ی پایین را می سازد و اگر ساخته شده بود به فرزند می گوید که بسازد
             */
            if (!showBottomOf.value) {
                showBottomOf.value = true;

                toast.success("سوال با موفقیت افزوده شد", {
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
            } else {
                showChilder.value = showChilder.value + 1;
            }
        }

        function remove() {
            if (store.getters.getSizeQuestions > 1) {
                store.commit("removeQuestion", index);
                showInOf.value = false;
                toast.success("سوال با موفقیت حذف شد", {
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
            } else {
                toast.error(
                    "نمی توان این سوال رو حذف کرد شما باید حداقل یک سوال داشته باشید",
                    {
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
                    }
                );
            }
        }

        return {
            add,
            remove,
            showTopOf,
            showInOf,
            showBottomOf,
            showChilder,
            index,
        };
    },
};
</script>

<style></style>
