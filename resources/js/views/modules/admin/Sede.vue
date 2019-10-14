<template>
    <v-layout justify-center >
        <v-flex shrink xs12>
            <v-card min-height="100%">
                <TableSede />
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import TableSede from '../../../components/sede/TableSede.vue'
 
    export default {
        name: 'Sede',
        components: {
            TableSede
        }
    }
</script>

<style lang="scss" scoped>

</style>