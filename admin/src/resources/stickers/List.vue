<template>
    <base-material-card :icon="resource.icon" :title="title">
        <va-list :filters="filters"
                disable-export
                disable-create>
            <va-data-table :fields="fields"

            disable-clone
                    disable-select
                    disable-show
                    disable-edit-redirect
            >
                <template
                        v-slot:[`field.images`]="{ value, item }"
                    >
                        <img
                            width="75"
                            :alt="item.description"
                            :src="value['512']"
                        />
                    </template>
            </va-data-table>
        </va-list>
    </base-material-card>
</template>

<script>
export default {
    props: ["resource", "title"],
    data() {
        return {
            filters: [
                { source: "id" },
                "description",
                "tags",
                "pack_name",
                "family_name",
                "added",
            ],
            fields: [
                { source: "id", sortable: true },
                { source: "images", sortable: false },
                "description",
                "tags",
                { source: "pack_name", sortable: true },
                "family_name",
                "added",
            ],
        };
    },
};
</script>
