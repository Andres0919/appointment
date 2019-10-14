<template>
    <v-layout justify-center >
        <v-flex shrink xs12>
            <router-view></router-view>
        </v-flex>
    </v-layout>
</template>

<script>
    
    import { mapMutations } from 'vuex'
    export default {
        name: 'Admin',
        components: {
        },
        mounted(){
            this.setMenu();
        },
        methods:{
            setMenu(){
                
                this.$store.commit('setMenu', {
                    title: '',
                    items: [
                        { name: 'Pacientes', path: '/admin/pacientes' },
                        { name: 'Tipos Agenda', path: '/admin/tipos-agenda' },
                        { name: 'Sedes', path: '/admin/sedes' },
                        { name: 'Roles y Permisos', path: '/admin/roles' },
                        { name: 'Usuarios', path: '/admin/users' },
                    ],
                    enabled: true
                })
            }
        }
    }
</script>

<style scoped>

</style>