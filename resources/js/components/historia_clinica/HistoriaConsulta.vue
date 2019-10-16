<template>
  <v-container>
    <v-layout row>
      <v-dialog v-model="dialog" max-width="1000px">
        <v-card>
          <v-toolbar flat color="primary" dark>
            <v-toolbar-title>Historia Clinica</v-toolbar-title>
          </v-toolbar>
          <v-tabs vertical>
            <v-tab>
              <v-icon left>mdi-account</v-icon>Información del paciente
            </v-tab>
            <v-tab>
              <v-icon left>list_alt</v-icon>Diagnostico
            </v-tab>

            <v-tab-item>
              <v-flex>
                <v-card flat>
                  <v-card-title class="headline grey lighten-2">Datos del paciente</v-card-title>
                  <v-container>
                    <v-layout wrap align-center>
                      <v-flex xs6 md3 lg4>
                        <v-text-field v-model="history.nombre" label="Nombre" outlined readonly></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg2>
                        <v-text-field v-model="history.cedula" label="Cédula" outlined readonly></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg2>
                        <v-text-field v-model="history.ips" label="IPS" outlined readonly></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg2>
                        <v-text-field v-model="history.edad" label="edad" outlined readonly></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg2>
                        <v-text-field v-model="history.sexo" label="sexo" outlined readonly></v-text-field>
                      </v-flex>
                    </v-layout>
                    <v-layout wrap align-center>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.tipoafiliado"
                          label="Tipo Afiliado"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.departamento"
                          label="Departamento"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.municipioafiliado"
                          label="Municipio Afiliado"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg4>
                        <v-text-field
                          v-model="history.direccion"
                          label="Direccion Residencia"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg2>
                        <v-text-field v-model="history.telefono" label="Telefono" outlined readonly></v-text-field>
                      </v-flex>
                    </v-layout>
                    <v-layout wrap align-center>
                      <v-flex xs6 md3 lg3>
                        <v-text-field v-model="history.celular" label="Celular" outlined readonly></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.fechasolicita"
                          label="Fecha Solicita"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg3>
                        <v-text-field
                          v-model="history.motivoconsulta"
                          label="Motivoconsulta"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg4>
                        <v-text-field
                          v-model="history.enfermedadactual"
                          label="Enfermedad Actual"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                    </v-layout>
                    <v-layout wrap align-center>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.resultayudadiagnostica"
                          label="Resulta Ayuda Diagnostica"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg3>
                        <v-text-field
                          v-model="history.oftalmologico"
                          label="Oftalmologico"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.genitourinario"
                          label="Genitourinario"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg3>
                        <v-text-field
                          v-model="history.otorrinoralingologico"
                          label="Otorrinoralingologico"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.linfatico"
                          label="Linfatico"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                    </v-layout>
                    <v-layout wrap align-center>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.osteomioarticular"
                          label="Osteomio Articular"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg3>
                        <v-text-field
                          v-model="history.neurologico"
                          label="Oftalmologico"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.cardiovascular"
                          label="Cardiovascular"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg3>
                        <v-text-field
                          v-model="history.tegumentario"
                          label="Tegumentario"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.respiratorio"
                          label="Respiratorio"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                    </v-layout>
                    <v-layout wrap align-center>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.endocrinologico"
                          label="Endocrinologico"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg3>
                        <v-text-field
                          v-model="history.gastrointestinal"
                          label="Gastrointestinal"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.norefiere"
                          label="No Refiere"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg3>
                        <v-text-field
                          v-model="history.timeconsulta"
                          label="Time Consulta"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.medicoordeno"
                          label="Medico Ordeno"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                    </v-layout>
                    <v-layout wrap align-center>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.entidademite"
                          label="Entidad Emite"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg3>
                        <v-text-field
                          v-model="history.finalidad"
                          label="Finalidad"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.observaciones"
                          label="Observaciones"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg3>
                        <v-text-field
                          v-model="history.datetimeingreso"
                          label="DateTime Ingreso"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.datetimesalida"
                          label="DateTime Salida"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                    </v-layout>
                    <v-layout wrap align-center>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.antropometricas"
                          label="Antropometricas"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg3>
                        <v-text-field
                          v-model="history.signosvitales"
                          label="Signos Vitales"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.otrossignosvitales"
                          label="Otros Signos Vitales"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg3>
                        <v-text-field
                          v-model="history.presionarterial"
                          label="Presión Arterial"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.condiciongeneral"
                          label="Condición General"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                    </v-layout>
                    <v-layout wrap align-center>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.tipoorden"
                          label="Tipo Orden"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg3>
                        <v-text-field
                          v-model="history.osteomuscular"
                          label="Osteomuscular"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.tipodiagnostico"
                          label="Tipo Diagnostico"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg3>
                        <v-text-field
                          v-model="history.planmanejo"
                          label="Plan Manejo"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.diagnosticoprincipal"
                          label="Diagnostico Principal"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                    </v-layout>
                    <v-layout wrap align-center>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.recomendaciones"
                          label="Recomendaciones"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg3>
                        <v-text-field
                          v-model="history.destinopaciente"
                          label="Destino Paciente"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg2>
                        <v-text-field
                          v-model="history.finalidad"
                          label="Finalidad"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg3>
                        <v-text-field
                          v-model="history.atendidopor"
                          label="Atendido Por"
                          outlined
                          readonly
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6 md3 lg2>
                        <v-text-field v-model="history.cups" label="Cups" outlined readonly></v-text-field>
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-card>
              </v-flex>
            </v-tab-item>

            <v-tab-item>
              <v-card flat>
                <v-card-title class="headline grey lighten-2">Diagnosticos</v-card-title>
                <v-data-table
                  class="fb-table-elem"
                  :headers="diagnosticHeaders"
                  :items="Diagnosticos"
                  item-key="id"
                  :items-per-page="5"
                  hide-actions
                  expand
                >
                  <template v-slot:items="Diagnostico">
                    <tr @click="Diagnostico.expanded = !Diagnostico.expanded">
                      <td class="text-xs-center">
                        <div class="datatable-cell-wrapper">
                          <v-checkbox
                            disabled
                            color="primary"
                            v-model="Diagnostico.item.Esprimario"
                            hide-details
                            :value="Diagnostico.item.Esprimario"
                          ></v-checkbox>
                        </div>
                      </td>
                      <td class="text-xs-center">
                        <div class="datatable-cell-wrapper">{{ Diagnostico.item.Cie10_id }}</div>
                      </td>
                      <td class="text-xs-center">
                        <div class="datatable-cell-wrapper">{{ Diagnostico.item.Tipodiagnostico }}</div>
                      </td>
                      <td class="text-xs-center">
                        <div class="datatable-cell-wrapper">
                          <v-select
                            :items="Diagnostico.item.Marcapaciente"
                            label="Marcar paciente"
                            v-model="Diagnostico.item.Marcapaciente"
                            attach
                            multiple
                            chips
                          ></v-select>
                        </div>
                      </td>
                    </tr>
                  </template>
                  <v-alert
                    v-slot:no-results
                    :value="true"
                    color="error"
                    icon="warning"
                  >Your search for "{{ search }}" found no results.</v-alert>
                  <template slot="expand" slot-scope="Diagnostico">
                    <v-card flat>
                      <v-card-text>
                        <pre>{{Diagnostico}}</pre>
                      </v-card-text>
                      <div class="datatable-container">
                        <v-card-text>
                          <pre>{{Diagnostico}}</pre>
                        </v-card-text>
                      </div>
                    </v-card>
                  </template>
                </v-data-table>
              </v-card>
            </v-tab-item>
          </v-tabs>
        </v-card>
        <v-card>
          <v-layout row wrap>
            <v-flex xs6 md3 lg3>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="cerrarModal()">Cerrar</v-btn>
              </v-card-actions>
            </v-flex>
            <v-flex xs6 md3 lg3>
              <v-tooltip top>
                <template v-slot:activator="{ on }">
                  <v-btn text icon color="blue" dark v-on="on">
                    <v-icon @click="printhc()">assignment_turned_in</v-icon>
                  </v-btn>
                </template>
                <span>Historial</span>
              </v-tooltip>
            </v-flex>
          </v-layout>
        </v-card>
      </v-dialog>
    </v-layout>
    <!-- <div id="app">
    <v-app id="inspire">-->
    <v-timeline>
      <v-timeline-item v-for="(historia, i) in historiapaciente" :key="i" small>
        <template v-slot:opposite>
          <span :class="`headline font-weight-bold`" v-text="historia.Datetimeingreso"></span>
        </template>
        <v-card :color="'green'" dark>
          <v-card-title class="title">{{historia.Nombre}}</v-card-title>
          <v-card-text class="white text--primary">
            <ul class="list-group list-group-horizontal">
              <li class="list-group-item">
                Cédula:
                <b>{{historia.Cédula}}</b>
              </li>
              <li class="list-group-item">
                Fecha Nacimiento:
                <b>{{historia.Fecha_Nacimiento}}</b>
              </li>
              <li class="list-group-item">
                Edad:
                <b>{{historia.Edad}}</b>
              </li>
              <li class="list-group-item">
                Sexo:
                <b>{{historia.Sexo}}</b>
              </li>
              <li class="list-group-item">
                Atendido por:
                <b>{{historia.Atendido_Por}}</b>
              </li>
            </ul>
            <v-btn :color="'green'" class="mx-0" outline @click="abrirModal(historia)">Ver más..</v-btn>
            <!-- <p v-show="showmore==i">Lorem ipsum dolor sit amet, no nam oblique veritus. Commune scaevola imperdiet nec
                                    ut, sed euismod convenire principes at. Est et nobis iisque percipit, an vim zril
            disputando voluptatibus, vix an salutandi sententiae.</p>-->
          </v-card-text>
        </v-card>
      </v-timeline-item>
    </v-timeline>
    <!-- </v-app>
    </div>-->
  </v-container>
