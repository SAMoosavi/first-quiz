<template>
    <Head title="home" />

    <div
        class="min-h-screen bg-gray-100 dark:bg-gray-900 "
    >
        <div
            class="flex w-full px-6 py-4 bg-sky-700 dark:bg-sky-400"
        >
            <navbar-link v-if="$page.props.user" :href="route('dashboard')">
                داشبورد
            </navbar-link>

            <template v-else>
                <navbar-link :href="route('login')"> ورود </navbar-link>

                <navbar-link :href="route('register')"> عضویت </navbar-link>
            </template>
            <on-off-dark-mode class="inline-block ml-4 mr-auto" />
            <Logo />
        </div>
        <why-u-s />
        Hi
    </div>
</template>

<script>
import { defineComponent } from "vue";
import { Head } from "@inertiajs/inertia-vue3";
import OnOffDarkMode from "@/component/OnOffDarkMode.vue";
import NavbarLink from "@/component/NavbarLink.vue";
import Logo from "@/component/Logo.vue";
import WhyUS from "./Home/WhyUS.vue";

export default defineComponent({
    components: {
        Head,
        OnOffDarkMode,
        NavbarLink,
        Logo,
        WhyUS,
    },
});
</script>

<style></style>
