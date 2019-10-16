<template>
    <v-layout justify-center >
        <v-flex shrink xs12>
            <RouterView />
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: 'AuditoriaLayout',
        components: {
        },
        mounted(){
            this.setMenu();
        },
        methods:{
            setMenu(){
                this.$store.commit('setMenu', {
                    title: 'Módulo Auditoria',
                    items: [
                        { name: 'Auditoria Medicamentos', path: '/auditoria/home', can: 'auditoria.medicamentos.enter'},
                        { name: 'Auditoria Servicios', path: '/auditoria/service', can: 'auditoria.servicios.enter'},
                        { name: 'Historico', path: '/auditoria/historico', can: 'auditoria.historico.enter' },
                        { name: 'Incapacidades', path: '/auditoria/incapacidad', can: 'auditoria.incapacidades.enter' },
                    ],
                    enabled: true
                })
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>