</template>

<script>
export default {
  data: () => ({
    historiapaciente: [],
    historia: {},
    history: {},
    cedula_paciente: '',
    input: null,
    dialog: false,
    nonce: 0,
    pdf: {},
    diagnosticHeaders: [
      {
        text: "Marcar Principal",
        align: "center",
        value: "marcar"
      },
      {
        text: "Diagnóstico",
        align: "center",
        value: "diagnostico"
      },
      {
        text: "Tipo Diagnóstico",
        align: "center",
        value: "tipo_diagnostico"
      },
      {
        text: "Marca",
        align: "center",
        value: "marca"
      },
      {
        text: "",
        align: "center",
        value: ""
      }
    ],
    Diagnosticos: [
    ]
  }),
  created() {
    this.resumenhistoria();
  },

  methods: {
    resumenhistoria() {

      this.cedula_paciente = localStorage.getItem("PacienteCedula");

      axios
        .post("/api/historiapaciente/gethistoria", {
          Num_Doc: this.cedula_paciente
        })
        .then(res => {
          this.historiapaciente = res.data;
          console.log(this.historiapaciente);
        });
    },
    comment() {
      const time = new Date().toTimeString();
      this.events.push({
        id: this.nonce++,
        text: this.input,
        time: time.replace(
          /:\d{2}\sGMT-\d{4}\s\((.*)\)/,
          (match, contents, offset) => {
            return ` ${contents
              .split(" ")
              .map(v => v.charAt(0))
              .join("")}`;
          }
        )
      });
      this.input = null;
    },
    abrirModal(historia) {
      this.historia = historia;
      this.fillHistory();
      //   this.fillDiagnostic(autorizacion);
      this.dialog = true;
    },
    cerrarModal() {
      this.dialog = false;
      //   this.estadoElegido = "";
      this.observaciones = "";
    },
    fillHistory() {
      if (this.historia.id) {
        this.history = this.getHistoryObj(this.historia);
      }
    },
    getHistoryObj(historia) {
      console.log("historia in get", historia);
      return (this.object = {
        nombre: historia.Nombre,
        edad: historia.Edad,
        sexo: historia.Sexo,
        antropometricas: historia.Antropometricas,
        atendido_por: historia.Atendido_Por,
        cardiovascular: historia.Cardiovascular,
        celular: historia.Celular,
        condiciongeneral: historia.Condiciongeneral,
        cedula: historia.Cédula,
        datetimeingreso: historia.Datetimeingreso,
        datetimesalida: historia.Datetimesalida,
        departamento: historia.Departamento,
        destinopaciente: historia.Destinopaciente,
        diagnosticoprincipal: historia.Diagnostico_Principal,
        direccionresidencia: historia.Direccion_Residencia,
        endocrinologico: historia.Endocrinologico,
        enfermedadactual: historia.Enfermedadactual,
        entidademite: historia.Entidademite,
        fechanacimiento: historia.Fecha_Nacimiento,
        fechasolicita: historia.Fecha_solicita,
        finalidad: historia.Finalidad,
        gastrointestinal: historia.Gastrointestinal,
        genitourinario: historia.Genitourinario,
        laboraen: historia.Laboraen,
        linfatico: historia.Linfatico,
        medicoordeno: historia.Medicoordeno,
        motivoconsulta: historia.Motivoconsulta,
        municipioafiliado: historia.Municipio_Afiliado,
        neurologico: historia.Neurologico,
        norefiere: historia.Norefiere,
        observaciones: historia.Observaciones,
        oftalmologico: historia.Oftalmologico,
        osteomioarticular: historia.Osteomioarticular,
        osteomuscular: historia.Osteomuscular,
        otorrinoralingologico: historia.Otorrinoralingologico,
        otrossignosvitales: historia.Otros_Signos_Vitales,
        otrossignosvitales: historia.Otros_Signos_Vitales,
        planmanejo: historia.Planmanejo,
        presionarterial: historia.Presión_Arterial,
        recomendaciones: historia.Recomendaciones,
        respiratorio: historia.Respiratorio,
        resultayudadiagnostica: historia.Resultayudadiagnostica,
        signosvitales: historia.Signos_Vitales,
        tegumentario: historia.Tegumentario,
        telefono: historia.Telefono,
        timeconsulta: historia.Timeconsulta,
        tipoafiliado: historia.Tipo_Afiliado,
        tipoorden: historia.Tipo_Orden,
        tipodiagnostico: historia.Tipodiagnostico,
        antecedentes: historia.Antecedentes,
        abdomen: historia.Abdomen,
        agudezavisual: historia.Agudezavisual,
        cabezacuello: historia.Cabezacuello,
        cardiopulmonar: historia.Cardiopulmonar,
        examenmama: historia.Examenmama,
        examenmental: historia.Examenmental,
        extremidades: historia.Extremidades,
        frecucardiaca: historia.Frecucardiaca,
        frecurespiratoria: historia.Frecurespiratoria,
        genitourinario: historia.Genitourinario,
        neurologico: historia.Neurologico,
        ojosfondojos: historia.Ojosfondojos,
        osteomuscular: historia.Osteomuscular,
        pielfraneras: historia.Pielfraneras,
        reflejososteotendinos: historia.Reflejososteotendinos,
        tactoretal: historia.Tactoretal,
        dietasaludable: historia.Dietasaludable,
        suenoreparador: historia.Suenoreparador,
        duermemenoseishoras: historia.Duermemenoseishoras,
        altonivelestres: historia.Altonivelestres,
        actividadfisica: historia.Actividadfisica,
        frecuenciasemana: historia.Frecuenciasemana,
        duracion: historia.Duracion,
        fumacantidad: historia.Fumacantidad,
        fumainicio: historia.Fumainicio,
        fumadorpasivo: historia.Fumadorpasivo,
        cantidadlicor: historia.Cantidadlicor,
        licorfrecuencia: historia.Licorfrecuencia,
        consumopsicoactivo: historia.Consumopsicoactivo,
        psicoactivocantidad: historia.Psicoactivocantidad,
        estilovidaobservaciones: historia.Estilovidaobservaciones,
        cedulamedico: historia.Cedulamedico,
        registromedico: historia.Registromedico,
        firma: historia.Firma,
        especialidad: historia.Especialidad,
        id: historia.id
      });
    },
    fillDiagnostic(autorizacion) {
      axios
        .get("/api/cie10/diagnostico/" + autorizacion.citaPaciente_id)
        .then(res => {
          this.Diagnostico = res.data;
          console.log("Diagnostico", this.Diagnostico);
        });
    },
    printhc() {
      if (this.historia) {
        let pdf = this.getPDFHistorial();
        pdf.type = "test";
        console.log("pdf", this.pdf);
        axios
          .post("/api/pdf/print-pdf", pdf, {
            responseType: "arraybuffer"
          })
          .then(res => {
            let blob = new Blob([res.data], {
              type: "application/pdf"
            });
            let link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
           window.open(link.href,"_blank");
          });
      }
    },
    getPDFHistorial() {
      return (this.pdf = {
        type: "test",
        FechaInicio: this.historia.Fecha_solicita,
        Nombre: this.historia.Nombre,
        Edad_Cumplida: this.historia.Edad,
        Sexo: this.historia.Sexo,
        Antropometricas: this.historia.Antropometricas,
        Atendido_Por: this.historia.Atendido_Por,
        Cardiovascular: this.historia.Cardiovascular,
        telefono: this.historia.Celular,
        Condiciongeneral: this.historia.Condiciongeneral,
        Cédula: this.historia.Cédula,
        Datetimeingreso: this.historia.Datetimeingreso,
        Datetimesalida: this.historia.Datetimesalida,
        Departamento: this.historia.Departamento,
        Destinopaciente: this.historia.Destinopaciente,
        Diagnostico_Principal: this.historia.Diagnostico_Principal,
        Diagnostico_Secundario: this.historia.Diagnostico_Secundario,
        Antecedentes: this.historia.Antecedentes,
        Direccion_Residencia: this.historia.Direccion_Residencia,
        Edad: this.historia.Edad,
        Endocrinologico: this.historia.Endocrinologico,
        Enfermedadactual: this.historia.Enfermedadactual,
        Entidademite: this.historia.Entidademite,
        Fecha_Nacimiento: this.historia.Fecha_Nacimiento,
        Fecha_solicita: this.historia.Fecha_solicita,
        Finalidad: this.historia.Finalidad,
        Gastrointestinal: this.historia.Gastrointestinal,
        Genitourinario: this.historia.Genitourinario,
        Laboraen: this.historia.Laboraen,
        Linfatico: this.historia.Linfatico,
        Medicoordeno: this.historia.Medicoordeno,
        Motivoconsulta: this.historia.Motivoconsulta,
        Municipio_Afiliado: this.historia.Municipio_Afiliado,
        Neurologico: this.historia.Neurologico,
        Nombre: this.historia.Nombre,
        Norefiere: this.historia.Norefiere,
        Observaciones: this.historia.Observaciones,
        Oftalmologico: this.historia.Oftalmologico,
        Osteomioarticular: this.historia.Osteomioarticular,
        Osteomuscular: this.historia.Osteomuscular,
        Otorrinoralingologico: this.historia.Otorrinoralingologico,
        Otros_Signos_Vitales: this.historia.Otros_Signos_Vitales,
        Planmanejo: this.historia.Planmanejo,
        Presión_Arterial: this.historia.Presión_Arterial,
        Recomendaciones: this.historia.Recomendaciones,
        Respiratorio: this.historia.Respiratorio,
        Resultayudadiagnostica: this.historia.Resultayudadiagnostica,
        Sexo: this.historia.Sexo,
        Signos_Vitales: this.historia.Signos_Vitales,
        Tegumentario: this.historia.Tegumentario,
        Telefono: this.historia.Telefono,
        Timeconsulta: this.historia.Timeconsulta,
        tipo_afiliado: this.historia.Tipo_Afiliado,
        Tipo_Orden: this.historia.Tipo_Orden,
        Tipodiagnostico: this.historia.Tipodiagnostico,
        Abdomen: this.historia.Abdomen,
        Agudezavisual: this.historia.Agudezavisual,
        Cabezacuello: this.historia.Cabezacuello,
        Cardiopulmonar: this.historia.Cardiopulmonar,
        Examenmama: this.historia.Examenmama,
        Examenmental: this.historia.Examenmental,
        Extremidades: this.historia.Extremidades,
        Frecucardiaca: this.historia.Frecucardiaca,
        Frecurespiratoria: this.historia.Frecurespiratoria,
        Genitourinario: this.historia.Genitourinario,
        Pulsosperifericos: this.historia.Pulsosperifericos,
        Ojosfondojos: this.historia.Ojosfondojos,
        Osteomuscular: this.historia.Osteomuscular,
        Pielfraneras: this.historia.Pielfraneras,
        Reflejososteotendinos: this.historia.Reflejososteotendinos,
        Tactoretal: this.historia.Tactoretal,
        Dietasaludable: this.historia.Dietasaludable,
        Suenoreparador: this.historia.Suenoreparador,
        Duermemenoseishoras: this.historia.Duermemenoseishoras,
        Altonivelestres: this.historia.Altonivelestres,
        Actividadfisica: this.historia.Actividadfisica,
        Frecuenciasemana: this.historia.Frecuenciasemana,
        Duracion: this.historia.Duracion,
        Fumacantidad: this.historia.Fumacantidad,
        Fumainicio: this.historia.Fumainicio,
        Fumadorpasivo: this.historia.Fumadorpasivo,
        Cantidadlicor: this.historia.Cantidadlicor,
        Licorfrecuencia: this.historia.Licorfrecuencia,
        Consumopsicoactivo: this.historia.Consumopsicoactivo,
        Psicoactivocantidad: this.historia.Psicoactivocantidad,
        Estilovidaobservaciones: this.historia.Estilovidaobservaciones,
        Cedulamedico: this.historia.Cedulamedico,
        Registromedico: this.historia.Registromedico,
        Firma: this.historia.Firma,
        Especialidad: this.historia.Especialidad,
        id: this.historia.id
      });
    }
  }
};
</script>

<style lang="scss" scoped>
</style>