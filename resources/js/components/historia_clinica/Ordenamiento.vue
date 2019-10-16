<template>
    <v-container style="max-width: 12000px;">
        <v-flex xs12 pb-3>
            <v-card>
                <v-container grid-list-xs>
                    <v-layout row wrap justify-space-between>
                        <span>
                            <b>Nombre completo paciente:</b>
                            {{ ` ${(paciente.Primer_Nom)? `${ paciente.Primer_Nom.charAt(0).toUpperCase() }${ paciente.Primer_Nom.slice(1)}` : ''} ${(paciente.SegundoNom)? `${paciente.SegundoNom.charAt(0).toUpperCase()}${paciente.SegundoNom.slice(1)}`: ''} ${(paciente.Primer_Ape)? `${paciente.Primer_Ape.charAt(0).toUpperCase()}${paciente.Primer_Ape.slice(1) }`: ''} ${(paciente.Segundo_Ape)?`${paciente.Segundo_Ape.charAt(0).toUpperCase()}${paciente.Segundo_Ape.slice(1)}` : ''} `}}
                        </span>
                        <span>
                            <b>Tipo y número de documento:</b>
                            {{ paciente.Tipo_Doc.toUpperCase()+' '+paciente.Num_Doc }}
                        </span>
                        <span>
                            <b>Edad:</b>
                            {{ paciente.Edad_Cumplida }}
                        </span>
                    </v-layout>
                </v-container>
            </v-card>
        </v-flex>
        <v-card>
            <v-container grid-list-xs>
                <v-layout row wrap>
                    <v-flex xs3>
                        <v-autocomplete label="Tipo ordenamiento" :items="tipoOrdenamiento" item-value="id"
                            item-text="Nombre" v-model="data.Tiporden_id" @input="tipoOrdenSelected()"></v-autocomplete>
                    </v-flex>
                    <template v-if="data.Tiporden_id == 1">
                        <v-flex xs12>
                            <v-card>
                                <v-card-text>
                                    <v-container grid-list-md>
                                        <v-layout row wrap>
											<v-flex xs3>
                                                <v-select v-model="incapacidad.Contingencia" :items="[
													'Enf. Comun ', 
													'licencia maternidad', 
													'Accidente de trabajo', 
													'Enf. Profesional', 
													'Licencia Paternidad', 
													'Accidente (Soat)'
												]" label="Contingencia" required></v-select>
                                            </v-flex>
                                            <v-flex xs3>
												<v-menu v-if="!path.includes('historiaclinica')" ref="show_start_date" :close-on-content-click="false" v-model="show_start_date" :nudge-right="40"
													:return-value.sync="incapacidad.FechaInicio" lazy transition="scale-transition" offset-y full-width min-width="290px"
													max-width="290px">
													<template v-slot:activator="{ on }">
														<v-text-field v-model="incapacidad.FechaInicio" label="Fecha Inicial" prepend-icon="event" readonly v-on="on">
														</v-text-field>
													</template>
													<v-date-picker color="primary" locale="es" @input="getFinalDate()" v-model="incapacidad.FechaInicio" full-width
														@click="$refs.show_start_date.save(incapacidad.FechaInicio)">
														<v-spacer></v-spacer>
														<v-btn flat color="primary" @click="show_start_date = false">Cancelar</v-btn>
														<v-btn flat color="primary" @click="$refs.show_start_date.save(incapacidad.FechaInicio)">OK</v-btn>
													</v-date-picker>
												</v-menu>
                                                <v-text-field v-else label="Fecha Inicio" readonly :type="'label'"
                                                    @input="getFinalDate()" v-model="incapacidad.FechaInicio" required></v-text-field>
                                            </v-flex>
                                            <v-flex xs1>
                                                <v-text-field :type="'number'" label="Cantidad días"
                                                    @input="getFinalDate()" v-model="incapacidad.CantidadDias" required>
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs3>
                                                <v-text-field label="Fecha Final" readonly :type="'label'"
                                                    v-model="incapacidad.FechaFinal" required></v-text-field>
                                            </v-flex>
                                            <v-flex xs2>
                                                <v-select v-model="incapacidad.Prorroga" :items="['Sí','No']"
                                                    label="Prorrogo" required></v-select>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap>
                                            <v-flex xs12 lg12>
                                                <v-autocomplete label="Labora en:" :items="colegios"
                                                    item-value="NomColegio" item-text="NomColegio"
                                                    v-model="incapacidad.Colegio" :loading="loading"
                                                    :search-input.sync="search" required>
                                                    ></v-autocomplete>
                                            </v-flex>
                                            <v-flex xs12 lg12>
                                                <v-textarea name="input-7-1" label="Descripción de incapacidad" value
                                                    v-model="incapacidad.Descripcion" required></v-textarea>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card-text>
                                <v-card-actions>
                                    <v-btn color="primary" round @click="generateInc()">Generar</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-flex>
                    </template>
                    <template v-if="data.Tiporden_id == 3">
                        <v-flex xs12>
                            <v-layout row wrap>
                                <v-flex xs9>
                                    <v-autocomplete label="Medicamento" :items="filteredMedicamentos" item-text="Nombre"
                                        v-model="articulos.medicamento" return-object></v-autocomplete>
                                </v-flex>
                                <v-flex xs3>
                                    <v-autocomplete label="Unidad presentación" :items="optionsUnidadPresentacion"
                                        v-model="articulos.Unidadmedida"></v-autocomplete>
                                </v-flex>
                                <v-flex xs1>
                                    <v-text-field v-model="articulos.Cantidadosis" label="Cantidad"></v-text-field>
                                </v-flex>
                                <v-flex xs2>
                                    <v-autocomplete :items="optionsVia" v-model="articulos.Via" label="Via">
                                    </v-autocomplete>
                                </v-flex>
                                <v-flex xs2>
                                    <v-select v-model="articulos.Unidadtiempo" :items="['Dosis Única','Horas']"
                                        label="Unidad tiempo"></v-select>
                                </v-flex>
                                <template v-if="articulos.Unidadtiempo == 'Horas'">
                                    <v-flex xs1>
                                        <v-text-field v-model="articulos.Frecuencia" label="Frecuencia"></v-text-field>
                                    </v-flex>
                                    <v-flex xs2>
                                        <v-text-field v-model="articulos.Duracion" label="Duración (dias al mes)">
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs2>
                                        <v-select v-model="articulos.NumMeses" label="Número meses" :items="meses"
                                            item-text="accion" item-value="value" hide-details></v-select>
                                        <!-- <v-text-field v-model="articulos.NumMeses" label="Número meses"></v-text-field> -->
                                    </v-flex>
                                </template>
                                <v-flex xs1>
                                    <v-text-field type="number" v-model="cantidadMensual" label="Cantidad mensual"
                                        readonly></v-text-field>
                                </v-flex>
                                <v-flex xs2>
                                    <v-text-field type="number" v-model="articulos.Cantidadpormedico"
                                        label="Cantidad mensual médico"></v-text-field>
                                </v-flex>
                                <v-flex xs4>
                                    <v-text-field v-model="articulos.Observacion" label="Observación"></v-text-field>
                                </v-flex>
                            </v-layout>
                            <v-btn color="success" round @click="addArticulo()">Agregar</v-btn>
                            <v-btn color="warning" round>Borrar campos</v-btn>
                        </v-flex>
                    </template>
                    <template v-if="data.Tiporden_id == 2 || data.Tiporden_id == 4">
                        <v-flex xs12>
                            <v-layout row wrap>
                                <v-flex xs11>
                                    <v-autocomplete label="Procedimiento" :items="filteredProcedimientos"
                                        item-text="full_name" v-model="procedimiento.cup" return-object>
                                    </v-autocomplete>
                                </v-flex>
                                <v-flex xs1>
                                    <v-text-field label="cantidad" v-model="procedimiento.cantidad"></v-text-field>
                                </v-flex>
                                <v-flex xs4>
                                    <v-text-field v-model="procedimiento.observacion" label="Observación">
                                    </v-text-field>
                                </v-flex>
                            </v-layout>
                            <v-btn color="success" round @click="addProcedimiento()">agregar</v-btn>
                        </v-flex>
                    </template>
                </v-layout>
                <v-layout v-show="data.Tiporden_id != 1" row wrap>
                    <v-flex xs12>
                        <v-data-table v-show="data.Tiporden_id == 3" :headers="headers" :items="data.articulos"
                            hide-actions class="elevation-1" pagination.sync="pagination" item-key="id" loading="true">
                            <template v-slot:items="props">
                                <td class="text-xs-center">{{ props.item.nombre }}</td>
                                <td class="text-xs-center">{{ props.item | PosViaAdmin }}</td>
                                <!--{{ props.item.Cantidadosis }} {{ (props.item.Unidadtiempo == 'Horas')? `${props.item.Unidadmedida} cada ${props.item.Frecuencia} Horas ${props.item.Duracion} dias por ${props.item.NumMeses} meses` : 'Dosis Única' }}-->
                                <td class="text-xs-center">{{ props.item.Cantidadpormedico }}</td>
                                <td class="text-xs-center">{{ props.item.Observacion }}</td>
                                <td class="text-xs-center">{{ props.item.Requiere_autorizacion }}</td>
                                <td class="text-xs-center">
                                    <v-btn color="error" @click="removeArticulo(props)" icon>
                                        <v-icon>clear</v-icon>
                                    </v-btn>
                                </td>
                            </template>
                            <v-alert v-slot:no-data :value="true" color="error" icon="warning">No hay datos.</v-alert>
                        </v-data-table>
                        <v-data-table v-show="data.Tiporden_id != 3" :headers="headersProcedimientos"
                            :items="data.procedimientos" hide-actions class="elevation-1" pagination.sync="pagination"
                            item-key="id" loading="true">
                            <template v-slot:items="props">
                                <td class="text-xs-center">{{ props.item.codigo }}</td>
                                <td class="text-xs-center">{{ props.item.nombre }}</td>
                                <td class="text-xs-center">{{ props.item.auditoria }}</td>
                                <td class="text-xs-center">{{ props.item.cantidad }}</td>
                                <td class="text-xs-center">{{ props.item.observacion }}</td>
                                <td class="text-xs-center">
                                    <v-btn color="error" @click="removeProcedimiento(props)" icon>
                                        <v-icon>clear</v-icon>
                                    </v-btn>
                                </td>
                            </template>
                            <v-alert v-slot:no-data :value="true" color="error" icon="warning">No hay datos.</v-alert>
                        </v-data-table>
                    </v-flex>
                    <v-layout row wrap>
                        <v-spacer></v-spacer>
                        <v-btn color="dark" round
                            v-show="(path == '/transcripcion' || path.includes('historiaclinica'))"
                            @click="generateOrder()">Ordenar</v-btn>
                    </v-layout>
                </v-layout>
            </v-container>
        </v-card>
        <v-flex pt-2>
            <v-card>
                <v-container grid-list-xs>
                    <v-layout row wrap>
                        <v-flex xs12>
                            <v-data-table v-show="data.Tiporden_id == 1" :headers="headersIncapacidadesOrdered"
                                :items="incapacidadOrdered" hide-actions class="elevation-1"
                                pagination.sync="pagination" item-key="id" loading="true">
                                <template v-slot:items="props">
                                    <td class="text-xs-center">{{ props.item.Fechainicio }}</td>
                                    <td class="text-xs-center">{{ props.item.Dias }}</td>
                                    <!--{{ props.item.Cantidadosis }} {{ (props.item.Unidadtiempo == 'Horas')? `${props.item.Unidadmedida} cada ${props.item.Frecuencia} Horas ${props.item.Duracion} dias por ${props.item.NumMeses} meses` : 'Dosis Única' }}-->
                                    <td class="text-xs-center">{{ props.item.Fechafinal }}</td>
                                    <td class="text-xs-center">{{ props.item.Prorroga }}</td>
                                    <td class="text-xs-center">{{ props.item.Contingencia }}</td>
                                    <!-- <td class="text-xs-center">
										<v-btn color="error" @click="removeArticulo(props)" icon>
											<v-icon>clear</v-icon>
										</v-btn>
				  </td>-->
                                </template>
                                <v-alert v-slot:no-data :value="true" color="error" icon="warning">No hay datos.
                                </v-alert>
                            </v-data-table>
                            <v-data-table v-show="data.Tiporden_id == 3" :headers="headersArticulosOrdered"
                                :items="articulosOrdered" hide-actions class="elevation-1" pagination.sync="pagination"
                                item-key="id" loading="true">
                                <template v-slot:items="props">
                                    <td class="text-xs-center">{{ props.item.nombre }}</td>
                                    <td class="text-xs-center">{{ props.item | PosViaAdmin }}</td>
                                    <!--{{ props.item.Cantidadosis }} {{ (props.item.Unidadtiempo == 'Horas')? `${props.item.Unidadmedida} cada ${props.item.Frecuencia} Horas ${props.item.Duracion} dias por ${props.item.NumMeses} meses` : 'Dosis Única' }}-->
                                    <td class="text-xs-center">{{ props.item.Cantidadpormedico }}</td>
                                    <td class="text-xs-center">{{ props.item.Observacion }}</td>
                                    <td class="text-xs-center">{{ props.item.estado }}</td>
                                    <!-- <td class="text-xs-center">
										<v-btn color="error" @click="removeArticulo(props)" icon>
											<v-icon>clear</v-icon>
										</v-btn>
				  </td>-->
                                </template>
                                <v-alert v-slot:no-data :value="true" color="error" icon="warning">No hay datos.
                                </v-alert>
                            </v-data-table>
                            <v-data-table v-show="data.Tiporden_id == 2 || data.Tiporden_id == 4"
                                :headers="headersProcedimientosOrdered" :items="cupsOrdered" hide-actions
                                class="elevation-1" pagination.sync="pagination" item-key="id" loading="true">
                                <template v-slot:items="props">
                                    <td class="text-xs-center">{{ props.item.codigo }}</td>
                                    <td class="text-xs-center">{{ props.item.nombre }}</td>
                                    <td class="text-xs-center">{{ props.item.ubicacion || 'No tiene' }}</td>
                                    <td class="text-xs-center">{{ props.item.observacion }}</td>
                                    <td class="text-xs-center">{{ props.item.estado }}</td>
                                </template>
                                <v-alert v-slot:no-data :value="true" color="error" icon="warning">No hay datos.
                                </v-alert>
                            </v-data-table>
                        </v-flex>
                        <v-layout row wrap>
                            <v-spacer></v-spacer>
                            <v-btn color="dark" round
                                v-show="(path == '/transcripcion' || path.includes('historiaclinica'))"
                                @click="printPDF()">Imprimir</v-btn>
                        </v-layout>
                    </v-layout>
                </v-container>
            </v-card>
        </v-flex>
    </v-container>
