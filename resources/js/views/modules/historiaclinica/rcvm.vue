<template>
  <v-layout row wrap>
    <v-flex xs12>
      <v-stepper v-model="e6" vertical>
        <v-stepper-step
            :complete="e6 > 1"
            editable
            :edit-icon="$vuetify.icons.complete"
            step="1"
        >Resultados laboratorios
        </v-stepper-step>

        <v-stepper-content step="1">
          <v-card color="lighten-1" class="mb-5" height="auto">
            <v-container grid-list-xs>
              <v-layout row wrap>
                <v-flex xs4 px-1>
                  <v-switch
                      color="primary"
                      v-model="GlicemiaBolean"

                      :label="'Glicemia'"
                  ></v-switch>
                  <v-text-field
                      :label="`Numero`"
                      :type="'number'"
                      v-show="GlicemiaBolean"
                      v-model="data.Glicemia"
                  ></v-text-field>
                  <v-text-field
                      :label="`Fecha`"
                      :type="'date'"
                      v-show="GlicemiaBolean"
                      v-model="data.Glicemiafecha"
                  ></v-text-field>
                </v-flex>


                <v-flex xs4 px-1>
                  <v-switch
                      color="primary"
                      v-model="HemoglobinaglicosiladaBolean"

                      :label="'Hemoglobinaglicosilada'"
                  ></v-switch>
                  <v-text-field
                      :label="`Numero`"
                      :type="'number'"
                      v-show="HemoglobinaglicosiladaBolean"
                      v-model="data.Hemoglobinaglicosilada"
                  ></v-text-field>
                  <v-text-field
                      :label="`Fecha`"
                      :type="'date'"
                      v-show="HemoglobinaglicosiladaBolean"
                      v-model="data.Hemoglobinafecha"
                  ></v-text-field>
                </v-flex>


                <v-flex xs4 px-1>
                  <v-switch
                      color="primary"
                      v-model="ColesteroltotalBolean"

                      :label="'Colesteroltotal'"
                  ></v-switch>
                  <v-text-field
                      :label="`Numero`"
                      :type="'number'"
                      v-show="ColesteroltotalBolean"
                      v-model="data.Colesteroltotal"
                  ></v-text-field>
                  <v-text-field
                      :label="`Fecha`"
                      :type="'date'"
                      v-show="ColesteroltotalBolean"
                      v-model="data.Colesteroltotalfecha"
                  ></v-text-field>
                </v-flex>

                <v-flex xs4 px-1>
                  <v-switch
                      color="primary"
                      v-model="ColesterolhdlBolean"

                      :label="'Colesterolhdl'"
                  ></v-switch>
                  <v-text-field
                      :label="`Numero`"
                      :type="'number'"
                      v-show="ColesterolhdlBolean"
                      v-model="data.Colesterolhdl"
                  ></v-text-field>
                  <v-text-field
                      :label="`Fecha`"
                      :type="'date'"
                      v-show="ColesterolhdlBolean"
                      v-model="data.Colesterolhdlfecha"
                  ></v-text-field>
                </v-flex>

                <v-flex xs4 px-1>
                  <v-switch
                      color="primary"
                      v-model="ColesterolldlBolean"

                      :label="'Colesterolldl'"
                  ></v-switch>
                  <v-text-field
                      :label="`Numero`"
                      :type="'number'"
                      v-show="ColesterolldlBolean"
                      v-model="data.Colesterolldl"
                  ></v-text-field>
                  <v-text-field
                      :label="`Fecha`"
                      :type="'date'"
                      v-show="ColesterolldlBolean"
                      v-model="data.Colesterolldlfecha"
                  ></v-text-field>
                </v-flex>


                <v-flex xs4 px-1>
                  <v-switch
                      color="primary"
                      v-model="TrigliceridosBolean"

                      :label="'Trigliceridos'"
                  ></v-switch>
                  <v-text-field
                      :label="`Numero`"
                      :type="'number'"
                      v-show="TrigliceridosBolean"
                      v-model="data.Trigliceridos"
                  ></v-text-field>
                  <v-text-field
                      :label="`Fecha`"
                      :type="'date'"
                      v-show="TrigliceridosBolean"
                      v-model="data.Trigliceridosfecha"
                  ></v-text-field>
                </v-flex>

                <v-flex xs4 px-1>
                  <v-switch
                      color="primary"
                      v-model="ProteinuriaBolean"

                      :label="'Proteinuria'"
                  ></v-switch>
                  <v-text-field
                      :label="`Numero`"
                      :type="'number'"
                      v-show="ProteinuriaBolean"
                      v-model="data.Proteinuria"
                  ></v-text-field>
                  <v-text-field
                      :label="`Fecha`"
                      :type="'date'"
                      v-show="ProteinuriaBolean"
                      v-model="data.Proteinuriafecha"
                  ></v-text-field>
                </v-flex>

                <v-flex xs4 px-1>
                  <v-switch
                      color="primary"
                      v-model="UroanalisisBolean"

                      :label="'Uroanalisis'"
                  ></v-switch>
                  <v-text-field
                      :label="`Numero`"
                      :type="'number'"
                      v-show="UroanalisisBolean"
                      v-model="data.Uroanalisis"
                  ></v-text-field>
                  <v-text-field
                      :label="`Fecha`"
                      :type="'date'"
                      v-show="UroanalisisBolean"
                      v-model="data.Uroanalisisfecha"
                  ></v-text-field>
                </v-flex>

                <v-flex xs4 px-1>
                  <v-switch
                      color="primary"
                      v-model="MicroalbuminuriaBolean"

                      :label="'Microalbuminuria'"
                  ></v-switch>
                  <v-text-field
                      :label="`Numero`"
                      :type="'number'"
                      v-show="MicroalbuminuriaBolean"
                      v-model="data.Microalbuminuria"
                  ></v-text-field>
                  <v-text-field
                      :label="`Fecha`"
                      :type="'date'"
                      v-show="MicroalbuminuriaBolean"
                      v-model="data.Microalbuminuriafecha"
                  ></v-text-field>
                </v-flex>

                <v-flex xs4 px-1>
                  <v-switch
                      color="primary"
                      v-model="CreatininaBolean"

                      :label="'Creatinina'"
                  ></v-switch>
                  <v-text-field
                      :label="`Numero`"
                      :type="'number'"
                      v-show="CreatininaBolean"
                      v-model="data.Creatinina"
                  ></v-text-field>
                  <v-text-field
                      :label="`Fecha`"
                      :type="'date'"
                      v-show="CreatininaBolean"
                      v-model="data.Creatininafecha"
                  ></v-text-field>
                </v-flex>

              </v-layout>
            </v-container>
          </v-card>
          <v-btn color="primary" round @click="guardaPrimerPaso()">Guardar y seguir</v-btn>
        </v-stepper-content>

        <v-stepper-step
            :complete="e6 > 2"
            editable
            :edit-icon="$vuetify.icons.complete"
            step="2"
        >Gestion del riesgo
        </v-stepper-step>
        <v-stepper-content step="2">
          <v-card color="lighten-1" class="mb-5" height="auto">
            <v-container grid-list-xs>
              <v-layout row wrap>
                <v-flex xs4 px-1>
                  <v-select
                      :items="items"
                      label="Disminucion de TFG"
                      v-model="data.Disminuciondetfg"
                  ></v-select>


                </v-flex>

                <v-flex xs4 px-1>
                  <v-select
                      :items="items"
                      label="Resultadoframinghan"
                      v-model="data.Resultadoframinghan"
                  ></v-select>


                </v-flex>

                <v-flex xs4 px-1>
                  <v-select
                      :items="items"
                      label="Cumplemetaterapeutica"
                      v-model="data.Cumplemetaterapeutica"
                  ></v-select>


                </v-flex>

                <v-flex xs4 px-1>
                  <v-select
                      :items="items"
                      label="Pacienteadherente"
                      v-model="data.Pacienteadherente"
                  ></v-select>


                </v-flex>

                <v-flex xs4 px-1>
                  <v-select
                      :items="items"
                      label="Pacientecontrolado"
                      v-model="data.Pacientecontrolado"
                  ></v-select>


                </v-flex>

                <v-flex xs4 px-1>
                  <v-select
                      :items="items"
                      label="Insulinorequiriente"
                      v-model="data.Insulinorequiriente"
                  ></v-select>


                </v-flex>

                <v-flex xs4 px-1>
                  <v-select
                      :items="items"
                      label="Signosdealarma"
                      v-model="data.Signosdealarma"
                  ></v-select>
                </v-flex>

                <v-flex xs4 px-1>
                  <v-select
                      :items="items"
                      label="Hospitalizacionesrecientes"
                      v-model="data.Hospitalizacionesrecientes"
                  ></v-select>


                </v-flex>

                <v-flex xs4 px-1>
                  <v-text-field
                      :label="`Valoracionpornutricion`"
                      :type="'date'"
                      v-model="data.Valoracionpornutricion"
                  ></v-text-field>

                </v-flex>

                <v-flex xs4 px-1>
                  <v-text-field
                      :label="`Valoracionporpsicologia`"
                      :type="'date'"
                      v-model="data.Valoracionporpsicologia"
                  ></v-text-field>

                </v-flex>
                <v-flex xs4 px-1>
                  <v-text-field
                      :label="`Asisteatallergrupaleducativo`"
                      :type="'date'"
                      v-model="data.Asisteatallergrupaleducativo"
                  ></v-text-field>

                </v-flex>

                <v-flex xs4 px-1>
                  <v-select
                      :items="['Medico individual','Enfermeria','Grupal']"
                      label="Proximocontrolcon"
                      v-model="data.Proximocontrolcon"
                  ></v-select>
                </v-flex>

                <v-flex xs4 px-1>
                  <v-select
                      :items="['Un Mes', '3 Meses', '4 Meses', '6 Meses']"
                      label="Periodicidadproximocontrol"
                      v-model="data.Periodicidadproximocontrol"
                  ></v-select>
                </v-flex>


              </v-layout>
            </v-container>
            <v-btn color="primary" round @click="guardarRCVM()">Guardar</v-btn>
          </v-card>
        </v-stepper-content>


      </v-stepper>
    </v-flex>
  </v-layout>
