<template>
    <v-layout row wrap>
        <v-dialog v-model="dialog" max-width="1000px">
            <v-card>
                <v-card-title class="headline grey lighten-2">Servicios</v-card-title>
                <v-data-table class="fb-table-elem" :headers="cupOrderHeaders"
                    :items="autorizacion.cupordens" item-key="index" v-model="selected" select-all>
                    <template v-slot:items="props">
                        <td class="text-xs-center">
                            <v-checkbox color="primary" :input-value="props.selected" v-model="selected"
                                :value="props.item" multiple hide-details></v-checkbox>
                        </td>
                        <td class="text-xs-center">
                            <div class="datatable-cell-wrapper">{{ props.item.id }}</div>
                        </td>
                        <td class="text-xs-center">
                            <div class="datatable-cell-wrapper">{{ props.item.Cup_Codigo }}</div>
                        </td>
                        <td class="text-xs-center">
                            <div class="datatable-cell-wrapper">{{ props.item.Cup_Nombre }}</div>
                        </td>
                        <td class="text-xs-center">
                            <div class="datatable-cell-wrapper">{{ props.item.observaciones }}</div>
                        </td>
                        <td class="text-xs-center">
                            <v-text-field v-model="props.item.Sede_Nombre" label="Edit" single-line
                                        counter autofocus></v-text-field>
                            <!-- <v-edit-dialog :return-value.sync="props.item.Sede_Nombre" large lazy persistent
                                        cancel-text="Cancelar" save-text="Cambiar" @save="updatePrestador(props.item)">
                                <div>{{ props.item.Sede_Nombre }}</div>
                                <template v-slot:input>
                                    <div class="mt-3 title">Update Sede Proveedor</div>
                                </template>
                                <template v-slot:input>
                                    <v-autocomplete label="Edit" :items="ListPrestador"
                                    item-value="id" item-text="Nombre"
                                    v-model="props.item.Sede_Id" :loading="loading"
                                    :search-input.sync="search" required
                                    ></v-autocomplete>
                                </template>
                            </v-edit-dialog> -->
                        </td>
                        <td class="text-xs-center">
                            <div class="datatable-cell-wrapper">{{ props.item.Sede_Direccion }}</div>
                        </td>
                        <td class="text-xs-center">
                            <div class="datatable-cell-wrapper">{{ props.item.Sede_Telefono }}</div>
                        </td>
                        <td class="text-xs-center">
                            <div class="datatable-cell-wrapper">{{ props.item.Cup_Cantidad }}</div>
                        </td>
                        <td class="text-xs-center">
                            <div class="datatable-cell-wrapper">{{ props.item.Auth_Name }} {{ props.item.Auth_Apellido }}</div>
                        </td>
                        <td class="text-xs-center">
                            <div class="datatable-cell-wrapper">{{ props.item.Auth_Nota }}</div>
                        </td>
                    </template>
                </v-data-table>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn v-show="show()" color="primary" round @click="printPDF()">Imprimir</v-btn>
                </v-card-actions>
            </v-card>
            <v-card>
                <v-tabs vertical>
                    <v-tab>
                        <v-icon left>mdi-account</v-icon>Acciones
                    </v-tab>
                    <v-tab>
                        <v-icon left>list_alt</v-icon>Adjuntos
                    </v-tab>
                    <v-tab-item v-if="can('auditoria.servicios.auditar')">
                        <v-card>
                            <v-card-title>
                                <span class="headline">Acciones</span>
                            </v-card-title>
                            <v-card-text>
                                <v-layout row wrap>
                                    <v-flex xs5 md3 lg6 px-1>
                                        <v-select v-model="action" append-icon="search" label="Seleccionar acción"
                                            :items="actions" item-text="accion" item-value="value" hide-details>
                                        </v-select>
                                    </v-flex>
                                    <v-flex xs5 md6 lg6 px-1>
                                        <span>Elegir una acción para cambiar el estado de la orden seleccionada</span>
                                    </v-flex>
                                </v-layout>
                                <v-container>
                                    <v-textarea name="input-7-1" label="Observacion" value v-model="observaciones">
                                    </v-textarea>
                                    <v-btn v-show="selected.length > 0" color="blue" class="ma-2 white--text"
                                        @click="enviarAccion(action)">
                                        Enviar
                                        <v-icon right dark>send</v-icon>
                                    </v-btn>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" flat @click="cerrarModal()">Cerrar</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-tab-item>
                    <v-tab-item>
                        <v-card flat>
                            <v-card-title class="headline grey lighten-2">Archivos Paciente
                            </v-card-title>
                            <v-data-table class="fb-table-elem" :headers="filesHeaders" :items="listOfFiles"
                                item-key="index">
                                <template v-slot:items="props">
                                    <td class="text-xs-center">
                                        <div class="datatable-cell-wrapper">{{ props.item.Name }}</div>
                                    </td>
                                    <td class="text-xs-center">
                                        <div class="datatable-cell-wrapper">{{ props.item.created_at }}</div>
                                    </td>
                                    <td>
                                        <v-btn text icon color="blue" dark>
                                            <v-icon @click="generate(props.item)">assignment_turned_in</v-icon>
                                        </v-btn>
                                        <span>Anexo</span>
                                    </td>

                                </template>
                            </v-data-table>
                        </v-card>
                    </v-tab-item>
                </v-tabs>
            </v-card>
        </v-dialog>
        <v-flex xs6>
            <v-select v-model="accion" append-icon="search" label="Seleccionar acción" :items="acciones"
                item-text="accion" item-value="value" hide-details></v-select>
        </v-flex>
        <v-flex xs4>
            <v-text-field v-model="cedula" type="number" label="Cédula" outlined></v-text-field>
        </v-flex>
        <v-flex xs2>
            <v-btn color="primary" round @click="find()">Buscar</v-btn>
        </v-flex>
        <template>
            <v-layout wrap>
                <v-flex>
                    <v-card>
                        <v-card-title>
                            <v-text-field v-model="search" append-icon="search" label="Buscar..." single-line
                                hide-details></v-text-field>
                        </v-card-title>
                        <v-data-table :headers="headers" :items="listaAutorizaciones" item-key="index" :search="search">
                            <template v-slot:items="props">
                                <td>
                                    <v-btn text icon color="blue" dark>
                                        <v-icon @click="printhc(props.item)">assignment_turned_in</v-icon>
                                    </v-btn>
                                    <span>Historia</span>
                                </td>
                                <td class="text-xs-center">{{ props.item.id}}</td>
                                <td class="text-xs-center">{{ props.item.created_at}}</td>
                                <td class="text-xs-center">{{ props.item.Departamento}}</td>
                                <td class="text-xs-center">{{ props.item.Municipio}}</td>
                                <td class="text-xs-center">{{ props.item.Primer_Nom}} {{ props.item.Primer_Ape}}</td>
                                <td class="text-xs-center">{{ props.item.Cedula}}</td>
                                <td class="text-xs-center">{{ props.item.Nombre_IPS}}</td>
                                <td class="text-xs-center">{{ props.item.Descripcion_CIE10}}</td>
                                <td class="text-xs-center">{{ props.item.User_Name}} {{ props.item.User_LastName}}</td>
                                <td class="text-xs-center">
                                    <v-btn color="blue" class="ma-2 white--text" @click="abrirModal(props.item)">
                                        Acciones
                                        <v-icon right dark>send</v-icon>
                                    </v-btn>
                                </td>
                            </template>
                            <v-alert v-slot:no-results :value="true" color="error" icon="warning">Your search for
                                "{{ search }}" found no results.</v-alert>
                        </v-data-table>
                        <v-layout row wrap>
                            <v-spacer></v-spacer>
                            <v-btn color="dark" round @click="expand = !expand">Exportar a Excel</v-btn>
                            <v-expand-x-transition>
                                <v-card v-show="expand" height="200" width="500" class="mx-auto">
                                    <v-card-text>
                                        <v-layout row wrap>
                                            <v-flex xs6>
                                                <v-menu ref="show_start_date" :close-on-content-click="false"
                                                    v-model="show_start_date" :nudge-right="40"
                                                    :return-value.sync="start_date" lazy transition="scale-transition"
                                                    offset-y full-width min-width="250px" max-width="250px">
                                                    <template v-slot:activator="{ on }">
                                                        <v-text-field v-model="start_date" label="Fecha Inicial"
                                                            prepend-icon="event" readonly v-on="on">
                                                        </v-text-field>
                                                    </template>
                                                    <v-date-picker color="primary" locale="es" v-model="start_date"
                                                        full-width @click="$refs.show_start_date.save(start_date)">
                                                        <v-spacer></v-spacer>
                                                        <v-btn flat color="primary" @click="show_start_date = false">
                                                            Cancelar
                                                        </v-btn>
                                                        <v-btn flat color="primary"
                                                            @click="$refs.show_start_date.save(start_date)">OK
                                                        </v-btn>
                                                    </v-date-picker>
                                                </v-menu>
                                            </v-flex>
                                            <!-- <v-spacer></v-spacer> -->
                                            <v-flex xs6>
                                                <v-menu ref="show_end_date" :close-on-content-click="false"
                                                    v-model="show_end_date" :nudge-right="40"
                                                    :return-value.sync="end_date" lazy transition="scale-transition"
                                                    offset-y full-width min-width="250px" max-width="250px">
                                                    <template v-slot:activator="{ on }">
                                                        <v-text-field v-model="end_date" label="Fecha Final"
                                                            prepend-icon="event" readonly v-on="on">
                                                        </v-text-field>
                                                    </template>
                                                    <v-date-picker color="primary" locale="es" v-model="end_date"
                                                        full-width crollable>
                                                        <v-spacer></v-spacer>
                                                        <v-btn flat color="primary" @click="show_end_date = false">
                                                            Cancelar</v-btn>
                                                        <v-btn flat color="primary"
                                                            @click="$refs.show_end_date.save(end_date)">
                                                            OK</v-btn>
                                                    </v-date-picker>
                                                </v-menu>
                                            </v-flex>
                                        </v-layout>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-btn color="primary" round @click="exportExcel()">Aceptar</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-expand-x-transition>
                        </v-layout>
                    </v-card>
                </v-flex>
            </v-layout>
        </template>
    </v-layout>
