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
                            Asignar cita de tipo <b> {{ actividad_selected }} </b> al usuario <b>{{ paciente.Primer_Nom }} {{ paciente.SegundoNom }} {{ paciente.Primer_Ape}} {{ paciente.Segundo_Ape }}</b> identificado con <b>{{ paciente.Tipo_Doc }}</b>  N° <b>{{ paciente.Num_Doc }}</b> el día <b>{{ fecha_selected }}</b> a las <b>{{ data.hora_inicio | time}}</b> en la sede <b>{{ sede_selected }}</b>, <b>{{ data.consultorio }}</b> con el médico <b>{{ medico_selected }}</b>
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
                                <v-btn v-if="can('Cancelarcita')" color="blue darken-1" flat @click="cancelarCita()">Enviar</v-btn>
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
                                                <!--<v-list-tile @click="confirmarCita()">
                                                    <v-list-tile-title>Confirmar<v-icon right color="success">check</v-icon></v-list-tile-title>
                                                </v-list-tile> -->
                                                <v-list-tile @click="openMotivo(cita_pendiente)">
                                                    <v-list-tile-title>Cancelar
                                                        <v-icon right color="error">clear</v-icon>
                                                    </v-list-tile-title>
                                                </v-list-tile>
                                                <v-list-tile @click="printPDF(cita_pendiente)">
                                                    <v-list-tile-title>Generar
                                                        <v-icon right color="success">assignment_turned_in</v-icon>
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
                                                                <!--<v-btn fab color="success" outline small @click="confirmarCita(props.item)">
                                                                    <v-icon color="success">check</v-icon>
                                                                </v-btn>-->
                                                                <v-btn fab color="error" outline small @click="openMotivo(props.item)">
                                                                    <v-icon color="error">clear</v-icon>
                                                                </v-btn>
                                                                <v-btn fab color="success" outline small @click="printPDF(props.item)" >
                                                                    <v-icon color="success">assignment_turned_in</v-icon>
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
                                    <v-date-picker v-model="fecha" :allowed-dates="diasDisponibles" :events="diasEvents" :show-current="false" event-color="green lighten-1" locale="es" color="primary" ></v-date-picker>
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
                                    <span class="error--text">Punto de atención : {{ paciente.NombreIPS }}</span><br />
                                    <span class="error--text">Médico de familia : {{paciente.Medicofamilia}}</span> 
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
                            <v-autocomplete
                             v-model="especialidad_selected"
                             :items="especialidades"
                             item-text="Nombre"
                             item-value="id"
                             label="Especialidades"
                             @input="fetchSedes()"
                            ></v-autocomplete>    
                        </v-flex>
                         <!-- sede -->
                        <v-flex
                         xs3
                         px-1
                         >
                         <v-select
                          v-model="sede_selected"
                          :items="sedes"
                          label="Sede"
                          item-text="Nombre"
                          item-value="id"
                          @input="fetchAgendas()"
                         ></v-select>    
                        </v-flex>
                        <v-flex
                         xs3
                         px-1
                         >
                         <v-autocomplete
                          v-model="actividad_selected"
                          :items="actividades"
                          item-text="name"
                          item-value="et_id"
                          label="Actividad"
                          @input="fetchAgendas()"
                          ></v-autocomplete>
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
                                <v-date-picker color="primary" locale="es" v-model="data.fecha_solicitada" :min="today" :show-current="false" @input="agendaSolicitada()"></v-date-picker>
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
                             :rows-per-page-items="[20,30,50]"
                             rows-per-page-text="Citas por página"
                             >
                                <template v-slot:items="props">
                                    <td class="text-xs-center">{{ props.item.hora_inicio | time }}</td>
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
                message: '',
                citas: {},
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
                today: moment().format('YYYY-MM-DD'),
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
                cancelarcita: {},
                allcita_pendiente: [],
                especialidades: [],
                sedes:[]
            }
        },
        filters:{
            fecha_cita_pendiente(fecha){
                return moment(fecha).format('dddd, D MMMM, YYYY');
            },
            time(date){
                return moment(date).format('HH:mm:ss');
            }
        },
        computed:{
            ...mapGetters(['can']),
            agendaDisponible(){
                let citasEnable = [];
                let citas = [];
                for (let i = 0; i < this.agendas.length; i++) {
                    let citas = [];
                    let medico = `${this.agendas[i].nombreMedico} ${this.agendas[i].apellidoMedico}`
                    if (medico === this.medico_selected && 
                        this.agendas[i].fecha == this.fecha ) {
                        citas = this.agendas[i].citas.map(cita =>  {
                            return {
                                id: cita.id,
                                hora_inicio: cita.Hora_Inicio,
                                consultorio: this.agendas[i].nombreConsultorio
                            }
                        });
                        citasEnable = citasEnable.concat(citas);
                    }
                }

                return citasEnable.sort((a, b) =>  moment(a.hora_inicio) - moment(b.hora_inicio));
            },
            sedesDisponible(){
                return this.agendas.filter((agenda) =>{
                    if(agenda.Especialidad == this.especialidad_selected) return true;
                    return false;  
                }).map((agenda) => agenda.Sede);
            },
            medicosSede(){
                return this.agendas.map((agenda) => `${agenda.nombreMedico} ${agenda.apellidoMedico}`)
            },
            especialiadesq(){
                return this.agendas.map(agenda => agenda.Especialidad )
            },
            actividades(){
                return this.especialidades.filter(e => this.especialidad_selected === e.id && this.sede_selected == e.sede) 
            },
        },
        mounted(){
            moment.locale('es');
        },
        methods: {
            fetchEspecialidades(){
                axios.get(`/api/agenda/agendaDisponible/especialidades`)
                    .then((res) => {
                        this.especialidades = res.data
                    });
            },
            fetchSedes(){
                axios.post(`/api/agenda/agendaDisponible/sedes`,{ especialidad: this.especialidad_selected })
                    .then((res) => {
                        this.sedes = res.data
                    });
            },
            fetchAgendas(){
                this.datePicker = false;
                if(this.especialidad_selected && this.sede_selected && this.actividad_selected){
                    axios.post('/api/agenda/agendaDisponible', { fecha: this.fecha, sede: this.sede_selected, tipo_agenda: this.actividad_selected })
                    .then(res => {
                        this.agendas = res.data
                    });
                }
                
            },
            search_paciente(){
                if(!this.cedula_paciente) return;

                this.fetchEspecialidades();
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
            openMotivo(cita = undefined){
                this.cancelarcita = cita;
                this.cancelar = {
                    id: cita.id,
                    motivo: '',
                    Paciente_id: null,
                    Detallecita_id:null,
                }
                this.motivoCancelar = true;
                
            },
            cancelarCita(){
                this.cancelar.Paciente_id = this.paciente.id;
                
                
                this.motivoCancelar = false;
                axios.put(`/api/cita/cancelar/${this.cancelar.id}`, this.cancelar)
                        .then((res) => {
                            swal({
                                title: "¡Cita Cancelada!",
                                text: `${res.data.message}`,
                                timer: 3000,
                                icon: "success",
                                buttons: false
                            });
                            this.cancelarcita = {};
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
                            // this.printPDF();
                            this.fetchAgendas();

                            this.citaPendiente(this.paciente.id);
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
                this.agendas.forEach((agenda) => {
                    if(agenda.fecha == val ){
                        dia = val;
                    }
                })
                if(dia) return dia
            },
            diasEvents(val){
                let dia = null;
                let many = false;
                this.agendas.forEach((agenda) =>{
                    if(agenda.fecha == val ){
                        dia = val;

                        let medico = `${agenda.nombreMedico} ${agenda.apellidoMedico}`
                        if(medico === this.medico_selected){
                            if(agenda.citas[0].Hora_Inicio.substring(0,10) === dia) many = true;
                        }

                    }
                })
                
                if(dia) {
                    if(many) return ['green lighten-1','red']
                    else return true
                }

                return false
            },
            printPDF(cita){


                var pdf = {};

                pdf = this.getPDFCitas(cita);

                axios
                    .post("/api/pdf/print-pdf", pdf, {
                    responseType: "arraybuffer"
                    })
                    .then(res => {
                    let blob = new Blob([res.data], { type: "application/pdf" });
                    let link = document.createElement("a");
                    link.href = window.URL.createObjectURL(blob);
                    window.open(link.href,"_blank");
                });
            },
            getPDFCitas(cita) {

                if (!this.paciente.Primer_Nom)
                    this.paciente.Primer_Nom = '';
                
                if (!this.paciente.SegundoNom) 
                    this.paciente.SegundoNom = '';

                if (!this.paciente.Primer_Ape)
                    this.paciente.Primer_Ape = ';'

                if (!this.paciente.Segundo_Ape) 
                    this.paciente.Segundo_Ape = '';

                this.message = `Asignar cita de tipo ${ cita.Tipo_agenda } al usuario ${ this.paciente.Primer_Nom } ${ this.paciente.SegundoNom } ${ this.paciente.Primer_Ape } ${ this.paciente.Segundo_Ape } identificado con ${ this.paciente.Tipo_Doc } N° ${ this.paciente.Num_Doc } el día ${ cita.Fecha } a las ${ moment(cita.Hora_Inicio).format('HH:mm:ss') } en la sede ${ cita.Sede }, ${ cita.Consultorio } con el médico ${ cita.Nombre_medico } ${ cita.Apellido_medico }`;
                return (this.citas = {
                    Primer_Nom: this.paciente.Primer_Nom,
                    Segundo_Nom: this.paciente.SegundoNom,
                    Primer_Ape: this.paciente.Primer_Ape,
                    Segundo_Ape: this.paciente.Segundo_Ape,
                    Tipo_Doc: this.paciente.Tipo_Doc,
                    Num_Doc: this.paciente.Num_Doc,
                    Edad_Cumplida: this.paciente.Edad_Cumplida,
                    Sexo: this.paciente.Sexo,
                    IPS: this.paciente.IPS,
                    Direccion_Residencia: this.paciente.Direccion_Residencia,
                    Correo: this.paciente.Correo,
                    Telefono: this.paciente.Telefono,
                    Tipo_Afiliado: this.paciente.Tipo_Afiliado,
                    Estado_Afiliado: this.paciente.Estado_Afiliado,
                    Tipo_cita: cita.Tipo_agenda,
                    type: "cita",
                    observaciones: this.message,
                });
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>