<template>
    <v-card min-height="100%">
        <v-container pa-1>
            <v-container pt-3 pb-1>
                <v-layout row>
                    <v-dialog v-model="dialog" persistent max-width="600px">
                    <v-card>
                        <v-card-title>
                        <span v-if="save" class="headline">Crear Tipo Agenda</span>
                        <span v-else class="headline">Editar Tipo Agenda</span>
                        </v-card-title>
                        <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                            <v-flex xs12 sm6 md6>
                                <v-autocomplete
                                    label="Especialidad"
                                    :items="especialidades"
                                    item-text="Nombre"
                                    item-value="id"
                                    v-model="data.especialidad"
                                ></v-autocomplete>
                            </v-flex>
                            <v-flex xs12 sm6 md6>
                                <v-autocomplete
                                    label="Actividad"
                                    :items="actividades"
                                    v-model="data.Tipoagenda_id"
                                    item-text="name"
                                    item-value="id"
                                ></v-autocomplete>
                            </v-flex>
                            <v-flex xs12 sm6 md6>
                                <v-text-field label="Duración(minutos)*" type="number" v-model="data.Duracion" required></v-text-field>
                            </v-flex>
                            </v-layout>
                        </v-container>
                        </v-card-text>
                        <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" flat @click="dialog = false">Cancelar</v-btn>
                        <v-btn v-if="save" color="blue darken-1" flat @click="saveTipoAgenda()">Guardar</v-btn>
                        <v-btn v-else color="blue darken-1" flat @click="updateTipoAgenda()">Actualizar</v-btn>
                        </v-card-actions>
                    </v-card>
                    </v-dialog>
                </v-layout>
            </v-container>
            <v-card-title>
                    <v-flex xs12>
                        <span class="headline layout justify-center">Tipo Agenda </span>
                    </v-flex>
                    <v-flex xs4>
                        <v-btn round @click="createTipoAgenda()" color="primary" dark><v-icon left>exposure_plus_1</v-icon>Nuevo Tipo Agenda</v-btn>
                    </v-flex>
                    <v-spacer></v-spacer>
                    <v-flex
                    sm5 
                    xs5>
                        <v-text-field
                            v-model="search"
                            append-icon="search"
                            label="Buscar..."
                            single-line
                            hide-details
                        ></v-text-field>
                    </v-flex>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="tAgendas"
                :search="search"
                >
                <template v-slot:items="props">
                    <td>{{ props.item.id }}</td>
                    <td class="text-xs-right">{{ props.item.nombreEspecilidad }}</td>
                    <td class="text-xs-right">{{ props.item.nombreActividad }}</td>
                    <td class="text-xs-right">{{ props.item.Duracion }} minutos</td>
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
        name:'TableEspecialidadTAgenda',
        data() {
            return {
                tAgendas: [],
                especialidades: [],
                actividades: [],
                search: '',
                headers: [
                    {
                        text: 'id',
                        align: 'left',
                        value: 'id'
                    },
                    {
                        text: 'Especialidad',
                        align: 'right',
                        sortable: false,
                        value: 'nombreEspecilidad'
                    },
                    {
                        text: 'Actividad',
                        align: 'right',
                        sortable: false,
                        value: 'nombreActividad'
                    },
                    {
                        text: 'Duración',
                        align: 'right',
                        sortable: false,
                        value: 'Duracion'
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
                    especialidad: '',
                    Tipoagenda_id: '',
                    Duracion: 0,
                },
            }
        },
        mounted () {
            this.fetchTipoAgenda();
            this.fetchTipoActividad();
            this.fetchEspecialidad();
        },
        computed: {
            ...mapGetters(['can'])
        },
        methods: {
            fetchTipoAgenda() {
                axios.get('/api/especialidad/Especialidadtipoagenda/all')
                    .then(res => this.tAgendas = res.data);
            },
            fetchTipoActividad() {
                axios.get('/api/tipoagenda/all')
                    .then(res => this.actividades = res.data);
            },
            fetchEspecialidad(){
                axios.get('/api/especialidad/all')
                    .then(res => this.especialidades = res.data);
            },
            createTipoAgenda(){
                this.fetchTipoActividad();
                this.fetchEspecialidad();
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
                    especialidad: '',
                    Tipoagenda_id: '',
                    Duracion: 0,
                }
            },
            saveTipoAgenda(){
                axios.post(`/api/especialidad/${this.data.especialidad}/Especialidadtipoagenda/create`,this.data)
                .then(res => {
                    this.emptyData();
                    this.dialog = false;
                    this.fetchTipoAgenda();
                    swal({
                        title: "¡Tipo Agenda Creado!",
                        text: " ",
                        timer: 2000,
                        icon: "success",
                        buttons: false
                    });
                })
                .catch(err => this.showError(err.response.data))
            },
            editTipoAgenda(tAgenda){
                this.data = tAgenda;
                this.save = false;
                this.dialog = true;
            },
            updateTipoAgenda() {
                axios.put(`/api/tipoagenda/edit/${this.data.id}`,this.data)
                    .then(res => {   
                        this.emptyData();
                        this.dialog = false;
                        this.fetchTipoAgenda();   
                        swal({
                            title: "¡Tipo Agenda Actualizado!",
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