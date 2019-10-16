<template>
  <v-layout row wrap>
    <v-flex xs12>
      <v-stepper v-model="e6" vertical>
        <v-stepper-step
          :complete="e6 > 1"
          editable
          :edit-icon="$vuetify.icons.complete"
          step="1"
        >ESTILOS DE VIDA</v-stepper-step>

        <v-stepper-content step="1">
          <v-container fluid>
            <v-layout row>
              <v-flex xs6 order-md1 order-xs1>
                <v-card color="lighten-1" class="mb-5" height="auto">
                  <v-card-text>
                    <v-flex xs10>
                      <v-layout row wrap>
                        <v-switch color="primary" v-model="data.a" label="Dieta"></v-switch>
                      </v-layout>
                      <v-text-field
                        label="Especificar calidad y frecuencia de las comidas"
                        spellcheck="true"
                        v-show="data.a"
                        v-model="data.Dietasaludable"
                      ></v-text-field>
                    </v-flex>
                    <v-flex xs10>
                      <v-switch color="primary" v-model="data.b" label="Alteraciones del Sueño"></v-switch>
                      <v-text-field
                        label="Especificar calidad y duración"
                        v-show="data.b"
                        v-model="data.Suenoreparador"
                      ></v-text-field>
                    </v-flex>
                    <!-- <v-flex xs10>
                      <v-switch color="primary" v-model="data.c" label="Duerme Menos de 6 Horas"></v-switch>
                      <v-text-field
                        label="Duerme Menos de 6 Horas"
                        v-show="data.c"
                        v-model="data.Duermemenoseishoras"
                      ></v-text-field>
                    </v-flex> -->
                    <v-flex xs10>
                      <v-switch
                        color="primary"
                        v-model="data.d"
                        label="Maneja Altos Niveles de Estres"
                      ></v-switch>
                      <v-text-field
                        label="Maneja Altos Niveles de Estres"
                        v-show="data.d"
                        v-model="data.Altosnivelesestres"
                      ></v-text-field>
                    </v-flex>
                    <v-flex xs10>
                      <v-switch color="primary" v-model="data.e" label="Actividad Física"></v-switch>
                      <!-- <v-text-field
                        label="Actividad Física"
                        v-show="data.e"
                        v-model="data.Actividadfisica"
                      ></v-text-field> -->
                      <v-text-field 
                      label="Duración" 
                      v-show="data.e"
                       v-model="data.Duracion">
                       </v-text-field>
                      <v-text-field
                        label="Intensidad"
                        v-show="data.e"
                        v-model="data.Actividadfisica"
                      ></v-text-field>
                      <v-text-field 
                      label="Frecuencia en la Semana" 
                      v-show="data.e" v-model="data.Frecuenciasemana">
                      </v-text-field>
                    </v-flex>
                  </v-card-text>
                </v-card>
              </v-flex>
              <v-flex xs6 order-md2 order-xs2>
                <v-card color="lighten-1" class="mb-5" height="auto">
                  <v-card-text>
                    <v-flex xs10>
                      <v-switch color="primary" v-model="data.f" label="Exposición Humo de Tabaco"></v-switch>
                      <v-text-field label="Si es fumador pasivo, poner 0" v-show="data.f" v-model="data.Fumacantidad"></v-text-field>
                      <v-text-field
                        label="Inició uso de cigarrillo"
                        v-show="data.f"
                        v-model="data.Fumainicio"
                      ></v-text-field>
                    </v-flex>
                    <v-flex xs10>
                      <span></span>
                      <v-switch color="primary" v-model="data.g" label="Consumo SPA"></v-switch>
                      <v-text-field
                        label="Fecha de Inicio"
                        v-show="data.g"
                        v-model="data.Fumadorpasivo"
                      ></v-text-field>
                    </v-flex>
                    <v-flex xs10>
                      <v-switch color="primary" v-model="data.h" label="Consumo Licor"></v-switch>
                      <v-text-field
                        label="Cantidad de tragos de licor"
                        v-show="data.h"
                        v-model="data.Cantidadlicor"
                      ></v-text-field>
                      <v-select
                        v-show="data.h"
                        :items="['Ocasional','Mensual', 'Semanal', 'Diario']"
                        label="Frecuencia"
                        v-model="data.Frecuencialicor"
                        chips
                      />
                    </v-flex>
                  </v-card-text>
                </v-card>
              </v-flex>
            </v-layout>
            <v-flex xs12>
              <v-card>
                <v-container fill-height fluid>
                  <v-layout fill-height>
                    <v-flex xs12 align-end flexbox>
                      <v-textarea
                        name="input-7-1"
                        label="Observación"
                        value
                        v-model="data.Estilovidaobservaciones"
                      ></v-textarea>
                    </v-flex>
                  </v-layout>
                </v-container>
              </v-card>
            </v-flex>
          </v-container>
          <v-btn color="primary" round @click="guardarEstilovida()">Guardar y seguir</v-btn>
        </v-stepper-content>
      </v-stepper>
    </v-flex>
  </v-layout>
