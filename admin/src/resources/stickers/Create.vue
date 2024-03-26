<template>
    <va-create-layout>
        <stickers-form :title="title" :item="item"></stickers-form>
    </va-create-layout>
</template>

<script>
export default {
    props: ["title", "item"],
};
</script>
