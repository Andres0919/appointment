<template>
    <v-layout justify-center fluid fill-height>
        <v-flex shrink xs12>
            <v-card height="40%">
                <TablePaciente />
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import TablePaciente from '../../../components/paciente/TablePaciente.vue'
    export default {
        name: 'Permisos',
        components:{
            TablePaciente
        }
    }
</script>

<style lang="scss" scoped>

</style>