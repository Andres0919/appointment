<template>
    <v-layout justify-center >
        <v-flex shrink xs12>
            <v-card min-height="100%">
                <TableUser />
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
import TableUser from '../../../components/user/TableUser'
export default {
    components:{
        TableUser,
    }
}
</script>

<style lang="scss" scoped>

</style>