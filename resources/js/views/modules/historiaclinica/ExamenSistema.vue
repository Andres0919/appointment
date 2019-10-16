<template>
  <v-layout row wrap>
    <v-flex xs12>
      <v-stepper v-model="e6" vertical>
        <v-stepper-step
          :complete="e6 > 1"
          editable
          :edit-icon="$vuetify.icons.complete"
          step="1"
        >MEDIDAS ANTROPOMÉTRICAS</v-stepper-step>
        <v-stepper-content step="1">
          <v-card color="lighten-1" class="mb-5" height="auto">
            <v-container grid-list-xs>
              <v-layout row wrap>
                <v-flex xs3 px-1>
                  <v-text-field label="Peso (Kg)" v-model="data.Peso" type="number"></v-text-field>
                </v-flex>
                <v-flex xs3 px-1>
                  <v-text-field label="Talla (cm)" v-model="data.Talla" type="number"></v-text-field>
                </v-flex>
                <v-flex xs3 px-1>
                  <v-text-field label="IMC" v-model="data.Imc" type="number" readonly></v-text-field>
                </v-flex>
                <v-flex xs3 px-1>
                  <v-text-field label="Clasificación" v-model="data.Clasificacion" readonly></v-text-field>
                </v-flex>
                <v-flex xs6 px-1>
                  <v-text-field
                    label="Perímetro Abdominal"
                    type="number"
                    v-model="data.Perimetroabdominal"
                  ></v-text-field>
                </v-flex>
                <v-flex xs6 px-1>
                  <v-text-field
                    v-if="Perimetrocefalico"
                    label="Perímetro Cefálico"
                    type="number"
                    v-model="data.Perimetrocefalico"
                  ></v-text-field>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card>
          <v-btn round color="primary" @click="guardarAntropometricas()">Guardar y seguir</v-btn>
        </v-stepper-content>

        <v-stepper-step
          :complete="e6 > 2"
          editable
          :edit-icon="$vuetify.icons.complete"
          step="2"
        >SIGNOS VITALES</v-stepper-step>
        <v-stepper-content step="2">
          <v-card color="lighten-1" class="mb-5">
            <v-container grid-list-xs>
              <v-layout row wrap>
                <v-flex xs4 px-1>
                  <v-text-field
                    label="Frecuencia cardiaca"
                    type="number"
                    v-model="data.Frecucardiaca"
                  ></v-text-field>
                </v-flex>
                <v-flex xs2 px-1>
                  <v-text-field label="Pulsos" type="number" v-model="data.Pulsos"></v-text-field>
                </v-flex>
                <v-flex xs4 px-1>
                  <v-text-field
                    label="Frecuencia Respiratoria"
                    type="number"
                    v-model="data.Frecurespiratoria"
                  ></v-text-field>
                </v-flex>
                <v-flex xs2 px-1>
                  <v-text-field label="Temperatura" type="number" v-model="data.Temperatura"></v-text-field>
                </v-flex>
                <v-flex xs4 px-1>
                  <v-text-field label="Sat. O2" type="number" v-model="data.Saturacionoxigeno"></v-text-field>
                </v-flex>
              </v-layout>

              <v-layout row wrap>
                <v-flex xs2 px-1>
                  <v-select
                    :items="['Sentado','Acostado','De pie']"
                    label="Posición"
                    v-model="data.Posicion"
                    chips
                  />
                </v-flex>
                <v-flex xs2 px-1>
                  <v-select
                    :items="['Derecha','Izquierda']"
                    label="Lateralidad"
                    v-model="data.Lateralidad"
                    chips
                  />
                </v-flex>
                <v-flex xs3 px-1>
                  <v-text-field
                    label="Presión / Sistólica"
                    value
                    type="number"
                    v-model="data.Presionsistolica"
                  ></v-text-field>
                </v-flex>
                <v-flex xs2 px-1>
                  <v-text-field
                    label="Presión / Diastólica"
                    value
                    type="number"
                    v-model="data.Presiondiastolica"
                  ></v-text-field>
                </v-flex>
                <v-flex xs3 px-1>
                  <v-text-field
                    label="Presión Arterial Media"
                    value
                    type="number"
                    v-model="data.Presionarterialmedia"
                  ></v-text-field>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card>
          <v-btn color="primary" round @click="guardarSignosVitales()">Guardar y seguir</v-btn>
        </v-stepper-content>

        <v-stepper-step
          :complete="e6 > 3"
          editable
          :edit-icon="$vuetify.icons.complete"
          step="3"
        >EXAMEN FÍSICO</v-stepper-step>
        <v-stepper-content step="3">
          <v-container grid-list-xs>
            <v-layout row wrap>
              <v-textarea
                name="input-7-1"
                label="Condiciones Generales"
                value
                v-model="data.Condiciongeneral"
              ></v-textarea>
            </v-layout>
            <v-layout row wrap>
              <v-flex xs4 px-1>
                <v-switch color="primary" v-model="data.a" label="Cabeza Cuello"></v-switch>
                <v-text-field label="Cabeza Cuello" v-show="data.a" v-model="data.Cabezacuello"></v-text-field>
              </v-flex>
              <v-flex xs4 px-1>
                <v-switch color="primary" v-model="data.b" label="Ojos y Fondo de Ojos"></v-switch>
                <v-text-field
                  label="Ojos y Fondo de Ojos"
                  v-show="data.b"
                  v-model="data.Ojosfondojos"
                ></v-text-field>
              </v-flex>
              <v-flex xs4 px-1>
                <v-switch color="primary" v-model="data.c" label="Agudeza Visual"></v-switch>
                <v-text-field label="Agudeza Visual" v-show="data.c" v-model="data.Agudezavisual"></v-text-field>
              </v-flex>
              <v-flex xs4 px-1>
                <v-switch color="primary" v-model="data.d" label="Cardiopulmonar"></v-switch>
                <v-text-field label="Cardiopulmonar" v-show="data.d" v-model="data.Cardiopulmonar"></v-text-field>
              </v-flex>
              <v-flex xs4 px-1>
                <v-switch color="primary" v-model="data.e" label="Abdomen"></v-switch>
                <v-text-field label="Abdomen" v-show="data.e" v-model="data.Abdomen"></v-text-field>
              </v-flex>
              <v-flex xs4 px-1>
                <v-switch color="primary" v-model="data.f" label="Osteomuscular"></v-switch>
                <v-text-field label="Osteomuscular" v-show="data.f" v-model="data.Osteomuscular"></v-text-field>
              </v-flex>
              <v-flex xs4 px-1>
                <v-switch color="primary" v-model="data.g" label="Extreminades"></v-switch>
                <v-text-field label="Extreminades" v-show="data.g" v-model="data.Extremidades"></v-text-field>
              </v-flex>
              <v-flex xs4 px-1>
                <v-switch color="primary" v-model="data.h" label="Pulsos Periféricos"></v-switch>
                <v-text-field
                  label="Pulsos Periféricos"
                  v-show="data.h"
                  v-model="data.Pulsosperifericos"
                ></v-text-field>
              </v-flex>
              <v-flex xs4 px-1>
                <v-switch color="primary" v-model="data.i" label="Neurológicos"></v-switch>
                <v-text-field label="Neurológicos" v-show="data.i" v-model="data.Neurologico"></v-text-field>
              </v-flex>
              <v-flex xs4 px-1>
                <v-switch color="primary" v-model="data.j" label="Reflejos Osteotendinosos"></v-switch>
                <v-text-field
                  label="Reflejos Osteotendinosos"
                  v-show="data.j"
                  v-model="data.Reflejososteotendinos"
                ></v-text-field>
              </v-flex>
              <v-flex xs4 px-1>
                <v-switch color="primary" v-model="data.k" label="Piel y Faneras"></v-switch>
                <v-text-field label="Piel y Faneras" v-show="data.k" v-model="data.Pielfraneras"></v-text-field>
              </v-flex>
              <v-flex xs4 px-1>
                <v-switch color="primary" v-model="data.l" label="Genitourinario"></v-switch>
                <v-text-field label="Genitourinario" v-show="data.l" v-model="data.Genitourinario"></v-text-field>
              </v-flex>
              <v-flex xs4 px-1>
                <v-switch color="primary" v-model="data.o" label="Examen de Mama"></v-switch>
                <v-text-field label="Examen de Mama" v-show="data.o" v-model="data.Examenmama"></v-text-field>
              </v-flex>
              <v-flex xs4 px-1>
                <v-switch color="primary" v-model="data.p" label="Tacto Rectal"></v-switch>
                <v-text-field label="Tacto Rectal" v-show="data.p" v-model="data.Tactoretal"></v-text-field>
              </v-flex>
              <v-flex xs4 px-1>
                <v-switch color="primary" v-model="data.q" label="Examen Mental"></v-switch>
                <v-text-field label="Examen Mental" v-show="data.q" v-model="data.Examenmental"></v-text-field>
              </v-flex>
            </v-layout>
          </v-container>
          <v-btn color="primary" round @click="guardarExamenFisico()">Guardar</v-btn>
        </v-stepper-content>
      </v-stepper>
    </v-flex>
  </v-layout>
