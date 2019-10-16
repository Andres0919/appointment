<template>
  <v-layout row wrap>
        <v-flex xs12>
            <v-stepper v-model="e6" vertical>
                <v-stepper-step :complete="e6 > 1" editable :edit-icon="$vuetify.icons.complete" step="1">
                    IMAGENOLOGÍA
                </v-stepper-step>

                <v-stepper-content step="1">
                    <v-card color="lighten-1" class="mb-5" height="auto">
                        <v-container grid-list-xs>
                            <v-textarea
                                name="input-7-1"
                                label="Indicacion"
                                value=""
                                v-model="data.Indicacion"
                            ></v-textarea>
                            <v-textarea
                                name="input-7-1"
                                label="Hallazgos"
                                value=""
                                v-model="data.Hallazgos"
                            ></v-textarea>
                            <v-textarea
                                name="input-7-1"
                                label="Conclusión"
                                value=""
                                v-model="data.Conclusion"
                            ></v-textarea>
                            <!-- <input
                            type="file"
                            id="file"
                            ref="myFiles"
                            class="custom-file-input"
                            multiple
                            v-on:change="onFilePicked"/> -->
                        </v-container>
                    </v-card>
                    <v-btn color="primary" round @click="submit()">Guardar y seguir</v-btn>
                </v-stepper-content>
            </v-stepper>
        </v-flex>
  </v-layout>
</template>
<script>
    import {EventBus} from '../../../event-bus.js';

    export default {
        created() {
            this.removeLocalStorage();
            this.getRoute();
            this.getLocalStorage();
        },
        data() {
            return {
                e6: 1,
                citaPaciente: '',
                data: {
                    Indicacion: '',
                    Hallazgos: '',
                    Conclusion: ''
                }
            }
        },

        mounted() {

        },

        methods: {
            fetchImagnenologia() {
                axios.get('/api/imagenologia/'+this.citaPaciente+'/imagenologia')
                    .then(res => {
                        this.data = res.data;
                    });
            },
            // onFilePicked() {
            //     this.files = this.$refs.myFiles.files;

            //     console.log("files", this.files);
            // },
            async submit() {
                if (!this.data.Hallazgos) {
                    swal({
                        title: "Debe asignar un hallazgo",
                        icon: "warning"
                    });
                    return;
                }

                if (!this.data.Conclusion) {
                    swal({
                        title: "Debe asignar un conclusión",
                        icon: "warning"
                    });
                    return;
                }

                axios.post(`/api/imagenologia/create/${this.citaPaciente}`, this.data)
                    .then(res => {
                        localStorage.setItem("Imagenologia", JSON.stringify(this.data));
                        swal({
                            title: "¡Historia Almacenada con Exito!",
                            text: `${res.data.message}`,
                            timer: 2000,
                            icon: "success",
                            buttons: false
                        });
                    });

            },
            getRoute() {
                this.citaPaciente = this.$route.query.cita_paciente;
            },
            getLocalStorage() {
                let imagenologia = JSON.parse(localStorage.getItem("Imagenologia"));
                if (imagenologia) {
                    this.data = imagenologia;
                } else {
                    this.fetchImagnenologia();
                }
            },
            removeLocalStorage() {
                localStorage.removeItem("Imagenologia");
            }
        }
    }
</script>
<style scoped>

</style>
