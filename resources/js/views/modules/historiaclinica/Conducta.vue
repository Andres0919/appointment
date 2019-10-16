<template>
  <v-layout row wrap>
	<v-flex xs12>
	  <v-stepper v-model="e6" vertical>
		<v-stepper-step
		  :complete="e6 > 1"
		  editable
		  :edit-icon="$vuetify.icons.complete"
		  step="1"
		>FINAL</v-stepper-step>

		<v-stepper-content step="1">
		  <v-card color="lighten-1" class="mb-5" height="auto">
			<v-container grid-list-xs>
			  <v-textarea name="input-7-1" label="Plan de manejo" v-model="data.Planmanejo" value></v-textarea>
			  <v-textarea
				name="input-7-1"
				label="Recomendaciones"
				auto-grow
				v-model="data.Recomendaciones"
				value
			  ></v-textarea>
			  <v-layout row wrap>
				<v-flex xs12 sm6>
				  <v-autocomplete
					:items="[
									'RIA Primera Infancia','RIA Infancia','RIA Adolescencia','RIA Juventud', 'RIA Adulto',
									'RIA Adulto Mayor','RIA Materno Perinatal', 'Control', 'Interconsulta', 'Domiciliaria', 
									'Urgencias', 'Hospitalización'
								]"
					label="Destino del paciente"
					append-icon="search"
					v-model="data.Destinopaciente"
				  ></v-autocomplete>
				</v-flex>
				<v-flex xs12 sm6>
				  <v-autocomplete
					:items="[
									'Atención del parto, del embarazo y posparto', 'Atención del recién nacido', 
									'Atención planificación familiar', 'Atención crecimiento y desarrollo', 
									'Atención joven Sano', 'Detención alteraciones del embarazo',
									'Detención alteraciones del adulto', 'Detención alteraciones agudeza Visual',
									'Enfermedad Profesional', 'No aplica'
								]"
					label="Finalidad"
					append-icon="search"
					v-model="data.Finalidad"
				  ></v-autocomplete>
				</v-flex>
			  </v-layout>
			</v-container>
		  </v-card>
		  <v-btn color="primary" @click="guardarConducta()">Guardar y terminar</v-btn>|
		  <!-- <v-btn color="dark" round @click="printRecomendation()">Descargar recomendaciones</v-btn> -->
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
	// this.getLocalStorage();
  },
  data() {
	return {
	  e6: 1,
	  Diagnostico: '',
	  data: {
		Planmanejo: "",
		Recomendaciones: "",
		Destinopaciente: "",
		Finalidad: ""
	  },
	  citaPaciente: 0,
	  paciente: {}
	};
  },
  mounted() {
	this.getLocalStorage();
  },
  methods: {
	guardarConducta() {
	  if (this.data.Planmanejo.length < 5) {
		swal("Plan de manejo debe ser minimo de 5 caracteres");
		return;
	  }

	  if (this.data.Recomendaciones.length < 5) {
		swal("Recomendaciones de consulta debe ser minimo de 5 caracteres");
		return;
	  }

	  if (this.Diagnostico == '') {
		swal({
		  title: "Conducta",
		  text:
			"Por favor ingrese un diagnostico principal!",
		  timer: 2000,
		  icon: "error",
		  buttons: false
		});
		return;
	  }

	  // if (this.data.Destinopaciente.length < 2) {
	  //     swal("Destino del paciente debe ser minimo de 2 caracteres")
	  //     return;
	  // }
	  axios
		.post("/api/conducta/" + this.citaPaciente + "/final", this.data)
		.then(res => {
		  this.e6 = 3;

		  localStorage.setItem("Conducta", JSON.stringify(this.data));

		  swal({
			title: res.data.message,
			text: " ",
			timer: 2000,
			icon: "success",
			buttons: false
		  });
		  // this.$router.push('/historiaclinica/gineco?cita_paciente='+this.citaPaciente);
		  EventBus.$emit("change_disabled_list_history", "CONDUCTA");
		  EventBus.$emit("send-recommendation", this.data);
		  EventBus.$emit("call-order");
		});
	},
	printRecomendation() {
	  if (!this.data.Recomendaciones) {
		swal({
		  title: "Impresión observaciones",
		  text: "Se requiere una recomendación.",
		  icon: "error"
		});
	  } else {
		axios
		  .get(`/api/paciente/getPacienteWithCita/${this.citaPaciente}`)
		  .then(res => {
			this.paciente = res.data;

			if (this.paciente.id) {
			  var pdf = {};

			  pdf = this.getPDFRecomendation();

			  axios
				.post("/api/pdf/print-pdf", pdf, {
				  responseType: "arraybuffer"
				})
				.then(res => {
				  let blob = new Blob([res.data], { type: "application/pdf" });
				  let link = document.createElement("a");
				  link.href = window.URL.createObjectURL(blob);
				  window.open(link.href, "_blank");
				});
			}
		  })
		  .catch(err => this.showError(err.response.data));
	  }
	},
	getPDFRecomendation() {
	  return (this.recomendacion = {
		Primer_Nom: this.paciente.Primer_Nom,
		Segundo_Nom: this.paciente.SegundoNom,
		Primer_Ape: this.paciente.Primer_Ape,
		Segundo_Ape: this.paciente.Segundo_Ape,
		Tipo_Doc: this.paciente.Tipo_Doc,
		Num_Doc: this.paciente.Num_Doc,
		Edad_Cumplida: this.paciente.Edad_Cumplida,
		Sexo: this.paciente.Sexo,
		IPS: this.paciente.NombreIPS,
		Direccion_Residencia: this.paciente.Direccion_Residencia,
		Correo: this.paciente.Correo,
		Telefono: this.paciente.Telefono,
		Tipo_Afiliado: this.paciente.Tipo_Afiliado,
		Estado_Afiliado: this.paciente.Estado_Afiliado,
		orden_id: this.order_id,
		type: "observacion",
		observaciones: this.data.Recomendaciones,
		cita_paciente_id: this.citaPaciente
	  });
	},
	getLocalStorage() {
	  let conducta = JSON.parse(localStorage.getItem("Conducta"));
	  let Diagnostico = JSON.parse(localStorage.getItem("Diagnostico"));
	  if (Diagnostico) {
		this.Diagnostico = Diagnostico;
	  }
	  if (conducta) {
		this.data = conducta;
	  } else {
		this.fetchConducta();
	  }
	},
	fetchConducta() {
	  let conducta = { cita_paciente_id: this.citaPaciente };

	  axios
		.post(`/api/conducta/getConductaByCita`, conducta)
		.then(res => {
		  if (res.data.Citapaciente_id) {
			this.data = res.data;
		  }
		})
		.catch(err => console.log(err.response));
	},
  }
};
</script>
