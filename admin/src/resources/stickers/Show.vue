<template>
    <va-show-layout>
        <va-show :item="item">
            <v-row justify="center">
                <v-col sm="6">
                    <base-material-card>
                        <template v-slot:heading>
                            <div class="display-2">
                                {{ title }}
                            </div>
                        </template>
                        <v-card-text>
                            <va-field source="id" type="number"></va-field>
                            <va-field
                                source="sticker_id"
                                type="number"
                            ></va-field>
                            <va-field source="description"></va-field>
                            <va-field source="pack_name"></va-field>
                            <va-field source="family_name"></va-field>
                            <va-field source="team_name"></va-field>
                            <va-field source="pack_name"></va-field>
                            <va-field
                                source="created_at"
                                type="date"
                            ></va-field>
                            <va-field
                                source="updated_at"
                                type="date"
                            ></va-field>
                        </v-card-text>
                    </base-material-card>
                </v-col>
            </v-row>
        </va-show>
    </va-show-layout>
</template>

<script>
export default {
    props: ["title", "item"],
};
</script>
