<template>
    <v-card min-height="100%" >
        <v-container pa-1>
            <v-container pt-3 pb-1>
                <v-layout row>
                    <v-dialog v-model="dialog" persistent max-width="600px">
                    <v-card>
                        <v-card-title>
                        <span v-if="save" class="headline">Crear Especialidad</span>
                        <span v-else class="headline">Editar Especialidad</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container grid-list-md>
                                <v-layout wrap>
                                <v-flex xs12 sm6 md6>
                                    <v-text-field label="Nombre *" v-model="data.Nombre" required></v-text-field>
                                </v-flex>
                                </v-layout>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" flat @click="dialog = false">Cancelar</v-btn>
                        <v-btn v-if="save" color="blue darken-1" flat @click="saveEspecialidad()">Guardar</v-btn>
                        <v-btn v-else color="blue darken-1" flat @click="updateEspecialidad()">Actualizar</v-btn>
                        </v-card-actions>
                    </v-card>
                    </v-dialog>
                </v-layout>
            </v-container>
            <v-card-title>
                <v-layout row wrap justify-center>
                    <span class="headline">Especialidades</span>
                </v-layout>
                <v-layout row wrap>
                    <v-btn round @click="createEspecialidad()" color="primary" dark><v-icon left>exposure_plus_1</v-icon>Nueva Especialidad</v-btn>
                    <v-spacer></v-spacer>
                    <v-flex
                    sm5 
                    xs12>
                        <v-text-field
                            v-model="search"
                            append-icon="search"
                            label="Buscar..."
                            single-line
                            hide-details
                        ></v-text-field>
                    </v-flex>
                </v-layout>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="especialidades"
                :search="search"
                >
                <template v-slot:items="props">
                    <td>{{ props.item.id }}</td>
                    <td class="text-xs-right">{{ props.item.Nombre }}</td>
                    <td class="text-xs-right">
                        <v-btn fab outline color="warning" small @click="editTipoAgenda(props.item)"><v-icon>edit</v-icon></v-btn>
                    </td>
                </template>
                <v-alert v-slot:no-results :value="true" color="error" icon="warning">
                    Your search for "{{ search }}" found no results.
                </v-alert>
            </v-data-table>
        </v-container>
    </v-card>
</template>

<script>
    import { mapGetters } from 'vuex';
    export default {
        name:'TableEspecialidad',
        data() {
            return {
                especialidades: [],
                search: '',
                headers: [
                    {
                        text: 'id',
                        align: 'left',
                        value: 'id'
                    },
                    {
                        text: 'Nombre',
                        align: 'right',
                        sortable: false,
                        value: 'Nombre'
                    },
                    {
                        text: '',
                        align: 'right',
                        sortable: false,
                        value: ''
                    }
                ],
                save: true,
                dialog: false,
                data:{
                    Nombre: ''
                },
            }
        },
        mounted () {
            this.fetchEspecialidad();
        },
        computed: {
            ...mapGetters(['can'])
        },
        methods: {
            fetchEspecialidad() {
                axios.get('/api/especialidad/all')
                    .then(res => this.especialidades = res.data);
            },
            createEspecialidad(){
                this.emptyData();
                this.save = true;
                this.dialog = true;
            },
            showError(message){
                swal({
                    title: "¡No puede ser!",
                    text: `${message.name}`,
                    icon: "warning",
                });
            },
            emptyData(){
                this.data = {
                    Nombre: '',
                }
            },
            saveEspecialidad(){
                axios.post('/api/especialidad/create',this.data)
                .then(res => {
                    this.emptyData();
                    this.dialog = false;
                    this.fetchEspecialidad();
                    swal({
                        title: "¡Especialidad Creada!",
                        text: " ",
                        timer: 2000,
                        icon: "success",
                        buttons: false
                    });
                })
                .catch(err => this.showError(err.response.data))
            },
            editTipoAgenda(especialidades){
                this.data = especialidades;
                this.save = false;
                this.dialog = true;
            },
            updateEspecialidad() {
                axios.put(`/api/especialidad/edit/${this.data.id}`,this.data)
                    .then(res => {   
                        this.emptyData();
                        this.dialog = false;
                        this.fetchEspecialidad();   
                        swal({
                            title: "¡Especialidad Actualizada!",
                            text: " ",
                            timer: 2000,
                            icon: "success",
                            buttons: false
                        });
                    })
                    .catch(err => console.log(err.response.data));
            },
        },
    }
</script>
<style lang="scss" scoped>

</style>