</template>
<script>
    import {
        mapGetters
    } from 'vuex';
    export default {
        name: "Auditoria",
        data() {
            return {
                listaAutorizaciones: [],
                autorizaciones: [],
                listOfFiles: [],
                selected: [],
                ListPrestador: [],
                dialog: false,
                expand: false,
                accion: "",
                action: "",
                search: "",
                cedula: "",
                Firma_Auditor: null,
                observaciones: "",
                autorizacion: {},
                pdf: {},
                bjectFrm: {},
                show_start_date: false,
                start_date: null,
                show_end_date: false,
                end_date: null,
                data: {
                    Tiporden_id: 3,
                    articulos: [],
                    procedimientos: []
                },
                headers: [{
                        text: "Historia",
                        sortable: false,
                        value: ""
                    },
                    {
                        text: "Orden",
                        sortable: false,
                        value: ""
                    },
                    {
                        text: "Fecha Solicitud",
                        sortable: false,
                        align: "center",
                        value: "FechaSolicitud"
                    },
                    {
                        text: "Departamento",
                        sortable: false,
                        align: "center",
                        value: ""
                    },
                    {
                        text: "Municipio",
                        sortable: false,
                        align: "center",
                        value: "Municipio"
                    },
                    {
                        text: "Nombre",
                        sortable: false,
                        align: "center",
                        value: "Primer_Nom"
                    },
                    {
                        text: "Cedula",
                        sortable: false,
                        align: "center",
                        value: "Cedula"
                    },
                    {
                        text: "Ips Atención",
                        sortable: false,
                        align: "center",
                        value: ""
                    },
                    {
                        text: "Diagnostico",
                        sortable: false,
                        align: "center",
                        value: "Descripcion_CIE10"
                    },
                    {
                        text: "Funcionario Carga Servicio",
                        sortable: false,
                        align: "center",
                        value: ""
                    },
                    {
                        text: "Acciones",
                        sortable: false,
                        align: "center",
                        value: ""
                    }
                ],
                acciones: [{
                        accion: "Aprobado Sin Autorización",
                        value: "1"
                    },
                    {
                        accion: "Aprobado Con Autorización",
                        value: "7"
                    },
                    {
                        accion: "PENDIENTE",
                        value: "15"
                    },
                    {
                        accion: "INADECUADO",
                        value: "24"
                    },
                    {
                        accion: "NEGADO",
                        value: "25"
                    },
                    {
                        accion: "ANULADO",
                        value: "26"
                    }
                ],
                actions: [{
                        accion: "INADECUADO",
                        value: "Inadecuado"
                    },
                    {
                        accion: "NEGADO",
                        value: "Negado"
                    },
                    {
                        accion: "ANULADO",
                        value: "Anulado"
                    }
                ],
                filesHeaders: [{
                        text: "Nombre",
                        align: "center",
                        value: "Name"
                    },
                    {
                        text: "Fecha",
                        align: "center",
                        value: "created_at"
                    },
                    {
                        text: "",
                        align: "center",
                        value: ""
                    }
                ],
                cupOrderHeaders: [{
                        text: "Orden Servicio",
                        sortable: false,
                        align: "center",
                        value: "id"
                    },
                    {
                        text: "Código",
                        sortable: false,
                        align: "center",
                        value: "Cup_Codigo"
                    },
                    {
                        text: "Nombre",
                        sortable: false,
                        align: "center",
                        value: "Cup_Nombre"
                    },
                    {
                        text: "Observacion",
                        sortable: false,
                        align: "center",
                        value: "observaciones"
                    },
                    {
                        text: "Prestador",
                        sortable: false,
                        align: "center",
                        value: "Sede_Nombre"
                    },
                    {
                        text: "Dirección Prestador",
                        sortable: false,
                        align: "center",
                        value: "Sede_Direccion"
                    },
                    {
                        text: "Teléfono Prestador",
                        sortable: false,
                        align: "center",
                        value: "Sede_Telefono"
                    },
                    {
                        text: "Cantidad",
                        sortable: false,
                        align: "center",
                        value: "Cup_Cantidad"
                    },
                    {
                        text: "Auditor",
                        sortable: false,
                        align: "center",
                        value: ""
                    },
                    {
                        text: "Nota Auditoria",
                        sortable: false,
                        align: "center",
                        value: "Auth_Nota"
                    },
                ],
            };
        },
        
        computed: {
            ...mapGetters(['can'])
        },
        methods: {
            find() {
                if (!this.accion) {
                    swal({
                        title: "Debe elegir algún estado",
                        icon: "warning"
                    });
                    return;
                } else if (!this.cedula) {
                    swal({
                        title: "Debe elegir una cédula",
                        icon: "warning"
                    });
                    return;
                }

                let state = {
                    status: this.accion,
                    cedula: this.cedula
                };

                axios.post("/api/autorizacion/listAuthServByState", state).then(res => {
                    if (res.data.length > 0)
                        this.listaAutorizaciones = res.data
                    else this.listaAutorizaciones = [];
                });
            },
            async exportExcel() {
                if (!this.accion) {
                    swal({
                        title: "Excel",
                        text: "Se requiere una acción",
                        timer: 2000,
                        icon: "error",
                        buttons: false
                    });
                    return;
                }

                if (!this.start_date) {
                    swal({
                        title: "Excel",
                        text: "Se requiere una fecha inicial",
                        timer: 2000,
                        icon: "error",
                        buttons: false
                    });
                    return;
                }

                if (!this.end_date) {
                    swal({
                        title: "Excel",
                        text: "Se requiere una fecha final",
                        timer: 2000,
                        icon: "error",
                        buttons: false
                    });
                    return;
                }

                if (this.start_date > this.end_date) {
                    swal({
                        title: "Excel",
                        text: "La fecha inicial es mayor a la fecha final",
                        timer: 2000,
                        icon: "error",
                        buttons: false
                    });
                    return;
                }

                let object = {
                    status: this.accion,
                    fechaStart: this.start_date,
                    fechaEnd: this.end_date
                };
            },
            printhc(autorizacion) {
                if (autorizacion) {
                    console.log("cita", autorizacion);
                    let cc = {
                        Num_Doc: autorizacion.Cedula
                    };
                    axios.post("/api/historiapaciente/gethistoria", cc).then(res => {
                        console.log("hc", res.data);
                        this.historiapaciente = res.data.find(h => h.id == autorizacion.citaPaciente_id);
                        if (!this.historiapaciente) {
                            swal({
                                title: "Historial",
                                text: "El historial no puede ser mostrado",
                                timer: 2000,
                                icon: "error",
                                buttons: false
                            });
                        } else {
                            let pdf = this.getPDFHistorial(this.historiapaciente);
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
                                    //ink.download = "Historia.pdf";

                                    window.open(link.href, "_blank");
                                    // //   window.print(link.href);
                                    // link.click();
                                });
                        }
                    });
                }
            },
            getPDFHistorial(autorizacion) {
                return (this.pdf = {
                    type: "test",
                    FechaInicio: autorizacion.Fecha_solicita,
                    Nombre: autorizacion.Nombre,
                    Edad_Cumplida: autorizacion.Edad,
                    Sexo: autorizacion.Sexo,
                    Antropometricas: autorizacion.Antropometricas,
                    Atendido_Por: autorizacion.Atendido_Por,
                    Cardiovascular: autorizacion.Cardiovascular,
                    telefono: autorizacion.Celular,
                    Condiciongeneral: autorizacion.Condiciongeneral,
                    Cédula: autorizacion.Cédula,
                    Datetimeingreso: autorizacion.Datetimeingreso,
                    Datetimesalida: autorizacion.Datetimesalida,
                    Departamento: autorizacion.Departamento,
                    Destinopaciente: autorizacion.Destinopaciente,
                    Diagnostico_Principal: autorizacion.Diagnostico_Principal,
                    Diagnostico_Secundario: autorizacion.Diagnostico_Secundario,
                    Direccion_Residencia: autorizacion.Direccion_Residencia,
                    Edad: autorizacion.Edad,
                    Endocrinologico: autorizacion.Endocrinologico,
                    Enfermedadactual: autorizacion.Enfermedadactual,
                    Entidademite: autorizacion.Entidademite,
                    Fecha_Nacimiento: autorizacion.Fecha_Nacimiento,
                    Fecha_solicita: autorizacion.Fecha_solicita,
                    Finalidad: autorizacion.Finalidad,
                    Gastrointestinal: autorizacion.Gastrointestinal,
                    Genitourinario: autorizacion.Genitourinario,
                    Laboraen: autorizacion.Laboraen,
                    Linfatico: autorizacion.Linfatico,
                    Medicoordeno: autorizacion.Medicoordeno,
                    Motivoconsulta: autorizacion.Motivoconsulta,
                    Municipio_Afiliado: autorizacion.Municipio_Afiliado,
                    Neurologico: autorizacion.Neurologico,
                    Nombre: autorizacion.Nombre,
                    Norefiere: autorizacion.Norefiere,
                    Observaciones: autorizacion.Observaciones,
                    Oftalmologico: autorizacion.Oftalmologico,
                    Osteomioarticular: autorizacion.Osteomioarticular,
                    Osteomuscular: autorizacion.Osteomuscular,
                    Otorrinoralingologico: autorizacion.Otorrinoralingologico,
                    Otros_Signos_Vitales: autorizacion.Otros_Signos_Vitales,
                    Planmanejo: autorizacion.Planmanejo,
                    Presión_Arterial: autorizacion.Presión_Arterial,
                    Recomendaciones: autorizacion.Recomendaciones,
                    Respiratorio: autorizacion.Respiratorio,
                    Resultayudadiagnostica: autorizacion.Resultayudadiagnostica,
                    Sexo: autorizacion.Sexo,
                    Signos_Vitales: autorizacion.Signos_Vitales,
                    Tegumentario: autorizacion.Tegumentario,
                    Telefono: autorizacion.Telefono,
                    Timeconsulta: autorizacion.Timeconsulta,
                    tipo_afiliado: autorizacion.Tipo_Afiliado,
                    Tipo_Orden: autorizacion.Tipo_Orden,
                    Tipodiagnostico: autorizacion.Tipodiagnostico,
                    id: autorizacion.id,
                    Firma: autorizacion.Firma
                });
            },
            printPDF() {

                swal({
                    title: 'Esta seguro de realizar la impresión!',
                    icon: "info",
                    buttons: ["Cancelar", "Confirmar"],
                    dangerMode: true
                }).then(async willDelete => {
                    if (willDelete) {

                        this.fillData(this.selected);

                        let printPages = {};
                        console.log("procedimientos before", this.procedimientos);
                        this.data.procedimientos.forEach(ser => {
                            if (!printPages.hasOwnProperty(ser.Sede_Id))
                                printPages[ser.Sede_Id] = [];

                            printPages[ser.Sede_Id].push(ser);
                        });

                        console.log("print", printPages);

                        for (const p in printPages) {
                            console.log(printPages[p]);
                            this.data.procedimientos = printPages[p];
                            var pdf = await this.getPDFOtros();

                            console.log("PDF", pdf);

                            await this.print(pdf);
                        }

                        var pdf = this.getPDFOtros();

                    }
                });
            },
            getPDFOtros() {
                console.log("autorizacion", this.autorizacion);
                return (this.objectFrm = {
                    Primer_Nom: this.autorizacion.Primer_Nom,
                    Segundo_Nom: this.autorizacion.Segundo_Nom,
                    Primer_Ape: this.autorizacion.Primer_Ape,
                    Segundo_Ape: this.autorizacion.Segundo_Ape,
                    Tipo_Doc: this.autorizacion.Tipo_Doc,
                    Num_Doc: this.autorizacion.Cedula,
                    Edad_Cumplida: this.autorizacion.Edad_Cumplida,
                    Sexo: this.autorizacion.Sexo,
                    IPS: this.autorizacion.Nombre_IPS,
                    Direccion_Residencia: this.autorizacion.Direccion_Residencia,
                    Correo: this.autorizacion.Correo,
                    Telefono: this.autorizacion.Telefono,
                    Celular: this.autorizacion.Celular,
                    Tipo_Afiliado: this.autorizacion.Tipo_Afiliado,
                    Estado_Afiliado: this.autorizacion.Estado_Afiliado,
                    dx_principal: this.autorizacion.Codigo_CIE10,
                    cita_paciente_id: this.autorizacion.citaPaciente_id,
                    orden_id: this.autorizacion.id,
                    Firma: this.autorizacion.Medico_Firma,
                    Firma_Auditor: this.Firma_Auditor,
                    type: "otros",
                    servicios: this.data.procedimientos
                });
            },
            fillData(selected) {
                this.data.procedimientos = [];

                this.Firma_Auditor = selected[0].Auth_Firma;

                selected.forEach(select => {

                    let obj = {
                        cantidad: select.Cup_Cantidad,
                        id: select.Cup_Id,
                        descripcion: select.Cup_Nombre,
                        codigo: select.Cup_Codigo,
                        nombre: select.Cup_Nombre,
                        observacion: select.observaciones,
                        sede_id: select.Sede_Id,
                        ubicacion: select.Sede_Nombre,
                        direccion: select.Sede_Direccion,
                        telefono: select.Sede_Telefono,
                        Auth_Nota: select.Auth_Nota
                    };

                    this.data.procedimientos.push(obj);
                });
            },
            abrirModal(autorizacion) {
                this.autorizacion = autorizacion;
                this.fillListOfFiles(autorizacion);
                this.cita_paciente = autorizacion.citaPaciente_id;
                this.dialog = true;
            },
            enviarAccion(nameAccion) {

                if (nameAccion == "") {
                    swal({
                        title: "Debe elegir una acción",
                        icon: "warning"
                    });
                    return;
                }

                if (this.observaciones == "") {
                    swal({
                        title: "Debe llenar la Observacion",
                        icon: "warning"
                    });
                    return;
                }

                const msg =
                    "Esta seguro de cambiar el estado de esta orden a " + nameAccion;
                swal({
                    title: msg,
                    icon: "warning",
                    buttons: ["Cancelar", "Confirmar"],
                    dangerMode: true
                }).then(willDelete => {
                    if (willDelete) {
                        let dataSend = {
                            observaciones: this.observaciones,
                            autorizaciones: this.selected,
                            type: "Servicios"
                        }

                        if (nameAccion == "Inadecuado") {
                            axios
                                .post("/api/autorizacion/StateInad", dataSend)
                                .then(res => console.log("res.data ", res.data))
                                .catch(err => console.log(err.response));
                        } else if (nameAccion == "Negado") {
                            axios
                                .post("/api/autorizacion/StateNeg", dataSend)
                                .then(res => console.log("res.data ", res.data))
                                .catch(err => console.log(err.response));
                        } else if (nameAccion == "Anulado") {
                            axios
                                .post("/api/autorizacion/StateAnu", dataSend)
                                .then(res => console.log("res.data ", res.data))
                                .catch(err => console.log(err.response));
                        }
                        this.cerrarModal();
                        this.find();
                    }
                });

            },
            cerrarModal() {
                this.idAutorizacion = 0;
                this.dialog = false;
                this.action = "";
                this.autorizaciones = [];
                this.observaciones = "";
                this.data.procedimientos = [];
                this.selected = [];
            },
            fillListOfFiles(auth) {
                console.log("test", auth);
                axios
                    .get(`/api/file/getFiles/${auth.citaPaciente_id}`)
                    .then(res => {
                        this.listOfFiles = res.data;
                        console.log("files", res.data);
                    });
            },
            generate(anexo) {
                console.log("path", anexo);
                window.open(anexo.Path, "_blank");
            },
            async print(pdf) {
                await axios
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
                    })
                    .catch(err => console.log(err.response));
            },
            show() {
                if (this.selected.length > 0 && 
                ( this.autorizacion.cupordens[0].Estado_id == 7 || 
                  this.autorizacion.cupordens[0].Estado_id == 1 )) {
                    return true;
                }
                return false;
            },
            updatePrestador(cup){
                axios.post(`/api/autorizacion/UpdateServ/${cup.id}`, cup)
                            .then((res) => {
                                this.cerrarModal();
                                this.find();
                                this.selected = [];
                                swal({
                                    title: `Orden modificada de manera exitosa`,
                                    text: " ",
                                    timer: 2000,
                                    icon: "success",
                                    buttons: false
                                });
                            })
                            .catch((err) => console.log(err));
            }
        }
    };

</script>

<style lang="scss" scoped>
</style>
