<template>
    <div>
        <button v-if="button" type="submit" class="w-full text-left" :class="classes">
            <slot></slot>
        </button>

        <a v-else-if="a" :href="href" :class="classes">
            <slot></slot>
        </a>

        <Link v-else :href="href" :class="classes">
            <slot></slot>
        </Link>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Link,
    },
    props: ["href", "as"],

    setup(props) {
        const button = props.as == "button" ? true : false;
        const a = props.as == "a" ? true : false;
        const classes =
            "block px-4 py-2 text-sm leading-5 text-gray-200 dark:text-gray-700 hover:text-white hover:dark:text-black hover:bg-sky-500 hover:dark:bg-sky-600 focus:text-white focus:outline-none focus:dark:text-black transition";

        return {
            button,
            a,
            classes,
        };
    },
};
</script>