</template>
<script>
import { EventBus } from "../../../event-bus.js";

export default {
  created() {
    this.citaPaciente = this.$route.query.cita_paciente;
  },
  data() {
    return {
      e6: 1,
      data: {
        Dietasaludable: "",
        Suenoreparador: "",
        Duermemenoseishoras: "",
        Altonivelestres: "",
        Actividadfisica: "",
        Frecuenciasemana: "",
        Intensidad: "",
        Duracion: "",
        Fumacantidad: "",
        Fumainicio: "",
        Fumadorpasivo: "",
        Consumelicor: "",
        Licorfrecuencia: "",
        Consumopsicoactivo: "",
        Psicoactivocantidad: "",
        Estilovidaobservaciones: ""
      },
      citaPaciente: 0
    };
  },
  mounted() {
    this.getLocalStorage();
  },
  methods: {
    guardarEstilovida() {
      // console.log(this.data)
      axios
        .post("/api/estilovida/" + this.citaPaciente + "/create", this.data)
        .then(res => {
          this.e6 = 3;
          localStorage.setItem("EstiloVida", JSON.stringify(this.data));
          this.$router.push(
            "/historiaclinica/examensistema?cita_paciente=" + this.citaPaciente
          );
          EventBus.$emit("change_disabled_list_history", "ESTILOS DE VIDA");
        });
    },
    getLocalStorage() {
      let estilo = JSON.parse(localStorage.getItem("EstiloVida"));
      if (estilo) {
          this.data = estilo;
      } else {
        this.fetchLifeStyle();
      }
    },
    fetchLifeStyle() {
      axios.get('/api/estilovida/'+this.citaPaciente+'/lifeStyle')
      .then(res => {  
        if (res.data.estilovida) {
          this.data = res.data.estilovida;
        }
        
        
        // (res.data.estilovida.Dietasaludable)? this.data.a = true : this.data.a = false;
        // (res.data.estilovida.Suenoreparador)? this.data.b = true : this.data.b = false;
        // (res.data.estilovida.Duermemenoseishoras)? this.data.c = true : this.data.c = false;
        // (res.data.estilovida.Altosnivelesestres)? this.data.d = true : this.data.d = false;
        // (res.data.estilovida.Actividadfisica)? this.data.e = true : this.data.e = false;
        // (res.data.estilovida.Frecuenciasemana)? this.data.e = true : this.data.e = false;
        // (res.data.estilovida.Fumainicio)? this.data.f = true : this.data.f = false;
        // (res.data.estilovida.Fumadorpasivo)? this.data.g = true : this.data.g = false;
        // (res.data.estilovida.Cantidadlicor)? this.data.h = true : this.data.h = false;
        // (res.data.estilovida.Frecuencialicor)? this.data.h = true : this.data.h = false;
      });
    }
  }
};
</script>
<style scoped>
</style>