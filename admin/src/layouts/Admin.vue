<template>
    <va-layout>
        <va-app-bar
            slot="app-bar"
            :header-menu="headerMenu"
            :profile-menu="profileMenu"
            dense
            dark
            @toggle="
                $vuetify.breakpoint.lgAndUp
                    ? (mini = !mini)
                    : (drawer = !drawer)
            "
        ></va-app-bar>
        <va-sidebar
            slot="sidebar"
            :menu="sidebarMenu"
            v-model="drawer"
            :mini-variant="mini"
        ></va-sidebar>
        <template slot="header">
            <va-breadcrumbs></va-breadcrumbs>
            <impersonate-message></impersonate-message>
        </template>
        <va-aside slot="aside"></va-aside>
        <va-footer slot="footer" :menu="footerMenu">
            &copy; 2020,
            <v-icon size="18"> mdi-xml </v-icon>
            with
            <v-icon size="18"> mdi-heart </v-icon>
            by
            <a href="https://www.company.com">My Awesome Company</a> for a
            better web.
        </va-footer>
    </va-layout>
</template>

<script>
import ImpersonateMessage from "@/components/ImpersonateMessage";
import nav from "../_nav";

export default {
    name: "App",
    components: {
        ImpersonateMessage,
    },
    data() {
        return {
            drawer: null,
            mini: false,
            headerMenu: [
                {
                    link: "/",
                    text: this.$t("menu.dashboard"),
                },
            ],
            footerMenu: [
                {
                    href: "#",
                    text: "About Us",
                },
                {
                    href: "#",
                    text: "Blog",
                },
                {
                    href: "#",
                    text: "License",
                },
            ],
            profileMenu: [
                {
                    icon: "mdi-account",
                    text: this.$t("menu.profile"),
                    link: "/profile",
                },
            ],
            sidebarMenu: nav(this.$i18n, this.$admin),
        };
    },
};
</script>
