<template>
    <v-layout justify-center >
        <v-flex shrink xs12>
            <RouterView />
        </v-flex>
    </v-layout>
</template>

<script>
    import Agendamiento from '../../../components/agendamiento/Agendamiento.vue'
 
    export default {
        name: 'Agendamiento',
        components: {
            Agendamiento
        },
        mounted(){
            this.setMenu();
        },
        methods:{
            setMenu(){
                this.$store.commit('setMenu', {
                    title: 'Módulo Citas',
                    items: [
                        { name: 'Asignación Citas', path: '/citas' },
                    ],
                    enabled: true
                })
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>