</template>
<script>
import { EventBus } from "../../../event-bus.js";
import { parse } from "path";

export default {
  created() {
    this.citaPaciente = this.$route.query.cita_paciente;
    EventBus.$on("recibir-paciente-examen-fisico", paciente => {
      this.paciente = paciente;
    });
  },
  data() {
    return {
      e6: 1,
      Perimetrocefalico: false,
      data: {
        Peso: "",
        Talla: "",
        Imc: "",
        Clasificacion: "",
        Perimetroabdominal: "",
        Perimetrocefalico: "",
        Frecucardiaca: "",
        Pulsos: "",
        Frecurespiratoria: "",
        Temperatura: "",
        Saturacionoxigeno: "",
        Posicion: "",
        Lateralidad: "",
        Presionsistolica: "",
        Presiondiastolica: "",
        Presionarterialmedia: "",
        Condiciongeneral: "",
        Cabezacuello: "",
        Ojosfondojos: "",
        Agudezavisual: "",
        Cardiopulmonar: "",
        Abdomen: "",
        Osteomuscular: "",
        Extremidades: "",
        Pulsosperifericos: "",
        Neurologico: "",
        Reflejososteotendinos: "",
        Pielfraneras: "",
        Genitourinario: "",
        Examenmama: "",
        Tactoretal: "",
        Examenmental: ""
      },
      citaPaciente: 0
    };
  },
  mounted() {
    this.getLocalStorage();
  },
  watch: {
    "data.Peso": function() {
      this.calcularIMC();
    },
    "data.Talla": function() {
      this.calcularIMC();
    },
    "data.Presionsistolica": function() {
      this.calcularMediaPresion();
    },
    "data.Presiondiastolica": function() {
      this.calcularMediaPresion();
    }
  },

  methods: {
    getPaciente() {
      if (this.paciente == null) {
        EventBus.$emit("enviar-paciente", "recibir-paciente-examen-fisico");
      }
    },
    calcularMediaPresion() {
      this.data.Presionarterialmedia =
        (parseInt(this.data.Presiondiastolica) * 2 +
          parseInt(this.data.Presionsistolica)) /
        3;
      this.data.Presionarterialmedia = Number.parseFloat(
        this.data.Presionarterialmedia
      ).toFixed(1);
    },
    calcularIMC() {
      this.getPaciente();

      if (this.paciente.Edad_Cumplida > 17) {
        this.data.Imc = this.data.Peso / Math.pow(this.data.Talla / 100, 2);

        this.data.Imc = parseFloat(this.data.Imc);
        if (this.data.Imc < 16.0) {
          this.data.Clasificacion = "Delgadez severa";
        } else if (this.data.Imc > 16.0 && this.data.Imc < 16.99) {
          this.data.Clasificacion = "Delgadez moderada";
        } else if (this.data.Imc > 17.0 && this.data.Imc < 18.49) {
          this.data.Clasificacion = "Delgadez aceptable";
        } else if (this.data.Imc > 18.5 && this.data.Imc < 24.99) {
          this.data.Clasificacion = "Normal";
        } else if (this.data.Imc > 25.0 && this.data.Imc < 29.99) {
          this.data.Clasificacion = "Pre-obeso";
        } else if (this.data.Imc > 30.0 && this.data.Imc < 34.99) {
          this.data.Clasificacion = "Obeso tipo I (riesgo moderado)";
        } else if (this.data.Imc > 35.0 && this.data.Imc < 39.99) {
          this.data.Clasificacion = "Obeso tipo II (riesgo severo)";
        } else if (this.data.Imc >= 40.0) {
          this.data.Clasificacion = "Obeso tipo III (riesgo muy severo)";
        }
      } else if (this.paciente.Edad_Cumplida < 5) {
        this.Perimetrocefalico = true;
      }
    },
    guardarAntropometricas() {
      this.data.Imc = parseInt(this.data.Imc);

      axios
        .post(
          "/api/examenfisico/antropometricas/" + this.citaPaciente,
          this.data
        )
        .then(res => {
          this.e6 = 2;
          localStorage.setItem("ExamenSistema", JSON.stringify(this.data));
          EventBus.$emit('change_disabled_list_history','EXAMEN FÍSICO')
        });
    },
    guardarSignosVitales() {
      let clasificacionPresion = "Normal";

      if (
        this.data.Presionsistolica > 180 ||
        this.data.Presiondiastolica > 120
      ) {
        clasificacionPresion = "CRISIS DE HIPERTENSION";
      } else if (
        this.data.Presionsistolica >= 140 ||
        this.data.Presiondiastolica >= 90
      ) {
        clasificacionPresion = "PRESION ARTERIAL ALTA (NIVEL 2)";
      } else if (
        this.data.Presionsistolica >= 130 ||
        this.data.Presiondiastolica >= 80
      ) {
        clasificacionPresion = "PRESION ARTERIAL ALTA (NIVEL 1)";
      } else if (
        this.data.Presionsistolica >= 120 &&
        this.data.Presiondiastolica < 80
      ) {
        clasificacionPresion = "ELEVADA";
      } else if (
        this.data.Presionsistolica < 120 &&
        this.data.Presiondiastolica < 80
      ) {
        clasificacionPresion = "NORMAL";
      }
      this.data.Clasificacionpresion = clasificacionPresion;

      // console.log(this.data.Clasificacionpresion);

      axios
        .post("/api/examenfisico/signosvitales/" + this.citaPaciente, this.data)
        .then(res => {
          this.e6 = 3;
          localStorage.setItem("ExamenSistema", JSON.stringify(this.data));
          //EventBus.$emit('change_disabled_list_history','ANTECEDENTES')
        });
    },

    guardarExamenFisico() {
      this.getPaciente();
      EventBus.$emit("change_disabled_list_history", "EXAMEN FÍSICO");
      // console.log(this.paciente.Sexo)
      axios
        .post(
          "/api/examenfisico/" + this.citaPaciente + "/examenfisico",
          this.data
        )
        .then(res => {
          this.e6 = 3;
          localStorage.setItem("ExamenSistema", JSON.stringify(this.data));
          this.$router.push("/historiaclinica/diagnostico?cita_paciente=" + this.citaPaciente);
        });
    },

    getLocalStorage() {
      let examen = JSON.parse(localStorage.getItem("ExamenSistema"));
      if (examen) {
          this.data = examen;
      } else {
        this.fetchExamen();
      }
    },

    fetchExamen() {
      axios.get('/api/examenfisico/'+this.citaPaciente+'/examenfisico')
        .then(res => {
            this.data = res.data;
        });
    }

  }
};
</script>
<style scoped>
</style>




