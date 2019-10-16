<template>
    <v-layout justify-center >
        <v-flex shrink xs12>
            <RouterView />
        </v-flex>
    </v-layout>
</template>

<script>
    import {EventBus} from '../../../event-bus.js';

    export default {
        name:'HistoriaClinicaLayout',
        created() {
            this.citaPaciente = this.$route.query.cita_paciente;
            this.getPaciente( );
        },
        mounted(){
            this.setMenu();
        },
        methods:{
            setMenu(){
                this.$store.commit('setMenu', {
                    title: 'Módulo Historia Clinica',
                    items: [
                        
                    ],
                    enabled: false
                })
            },
            getPaciente() {
                console.log('object');
                axios.get('/api/cita/'+this.citaPaciente+'/datospaciente').then((res) => {
                    this.paciente = res.data
                    EventBus.$emit('informacion-paciente-layout', this.paciente)
                })
            }
        },
        data() {
            return {
                citaPaciente: 0,
                paciente: null
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>