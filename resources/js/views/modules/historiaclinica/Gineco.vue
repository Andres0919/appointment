<template>
  <v-layout row wrap>
    <v-flex xs12>
      <v-stepper v-model="e6" vertical>
        <v-stepper-step
          :complete="e6 > 1"
          editable
          :edit-icon="$vuetify.icons.complete"
          step="1"
        >ANTECEDENTES GINECO OBSTÉTRICOS</v-stepper-step>

        <v-stepper-content step="1">
          <v-container fluid>
            <v-layout row>
              <v-flex grow pa-1>
                <v-card color="lighten-1" class="mb-5" height="auto">
                  <v-card-text>
                    <v-flex xs12>
                      <v-layout row wrap>
                        <v-switch color="primary" v-model="data.a" label="FUM"></v-switch>
                      </v-layout>
                      <v-text-field
                        label="FUM"
                        v-show="data.a"
                        v-model="data.Fechaultimamenstruacion"
                      ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                      <v-switch color="primary" v-model="data.b" label="Gestante"></v-switch>
                      <v-text-field label="Gestante" v-show="data.b" v-model="data.Gestaciones"></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                      <v-switch color="primary" v-model="data.c" label="Partos"></v-switch>
                      <v-text-field label="Partos" v-show="data.c" v-model="data.Partos"></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                      <v-switch color="primary" v-model="data.d" label="Aborto provocado"></v-switch>
                      <v-text-field
                        label="Aborto provocado"
                        v-show="data.d"
                        v-model="data.Abortoprovocado"
                      ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                      <v-switch color="primary" v-model="data.x" label="Aborto espontáneo"></v-switch>
                      <v-text-field
                        label="Aborto espontáneo"
                        v-show="data.x"
                        v-model="data.Abortoespontaneo"
                      ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                      <v-switch color="primary" v-model="data.f" label="Mortinato"></v-switch>
                      <v-text-field label="Mortinato" v-show="data.f" v-model="data.Mortinato"></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                      <v-switch color="primary" v-model="data.g" label="Gestante"></v-switch>
                      <v-text-field
                        label="Fecha Problable Parto"
                        v-show="data.g"
                        v-model="data.Gestantefechaparto"
                      ></v-text-field>
                      <v-text-field
                        label="Numero Control Prenatal"
                        v-show="data.g"
                        v-model="data.Gestantenumeroctrlprenatal"
                      ></v-text-field>
                    </v-flex>
                  </v-card-text>
                </v-card>
              </v-flex>
              <v-flex grow pa-1>
                <v-card color="lighten-1" class="mb-5" height="auto">
                  <v-card-text>
                    <v-flex xs12>
                      <span></span>
                      <v-switch color="primary" v-model="data.h" label="Eutoxico"></v-switch>
                      <v-text-field label="Eutoxico" v-show="data.h" v-model="data.Eutoxico"></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                      <v-switch color="primary" v-model="data.i" label="Cesareas"></v-switch>
                      <v-text-field label="Cesareas" v-show="data.i" v-model="data.Cesaria"></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                      <v-switch color="primary" v-model="data.j" label="Cáncer Cuello Uterino"></v-switch>
                      <v-text-field
                        label="Cáncer Cuello Uterino"
                        v-show="data.j"
                        v-model="data.Cancercuellouterino"
                      ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                      <v-switch color="primary" v-model="data.k" label="Última Citologia"></v-switch>
                      <v-text-field
                        label="Última Citologia"
                        v-show="data.k"
                        v-model="data.Ultimacitologia"
                      ></v-text-field>
                      <v-text-field label="Resultado" v-show="data.k" v-model="data.Resultado"></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                      <v-switch color="primary" v-model="data.l" label="Menarquia"></v-switch>
                      <v-text-field label="Menarquia" v-show="data.l" v-model="data.Menarquia"></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                      <v-switch color="primary" v-model="data.m" label="Ciclos"></v-switch>
                      <v-text-field label="Ciclos" v-show="data.m" v-model="data.Ciclos"></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                      <v-switch color="primary" v-model="data.n" label="Regulares"></v-switch>
                      <v-text-field label="Regulares" v-show="data.n" v-model="data.Regulares"></v-text-field>
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
                        label="Observacion"
                        value
                        v-model="data.Observaciongineco"
                      ></v-textarea>
                    </v-flex>
                  </v-layout>
                </v-container>
              </v-card>
            </v-flex>
          </v-container>
          <v-btn color="primary" round @click="guardarAntecedentesgineco()">Guardar y seguir</v-btn>
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
        Fechaultimamenstruacion: "",
        Gestaciones: "",
        Partos: "",
        Abortoprovocado: "",
        Abortoespontaneo: "",
        Mortinato: "",
        Gestantefechaparto: "",
        Gestantenumeroctrlprenatal: "",
        Eutoxico: "",
        Cesaria: "",
        Cancercuellouterino: "",
        Ultimacitologia: "",
        Resultado: "",
        Menarquia: "",
        Ciclos: "",
        Regulares: "",
        Observaciongineco: ""
      },
      citaPaciente: 0
    };
  },
  mounted() {
    this.getLocalStorage();
  },
  methods: {
    guardarAntecedentesgineco() {
      //  console.log(this.data)
      axios
        .post("/api/gineco/" + this.citaPaciente + "/create", this.data)
        .then(res => {
          this.e6 = 3;
          localStorage.setItem("Gineco", JSON.stringify(this.data));
           this.$router.push("/historiaclinica/stylelive?cita_paciente=" + this.citaPaciente);
          EventBus.$emit(
            "change_disabled_list_history",
            "ANTECEDENTES GINECO OBSTÉTRICOS"
          );
        });
    },
    getLocalStorage() {
        let gineco = JSON.parse(localStorage.getItem("Gineco"));
        if (gineco) {
            this.data = gineco;
        } else {
          this.fetchGineco();
        }
    },
    fetchGineco() {
        axios.get('/api/gineco/'+this.citaPaciente+'/gineco')
          .then(res => { 
              this.data = res.data;
              // (res.data.Fechaultimamenstruacion)? this.data.a = true : this.data.a = false;
              // (res.data.Gestaciones)? this.data.b = true : this.data.b = false;
              // (res.data.Partos)? this.data.c = true : this.data.c = false;
              // (res.data.Abortoprovocado)? this.data.d = true : this.data.d = false;
              // (res.data.Abortoespontaneo)? this.data.x = true : this.data.x = false;
              // (res.data.Mortinato)? this.data.f = true : this.data.f = false;
              // (res.data.Gestantefechaparto)? this.data.g = true : this.data.g = false;
              // (res.data.Gestantenumeroctrlprenatal)? this.data.g = true : this.data.g = false;
              // (res.data.Eutoxico)? this.data.h = true : this.data.h = false;
              // (res.data.Cesaria)? this.data.i = true : this.data.i = false;
              // (res.data.Cancercuellouterino)? this.data.j = true : this.data.j = false;
              // (res.data.Ultimacitologia)? this.data.k = true : this.data.k = false;
              // (res.data.Resultado)? this.data.k = true : this.data.k = false;
              // (res.data.Menarquia)? this.data.l = true : this.data.l = false;
              // (res.data.Ciclos)? this.data.m = true : this.data.m = false;
              // (res.data.Regulares)? this.data.n = true : this.data.n = false;
          });
    },
  }
};
</script>
<style scoped>
</style>
