<template>
    <base-material-card :icon="resource.icon" :title="title">
        <va-list disable-create disable-export :filters="filters">
            <template v-slot:actions>
                <va-action-button
                    label="Send notify"
                    icon="mdi-send"
                    text
                    :loading="isSending"
                    @click="dialog = true"
                ></va-action-button>
            </template>
            <va-data-table :fields="fields"> </va-data-table>
        </va-list>
        <v-dialog v-model="dialog" max-width="900">
            <v-card>
                <v-toolbar dark color="primary">
                    <v-btn icon dark @click="dialog = false">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                    <v-toolbar-title> Send notify </v-toolbar-title>
                </v-toolbar>
                <v-list>
                    <v-list-item>
                        <v-list-item-content>
                            <v-card-text v-if="isSending">
                                Loading...
                                <v-progress-linear
                                    indeterminate
                                ></v-progress-linear>
                            </v-card-text>
                            <v-text-field
                                label="Title"
                                v-model="messageTitle"
                                :disabled="isSending"
                                autofocus
                            ></v-text-field>
                            <v-text-field
                                label="Body"
                                v-model="messageBody"
                                :disabled="isSending"
                            ></v-text-field>
                            <v-checkbox
                                label="Sound"
                                v-model="messageSound"
                                :disabled="isSending"
                            ></v-checkbox>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary darken-1"
                        :disabled="!canClickSend"
                        :loading="isSending"
                        @click="sendNotify"
                    >
                        Send
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </base-material-card>
</template>

<script>
export default {
    props: ["resource", "title"],
    data() {
        return {
            filters: [
                { source: "id" },
                "expo_push_token",
                { source: "locale", alwaysOn: true },
                { source: "timezone", alwaysOn: true },
                { source: "updated_at", type: "date" },
            ],
            fields: [
                { source: "id", sortable: true },
                "expo_push_token",
                { source: "locale", sortable: true },
                { source: "timezone", sortable: true },
                { source: "updated_at", type: "date", sortable: true },
            ],
            isSending: false,
            dialog: false,
            messageTitle: "",
            messageBody: "",
            messageSound: false,
        };
    },
    computed: {
        canClickSend: function () {
            return Boolean(
                !this.isSending && this.messageTitle && this.messageBody
            );
        },
    },
    methods: {
        sendNotify: async function () {
            this.isSending = true;
            try {
                await this.$store.dispatch("customers/create", {
                    data: {
                        title: this.messageTitle,
                        body: this.messageBody,
                        sound: this.messageSound ? 1 : 0,
                    },
                });
            } catch (e) {
                console.log(e);
            } finally {
                this.isSending = false;
                this.closeNotifyModal();
            }
        },
        closeNotifyModal: function () {
            this.dialog = false;
            this.messageTitle = "";
            this.messageBody = "";
            this.messageSound = false;
        },
    },
};
</script>
