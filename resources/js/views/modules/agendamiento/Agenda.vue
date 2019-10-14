<template>
    <v-layout justify-center >
        <v-flex shrink xs12>
            <v-card min-height="100%">
                <AgendaTable />
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import AgendaTable from '../../../components/agendamiento/AgendaTable.vue'
    export default {
        name:'Agendas',
        components: {
            AgendaTable
        }
    }
</script>

<style lang="scss" scoped>

</style>