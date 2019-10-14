<template>
    <v-card min-height="100%">
        <v-container pa-1>
            <v-container pt-3 pb-1>
                <v-layout row>
                    <v-dialog v-model="dialog" persistent max-width="600px">
                    <v-card>
                        <v-card-title>
                        <span v-if="save" class="headline">Crear Actividad</span>
                        <span v-else class="headline">Editar Actividad</span>
                        </v-card-title>
                        <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12 sm6 md6>
                                    <v-text-field label="Nombre *" v-model="data.name" required></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-container>
                        </v-card-text>
                        <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" flat @click="dialog = false">Cancelar</v-btn>
                        <v-btn v-if="save" color="blue darken-1" flat @click="saveActividad()">Guardar</v-btn>
                        <v-btn v-else color="blue darken-1" flat @click="updateActividad()">Actualizar</v-btn>
                        </v-card-actions>
                    </v-card>
                    </v-dialog>
                </v-layout>
            </v-container>
            <v-card-title>
                <v-flex xs12>
                    <span class="headline layout justify-center">Actividades</span>
                </v-flex>
                    <v-flex xs4>                        
                        <v-btn round @click="createActividad()" color="primary" dark><v-icon left>exposure_plus_1</v-icon>Nueva Actividad</v-btn>
                    </v-flex>
                    <v-spacer></v-spacer>
                    <v-flex
                    xs6>
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
                :items="tAgenda"
                :search="search"
                >
                <template v-slot:items="props">
                    <td>{{ props.item.id }}</td>
                    <td class="text-xs-right">{{ props.item.name }}</td>
                    <td class="text-xs-right">
                        <v-btn fab outline color="warning" small @click="editActividad(props.item)"><v-icon>edit</v-icon></v-btn>
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
        name:'TableTipoAgenda',
        data() {
            return {
                tAgenda: [],
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
                        value: 'name'
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
                    name: ''
                },
            }
        },
        mounted () {
            this.fetchActividad();
        },
        computed: {
            ...mapGetters(['can'])
        },
        methods: {
            fetchActividad() {
                axios.get('/api/tipoagenda/all')
                    .then(res => this.tAgenda = res.data);
            },
            createActividad(){
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
                    name: ''
                }
            },
            saveActividad(){
                axios.post('/api/tipoagenda/create',this.data)
                .then(res => {
                    this.emptyData();
                    this.dialog = false;
                    this.fetchActividad();
                    swal({
                        title: "¡Actividad Creado!",
                        text: " ",
                        timer: 2000,
                        icon: "success",
                        buttons: false
                    });
                })
                .catch(err => this.showError(err.response.data))
            },
            editActividad(tAgenda){
                this.data.id = tAgenda.id;
                this.data.name = tAgenda.name;
                this.save = false;
                this.dialog = true;
            },
            updateActividad() {
                axios.put(`/api/tipoagenda/edit/${this.data.id}`,this.data)
                    .then(res => {   
                        this.emptyData();
                        this.dialog = false;
                        this.fetchActividad();   
                        swal({
                            title: "¡Actividad Actualizado!",
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