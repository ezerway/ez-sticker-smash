<template>
    <v-form ref="form" @submit.prevent="validate">
        <div class="text-right text-body-2">
            <router-link :to="{ name: 'register' }">
                {{ $t("auth.register") }} &gt;
            </router-link>
        </div>

        <v-text-field
            :label="$t('auth.username')"
            prepend-icon="mdi-account"
            v-model="form.username"
            required
            :error-messages="errorMessages.email"
        ></v-text-field>

        <div class="text-right text-body-2">
            <router-link :to="{ name: 'forgot_password' }">
                {{ $t("auth.forgot_password") }} &gt;
            </router-link>
        </div>

        <v-text-field
            :label="$t('auth.password')"
            prepend-icon="mdi-lock"
            type="password"
            v-model="form.password"
            required
        ></v-text-field>

        <v-checkbox
            v-model="form.remember"
            :label="$t('auth.remember')"
        ></v-checkbox>

        <div class="text-center">
            <v-btn
                :loading="loading"
                color="primary"
                large
                type="submit"
                text
                rounded
                >{{ $t("auth.sign_in") }}</v-btn
            >
        </div>
    </v-form>
</template>

<script>
import { mapActions } from "vuex";

export default {
    data() {
        return {
            form: {
                username: null,
                password: null,
                remember: false,
            },
            errorMessages: {},
            loading: false,
        };
    },
    methods: {
        ...mapActions({
            login: "auth/login",
        }),
        async validate() {
            if (this.$refs.form.validate()) {
                this.loading = true;

                try {
                    await this.login(this.form);
                } catch (e) {
                    if (e.errors) {
                        this.errorMessages = e.errors;
                        return;
                    }

                    this.errorMessages = { email: [e.message] };
                } finally {
                    this.loading = false;
                }
            }
        },
    },
};
</script>

<style scoped>
#login-page {
    background-color: var(--v-primary-lighten5);
}
</style>
