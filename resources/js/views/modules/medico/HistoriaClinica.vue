<template>
    <v-layout row wrap>
        <!-- Dialogo de actualizacion de datos del paciente -->
        <v-dialog v-model="datospaci" persistent max-width="600px">
            <v-card>
                <v-card-title class="headline primary">
                    <v-card-text class="white--text">
                        <span class="text--white">Actualización de los datos del paciente</span>
                    </v-card-text>
                </v-card-title>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12 sm4 md4 v-for="input in inputs" :key="input.id">
                            <v-select :label="input.label" v-model="paciente[input.value]" :items="input.options"
                                v-if="input.type == 'select'">
                            </v-select>
                            <v-text-field :label="input.label" v-model="paciente[input.value]" v-else>
                            </v-text-field>

                        </v-flex>
                    </v-layout>
                </v-container>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" flat @click="updateDatapaci()">Actualizar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- Fin del dialogp -->
        <v-flex xs2 pl-1>
            <v-card style="display:fixed">
                <v-navigation-drawer permanent width="300%">
                    <v-list>
                        <v-divider></v-divider>
                        <template v-for="item in modulos">
                            <v-list-tile v-show="sexoPaciente(item.sexo)" active-class="white--text primary"
                                :key="item.id" :to="item.path" :disabled="item.disabled">
                                <v-list-tile-content>
                                    <v-list-tile-title>{{ item.text }}</v-list-tile-title>
                                </v-list-tile-content>
                            </v-list-tile>
                            <v-divider :key="item.id"></v-divider>
                        </template>
                    </v-list>
                </v-navigation-drawer>
            </v-card>
        </v-flex>
        <v-flex xs10 pl-1>
            <v-card>
                <RouterView />
            </v-card>
        </v-flex>
    </v-layout>
