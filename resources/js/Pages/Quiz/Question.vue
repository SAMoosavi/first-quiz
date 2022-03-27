<template>
    <transition-group
        tag="div"
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="transform opacity-0 -translate-x-1/3"
        enter-to-class="transform translate-x-0 opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="transform translate-x-0 opacity-100"
        leave-to-class="transform opacity-0 -translate-x-1/4"
        move-class="transition transform-all"
    >
        <template v-if="showTopOf">
            <question :showChilder="showChilderTop" />
        </template>

        <div
            :key="index"
            v-if="showInOf"
            class="flex flex-col items-center justify-between w-full p-1 py-4 my-2 transition-all duration-200 transform border-2 border-indigo-500 border-dotted divide-indigo-500 shadow lg:flex-row group hover:scale-x-105 dark:border-indigo-400 hover:border-solid shadow-transparent hover:shadow-indigo-800 dark:hover:shadow-indigo-400"
        >
            <div class="flex-auto w-full px-2 group-hover:px-4">
                <creat-question :index="index" />
            </div>
            <div
                class="flex flex-auto gap-3 px-2 md:hidden group-hover:px-4 md:group-hover:flex lg:group-hover:flex-col"
            >
                <Button type="button" @click="add" :loding="lodAdd">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                    </svg>
                </Button>
                <Button type="button" @click="remove" :loding="lodRemove">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 13h6m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                    </svg>
                </Button>
            </div>
        </div>

        <template v-if="showBottomOf">
            <question :showChilder="showChilderBottom" />
        </template>
    </transition-group>
</template>
<script>
import { ref } from "@vue/reactivity";
import { watch } from "@vue/runtime-core";
import { useStore } from "vuex";
import { useToast } from "vue-toastification";
import CreatQuestion from "./CreatQuestion.vue";
import Button from "@/component/Button.vue";

export default {
    components: { CreatQuestion, Button },
    name: "Question",
    props: {
        showChilder: Number,
    },
    setup(props) {
        const showTopOf = ref(false);
        const showInOf = ref(true);
        const showBottomOf = ref(false);
        const showChilderBottom = ref(0);
        const showChilderTop = ref(0);
        const index = new Date().getTime();
        const toast = useToast();
        const store = useStore();
        const lodAdd = ref(false);
        const lodRemove = ref(false);

        function toastSuccess(text) {
            toast.success(text, {
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
                    toastSuccess("سوال با موفقیت افزوده شد");
                } else {
                    showChilderTop.value = newVall;
                }
            }
        );

        store.commit("addQuestions", index);

        function add() {
            /*
             *خانه ی پایین را می سازد و اگر ساخته شده بود به فرزند می گوید که بسازد
             */
            lodAdd.value = true;
            if (!showBottomOf.value) {
                showBottomOf.value = true;

                toastSuccess("سوال با موفقیت افزوده شد");
            } else {
                showChilderBottom.value = showChilderBottom.value + 1;
            }
            setTimeout(() => (lodAdd.value = false), 200);
        }

        function remove() {
            lodRemove.value = true;
            if (store.getters.getSizeQuestions > 1) {
                setTimeout(() => {
                    store.commit("removeQuestion", index);
                    showInOf.value = false;
                    toastSuccess("سوال با موفقیت حذف شد");
                }, 200);
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
            setTimeout(() => (lodRemove.value = false), 200);
        }

        return {
            add,
            remove,
            showTopOf,
            showInOf,
            showBottomOf,
            showChilderBottom,
            showChilderTop,
            index,
            lodAdd,
            lodRemove,
        };
    },
};
</script>

<style></style>
