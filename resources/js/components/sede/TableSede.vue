<template>
    <v-container pa-1>
        <v-container pt-3 pb-1>
            <v-layout row>
                <v-dialog v-model="dialog" persistent max-width="600px">
                <v-card>
                    <v-card-title>
                    <span v-if="save" class="headline">Crear Sede</span>
                    <span v-else class="headline">Editar Sede</span>
                    </v-card-title>
                    <v-card-text>
                    <v-container grid-list-md>
                        <v-layout wrap>
                        <v-flex xs12 sm6 d-flex>
                            <v-autocomplete
                            v-model="data.Municipio_id"
                            :items="municipios"
                            label="Municipio"
                            item-text="Nombre"
                            item-value="id"
                            v-validate="'required'"
                            ></v-autocomplete>
                        </v-flex>
                        <v-flex xs12 sm6 md6>
                            <v-text-field 
                                label="Nombre*" 
                                v-model="data.Nombre" 
                                required>
                            </v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 md6>
                            <v-text-field 
                                label="Direccion*" 
                                v-model="data.Direccion"
                                v-validate="'required'"
                                :error-messages="errors.collect(data.Direccion)"
                                required>
                            </v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 md6>
                            <v-text-field 
                                label="Telefono*" 
                                v-model="data.Telefono"
                                v-validate="'required|max:20|integer'" 
                                required>
                            </v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 md6>
                            <v-text-field label="NIT*" v-model="data.Nit" required></v-text-field>
                        </v-flex>
                        <pre>{{data}}</pre>
                        </v-layout>
                    </v-container>
                    </v-card-text>
                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" flat @click="dialog = false">Cancelar</v-btn>
                    <v-btn v-if="save" color="blue darken-1" flat @click="saveSede()">Guardar</v-btn>
                    <v-btn v-else color="blue darken-1" flat @click="updateSede()">Actualizar</v-btn>
                    </v-card-actions>
                </v-card>
                </v-dialog>
            </v-layout>
        </v-container>
        <v-container pt-3 pb-1>
            <v-layout row>
                <v-dialog v-model="subDialog" persistent max-width="600px">
                <v-card>
                    <v-card-title>
                    <span v-if="save" class="headline">Crear Consultorio</span>
                    <span v-else class="headline">Editar Consultorio</span>
                    </v-card-title>
                    <v-card-text>
                    <v-container grid-list-md>
                        <v-layout wrap>
                        <v-flex xs12 sm6 md6>
                            <v-text-field 
                                label="Nombre*" 
                                v-model="subData.Nombre"
                                v-validate="'requiered|max:13|string'"
                                :counter="13"
                                :error-messages="errors.collect('Nombre')"
                                data-vv-name="Nombre"
                                required>                                
                            </v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 md6>
                            <v-select
                                v-model="subData.Descripcion"
                                v-validate="'required'"
                                :items="items"
                                :error-messages="errors.collect(subData.Descripcion)"
                                label="Piso*"
                                data-vv-name="subData.Descripcion"
                                required>
                            </v-select>
                        </v-flex>
                        <v-flex xs12 sm6 md6>
                            <v-text-field label="Número Pacientes*" v-model="subData.Cantidad"  required></v-text-field>
                        </v-flex>
                        <pre>{{subData}}</pre>
                        </v-layout>
                    </v-container>
                    </v-card-text>
                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" flat @click="subDialog = false">Cancelar</v-btn>
                    <v-btn v-if="subSave" color="blue darken-1" flat @click="saveConsultorio()">Guardar</v-btn>
                    <v-btn v-else color="blue darken-1" flat @click="updateConsultorio()">Actualizar</v-btn>
                    </v-card-actions>
                </v-card>
                </v-dialog>
            </v-layout>
        </v-container>
        <v-card-title>
            <v-btn round @click="createSede()"  color="primary" dark><v-icon left>person_add</v-icon>Nueva Sede</v-btn>
        <v-spacer></v-spacer>
        <v-flex 
         xs1
         sm5
         >
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
            :items="sedes"
            :search="search"
            rowsPerPageText="Filas por página"
            >
            <template v-slot:items="props">
            <tr @click="expandTable(props)">
                <td>{{ props.item.id }}</td>
                <td class="text-xs-right">{{ props.item.Nombre }}</td>
                <td class="text-xs-right">{{ props.item.Direccion }}</td>
                <td class="text-xs-right">{{ props.item.Telefono }}</td>
                <td class="text-xs-right">{{ props.item.Nit }}</td>
                <td class="text-xs-right">
                    <v-btn fab outline color="warning" small @click="editSede(props.item)"><v-icon>edit</v-icon></v-btn>
                    <v-btn fab outline color="success" small @click="createConsultorio(props)" ><v-icon>add</v-icon></v-btn>
                </td>
            </tr>
            </template>
            <template v-slot:expand="props">
                <v-data-table
                 :headers="subHeaders"
                 :items="consultorios"
                 :hide-actions="true"
                 >
                    <template v-slot:items="props">
                        <td>{{ props.item.id }}</td>
                        <td class="text-xs-right">{{ props.item.Nombre }}</td>
                        <td class="text-xs-right">{{ props.item.Descripcion }}</td>
                        <td class="text-xs-right">{{ props.item.Cantidad }}</td>
                        <td class="text-xs-right">
                            <v-btn fab color="warning" small @click="editConsultorio(props.item)"><v-icon>edit</v-icon></v-btn>
                        </td>
                    </template>

                    <v-card flat>
                    <v-card-text>{{ props.item.Nombre }}</v-card-text>
                    </v-card>
                </v-data-table>
            </template>
            <v-alert v-slot:no-results :value="true" color="error" icon="warning">
                Your search for "{{ search }}" found no results.
            </v-alert>
        </v-data-table>
    </v-container>