</template>
<script>
    import {EventBus} from "../../../event-bus.js";

    export default {
        created() {
            this.citaPaciente = this.$route.query.cita_paciente;
        },
        data() {
            return {
                e6: 1,
                GlicemiaBolean: false,
                HemoglobinaglicosiladaBolean: false,
                ColesteroltotalBolean: false,
                ColesterolhdlBolean: false,
                ColesterolldlBolean: false,
                TrigliceridosBolean: false,
                ProteinuriaBolean: false,
                UroanalisisBolean: false,
                MicroalbuminuriaBolean: false,
                CreatininaBolean: false,
                data: {
                    Glicemiafecha: '',
                    Glicemia: '',
                    Hemoglobinaglicosilada: '',
                    Hemoglobinafecha: '',
                    Colesteroltotal: '',
                    Colesteroltotalfecha: '',
                    Colesterolhdl: '',
                    Colesterolhdlfecha: '',
                    Colesterolldl: '',
                    Colesterolldlfecha: '',
                    Trigliceridos: '',
                    Trigliceridosfecha: '',
                    Proteinuria: '',
                    Proteinuriafecha: '',
                    Uroanalisis: '',
                    Uroanalisisfecha: '',
                    Microalbuminuria: '',
                    Microalbuminuriafecha: '',
                    Creatinina: '',
                    Creatininafecha: '',
                    Disminuciondetfg: '',
                    Resultadoframinghan: '',
                    Cumplemetaterapeutica: '',
                    Pacienteadherente: '',
                    Pacientecontrolado: '',
                    Insulinorequiriente: '',
                    Signosdealarma: '',
                    Hospitalizacionesrecientes: '',
                    Valoracionpornutricion: '',
                    Valoracionporpsicologia: '',
                    Asisteatallergrupaleducativo: '',
                    Periodicidadproximocontrol: '',
                    Proximocontrolcon: '',
                },
                items: ['SI', 'NO'],

            };
        },


        mounted() {
          this.getLocalStorage();
        },
        methods: {

            guardaPrimerPaso() {
                this.e6 = 2;
                axios.post("/api/labgestion/" + this.citaPaciente + '/create',this.data).then((res) => {
                    // this.e6 = 3;
                    console.log(res.data);
                    localStorage.setItem("rcvm", JSON.stringify(this.data));
                    // this.$router.push('/historiaclinica/patologias?cita_paciente='+this.citaPaciente);
                    // EventBus.$emit('change_disabled_list_history','ANTECEDENTES')
                })
            },
            guardarRCVM() {
                axios.post("/api/labgestion/" + this.citaPaciente + '/create',this.data).then((res) => {
                    // this.e6 = 3;
                    console.log(res.data);
                    localStorage.setItem("rcvm", JSON.stringify(this.data));
                     this.$router.push('/historiaclinica/conducta?cita_paciente='+this.citaPaciente);
                    // EventBus.$emit('change_disabled_list_history','ANTECEDENTES')
                })
                    .catch(err => console.log(err.response.data));
                this.e6 = 2;
                // console.log(this.pacienteantecedente)
            },
            getLocalStorage() {
                let rcvm = JSON.parse(localStorage.getItem("rcvm"));
                if (rcvm) {
                    this.data = rcvm;
                } else {
                  this.fetchrcvm();
                }
            },
            fetchrcvm() {
              axios.get('/api/gineco/'+this.citaPaciente+'/gineco')
                .then(res => {  
                  this.data = res.data;
                });
            }
        }
    };
</script>
<style scoped>
</style>