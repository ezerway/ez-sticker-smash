<template>
    <va-edit-layout>
        <customers-form :id="id" :title="title" :item="item"></customers-form>
    </va-edit-layout>
</template>

<script>
export default {
    props: ["id", "title", "item"],
};
</script>
