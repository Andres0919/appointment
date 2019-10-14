<template>
    <div>
        <v-container pa-1>
            <v-card-title>
                <v-spacer></v-spacer>
                <v-flex xs5 >
                    <v-autocomplete
                        v-model="data.medico_id"
                        :items="listMedicos"
                        item-text="nombre"
                        item-value="id"
                        label="Buscar médico..."
                        clear-icon
                        @change="fetchAgendaMedico"
                    ></v-autocomplete>
                </v-flex>
            </v-card-title>
            <v-layout row wrap>
                <v-flex
                    sm4
                    xs12
                    class="text-sm-left text-xs-center"
                    >
                    <v-btn @click="$refs.calendar.prev()">
                        <v-icon
                            dark
                            left
                            >
                            keyboard_arrow_left
                        </v-icon>
                        Anterior
                    </v-btn>
                </v-flex>
                <v-spacer></v-spacer>
                <v-btn outline round color="warning" v-show="type == 'day'" @click="type='week'">SEMANAL</v-btn>
                <v-btn outline round color="warning" v-show="type != 'month'" @click="type='month'">MENSUAL</v-btn>
                <v-spacer></v-spacer>
                <v-flex
                    sm4
                    xs12
                    class="text-sm-right text-xs-center"
                    >
                    <v-btn @click="$refs.calendar.next()">
                        Siguiente
                        <v-icon
                            right
                            dark
                            >
                            keyboard_arrow_right
                        </v-icon>
                    </v-btn>
                </v-flex>
            </v-layout>     
            <v-layout>
                <v-flex >
                    <v-sheet height="500">
                        <v-calendar
                         ref="calendar"
                         :type="type"
                         v-model="today"
                         color="primary"
                         locale="es"
                         @click:date="daySelected()"
                         intervalHeight="70"
                         >
                            <template v-slot:day="{ date }">
                                <template v-for="event in eventsMap[date]">
                                    <v-menu
                                        :key="event.Nombre"
                                        v-model="event.open"
                                        full-width
                                        offset-x
                                     >
                                        <template v-slot:activator="{ on }">
                                        <div
                                            v-if="!event.time"
                                            v-ripple
                                            :class="(event.Estado_id == 3)? 'my-event' : 'my-event-blocked'"
                                            v-on="on"
                                            v-html="event.tAgenda"
                                        ></div>
                                        </template>
                                        <v-card
                                         color="grey lighten-4"
                                         min-width="350px"
                                         flat
                                         >
                                        <v-toolbar
                                            color="primary"
                                            dark
                                         >
                                            <v-spacer></v-spacer>
                                            <v-toolbar-title>
                                                {{event.Hora_Inicio | hourFormat}} - {{ event.Hora_Final | hourFormat }} | {{ event.Sede }}
                                                <v-btn dark small fab outline @click="blockAgenda(event)">
                                                    <v-icon>block</v-icon>
                                                </v-btn>
                                                <v-btn dark small fab outline @click="cancelarAgenda(event)">
                                                    <v-icon>clear</v-icon>
                                                </v-btn>
                                            </v-toolbar-title>
                                            <v-spacer></v-spacer>
                                        </v-toolbar>
                                        </v-card>
                                    </v-menu>
                                </template>
                            </template>
                            <template v-slot:dayBody="{ date, timeToY, minutesToPixels }">
                                <template v-for="event in eventsWeekMap[date]">
                                    <!-- timed events -->
                                    <v-menu
                                        :key="event.Nombre"
                                        v-model="event.open"
                                        full-width
                                        offset-x
                                     >
                                        <template v-slot:activator="{ on }">
                                        <div
                                        v-ripple
                                        v-if="event.time"
                                        :key="event.id"
                                        :style="{ top: timeToY(event.time) + 'px', height: minutesToPixels(event.duration) + 'px' }"
                                        :class="(event.estado == 3 && event.estadoagenda == 3)? 'my-cita-event with-time' : 'my-cita-event-blocked with-time'"
                                        v-on="on"
                                        v-html="event.title"
                                        ></div>
                                        </template>
                                        <v-card
                                         color="grey lighten-4"
                                         min-width="150px"
                                         flat
                                         >
                                        <v-toolbar
                                            color="primary"
                                            dark
                                         >
                                            <v-spacer></v-spacer>
                                            <v-toolbar-title>
                                                <v-btn dark small fab outline @click="blockCita(event)">
                                                    <v-icon>block</v-icon>
                                                </v-btn>
                                            </v-toolbar-title>
                                            <v-spacer></v-spacer>
                                        </v-toolbar>
                                        </v-card>
                                    </v-menu>
                                </template>
                            </template>
                        </v-calendar>
                    </v-sheet>
                </v-flex>
            </v-layout>
        </v-container>   
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import moment from 'moment';
    import swal from 'sweetalert';
    export default {
        name: 'AgendaTable',
        data() {
            return {
                agendas: [],
                dialog: false,
                type: 'month',
                save: true,
                medicos: [],
                data:{
                    medico_id: null,
                    fecha: moment().format('YYYY-MM-DD')
                },
                datePicker: false,
                today: moment().format('YYYY-MM-DD'),
            }
        },
        filters:{
            estadoCita: (estado) => { if(estado == 1) return 'Disponible' },
            hourFormat: (fecha) => moment(fecha).format('LT'),
        },
        computed:{
            ...mapGetters(['can']),
            filteredAgenda() {
                // return this.agendas.filter(d => {
                //     return Object.keys(this.filters).every(f => {
                //         return this.filters[f].length < 1 || this.filters[f].includes(d[f])
                //     })
                // })
                return this.agendas.map(agenda => agenda.citas)
            },
            listMedicos(){
                return this.medicos.map(medico => {
                    return {
                        id:  medico.id,
                        nombre: `${medico.cedula} - ${medico.name} ${medico.apellido}`
                    }
                })
            },
            listCitas(){
                let citas = []
                for (let i = 0; i < this.agendas.length; i++) {
                    citas = this.agendas[i].citas.map(cita => {
                        return {
                            sede: this.agendas[i].Nombre,
                            consultorio: this.agendas[i].consultorio,
                            tipo_agenda: this.agendas[i].tAgenda,
                            hora: cita.Hora_Inicio,
                            estado: cita.Estado
                        } 
                    })
                }
                return citas
            },
              // convert the list of events into a map of lists keyed by date
            eventsMap () {
                const map = {} 
                this.agendas.forEach(e => (map[e.Fecha] = map[e.Fecha] || []).push(e))
                return map
            },
            eventsWeekMap(){
                let citas = [];

                for (let i = 0; i < this.agendas.length; i++) {
                    if(!citas.hasOwnProperty(this.agendas[i].Fecha)) citas[this.agendas[i].Fecha] = [];
                    citas[this.agendas[i].Fecha] = citas[this.agendas[i].Fecha].concat(this.agendas[i].citas.map((cita) => {
                            return {
                                id: cita.id,
                                date: this.agendas[i].Fecha,
                                time: moment(cita.Hora_Inicio).format('HH:mm'),
                                title: moment(cita.Hora_Inicio).format('HH:mm'),
                                duracion: this.agendas.Duracion,
                                estado: cita.Estado_id,
                                estadoagenda: this.agendas[i].Estado_id
                            }
                        }))
                }
                return citas
            }
            },
            methods: {
            open (event) {
                alert(event.title)
            }
        },
        mounted () {
            this.fetchMedicos();
        },
        methods: {
            fetchAgendaMedico(){
                this.datePicker= false;
                axios.post('/api/agenda/agendamedicos', this.data)
                    .then(res => this.agendas = res.data)
                    .catch(err => console.log('err', err));
            },
            fetchMedicos(){
                axios.get('/api/user/medicos')
                    .then(res => this.medicos = res.data);
            },
            showError(message){
                swal({
                    title: "¡No puede ser!",
                    text: `${message.email}`,
                    icon: "warning",
                });
            },
            emptyData(){
                this.data = {
                    name: '',
                    apellido: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    roles: null
                }
            },
            columnValueList(val) {
                return this.agendas.map(d => d[val])
            },
            daySelected(e){
                switch (this.type) {
                    case 'month':
                        this.type = 'week'
                        break;
                    case 'week':
                        this.type = 'day'                        
                        break;
                
                    default:
                        break;
                }
            },
            cancelarAgenda(event){
                swal({
                    title: 'Eliminar agenda',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                }).then((confirm) => {
                        if(confirm){
                            axios.put(`/api/agenda/cancelar/${event.id}`)
                                .then((res) => {
                                    swal({
                                        title: "¡Agenda cancelada!",
                                        text: `${res.data.message}`,
                                        timer: 2000,
                                        icon: "success",
                                        buttons: false
                                    });
                                    this.fetchAgendaMedico();
                                }).catch((err) => console.log(err.response))
                        }
                        
                    });
            },
            blockAgenda(event){
                //console.log('event :', event);
                let msg = '';
                if(event.Estado_id == 3) msg = 'Bloquear agenda';
                else msg = 'Desbloquear agenda';
                swal({
                    title: msg,
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                }).then((confirm) => {
                        if(confirm){
                            axios.put(`/api/agenda/bloquear/${event.id}`)
                                .then((res) => {
                                    swal({
                                        title: res.data.message,
                                        text: ' ',
                                        timer: 2000,
                                        icon: "success",
                                        buttons: false
                                    });
                                    this.fetchAgendaMedico();
                                }).catch((err) => console.log(err.response))
                        }
                        
                    });

            },
            blockCita(event){
                //console.log('event :', event);
                let msg = '';
                if(event.estado == 3) msg = 'Bloquear cita';
                else msg = 'Desbloquear cita';
                swal({
                    title: msg,
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                }).then((confirm) => {
                        if(confirm){
                            axios.put(`/api/cita/bloquear/${event.id}`)
                                .then((res) => {
                                    swal({
                                        title: res.data.message,
                                        text: ' ',
                                        timer: 2000,
                                        icon: "success",
                                        buttons: false
                                    });
                                    this.fetchAgendaMedico();
                                }).catch((err) => console.log(err.response))
                        }
                        
                    });

            }
        },
    }
