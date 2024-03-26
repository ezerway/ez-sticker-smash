<template>
    <va-edit-layout>
        <stickers-form :id="id" :title="title" :item="item"></stickers-form>
    </va-edit-layout>
</template>

<script>
export default {
    props: ["id", "title", "item"],
};
</script>
