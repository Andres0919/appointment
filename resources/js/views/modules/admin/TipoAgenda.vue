<template>
    <div>
        <v-layout justify-center >
            <v-flex shrink xs12 px-1>
                <TableEspecialidad />
            </v-flex>
            <v-flex shrink xs12 px-1>
                    <TableTipoAgenda />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex shrink xs12 pa-1>
                <TableEspecialidadTAgenda />
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
    import TableTipoAgenda from '../../../components/tipos_agenda/TableTipoAgenda.vue'
    import TableEspecialidad from '../../../components/tipos_agenda/TableEspecialidad.vue'
    import TableEspecialidadTAgenda from '../../../components/tipos_agenda/TableEspecialidadTAgenda.vue'
 
    export default {
        name: 'TipoAgenda',
        components: {
            TableTipoAgenda,
            TableEspecialidad,
            TableEspecialidadTAgenda
        }
    }
</script>

<style lang="scss" scoped>

</style>