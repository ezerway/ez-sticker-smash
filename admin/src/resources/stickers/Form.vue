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
                        <va-number-input source="sticker_id"></va-number-input>
                        <va-text-input source="description"></va-text-input>
                        <va-text-input source="pack_name"></va-text-input>
                        <va-text-input source="family_name"></va-text-input>
                        <va-text-input source="team_name"></va-text-input>
                        <va-text-input source="pack_name"></va-text-input>
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
