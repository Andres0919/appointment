<template>
    <v-layout justify-center >
        <v-flex shrink xs12>
            <v-card min-height="100%">
                <Agendamiento />
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import Agendamiento from '../../../components/agendamiento/Agendamiento.vue'
 
    export default {
        name: 'AgendamientoMedico',
        components: {
            Agendamiento
        }
    }
</script>

<style lang="scss" scoped>

</style>