</script>

<style lang="stylus" scoped>
  
  .my-event-blocked {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    border-radius: 2px;
    background-color: #ccc;
    color: #ffffff;
    border: 1px solid #ccc;
    width: 100%;
    font-size: 12px;
    padding: 3px;
    cursor: pointer;
    margin-bottom: 1px;
  }

  .my-event {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    border-radius: 2px;
    background-color: #1867c0;
    color: #ffffff;
    border: 1px solid #1867c0;
    width: 100%;
    font-size: 12px;
    padding: 3px;
    cursor: pointer;
    margin-bottom: 1px;

}

    .my-cita-event {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        border-radius: 2px;
        background-color: #1867c0;
        color: #ffffff;
        border: 1px solid #1867c0;
        width: 100%;
        font-size: 12px;
        padding: 3px;
        cursor: pointer;
        margin-bottom: 1px;
    }
    .my-cita-event-blocked {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        border-radius: 2px;
        background-color: #ccc;
        color: #ffffff;
        border: 1px solid #ccc;
        width: 100%;
        font-size: 12px;
        padding: 3px;
        cursor: pointer;
        margin-bottom: 1px;
    }

   .my-cita-event.with-time {
    position: absolute;
    right: 4px;
    margin-right: 0px;
    border: #000 1px solid;
  }

  .my-cita-event-blocked.with-time {
    position: absolute;
    right: 4px;
    margin-right: 0px;
    border: #ccc 1px solid;
  }
</style>