</template>
<script>
    import {
        mapGetters
    } from 'vuex';
    import {
        EventBus
    } from '../../../event-bus.js';
    import {
        constants
    } from 'crypto';

    export default {
        created() {
            this.cita_paciente = this.$route.query.cita_paciente;
            this.getPaciente();
            this.fetchAntecedentespersonales();
            this.historia();

        },
        data() {
            return {
                datospaci: false,
                datospaci: true,
                modulos: [],
                cita_paciente: 0,
                paciente: {
                    Celular: '',
                    Correo: '',
                    Dane_Dpto: '',
                    Dane_Mpio: '',
                    Departamento: '',
                    Direccion_Residencia: '',
                    Discapacidad: '',
                    Doc_Cotizante: '',
                    Dpto_Atencion: '',
                    Edad_Cumplida: '',
                    Estado_Afiliado: '',
                    Estrato: '',
                    Etnia: '',
                    Fecha_Afiliado: '',
                    Fecha_Emision: '',
                    Fecha_Naci: '',
                    Grado_Discapacidad: '',
                    IPS: '',
                    Laboraen: '',
                    Medicofamilia: '',
                    Mpio_Afiliado: '',
                    Mpio_Atencion: '',
                    Mpio_Labora: '',
                    Mpio_Residencia: '',
                    Nivel_Sisben: '',
                    Num_Doc: '',
                    Num_Folio: '',
                    Num_Hijos: '',
                    Orden_Judicial: '',
                    Parentesco: '',
                    Primer_Ape: '',
                    Primer_Nom: '',
                    RH: '',
                    Region: '',
                    Sede_Odontologica: '',
                    SegundoNom: '',
                    Segundo_Ape: '',
                    Sexo: '',
                    Sexo_Biologico: '',
                    Subregion: '',
                    Telefono: '',
                    Tienetutela: '',
                    TipoDoc_Cotizante: '',
                    Tipo_Afiliado: '',
                    Tipo_Cotizante: '',
                    Tipo_Doc: '',
                    Tipo_Regimen: '',
                    Ut: '',
                    Vivecon: '',
                    RH: '',
                    Tienetutela: '',
                    Nivelestudio: ''
                },
                inputs: [{
                        label: 'Fecha Nacimiento',
                        value: 'Fecha_Naci',
                        type: 'text'
                    },
                    {
                        label: 'Edad Cumplida',
                        value: 'Edad_Cumplida'
                    },
                    {
                        label: 'Etnia',
                        value: 'Etnia',
                        type: 'select',
                        options: [
                            'Indígena',
                            'Gitano',
                            'Raizal',
                            'Palenquero',
                            'Negro(a)',
                            'Mulato(a)',
                            'Afrocolombiano(a)',
                            'Afro descendiente'
                        ]
                    },
                    {
                        label: 'Donde labora',
                        value: 'Laboraen'
                    },
                    {
                        label: 'Mpio Labora',
                        value: 'Mpio_Labora'
                    },
                    {
                        label: 'Direccion Residencia',
                        value: 'Direccion_Residencia'
                    },
                    {
                        label: 'Mpio Residencia',
                        value: 'Mpio_Residencia'
                    },
                    {
                        label: 'Telefono',
                        value: 'Telefono'
                    },
                    {
                        label: 'Correo',
                        value: 'Correo'
                    },
                    {
                        label: 'Estrato',
                        value: 'Estrato',
                        type: 'select',
                        options: [
                            '1',
                            '2',
                            '3',
                            '4',
                            '5',
                            '6',
                            '7',
                            '8'
                        ]

                    },
                    {
                        label: 'Celular',
                        value: 'Celular'
                    },
                    {
                        label: 'Número de Hijos',
                        value: 'Num_Hijos'
                    },
                    {
                        label: 'Vivecon',
                        value: 'Vivecon'
                    },
                    {
                        label: 'RH',
                        value: 'RH',
                        type: 'select',
                        options: [
                            'O+',
                            'O-',
                            'A+',
                            'A-',
                            'B+',
                            'B-',
                            'AB+',
                            'AB-'
                        ]
                    },
                    {
                        label: 'Nivelestudio',
                        value: 'Nivelestudio'
                    },
                ],
                antecedentesRCVM: ['Hipertension Arterial', 'Dislipidemia', 'Diabetes Mellitus',
                    'Enfermedad Cardiovascular'
                ]
            }
        },
        computed: {
            ...mapGetters(['fullName', 'can', 'avatar'])
        },
        methods: {
            historia() {

                // if (this.can('imagenologia')) {
                //     this.modulos = [{
                //         text: 'IMAGENOLOGÍA',
                //         path: '/historiaclinica/imagenologia?cita_paciente=' + this.cita_paciente,
                //         disabled: false,
                //         sexo: 'Ambos'
                //     }, ]
                // } else {
                    this.modulos = [
                        {
                            text: 'ANAMNESIS',
                            path: '/historiaclinica/motivoconsulta?cita_paciente=' + this.cita_paciente,
                            disabled: false,
                            sexo: 'Ambos'
                        },
                        {
                            text: 'ANTECEDENTES',
                            path: '/historiaclinica/patologias?cita_paciente=' + this.cita_paciente,
                            disabled: true,
                            sexo: 'Ambos'
                        },
                        {
                            text: 'ANTECEDENTES GINECO OBSTÉTRICOS',
                            path: '/historiaclinica/gineco?cita_paciente=' + this.cita_paciente,
                            disabled: true,
                            sexo: 'F'
                        },
                        {
                            text: 'ESTILOS DE VIDA',
                            path: '/historiaclinica/stylelive?cita_paciente=' + this.cita_paciente,
                            disabled: true,
                            sexo: 'Ambos'
                        },
                        {
                            text: 'EXAMEN FÍSICO',
                            path: '/historiaclinica/examensistema?cita_paciente=' + this.cita_paciente,
                            disabled: true,
                            sexo: 'Ambos'
                        },
                        {
                            text: 'DIAGNOSTICOS',
                            path: '/historiaclinica/diagnostico?cita_paciente=' + this.cita_paciente,
                            disabled: true,
                            sexo: 'Ambos'
                        },
                        {
                            text: 'CONDUCTA',
                            path: '/historiaclinica/conducta?cita_paciente=' + this.cita_paciente,
                            disabled: true,
                            sexo: 'Ambos'
                        },

                    ];
                    EventBus.$on('change_disabled_list_history', (nombre) => {
                        this.modulos[this.modulos.findIndex(x => x.text == nombre)].disabled = false;
                    })
                // }

            },
            updateDatapaci() {
                axios.put(`/api/paciente/edit/${this.paciente.id}`, this.paciente)
                    .then(res => {
                        this.datospaci = false;
                        swal({
                            title: "¡Paciente Actualizado!",
                            text: " ",
                            type: "success",
                            timer: 2000,
                            icon: "success",
                            buttons: false
                        });
                    })
                    .catch(err => console.log(err.response.paciente));
            },
            getPaciente() {
                console.log('object');
                axios.get('/api/cita/' + this.cita_paciente + '/datospaciente')
                    .then((res) => {
                        this.paciente = res.data
                        console.log(this.paciente)
                        EventBus.$emit('informacion-paciente-layout', this.paciente)
                    })
            },

            fetchAntecedentespersonales() {
                axios
                    .get("/api/pacienteantecedente/antecedentes/" + this.cita_paciente + "")
                    .then(res => {
                        let addRCVM = false
                        res.data.forEach(dat => {
                            // console.log(this.antecedentesRCVM)
                            // console.log(dat)
                            // console.log(dat.Nombre)
                            if (this.antecedentesRCVM.includes(dat.Nombre)) {
                                addRCVM = true
                            }
                        });

                        if (addRCVM) {
                            this.modulos.splice(-1, 0, {
                                text: 'RCCVM',
                                path: '/historiaclinica/rcvm?cita_paciente=' + this.cita_paciente,
                                disabled: false,
                                sexo: 'Ambos'
                            })
                        }
                    });
            },

            sexoPaciente(sexo) {
                if (sexo == 'Ambos' || this.paciente.Sexo == sexo) {
                    return true;
                }
                return false;
            }
        },

    }

</script>
<style scoped>
</style>