</template>

<script>
    import {
        EventBus
    } from "../../event-bus.js";
    import moment from "moment";
    import swal from "sweetalert";

    export default {
        props: {
            paciente: {
                type: Object,
                default: null
            }
        },
        data: () => ({
            medicamentos: [],
            medicamentosByYes: [],
            medicamentosByNo: [],
            tipoOrdenamiento: [],
            colegios: [],
            servicios: [],
            serviciosByYes: [],
            serviciosByNo: [],
            ubicaciones: [],
            cie10s: [],
            object: {},
            incap: {},
            recomendacion: {},
            cups: [],
            cupsOrdered: [],
            articulosOrdered: [],
            incapacidadOrdered: [],
            cita_paciente: null,
            yearago: null,
            loading: false,
			enable: true,
			show_start_date: false,
            recomendation: "",
            path: "",
            search: '',
            order_id: "",
            PosViaAdmin: "",
            optionsVia: [
                "ORAL",
                "SUBLINGUAL",
                "NASAL",
                "BUCAL",
                "VAGINAL",
                "RECTAL",
                "TÓPICO",
                "OFTÁLMICO",
                "ÓTICO",
                "INTRAVENOSO",
                "INTRAMUSCULAR",
                "SUBCUTÁNEA",
                "INTRADÉRMICA",
                "ENJUAGUES",
                "INTRATECTAL",
                "ENTERAL",
                "TRANSDÉRMICA",
                "NO APLICA",
            ],
            optionsUnidadPresentacion: [
                "ml",
                "UNIDAD",
                "UNIDAD INTERNACIONAL",
                "TABLETA",
                "CAPSULA",
                "COMPRIMIDO",
                "APLICACIONES",
                "SOBRES",
                "INHALACIONES",
                "GOTAS"
            ],
            meses: [{
                    accion: "1",
                    value: "1"
                },
                {
                    accion: "2",
                    value: "2"
                },
                {
                    accion: "3",
                    value: "3"
                }
            ],
            headersIncapacidadesOrdered: [{
                    text: "Fecha inicio",
                    align: "center",
                    value: "Fechainicio"
                },
                {
                    text: "Dias",
                    align: "center",
                    value: "Dias"
                },
                {
                    text: "Fecha final",
                    align: "center",
                    value: "Fechafinal"
                },
                {
                    text: "Prorroga",
                    align: "center",
                    value: "Prorroga"
                },
                {
                    text: "Contingencia",
                    align: "center",
                    value: "Contingencia"
                }
            ],
            headersProcedimientos: [{
                    text: "Código",
                    align: "center",
                    value: "codigo",
                    sortable: false
                },
                {
                    text: "Descripción",
                    align: "center",
                    value: "descripcion",
                    sortable: false
                },
                {
                    text: "Req. Auditoria",
                    align: "center",
                    value: "auditoria",
                    sortable: false
                },
                {
                    text: "Cantidad",
                    align: "center",
                    value: "cantidad",
                    sortable: false
                },
                {
                    text: "Observación",
                    align: "center",
                    value: "observacion",
                    sortable: false
                },
                {
                    text: "",
                    align: "center",
                    value: ""
                }
            ],
            headersProcedimientosOrdered: [{
                    text: "Código",
                    align: "center",
                    value: "codigo",
                    sortable: false
                },
                {
                    text: "Descripción",
                    align: "center",
                    value: "descripcion",
                    sortable: false
                },
                {
                    text: "Ubicación",
                    align: "center",
                    value: "ubicacion",
                    sortable: false
                },
                {
                    text: "Observación",
                    align: "center",
                    value: "Observacionorden",
                    sortable: false
                },
                {
                    text: "Estado actual",
                    align: "center",
                    value: "estado",
                    sortable: false
                }
            ],
            headersArticulosOrdered: [{
                    text: "Medicamento",
                    align: "center",
                    value: "nombre",
                    sortable: false
                },
                {
                    text: "Descripción",
                    align: "center",
                    value: "Cantidadosis",
                    sortable: false
                },
                {
                    text: "Cantidad mensual",
                    align: "center",
                    value: "Cantidadpormedico",
                    sortable: false
                },
                {
                    text: "Observación",
                    align: "center",
                    value: "Observacion",
                    sortable: false
                },
                {
                    text: "Estado",
                    align: "center",
                    value: "estado",
                    sortable: false
                },
                {
                    text: "",
                    align: "left",
                    value: ""
                }
            ],
            headers: [{
                    text: "Medicamento",
                    align: "center",
                    value: "nombre",
                    sortable: false
                },
                {
                    text: "Descripción",
                    align: "center",
                    value: "Cantidadosis",
                    sortable: false
                },
                {
                    text: "Cantidad mensual",
                    align: "center",
                    value: "Cantidadpormedico",
                    sortable: false
                },
                {
                    text: "Observación",
                    align: "center",
                    value: "Observacion",
                    sortable: false
                },
                {
                    text: "Requiere autorización",
                    align: "center",
                    value: "Requiere_autorizacion",
                    sortable: false

                },
                {
                    text: "",
                    align: "left",
                    value: ""
                }
            ],
            data: {
                Tiporden_id: null,
                articulos: [],
                procedimientos: []
            },
            articulos: {
                medicamento: {},
                Cantidadosis: "1",
                Unidadmedida: "",
                Frecuencia: "0",
                Via: "ORAL",
                Unidadtiempo: "Dosis Única",
                Duracion: "",
                Cantidadmensual: "",
                NumMeses: "1",
                Cantidadpormedico: "",
                Observacion: ""
            },
            procedimiento: {
                cup: {},
                cantidad: "",
                observacion: ""
            },
            incapacidad: {
                FechaInicio: null,
                CantidadDias: 0,
                FechaFinal: null,
                Prorroga: "",
                Cie10: "",
                TextCie10: "",
                Contingencia: "",
                Descripcion: "",
                Colegio: ""
            }
        }),
        filters: {
            PosViaAdmin: item => {
                if (item.Unidadtiempo == "Horas")
                    return `${item.Cantidadosis} ${item.Unidadmedida} ${item.Via} cada ${
		  item.Frecuencia
		} Horas X ${item.Duracion} dias por 
					${
					  item.NumMeses > 1
						? `${item.NumMeses} meses`
						: `${item.NumMeses} mes`
					}`;
                else
                    return `${item.Cantidadosis} ${item.Unidadmedida} ${item.Via} Única vez ${item.Cantidadpormedico}`;
            }
        },
        watch: {
            search: function () {
                if (this.search && this.search.length == 3) {
                    this.fetchColegios();
                }
            }
        },
        computed: {
            cantidadMensual() {
                if (this.articulos.Unidadtiempo == "Horas") {
                    this.articulos.Cantidadmensual = Math.round(
                        (24 / this.articulos.Frecuencia) *
                        this.articulos.Cantidadosis *
                        this.articulos.Duracion
                    );
                } else {
                    this.articulos.Cantidadmensual = this.articulos.Cantidadosis;
                }
                return this.articulos.Cantidadmensual || 0;
            },
            filteredMedicamentos() {
                let less = this.articulosOrdered.map(articulo => articulo.codesumi_id);
                less = less.concat(this.data.articulos.map(articulo => articulo.id));
                return this.medicamentos.filter(med => {
                    if (!less.find(l => l == med.id)) return med;
                });
            },
            filteredProcedimientos() {
                console.log("cupsOrdered", this.cupsOrdered);
                let less = this.cupsOrdered.map(proc => proc.cup_id);
                less = less.concat(this.data.procedimientos.map(proc => proc.id));
                return this.cups.filter(cup => {
                    if (!less.find(l => l == cup.id)) return cup;

                    return false
                }).map(cup => {
                    return {
                        ...cup,
                        full_name: `${cup.Codigo} - ${cup.Nombre}`
                    }
                });
            }

            // cieConcat() {
            //   return this.cie10s.map(cie => {
            // 	return {
            // 	  id: cie.id,
            // 	  nombre: `${cie.Codigo_CIE10} - ${cie.Descripcion}`,
            // 	  CIE10: cie.Codigo_CIE10
            // 	};
            //   });
            // }
        },
        created() {
            this.fetchTipoOrdenamiento();
            this.fetchCie10s();
            this.getLocalStorage();
        },
        methods: {
            generateOrder() {
                swal({
                    title: "¿Está Seguro(a)?",
                    text: "Se realizará la creación de la orden!",
                    type: "success",
                    icon: "info",
                    buttons: ["Cancelar", "Confirmar"],
                    dangerMode: true
                }).then(willDelete => {
                    if (willDelete) {
                        axios
                            .post(
                                `/api/orden/citapaciente/${this.cita_paciente}/create`,
                                this.data
                            )
                            .then(res => {

                                if (this.data.Tiporden_id == 3) {
                                    this.fetchMedicamentosOrdered();
                                } else {
                                    this.fetchCupsOrdered();
                                }

                                this.clearData();
                                if (res.data.ubicaciones.length > 0) {
                                    this.ubicaciones = res.data.ubicaciones;
                                }

                                swal("¡Orden creada de manera exitosa!", {
                                    timer: 2000,
                                    icon: "success",
                                    buttons: false
                                });

                            })
                            .catch(err => this.showError(err.response.data.message))
                    }
                });
            },
            fetchTipoOrdenamiento() {
                this.path = this.$route.path;
                if (this.path.includes('historiaclinica')) {
                    this.incapacidad.FechaInicio = moment().format("YYYY-MM-DD");
                }
                this.cita_paciente = this.$route.query.cita_paciente;
                axios.get("/api/tipoOrden/all").then(res => {
                    this.tipoOrdenamiento = res.data;
                });
            },
            async fetchCups() {
                await axios
                    .post("/api/cups/orden/" + this.cita_paciente, this.data)
                    .then(res => {
                        this.cups = res.data;
                    });
            },
            async fetchCupsInterconsultas() {
                await axios.get("/api/cups/interconsultas/" + this.cita_paciente).then(res => {
                    this.cups = res.data;
                });
            },
            async fetchMedicamentos() {
                await axios
                    .get("/api/codesumi/medicamentosumi/" + this.cita_paciente)
                    .then(res => {
                        console.log(res);
                        this.medicamentos = res.data;
                    });
            },
            fetchCie10s() {
                axios.get("/api/cie10/all").then(res => {
                    this.cie10s = res.data;
                });
            },
            async tipoOrdenSelected() {
                switch (this.data.Tiporden_id) {
                    case 1:
                        this.fetchIncOrdenred();
                        //this.fetchColegios();
                        break;
                    case 2:
                        this.fetchCupsInterconsultas();
                        this.fetchCupsOrdered();
                        break;
                    case 3:
                        await this.fetchMedicamentosOrdered();
                        this.fetchMedicamentos();
                        break;
                    case 4:
                        this.fetchCups();
                        this.fetchCupsOrdered();
                        break;

                    default:
                        break;
                }
            },
            async fetchMedicamentosOrdered() {
                await axios
                    .get(`/api/orden/getOrderedCodesumi/${this.cita_paciente}`)
                    .then(res => {
                        if (res.data.hasOwnProperty("id"))
                            this.articulosOrdered = res.data.detaarticulordens.map(art => art);
                        else this.articulosOrdered = [];
                        this.order_id = res.data.id;
                    });
            },
            fetchCupsOrdered() {
                axios
                    .post(`/api/orden/getOrderedCup/${this.cita_paciente}`, {
                        Tiporden_id: this.data.Tiporden_id
                    })
                    .then(res => {
                        this.cupsOrdered = res.data;
                        if (res.data.length > 0)
                            this.order_id = this.cupsOrdered[0].hasOwnProperty("Orden_id") ?
                            this.cupsOrdered[0].Orden_id :
                            null;
                        else this.order_id = null;
                    });
            },
            fetchIncOrdenred() {
                axios.get(`/api/orden/getOrderedCie/${this.cita_paciente}`).then(res => {
                    console.log(res);
                    this.incapacidadOrdered = res.data;
                });
            },
            // saveProcedimientos() {
            //   axios
            //     .post(`/api/orden/citapaciente/${this.cita_paciente}/create`, this.data)
            //     .then(res => {
            //       swal({
            //         title: res.data.message,
            //         text: " ",
            //         type: "success",
            //         timer: 2000,
            //         icon: "success",
            //         buttons: false
            //       });
            //     });
            // },
            addArticulo() {
                if (
                    this.articulos.medicamento.hasOwnProperty("id") &&
                    this.articulos.Cantidadosis &&
                    this.articulos.Unidadmedida &&
                    this.articulos.Via &&
                    this.articulos.Unidadtiempo &&
                    this.articulos.Cantidadmensual &&
                    this.articulos.NumMeses &&
                    this.articulos.Cantidadpormedico
                ) {
                    if (
                        parseInt(this.articulos.medicamento.Cantidadmaxordenar) >=
                        this.articulos.Cantidadpormedico
                    ) {
                        if (this.articulos.Unidadtiempo == "Horas") {
                            if (
                                !this.articulos.Frecuencia ||
                                this.articulos.Frecuencia <= 0 ||
                                !this.articulos.Duracion ||
                                this.articulos.Duracion > 30
                            ) {
                                return;
                            }
                        }

                        // let PosViaAdmin = this.getPosViaAdmin();
                        this.data.articulos.push({
                            id: this.articulos.medicamento.id,
                            nombre: this.articulos.medicamento.Nombre,
                            Cantidadosis: this.articulos.Cantidadosis,
                            Unidadmedida: this.articulos.Unidadmedida,
                            Via: this.articulos.Via,
                            Frecuencia: this.articulos.Frecuencia,
                            Unidadtiempo: this.articulos.Unidadtiempo,
                            Duracion: this.articulos.Duracion,
                            Cantidadmensual: this.articulos.Cantidadmensual,
                            NumMeses: this.articulos.NumMeses,
                            Observacion: this.articulos.Observacion,
                            Requiere_autorizacion: this.articulos.medicamento
                                .Requiere_autorizacion,
                            Cantidadpormedico: this.articulos.Cantidadpormedico
                        });
                        this.clearDataArticulo();
                    } else {
                        swal({
                            title: "Cantidad formulada no permitida",
                            text: "Ingresar una cantidad menor en el campo 'cantidad mensual médico'",
                            icon: "error"
                        });
                    }
                }
            },
            addProcedimiento() {
                if (
                    this.procedimiento.cup.hasOwnProperty("id") &&
                    this.procedimiento.cantidad > 0
                ) {
                    this.data.procedimientos.push({
                        id: this.procedimiento.cup.id,
                        codigo: this.procedimiento.cup.Codigo,
                        nombre: this.procedimiento.cup.Nombre,
                        auditoria: this.procedimiento.cup.Requiere_auditoria,
                        cantidad: this.procedimiento.cantidad,
                        observacion: this.procedimiento.observacion
                    });
                    this.clearDataProcedimiento();
                }
            },
            clearDataArticulo() {
                this.articulos = {
                    medicamento: "",
                    Cantidadosis: "1",
                    Unidadmedida: "",
                    Via: "ORAL",
                    Frecuencia: "0",
                    Unidadtiempo: "Dosis Única",
                    Duracion: "1",
                    Cantidadmensual: "",
                    NumMeses: "1",
                    Cantidadpormedico: "",
                    Observacion: ""
                };
            },
            clearDataProcedimiento() {
                this.procedimiento.cup = {};
                this.procedimiento.cantidad = "";
                this.procedimiento.observacion = "";
            },
            removeArticulo(articulo) {
                this.data.articulos.splice(articulo.index, 1);
            },
            removeProcedimiento(procedimientos) {
                this.data.procedimientos.splice(procedimientos.index, 1);
            },
            getPDFFormula() {

                // if (this.paciente.Cie10_id == '') {
                // 	swal({
                // 	title: "Formula",
                // 	text:
                // 		"Ingrese un diagnostico!",
                // 	timer: 2000,
                // 	icon: "error",
                // 	buttons: false
                // 	});
                // }

                return (this.object = {
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
                    Correo: this.paciente.Correo1,
                    Celular: this.paciente.Telefono,
                    Tipo_Afiliado: this.paciente.Tipo_Afiliado,
                    Estado_Afiliado: this.paciente.Estado_Afiliado,
                    medico_ordena: this.paciente.medicoordeno,
                    dx_principal: this.paciente.Cie10_id,
                    orden_id: this.order_id,
                    type: "formula",
                    medicamentos: this.medicamentosByNo,
                    cita_paciente_id: this.cita_paciente
                });
            },
            getPDFIncap() {

                //   if (this.paciente.Cie10_id == '') {
                // 		swal({
                // 		title: "Incapacidad",
                // 		text:
                // 			"Ingrese un diagnostico!",
                // 		timer: 2000,
                // 		icon: "error",
                // 		buttons: false
                // 		});
                // 	}

                return (this.object = {
                    Primer_Nom: this.paciente.Primer_Nom,
                    Segundo_Nom: this.paciente.SegundoNom,
                    Primer_Ape: this.paciente.Primer_Ape,
                    Segundo_Ape: this.paciente.Segundo_Ape,
                    Nombre: `${this.paciente.Primer_Nom} ${this.paciente.SegundoNom} ${this.paciente.Primer_Ape} ${this.paciente.Segundo_Ape} `,
                    Tipo_Doc: this.paciente.Tipo_Doc,
                    Num_Doc: this.paciente.Num_Doc,
                    Edad_Cumplida: this.paciente.Edad_Cumplida,
                    Sexo: this.paciente.Sexo,
                    IPS: this.paciente.NombreIPS,
                    Direccion_Residencia: this.paciente.Direccion_Residencia,
                    Correo: this.paciente.Correo1,
                    Celular: this.paciente.Telefono,
                    Tipo_Afiliado: this.paciente.Tipo_Afiliado,
                    Estado_Afiliado: this.paciente.Estado_Afiliado,
                    medico_ordena: this.paciente.medicoordeno,
                    dx_principal: this.paciente.Cie10_id,
                    orden_id: this.order_id,
                    type: "incapacidad",
                    cita_paciente_id: this.cita_paciente,
                    FechaInicio: this.incapacidad.FechaInicio,
                    CantidadDias: this.incapacidad.CantidadDias,
                    FechaFinal: this.incapacidad.FechaFinal,
                    Prorroga: this.incapacidad.Prorroga,
                    Cie10: this.incapacidad.Cie10,
                    Contingencia: this.incapacidad.Contingencia,
                    Descripcion: this.incapacidad.Descripcion,
                    // TextCie10: this.incapacidad.TextCie10
                    TextCie10: this.paciente.Cie10_id
                });
            },
            getPosViaAdmin(medicamento) {
                if (medicamento.Unidadtiempo == "Horas")
                    return `${medicamento.Cantidadosis} ${medicamento.Unidadmedida} ${
		  medicamento.Via
		} cada ${medicamento.Frecuencia} Horas X ${
		  medicamento.Duracion
		} dias por ${
		  medicamento.NumMeses > 1
			? `${medicamento.NumMeses} meses`
			: `${medicamento.NumMeses} mes`
		}`;
                else
                    return `${medicamento.Cantidadosis} ${medicamento.Unidadmedida} ${medicamento.Via} Única vez ${medicamento.Cantidadpormedico}`;
            },
            generateInc() {

                if (this.incapacidad.FechaInicio == '') {
                    swal({
                        title: "Incapacidad",
                        text: "Por favor ingrese una fecha de inicio!",
                        timer: 2000,
                        icon: "error",
                        buttons: false
                    });
                    return;
                }

                if (this.incapacidad.CantidadDias == 0) {
                    swal({
                        title: "Incapacidad",
                        text: "Por favor ingrese una cantidad de días!",
                        timer: 2000,
                        icon: "error",
                        buttons: false
                    });
                    return;
                }

                if (this.incapacidad.FechaFinal == '') {
                    swal({
                        title: "Incapacidad",
                        text: "Por favor ingrese una fecha final!",
                        timer: 2000,
                        icon: "error",
                        buttons: false
                    });
                    return;
                }

                if (this.incapacidad.Prorroga == '') {
                    swal({
                        title: "Incapacidad",
                        text: "Por favor ingrese una prorroga!",
                        timer: 2000,
                        icon: "error",
                        buttons: false
                    });
                    return;
                }

                if (this.incapacidad.Contingencia == '') {
                    swal({
                        title: "Incapacidad",
                        text: "Por favor ingrese una contingencia!",
                        timer: 2000,
                        icon: "error",
                        buttons: false
                    });
                    return;
                }

                if (this.incapacidad.Colegio == '') {
                    swal({
                        title: "Incapacidad",
                        text: "Por favor ingrese una colegio!",
                        timer: 2000,
                        icon: "error",
                        buttons: false
                    });
                    return;
                }

                // this.yearago = moment().subtract(1, 'years').format("YYYY-MM-DD");

                // if (this.incapacidad.FechaInicio < this.yearago) {
                //     swal({
                //         title: "Incapacidad",
                //         text: "La fecha inicial no puede ser inferior a un año en el pasado!",
                //         timer: 2000,
                //         icon: "error",
                //         buttons: false
                //     });
                //     return;
                // }

                swal({
                    title: "¿Está Seguro(a)?",
                    text: "Se guardará la incapacidad!",
                    type: "success",
                    icon: "info",
                    buttons: ["Cancelar", "Confirmar"],
                    dangerMode: true
                }).then(async willDelete => {
                    if (willDelete) {
                        console.log("enable", this.enable);
                        if (this.enable == false) {
                            swal({
                                title: "Incapacidad",
                                text: "Por favor ingrese una cantidad de días válida",
                                timer: 2000,
                                icon: "error",
                                buttons: false
                            });
                            return;
                        }

                        let incapacidad = this.getIncapacidad();
                        this.data = {
                            ...this.data,
                            ...incapacidad
                        };
                        console.log(this.data);
                        await axios
                            .post(
                                `/api/orden/citapaciente/${this.cita_paciente}/create`,
                                this.data
                            )
                            .then(res => {
                                this.order_id = res.data.orden_id;
                                this.fetchIncOrdenred();
                                swal("¡Orden creada de manera exitosa!", {
                                    timer: 2000,
                                    icon: "success",
                                    buttons: false
                                });
                            })
                            .catch(err => {
                                this.showError(err.response.data.message);
                            });
                    }
                });
            },
            getFinalDate() {

                this.enable = true;

                if (this.incapacidad.CantidadDias <= 0) {
                    swal({
                        title: "Incapacidad",
                        text: "Por favor ingrese una cantidad de días mayor a 0",
                        timer: 2000,
                        icon: "error",
                        buttons: false
                    });

                    this.enable = false;
					this.incapacidad.FechaFinal = null;
					
                }

                if (this.incapacidad.Contingencia != 'licencia maternidad' && this.incapacidad.CantidadDias > 30) {
                    swal({
                        title: "Incapacidad",
                        text: "Por favor ingrese una cantidad de días menor o igual a 30 días!",
                        timer: 2000,
                        icon: "error",
                        buttons: false
                    });

					this.enable = false;
					this.incapacidad.FechaFinal = null;
					
                }

                if (this.enable == true) {

                    console.log("Dias", this.incapacidad.CantidadDias);

                    this.incapacidad.FechaFinal = moment(this.incapacidad.FechaInicio)
                        .add(this.incapacidad.CantidadDias - 1, "d")
                        .format("YYYY-MM-DD");

                    console.log("Final", this.incapacidad.FechaFinal);

                }

            },
            getIncapacidad() {
                let object = this.cie10s.find(
                    cie => cie.Codigo_CIE10 == this.paciente.Cie10_id
                );

                return (this.incap = {
                    Fechainicio: this.incapacidad.FechaInicio,
                    Dias: this.incapacidad.CantidadDias,
                    Fechafinal: moment(this.incapacidad.FechaFinal).format(),
                    Prorroga: this.incapacidad.Prorroga,
                    Cedula: this.paciente.Num_Doc,
                    // Cie10_id: this.incapacidad.Cie10,
                    Cie10_id: object.id,
                    Contingencia: this.incapacidad.Contingencia,
                    Descripcion: this.incapacidad.Descripcion,
                    Laboraen: this.incapacidad.Colegio
                });
            },
            getPDFOtros() {
                console.log("Paciente", this.paciente);

                //   if (this.paciente.Cie10_id == '') {
                // 	swal({
                // 	  title: "Servicios",
                // 	  text:
                // 		"Ingrese un diagnostico!",
                // 	  timer: 2000,
                // 	  icon: "error",
                // 	  buttons: false
                // 	});
                //   }

                return (this.object = {
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
                    Correo: this.paciente.Correo1,
                    Celular: this.paciente.Telefono,
                    Tipo_Afiliado: this.paciente.Tipo_Afiliado,
                    Estado_Afiliado: this.paciente.Estado_Afiliado,
                    medico_ordena: this.paciente.medicoordeno,
                    dx_principal: this.paciente.Cie10_id,
                    cita_paciente_id: this.cita_paciente,
                    orden_id: this.order_id,
                    type: "otros",
                    servicios: this.serviciosByNo
                });
            },
            setUbicacion() {
                var ubicacion = " ";
                // var procedures = [];
                // var medicamentos = [];

                // this.data.articulos.forEach(medicamento => {
                //   if (medicamento.Requiere_autorizacion != "SI") {
                //     medicamentos.push(medicamento);
                //   }
                // });

                // this.data.procedimientos.forEach(procedimiento => {
                //   if (procedimiento.auditoria != "Si") {
                //     procedures.push(procedimiento);
                //   }
                // });

                if (this.ubicaciones.length > 0) {
                    this.data.procedimientos.map(procedimiento => {
                        let object = this.ubicaciones.find(
                            ubicacion => ubicacion.tarifacup_id == procedimiento.id
                        );

                        procedimiento.cantidad = procedimiento.cantidad;
                        procedimiento.id = procedimiento.id;
                        procedimiento.descripcion = procedimiento.descripcion;
                        procedimiento.codigo = procedimiento.codigo;
                        procedimiento.nombre = procedimiento.nombre;
                        procedimiento.observacion = procedimiento.observacion;

                        if (object) {
                            procedimiento.ubicacion = `${object.nombre_prestador}`;
                            procedimiento.direccion = `${object.direccion}`;
                            procedimiento.telefono = `${object.telefono}`;
                        } else {
                            procedimiento.ubicacion = ubicacion;
                            procedimiento.direccion = ubicacion;
                            procedimiento.telefono = ubicacion;
                        }
                    });
                } else {
                    this.data.procedimientos.map(procedimiento => {
                        procedimiento.cantidad = procedimiento.cantidad;
                        procedimiento.id = procedimiento.id;
                        procedimiento.descripcion = procedimiento.descripcion;
                        procedimiento.codigo = procedimiento.codigo;
                        procedimiento.nombre = procedimiento.nombre;
                        procedimiento.observacion = procedimiento.observacion;
                        procedimiento.ubicacion = ubicacion;
                        procedimiento.direccion = ubicacion;
                        procedimiento.telefono = ubicacion;
                    });
                }

                // this.data.procedimientos = procedures;
                // this.data.articulos = medicamentos;
            },
            printRecomendation() {
                var pdf = {};

                pdf = this.getPDFRecomendation();

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
                        window.open(link.href, "_blank");
                        //   link.download = "Results.pdf";
                        //   window.print(link.href);
                        //   link.click();
                    });
            },
            getPDFRecomendation() {

                // if (this.paciente.Cie10_id == '') {
                // 	swal({
                // 	title: "Recomendación",
                // 	text:
                // 		"Ingrese un diagnostico!",
                // 	timer: 2000,
                // 	icon: "error",
                // 	buttons: false
                // 	});
                // }

                return (this.recomendacion = {
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
                    Correo: this.paciente.Correo1,
                    Celular: this.paciente.Telefono,
                    Tipo_Afiliado: this.paciente.Tipo_Afiliado,
                    Estado_Afiliado: this.paciente.Estado_Afiliado,
                    medico_ordena: this.paciente.medicoordeno,
                    dx_principal: this.paciente.Cie10_id,
                    orden_id: this.order_id,
                    type: "observacion",
                    observaciones: this.recomendation,
                    cita_paciente_id: this.cita_paciente
                });
            },
            async separateByAutorization() {
                console.log("articulos", this.articulosOrdered);
                console.log("procedimiento", this.cupsOrdered);

                if (this.data.Tiporden_id == 2 || this.data.Tiporden_id == 4) {
                    await this.getCupOrden();
                }
                if (this.data.Tiporden_id == 3) {
                    await this.getDetaArticulo();
                }

                console.log("Service No", this.serviciosByNo);
                console.log("Service Yes", this.serviciosByYes);

                console.log("Articulo No", this.medicamentosByNo);
                console.log("Articulo Yes", this.medicamentosByYes);
            },
            async getDetaArticulo() {
                this.medicamentosByNo = [];
                this.medicamentosByYes = [];

                // await axios
                //     .get(`/api/orden/getInDetaArticuloOrden/${this.order_id}`)
                //     .then(res => {
                //         this.articulosOrdered.forEach(medicamento => {
                //             let object = res.data.find(c => c.codesumi_id == medicamento.id);

                //             if (object.Estado_id != 15) {
                //                 this.medicamentosByNo.push(medicamento);
                //             } else {
                //                 this.medicamentosByYes.push(medicamento);
                //             }
                //         });
                //     });

                this.articulosOrdered.forEach(medicamento => {
                    medicamento.PosViaAdmin = this.getPosViaAdmin(medicamento);

                    if (medicamento.Estado_id != 15) {
                        this.medicamentosByNo.push(medicamento);
                    } else {
                        this.medicamentosByYes.push(medicamento);
                    }
                });
            },
            async getCupOrden() {
                this.serviciosByNo = [];
                this.serviciosByYes = [];

                // await axios.get(`/api/orden/getInCupOrden/${this.order_id}`).then(res => {
                //     console.log("cup", res.data);
                //     this.cupsOrdered.forEach(procedimiento => {
                //         let object = res.data.find(c => c.Cup_id == procedimiento.id);

                //         if (object.Estado_id != 15) {
                //             this.serviciosByNo.push(procedimiento);
                //         } else {
                //             this.serviciosByYes.push(procedimiento);
                //         }
                //     });
                // });

                this.cupsOrdered.forEach(procedimiento => {
                    if (procedimiento.Estado_id != 15) {
                        this.serviciosByNo.push(procedimiento);
                    } else {
                        this.serviciosByYes.push(procedimiento);
                    }
                });
            },
            getConducta() {
                let conducta = {
                    cita_paciente_id: this.cita_paciente
                };

                axios
                    .post(`/api/conducta/getConductaByCita`, conducta)
                    .then(res => {
                        if (res.data.conducta.Recomendaciones) {
                            this.recomendation = res.data.conducta.Recomendaciones;
                        }
                    })
                    .catch(err => console.log(err.response));
            },
            clearData() {
                this.data = {
                    Tiporden_id: this.data.Tiporden_id,
                    articulos: [],
                    procedimientos: []
                };
            },
            getLocalStorage() {
                let Diagnostico = JSON.parse(localStorage.getItem("Diagnostico"));
                if (Diagnostico) {
                    let object = Diagnostico.find(diag => diag.Esprimario == true);
                    this.paciente.Cie10_id = object.Codigo;
                }
            },
            async printPDF() {
                if ((this.articulosOrdered.length == 0 && this.cupsOrdered.length == 0) && this.data.Tiporden_id !=
                    1) {
                    swal({
                        title: "Impresión",
                        text: "No se encuentran servicios o articulos que imprimir",
                        icon: "warning",
                    });
                    return;
                } else {
                    await this.clearPropsBy();
                    await this.separateByAutorization();
                    var pdf = {};
                    let print = false;
                    switch (this.data.Tiporden_id) {
                        case 1:
                            pdf = await this.getPDFIncap();
                            await this.print(pdf);
                            if (this.recomendation) {
                                this.printRecomendation();
                            }
                            break;
                        case 3:
                            if (this.medicamentosByNo.length == 0) {
                                swal({
                                    title: "Impresión",
                                    text: "Se generó la orden pero los medicamentos requieren auditoria",
                                    icon: "info"
                                });

                                break;
                            }

                            this.getConducta();
                            pdf = await this.getPDFFormula();
                            await this.print(pdf);
                            if (this.recomendation) {
                                this.printRecomendation();
                            }
                            break;
                        case 2:
                        case 4:
                            if (this.serviciosByNo.length == 0) {
                                swal({
                                    title: "Impresión",
                                    text: "Se generó la orden pero los servicios requieren auditoria",
                                    icon: "info"
                                });

                                break;
                            }

                            this.getConducta();

                            this.setUbicacion();

                            let printPages = {};
                            this.serviciosByNo.forEach(ser => {
                                if (!printPages.hasOwnProperty(ser.Ubicacion_id))
                                    printPages[ser.Ubicacion_id] = [];

                                printPages[ser.Ubicacion_id].push(ser);
                            });

                            for (const p in printPages) {
                                console.log(printPages[p]);
                                this.serviciosByNo = printPages[p];
                                pdf = await this.getPDFOtros();
                                await this.print(pdf);
                            }
                            if (this.recomendation) {
                                this.printRecomendation();
                            }
                            break;
                    }
                }
            },
            clearPropsBy() {
                this.medicamentosByNo = [];
                this.medicamentosByYes = [];
                this.serviciosByNo = [];
                this.serviciosByYes = [];
            },
            async print(pdf) {
                await axios
                    .post("/api/pdf/print-pdf", pdf, {
                        responseType: "arraybuffer"
                    })
                    .then(async res => {
                        let blob = new Blob([res.data], {
                            type: "application/pdf"
                        });
                        let link = document.createElement("a");
                        link.href = window.URL.createObjectURL(blob);
                        window.open(link.href, "_blank");
                        // link.download = "Results.pdf";
                        //   window.print(link.href);
                        // link.click();

                        // this.$router.go();

                    })
                    .catch(err => console.log(err.response));
            },
            fetchColegios() {
                //colegios
                // axios.get(`api/colegio/all`).then(res => {
                // 	console.log(res);
                // 	this.colegios = res.data;
                // 	console.log("colegio", this.colegios);
                //   });
                this.loading = true;
                axios.post('/api/colegio/getColegioByName', {
                        nombre: this.search
                    })
                    .then(res => {
                        this.colegios = res.data
                        this.loading = false;
                    })
            },
            showError(message){
                swal({
                    title: "¡No puede ser!",
                    text: `${message}`,
                    icon: "warning",
                });
            },
        }
    };

</script>