</template>

<script>
    import { mapGetters } from 'vuex';
    export default {
        name:'TableSede',
        data() {
            return {
                expand: false,
                sedes: [],
                municipios:[],
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
                        text: 'Direccion',
                        align: 'right',
                        sortable: false,
                        value: 'Direccion'
                    },
                    {
                        text: 'Telefono',
                        align: 'right',
                        sortable: false,
                        value: 'Telefono'
                    },
                    {
                        text: 'NIT',
                        align: 'right',
                        sortable: false,
                        value: 'Nit'
                    },
                    {
                        text: '',
                        align: 'right',
                        sortable: false,
                        value: ''
                    }
                ],
                subHeaders: [
                     {  text: 'id', align: 'left', value: 'id' },
                     {  text: 'Nombre', align: 'right', value: 'Nombre' },
                     {  text: 'Piso', align: 'right', value: 'Descripcion' },
                     {  text: 'Cantidad', align: 'right', value: 'Cantidad' },
                     {  text: '', align: 'right', value: '' },
                ],
                save: true,
                subSave: true,
                dialog: false,
                subDialog: false,
                data:{
                    Nombre:'',
                    Direccion:'',
                    Telefono: '',
                    Nit:'',
                    Municipio_id:''
                },
                subData:{
                    Sede_id: '',
                    Nombre: '',
                    Descripcion: '',
                    Cantidad: ''
                },
                consultorios: [],
                items: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']
            }
        },

        mounted () {
            this.fetchSedes();
            this.fetchMunicipios();
        },
        computed: {
            ...mapGetters(['can'])
        },
        methods: {
            fetchSedes() {
                axios.get('/api/sede/all')
                    .then(res => this.sedes = res.data);
            },
            fetchMunicipios() {
                axios.get('/api/municipio/all')
                    .then(res => this.municipios = res.data);
            },
            createSede(){
                this.emptyData();
                this.save = true;
                this.dialog = true;
            },
            async createConsultorio(sede){
                await this.emptySubData();
                this.subData.Sede_id = sede.item.id;
                this.subSave = true;
                this.subDialog = true;
            },
            showError(message){
                let msg = message.message || message.Nombre
                swal({
                    title: "¡No puede ser!",
                    text: `${msg}`,
                    icon: "warning",
                });
            },
            async expandTable(props){
                await this.getConsultorios(props.item.id);
                props.expanded = !props.expanded;
                
            },
            getConsultorios(sedeId){
                axios.get(`/api/sede/${sedeId}/consultorio/all`)
                .then(res =>  this.consultorios = res.data )
                .catch(err => this.showError(err.response.data))
            },
            emptyData(){
                this.data = {
                    Nombre: '',
                    Direccion: '',
                    Telefono: '',
                    Nit: '',
                    Municipio_id:''
                }
            },
            emptySubData(){
                this.subData = {
                    Sede_id: '',
                    Nombre: '',
                    Descripcion: ''
                }
            },
            saveSede(){
                axios.post('/api/sede/create',this.data)
                .then(res => {
                    this.emptyData();
                    this.dialog = false;
                    this.fetchSedes();
                    swal({
                        title: "¡Sede Creada!",
                        text: " ",
                        timer: 2000,
                        icon: "success",
                        buttons: false
                    });
                })
                .catch(err => this.showError(err.response.data))
            },
            saveConsultorio(){
                axios.post(`/api/sede/${this.subData.Sede_id}/consultorio/create`,this.subData)
                .then(res => {
                    this.subDialog = false;
                    this.getConsultorios(this.subData.Sede_id);
                    this.emptySubData();
                    swal({
                        title: "¡Consultorio Creado!",
                        text: " ",
                        timer: 2000,
                        icon: "success",
                        buttons: false
                    });
                })
                .catch(err => {
                    this.showError(err.response.data)
                })
            },
            editSede(role){
                this.data = role;
                this.save = false;
                this.dialog = true;
            },
            editConsultorio(consultorio){
                this.subData = consultorio;
                this.subSave = false;
                this.subDialog = true;
            },
            updateSede() {
                axios.put(`/api/sede/edit/${this.data.id}`,this.data)
                    .then(res => {   
                        this.emptyData();
                        this.dialog = false;
                        this.fetchSedes();   
                        swal({
                            title: "¡Sede Actualizada!",
                            text: " ",
                            timer: 2000,
                            icon: "success",
                            buttons: false
                        });
                    })
                    .catch(err => console.log(err.response.data));
            },
            updateConsultorio(){
                axios.put(`/api/sede/${this.subData.Sede_id}/consultorio/edit/${this.subData.id}`,this.subData)
                    .then(res => {   
                        this.emptySubData();
                        this.subDialog = false;
                        swal({
                            title: "¡Consultorio Actualizado!",
                            text: " ",
                            timer: 2000,
                            icon: "success",
                            buttons: false
                        });
                    })
                    .catch(err => console.log(err.response.data));
            }
        },
    }
</script>
<style lang="scss" scoped>

</style>