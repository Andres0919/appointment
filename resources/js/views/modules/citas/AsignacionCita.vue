<template>
    <v-layout>
        <template>
            <div class="text-xs-center">
                <v-dialog
                 v-model="dialog"
                 width="500"
                 >
                    <v-card>
                        <v-card-title
                         class="headline"
                         >
                            Agendar Cita
                        </v-card-title>
                        <v-card-text>
                            Asignar cita de tipo <b> {{ actividad_selected }} </b> al usuario <b>{{ paciente.Primer_Nom }} {{ paciente.SegundoNom }} {{ paciente.Primer_Ape}} {{ paciente.Segundo_Ape }}</b> identificado con <b>{{ paciente.Tipo_Doc }}</b>  N° <b>{{ paciente.Num_Doc }}</b> el día <b>{{ fecha_selected }}</b> a las <b>{{ data.hora_inicio }}</b> en la sede <b>{{ sede_selected }}</b> con el médico <b>{{ medico_selected }}</b>
                        </v-card-text>
                        <v-divider></v-divider>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                             flat
                             @click="dialog = false"
                             >
                                cancelar
                            </v-btn>
                            <v-btn
                             color="primary"
                             flat
                             @click="agendarCita()"
                             >
                                Aceptar
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </div>
        </template>
        <v-flex shrink xs4 mr-1>
            <v-card max-height="100%" class="mb-3">
                <v-card-title>
                    <span class="title layout justify-center font-weight-light">Buscar Paciente</span>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-container grid-list-md fluid class="pa-0">
                        <v-layout wrap align-center justify-center>
                            <v-flex xs12>
                                <v-form @submit.prevent="search_paciente()">
                                    <v-layout row wrap>
                                        <v-flex xs10>
                                            <v-text-field v-model="cedula_paciente" label="Número de Documento"></v-text-field>
                                        </v-flex>
                                        <v-flex xs2>
                                            <v-btn 
                                            @click="search_paciente()"
                                            @keyup.enter="search_paciente()"
                                            v-if="!paciente.id"
                                            fab 
                                            outline 
                                            small 
                                            color="success"
                                            >
                                                <v-icon>search</v-icon>
                                            </v-btn> 
                                            <v-btn 
                                                @click="clearFields()"
                                                v-if="paciente.id"
                                                fab 
                                                outline 
                                                small 
                                                color="error"
                                                >
                                                    <v-icon>clear</v-icon>
                                            </v-btn>
                                        </v-flex>
                                    </v-layout>                          
                                </v-form>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card-text>
            </v-card>
            <v-flex>
                <v-expansion-panel>
                    <v-expansion-panel-content>
                        <template v-slot:header>
                            <div>
                                <v-badge right>
                                    <template v-slot:badge>
                                        <span v-if="cita_pendiente.Tipo_agenda" >{{ allcita_pendiente.length }}</span>
                                    </template>
                                    <span>Cita Pendiente</span>
                                </v-badge>
                            </div>
                        </template>
                        <v-divider></v-divider>
                        <v-dialog v-model="motivoCancelar" persistent max-width="600px">
                            <v-card>
                                <v-card-title>
                                <span class="headline">Motivo</span>
                                </v-card-title>
                                <v-card-text>
                                <v-container grid-list-md>
                                    <v-layout wrap>
                                    <v-flex xs12>
                                        <v-textarea
                                            v-model="cancelar.motivo"
                                            name="input-7-1"
                                            label="Motivo por el cual se cancela la cita"
                                            value=""
                                        ></v-textarea>
                                    </v-flex>
                                    </v-layout>
                                </v-container>
                                </v-card-text>
                                <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" flat @click="motivoCancelar = false">Cerrar</v-btn>
                                <v-btn color="blue darken-1" flat @click="cancelarCita()">Enviar</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <v-card>
                            <v-card-text>
                                <v-flex xs12 v-if="cita_pendiente.Tipo_agenda">
                                    <v-list two-line subheader>
                                        <v-menu offset-x>
                                            <template v-slot:activator="{ on }">
                                                <v-btn color="success" v-on="on" flat icon absolute right>
                                                    <v-icon>more_vert</v-icon>
                                                </v-btn>
                                            </template>
                                            <v-list>
                                                <v-list-tile @click="confirmarCita()">
                                                    <v-list-tile-title>Confirmar<v-icon right color="success">check</v-icon></v-list-tile-title>
                                                </v-list-tile>
                                                <v-list-tile @click="openMotivo()">
                                                    <v-list-tile-title>Cancelar 
                                                        <v-icon right color="error">clear</v-icon>
                                                        </v-list-tile-title>
                                                </v-list-tile>
                                            </v-list>
                                        </v-menu>
                                        <span class="headline layout justify-center"> {{ cita_pendiente.Tipo_agenda }}</span>
                                        <p class="text-md-center">{{ cita_pendiente.Especialidad }}</p>
                                        <v-list-tile avatar>
                                            <v-list-tile-content>
                                            <v-list-tile-title>Fecha</v-list-tile-title>
                                            <v-list-tile-sub-title>{{ cita_pendiente.Fecha | fecha_cita_pendiente}}</v-list-tile-sub-title>    
                                            </v-list-tile-content>
                                        </v-list-tile>
                                        <v-list-tile avatar>
                                            <v-list-tile-content>
                                            <v-list-tile-title>Hora</v-list-tile-title>
                                            <v-list-tile-sub-title>{{ cita_pendiente.Hora_Inicio }}</v-list-tile-sub-title>
                                            </v-list-tile-content>
                                        </v-list-tile>
                                        <v-list-tile avatar>
                                            <v-list-tile-content>
                                            <v-list-tile-title>Sede</v-list-tile-title>
                                            <v-list-tile-sub-title>{{ cita_pendiente.Sede }}</v-list-tile-sub-title>
                                            </v-list-tile-content>
                                        </v-list-tile>
                                        <v-list-tile avatar>
                                            <v-list-tile-content>
                                            <v-list-tile-title>Médico</v-list-tile-title>
                                            <v-list-tile-sub-title>{{ cita_pendiente.Nombre_medico }} {{ cita_pendiente.Apellido_medico }}</v-list-tile-sub-title>
                                            </v-list-tile-content>
                                        </v-list-tile>
                                    </v-list>
                                    <v-layout>
                                        <v-spacer></v-spacer>
                                        <v-btn flat small color="primary" @click="todaspendientesmodal = true">ver más!</v-btn>
                                    </v-layout>
                                    <v-dialog
                                    v-model="todaspendientesmodal"
                                    width="80%"
                                    >                                    
                                        <v-card>
                                            <v-card-title
                                            class="headlines lighten-2"
                                            primary-title
                                            >Citas Pendientes
                                            </v-card-title>
                                            <v-card-text>
                                                <v-data-table
                                                :headers="headerCitaPendientes"
                                                :items="allcita_pendiente"
                                                class="elevation-1"
                                                hide-actions
                                                >
                                                    <template v-slot:items="props">
                                                        <td>{{ props.item.Especialidad }}</td>
                                                        <td class="text-xs-center">{{ props.item.Tipo_agenda }}</td>
                                                        <td class="text-xs-center">{{ props.item.Fecha | fecha_cita_pendiente }}</td>
                                                        <td class="text-xs-center">{{ props.item.Hora_Inicio }}</td>
                                                        <td class="text-xs-center">{{ props.item.Sede }}</td>
                                                        <td class="text-xs-center">{{ props.item.Nombre_medico }}</td>
                                                        <td class="text-xs-center">
                                                                <v-btn fab color="success" outline small @click="confirmarCita(props.item)">
                                                                    <v-icon color="success">check</v-icon>
                                                                </v-btn>
                                                                <v-btn fab color="error" outline small @click="openMotivo(props.item)">
                                                                    <v-icon color="error">clear</v-icon>
                                                                </v-btn>
                                                        </td>
                                                    </template>
                                                </v-data-table>
                                            </v-card-text>
                                            <v-divider></v-divider>
                                            <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn
                                            color="primary"
                                            flat
                                            @click="todaspendientesmodal = false"
                                            >Cerrar
                                            </v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                </v-flex> 
                                <h3 v-else class="layout justify-center">Ninguna</h3>
                            </v-card-text>
                        </v-card>
                    </v-expansion-panel-content>
                    <v-expansion-panel-content>
                        <template v-slot:header>
                            <div>Cita Anterior</div>
                        </template>
                        <v-divider></v-divider>
                        <v-card>
                            <v-card-text>
                                <h3 class="layout justify-center">Ninguna</h3>
                            </v-card-text>
                        </v-card>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-flex>
            <v-flex mt-3>
                <v-card>
                    <v-card-title>
                        <span class="title layout justify-center font-weight-light">Fecha disponible</span>
                    </v-card-title>
                    <v-divider></v-divider>

                    <v-card-text>
                        <v-container>
                            <v-layout row wrap>
                                <v-flex xs12>
                                    <v-date-picker v-model="fecha" :allowed-dates="diasDisponibles" locale="es" color="primary" ></v-date-picker>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-flex>
        <v-flex shrink xs8 ml-1 >
            <v-card max-height="100%" class="mb-3">
                <v-card-title>
                    <span class="title layout justify-center font-weight-light">Datos Paciente</span>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-container grid-list-md fluid class="pa-0">
                        <v-layout wrap>
                            <v-flex xs4>
                                <v-text-field v-model="paciente.Primer_Nom" readonly label="Nombre"></v-text-field>
                            </v-flex>
                            <v-flex xs3>
                                <v-text-field v-model="paciente.Primer_Ape" readonly label="Apellido"></v-text-field>
                            </v-flex>
                            <v-flex xs1>
                                <v-text-field v-model="paciente.Tipo_Doc" readonly label="Tipo Documento"></v-text-field>
                            </v-flex>
                            <v-flex xs3>
                                <v-text-field v-model="paciente.Num_Doc" readonly label="Número Documento"></v-text-field>
                            </v-flex>
                            <v-flex xs1>
                                <v-text-field v-model="paciente.Edad_Cumplida" readonly label="Edad"></v-text-field>
                            </v-flex>
                            <v-flex xs4>
                                <v-text-field v-model="paciente.Telefono" label="Telefono"></v-text-field>
                            </v-flex>
                            <v-flex xs4>
                                <v-text-field v-model="paciente.Celular1" label="Celular"></v-text-field>
                            </v-flex>
                            <v-flex xs4>
                                <v-text-field v-model="paciente.Celular2" label="Celular 2 (opcional)"></v-text-field>
                            </v-flex>
                            <v-flex xs6>
                                <v-text-field v-model="paciente.Correo1" label="Correo"></v-text-field>
                            </v-flex>
                            <v-flex xs6>
                                <v-text-field v-model="paciente.Correo2" label="Correo 2 (opcional)"></v-text-field>
                            </v-flex>
                            
                        </v-layout>
                        <v-layout row wrap v-show="paciente.id">
                            <v-layout row wrap>
                                <v-flex xs6>
                                    <span class="error--text">Punto de atención : {{ paciente.IPS }}</span><br />
                                    <span class="error--text">Médico de familia : No tiene</span> 
                                </v-flex>   
                            </v-layout>
                            <v-spacer></v-spacer>
                            <v-btn color="warning" @click="actualizarDatosPersonales()" round outline>Actualizar</v-btn>
                        </v-layout>
                    </v-container>
                </v-card-text>
            </v-card>
            <v-card max-height="100%" v-show="true">
                <v-card-title>
                    <span class="title layout justify-center font-weight-light">Agenda Disponible Médico</span>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-layout row wrap>
                        <v-flex 
                         xs3
                         px-1
                         > <!-- especialidad -->
                            <v-select
                             v-model="especialidad_selected"
                             :items="especialiades"
                             item-text="name"
                             item-value="name"
                             label="Especialidades"
                            ></v-select>    
                        </v-flex>
                         <!-- sede -->
                        <v-flex
                         xs3
                         px-1
                         >
                         <v-select
                          v-model="sede_selected"
                          :items="sedesDisponible"
                          label="Sede"
                         ></v-select>    
                        </v-flex>
                        <v-flex
                         xs3
                         px-1
                         >
                         <v-select
                          v-model="actividad_selected"
                          :items="actividades"
                          item-text="name"
                          item-value="name"
                          label="Actividad"
                          ></v-select>
                        </v-flex>
                        <v-flex
                         xs3
                         px-1                            
                         >
                         <v-select
                          v-model="medico_selected"
                          :items="medicosSede"
                          label="Médico"
                         ></v-select>    
                        </v-flex>
                        <v-flex xs3> <!-- fecha -->
                            <v-menu
                                v-model="datePicker"
                                :close-on-content-click="false"
                                :nudge-right="40"
                                lazy
                                transition="scale-transition"
                                offset-y
                                full-width
                                min-width="290px"
                             >
                                <template v-slot:activator="{ on }">
                                <v-combobox
                                    v-model="data.fecha_solicitada"
                                    label="Fecha solicitada"
                                    prepend-icon="event"
                                    readonly
                                    v-on="on"
                                   
                                ></v-combobox>
                                </template>
                                <v-date-picker color="primary" :allowed-dates="diasDisponibles" locale="es" v-model="data.fecha_solicitada" @input="agendaSolicitada()"></v-date-picker>
                            </v-menu>
                        </v-flex> 
                    </v-layout>
                    <v-container grid-list-md fluid class="pa-0">
                        <template>
                            <v-data-table
                             :headers="headers"
                             :items="agendaDisponible"
                             item-key="name"
                             class="elevation-1"
                             color="primary"
                             >
                                <template v-slot:items="props">
                                    <td class="text-xs-center">{{ props.item.hora_inicio }}</td>
                                    <td class="text-xs-center">{{ props.item.consultorio }}</td>
                                    <td class="text-xs-center">
                                        <v-btn
                                            v-show="paciente.id"
                                            color="success"
                                            fab
                                            outline
                                            small
                                            @click="asignarCita(props.item)"
                                            >
                                            <v-icon>how_to_reg</v-icon>
                                        </v-btn>
                                    </td>
                                </template>
                            </v-data-table>
                        </template>
                    </v-container>
                </v-card-text>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import { mapGetters } from 'vuex';
    import moment from 'moment';
    export default {
        name:'AsignacionCita',
        components: {
        },
        data(){
            return {
                motivoCancelar: false,
                dialog: false,
                todaspendientesmodal: false,
                headerCitaPendientes: [
                    { text: 'Especialidad', align: 'center', sortable: false, value: 'Especialidad' },
                    { text: 'Actividad', align: 'center', sortable: false, value: 'Tipo_agenda' },
                    { text: 'Fecha', align: 'center', sortable: false, value: 'Fecha' },
                    { text: 'Hora Inicio', align: 'center', sortable: false, value: 'Hora_Inicio' },
                    { text: 'Sede', align: 'center', sortable: false, value: 'Sede' },
                    { text: 'Nombre medico', align: 'center', sortable: false, value: 'Nombre_medico' },
                    { text: '', align: 'center', sortable: false, value: '' },
                ],
                headers: [
                    { text: 'Hora', align: 'center', sortable: false, value: 'Agenda_id' },
                    { text: 'Consultorio', sortable: false, align: 'center', value: 'consultorio' },
                    { text: '', align: 'center', value: '' },
                ],
                agendas: [],
                cedula_paciente: '',
                medico_selected: null,
                sede_selected: null,
                especialidad_selected: null,
                actividad_selected: null,
                fecha_selected: null,
                tipos_agenda: null,
                datePicker: false,
                dateSolicitada: false,
                fecha: null,
                cancelar: {
                    motivo: '',
                    Paciente_id: null,
                    Detallecita_id:null,
                },
                confirmar:{
                    Paciente_id: null,
                    Detallecita_id:null,
                },
                paciente: {
                    Primer_Nom: '',
                    Primer_Ape: '',
                    Tipo_Doc: '',
                    Num_Doc: '',
                    Edad_Cumplida: ''
                },
                ubicacion:{
                    Telefono: '',
                    Celular1:'',
                    Celular2:'',
                    Correo1:'',
                    Correo2:'',
                },
                data:{
                    cita_id: null,
                    hora_inicio: null,
                    consultorio: null,
                    Paciente_id: null,
                    fecha_solicitada: null,
                },
                cita_pendiente:{
                    Hora_Inicio: '',
                    Consultorio: '',
                    Sede: '',
                    Nombre_medico: '',
                    Apellido_medico: '',
                    Especialidad: '',
                    Tipo_agenda: '',
                },
                allcita_pendiente: [],
            }
        },
        filters:{
            fecha_cita_pendiente(fecha){
                return moment(fecha).format('dddd, D MMMM, YYYY');
            }
        },
        computed:{
            ...mapGetters(['can']),
            agendaDisponible(){
                let citas = [];
                for (let i = 0; i < this.agendas.length; i++) {
                    let medico = `${this.agendas[i].nombreMedico} ${this.agendas[i].apellidoMedico}`
                    if (this.agendas[i].Sede === this.sede_selected && this.agendas[i].Especialidad == this.especialidad_selected && this.agendas[i].tipoActividad === this.actividad_selected && medico === this.medico_selected && this.agendas[i].fecha == this.fecha ) {
                        citas = this.agendas[i].citas.map(cita =>  {
                            return {
                                id: cita.id,
                                hora_inicio: cita.Hora_Inicio,
                                consultorio: this.agendas[i].nombreConsultorio
                            }
                        });
                    }
                }
                return citas
            },
            sedesDisponible(){
                return this.agendas.filter((agenda) =>{
                    if(agenda.Especialidad == this.especialidad_selected) return true;
                    return false;  
                }).map((agenda) => agenda.Sede);
            },
            medicosSede(){
                return this.agendas.filter((agenda) =>{
                    if(agenda.Especialidad == this.especialidad_selected && agenda.tipoActividad == this.actividad_selected && agenda.Sede == this.sede_selected ) return true;
                    return false;
                }).map((agenda) => `${agenda.nombreMedico} ${agenda.apellidoMedico}`)
            },
            especialiades(){
                return this.agendas.map(agenda => agenda.Especialidad )
            },
            actividades(){
                return this.agendas.filter((agenda) => {
                    if(agenda.Especialidad == this.especialidad_selected && agenda.Sede == this.sede_selected)  return true
                    return false;
                }).map((agenda) => agenda.tipoActividad);
            },
        },
        mounted(){
            moment.locale('es');
            this.fetchAgendas();
        },
        methods: {
            fetchAgendas(){
                this.datePicker = false;
                axios.post('/api/agenda/agendaDisponible', { fecha: this.fecha })
                    .then(res => this.agendas = res.data);
            },
            search_paciente(){
                if(!this.cedula_paciente) return;

                axios.get(`/api/paciente/showEnabled/${this.cedula_paciente}`)
                    .then((res) => {
                        if(res.data.paciente) {
                            this.paciente = res.data.paciente;
                            this.sede_selected = this.paciente.IPS;
                            this.citaPendiente(res.data.paciente.id);
                        }
                        if(res.data.message) this.showMessage(res.data.message);
                    });
            },
            citaPendiente(Paciente_id){
                axios.post(`/api/cita/citaspendientes`,{
                    Paciente_id
                })
                .then((res) => {
                  // console.log(res);
                    if(res.data[0]){
                        this.cita_pendiente = res.data[0];
                        this.allcita_pendiente = res.data;
                    }else{
                        this.cita_pendiente = {
                            Hora_Inicio: '',
                            Consultorio: '',
                            Sede: '',
                            Nombre_medico: '',
                            Apellido_medico: '',
                            Especialidad: '',
                            Tipo_agenda: '',
                        };
                        this.allcita_pendiente = null;
                    }
                });
            },
            asignarCita(cita){
                this.dialog = true;
                this.data.cita_id = cita.id;
                this.data.hora_inicio = cita.hora_inicio;
                this.data.consultorio = cita.consultorio;
                this.data.Paciente_id = this.paciente.id;
                this.fecha_selected = moment(this.fecha).format('dddd, D MMMM, YYYY');
            },
            actualizarDatosPersonales(){
                axios.put(`/api/paciente/edit_ubicacion_data/${this.paciente.id}`, this.paciente)
                        .then((res) => {
                            swal({
                                title: "¡Datos Actualizados!",
                                text: ` `,
                                timer: 2000,
                                icon: "success",
                                buttons: false
                            });
                        })
            },
            openMotivo(){
                this.cancelar = {
                    motivo: '',
                    Paciente_id: null,
                    Detallecita_id:null,
                }
                this.motivoCancelar = true;
                
            },
            cancelarCita(){
              // console.log('cancelar',this.cita_pendiente)
                this.cancelar.Paciente_id = this.paciente.id;
                this.cancelar.Detallecita_id = this.cita_pendiente.detallecita_id;
                this.motivoCancelar = false;
                axios.put(`/api/cita/cancelar/${this.cita_pendiente.id}`, this.cancelar)
                        .then((res) => {
                            swal({
                                title: "¡Cita Cancelada!",
                                text: `${res.data.message}`,
                                timer: 3000,
                                icon: "success",
                                buttons: false
                            });
                            this.citaPendiente(this.paciente.id);
                        })
            },
            confirmarCitaModal(cita){
                this.confirmar.Paciente_id = this.paciente.id;
                swal({
                        title: "¿Confirmar Cita?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((confirm) => {
                        if(confirm){
                            axios.put(`/api/cita/confirmar/${this.cita.id}`, this.confirmar)
                                .then((res) => {
                                  // console.log('confirmado',res.data);
                                    swal({
                                        title: "¡Cita confirmada!",
                                        text: `${res.data.message}`,
                                        timer: 3000,
                                        icon: "success",
                                        buttons: false
                                    });
                                    this.citaPendiente(this.paciente.id);
                                })
                        }
                        
                    });
            },
            confirmarCita(){
                this.confirmar.Paciente_id = this.paciente.id;
                swal({
                        title: "¿Confirmar Cita?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((confirm) => {
                        if(confirm){
                            axios.put(`/api/cita/confirmar/${this.cita_pendiente.id}`, this.confirmar)
                                .then((res) => {
                                  // console.log('confirmado',res.data);
                                    swal({
                                        title: "¡Cita confirmada!",
                                        text: `${res.data.message}`,
                                        timer: 3000,
                                        icon: "success",
                                        buttons: false
                                    });
                                    this.citaPendiente(this.paciente.id);
                                }).catch((err) => console.log(err.response))
                        }
                        
                    });
            },
            agendarCita(){
                axios.put(`/api/cita/asignarcita/${this.data.cita_id}`, this.data )
                        .then((res) => {
                            this.dialog = false;
                            //this.clearFields();
                            this.fetchAgendas();
                          // console.log('res', res)
                            swal({
                                title: "¡Cita Agendada!",
                                text: `${res.data.message}`,
                                timer: 3000,
                                icon: "success",
                                buttons: false
                            });
                        })
                        .catch((err) => this.showMessage(err.response.data.message))
            },
            showMessage(message){
                swal({
                    title: `${message}`,
                    icon: "warning",
                });
            },
            clearFields(){
                this.cedula_paciente = '',
                this.medico_selected = null,
                this.sede_selected = null,
                this.actividad_selected = null,
                this.especialidad_selected = null,
                this.fecha_selected = null,
                this.fecha = moment().format('YYYY-MM-DD'),
                this.paciente = {
                    Primer_Nom: '',
                    Primer_Ape: '',
                    Tipo_Doc: '',
                    Num_Doc: '',
                    Edad_Cumplida: ''
                }
                this.cedula_paciente = '';
                this.ubicacion = {
                    Telefono: '',
                    Celular1:'',
                    Celular2:'',
                    Correo1:'',
                    Correo2:'',
                }
                this.data = {
                    Paciente_id: null,
                    cita_id: null,
                    hora_inicio: null,
                    consultorio: null,
                    fecha_solicitada: moment().format('YYYY-MM-DD'),
                }
                this.cita_pendiente = {
                    Hora_Inicio: '',
                    Consultorio: '',
                    Sede: '',
                    Nombre_medico: '',
                    Apellido_medico: '',
                    Especialidad: '',
                    Tipo_agenda: '',
                }
                this.cancelar = {
                    motivo: '',
                    Paciente_id: null,
                    Detallecita_id:null,
                }
            },
            agendaSolicitada(){
                this.dateSolicitada = false;
                this.fecha = this.data.fecha_solicitada;
                this.fetchAgendas();
            },
            diasDisponibles(val){
                let dia = null;
                this.agendas.forEach((agenda) =>{
                    if(agenda.Especialidad == this.especialidad_selected && agenda.tipoActividad == this.actividad_selected && agenda.Sede == this.sede_selected && agenda.fecha == val ){
                        dia = val;

                    }
                })
                if(dia) return dia

            }
        }
    }
</script>

<style lang="scss" scoped>

</style>