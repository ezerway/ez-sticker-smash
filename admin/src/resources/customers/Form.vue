<template>
    <va-form :id="id" :item="item">
        <v-row justify="center">
            <v-col sm="6">
                <base-material-card>
                    <template v-slot:heading>
                        <div class="display-2">
                            {{ title }}
                        </div>
                    </template>
                    <v-card-text>
                        <va-number-input source="id"></va-number-input>
                        <va-text-input source="expo_push_token"></va-text-input>
                        <va-text-input source="locale"></va-text-input>
                        <va-date-input source="created_at"></va-date-input>
                        <va-date-input source="updated_at"></va-date-input>
                    </v-card-text>
                    <va-save-button></va-save-button>
                </base-material-card>
            </v-col>
        </v-row>
    </va-form>
</template>

<script>
export default {
    props: ["id", "title", "item"],
};
</script>
