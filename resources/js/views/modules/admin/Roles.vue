<template>
    <v-layout justify-center >
        <v-flex shrink xs12>
            <v-layout row wrap>
                <v-flex xs6 px-1>
                    <TableRole />
                </v-flex>
                <v-flex xs6 px-1>
                    <TablePermiso />
                </v-flex>
            </v-layout>
        </v-flex>
    </v-layout>
</template>

<script >
    import TableRole from '../../../components/role/TableRole.vue'
    import TablePermiso from '../../../components/permiso/TablePermiso.vue'

    export default {
        components:{
            TableRole,
            TablePermiso
        }
    }
</script>

<style lang="scss" scoped>

</style>