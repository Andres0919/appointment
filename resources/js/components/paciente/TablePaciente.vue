<template>
    <v-container pa-1 >
        <v-container>
            <v-layout row fill-height>
                <v-dialog v-model="dialog" persistent max-width="1000px">
                    <v-card>
                        <v-card-title>
                            <span v-if="save" class="headline">Crear Paciente</span>
                            <span v-else class="headline">Editar Paciente</span>
                        </v-card-title>
                        <v-card-text height="300">
                            <v-container grid-list-md>
                                <v-layout wrap>
                                    <v-flex xs12 sm3 md3 v-for="input in inputs" :key="input.id">
                                        <v-text-field
                                        :label="input.label" 
                                        v-model= "data[input.value]" 
                                        :readonly="!edit"
                                        ></v-text-field>
                                    </v-flex>
                                    <!-- <pre>{{data}}</pre> -->
                                </v-layout>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" flat @click="dialog = false">Cancelar</v-btn>
                        <v-btn v-if="save" color="blue darken-1" flat @click="registerPaciente()">Guardar</v-btn>
                        <v-btn v-else-if="edit" color="blue darken-1" flat @click="updatePaciente()">Actualizar</v-btn>
                        <v-btn v-else color="blue darken-1" flat @click="editPaciente()">Editar</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-layout>
        </v-container>
        
        <v-card-title justify-center>
            <v-btn round color="primary" @click="createPaciente()" dark><v-icon left>person_add</v-icon>Crear Paciente</v-btn>
            <v-spacer></v-spacer>
            <v-flex 
             sm5
             xs12
             >    
                <v-text-field
                    v-model="search"
                    label="Ingresa el documento del paciente"
                    single-line
                    hide-details
                ></v-text-field>
                
            </v-flex>
            <v-btn outline @click="getPaciente" small fab color="success">
                <v-icon>search</v-icon>
            </v-btn>
        </v-card-title>
    </v-container>
</template>

<script>
    export default {
        data() {
            return {
                search:'',
                dialog: false,
                save: true,
                edit: false,
                data:{
                    Region: '',
                    Ut: '',
                    Primer_Nom: '',
                    SegundoNom: '',
                    Primer_Ape: '',
                    Segundo_Ape: '',
                    Tipo_Doc: '',
                    Num_Doc: '',
                    Sexo: '',
                    Fecha_Afiliado: '',
                    Fecha_Naci: '',
                    Edad_Cumplida: '',
                    Discapacidad: '',
                    Grado_Discapacidad: '',
                    Tipo_Afiliado: '',
                    Orden_Judicial: '',
                    Num_Folio: '',
                    Fecha_Emision: '',
                    Parentesco: '',
                    TipoDoc_Cotizante: '',
                    Doc_Cotizante: '',
                    Tipo_Cotizante: '',
                    Estado_Afiliado: '',
                    Dane_Mpio: '',
                    Mpio_Afiliado: '',
                    Dane_Dpto: '',
                    Departamento: '',
                    Subregion: '',
                    Dpto_Atencion: '',
                    Mpio_Atencion: '',
                    IPS: '',
                    Sede_Odontologica: '',
                    Medicofamilia: '',
                    Etnia: '',
                    Nivel_Sisben: '',
                    Laboraen: '',
                    Mpio_Labora: '',
                    Direccion_Residencia: '',
                    Mpio_Residencia: '',
                    Telefono: '',
                    Correo: '',
                    Estrato: '',
                    Celular: '',
                    Sexo_Biologico: '',
                    Tipo_Regimen: '',
                    Num_Hijos: '',
                    Vivecon: '',
                    RH: '',
                },
                inputs: [
                    { label: 'Region', value: 'Region' },
                    { label: 'Ut', value: 'Ut' },
                    { label: 'Primer Nombre', value: 'Primer_Nom' },
                    { label: 'Segundo Nombre', value: 'SegundoNom' },
                    { label: 'Primer Apellido', value: 'Primer_Ape' },
                    { label: 'Segundo Apellido', value: 'Segundo_Ape' },
                    { label: 'Tipo Documento', value: 'Tipo_Doc' },
                    { label: 'Número Documento', value: 'Num_Doc' },
                    { label: 'Sexo', value: 'Sexo' },
                    { label: 'Fecha Afiliado', value: 'Fecha_Afiliado' },
                    { label: 'Fecha Nacimiento', value: 'Fecha_Naci' },
                    { label: 'Edad Cumplida', value: 'Edad_Cumplida' },
                    { label: 'Discapacidad', value: 'Discapacidad' },
                    { label: 'Grado Discapacidad', value: 'Grado_Discapacidad' },
                    { label: 'Tipo Afiliado', value: 'Tipo_Afiliado' },
                    { label: 'Orden Judicial', value: 'Orden_Judicial' },
                    { label: 'Num Folio', value: 'Num_Folio' },
                    { label: 'Fecha Emision', value: 'Fecha_Emision' },
                    { label: 'Parentesco', value: 'Parentesco' },
                    { label: 'Tipo Documento Cotizante', value: 'TipoDoc_Cotizante' },
                    { label: 'Documento Cotizante', value: 'Doc_Cotizante' },
                    { label: 'Tipo Cotizante', value: 'Tipo_Cotizante' },
                    { label: 'Estado Afiliado', value: 'Estado_Afiliado' },
                    { label: 'Dane Mpio', value: 'Dane_Mpio' },
                    { label: 'Mpio Afiliado', value: 'Mpio_Afiliado' },
                    { label: 'Dane Dpto', value: 'Dane_Dpto' },
                    { label: 'Departamento', value: 'Departamento' },
                    { label: 'Subregion', value: 'Subregion' },
                    { label: 'Dpto Atencion', value: 'Dpto_Atencion' },
                    { label: 'Mpio Atencion', value: 'Mpio_Atencion' },
                    { label: 'IPS', value: 'IPS' },
                    { label: 'Sede Odontologica', value: 'Sede_Odontologica' },
                    { label: 'Medico Familia', value: 'Medicofamilia' },
                    { label: 'Etnia', value: 'Etnia' },
                    { label: 'Nivel Sisben', value: 'Nivel_Sisben' },
                    { label: 'Donde labora', value: 'Laboraen' },
                    { label: 'Mpio Labora', value: 'Mpio_Labora' },
                    { label: 'Direccion Residencia', value: 'Direccion_Residencia' },
                    { label: 'Mpio Residencia', value: 'Mpio_Residencia' },
                    { label: 'Telefono', value: 'Telefono' },
                    { label: 'Correo', value: 'Correo' },
                    { label: 'Estrato', value: 'Estrato' },
                    { label: 'Celular', value: 'Celular' },
                    { label: 'Sexo Biologico', value: 'Sexo_Biologico' },
                    { label: 'Tipo Regimen', value: 'Tipo_Regimen' },
                    { label: 'Número de Hijos', value: 'Num_Hijos' },
                    { label: 'Vivecon', value: 'Vivecon' },
                    { label: 'RH', value: 'RH' },
                ]
            }
        },
        methods: {
            createPaciente(){
                this.emptyData();
                this.edit = true;
                this.dialog = true;
                this.save = true;
            },
            registerPaciente() {
                axios.post('/api/paciente/create', this.data)
                    .then((res) => {
                        this.emptyData();
                        this.dialog = false;
                        swal({
                            title: "Paciente Creado!",
                            text: " ",
                            type: "success",
                            timer: 2000,
                            icon: "success",
                            buttons: false
                        });
                    })
                    .catch((err) => this.showError(err.response.data));
            },
            showError(message){
                swal({
                    title: "¡Paciente con este Número de Documento ya existe!",
                    text: `${message.email}`,
                    icon: "warning",
                });
            },
            emptyData(){
                this.data = {
                    Region: 'prueba',
                    Ut: 'prueba',
                    Primer_Nom: 'prueba',
                    SegundoNom: 'prueba',
                    Primer_Ape: 'prueba',
                    Segundo_Ape: 'prueba',
                    Tipo_Doc: 'prueba',
                    Num_Doc: '123',
                    Sexo: 'F',
                    Fecha_Afiliado: 'prueba',
                    Fecha_Naci: 'prueba',
                    Edad_Cumplida: '19',
                    Discapacidad: 'prueba',
                    Grado_Discapacidad: 'prueba',
                    Tipo_Afiliado: 'prueba',
                    Orden_Judicial: 'prueba',
                    Num_Folio: 'prueba',
                    Fecha_Emision: 'prueba',
                    Parentesco: 'prueba',
                    TipoDoc_Cotizante: 'prueba',
                    Doc_Cotizante: 'prueba',
                    Tipo_Cotizante: 'prueba',
                    Estado_Afiliado: '1',
                    Dane_Mpio: 'prueba',
                    Mpio_Afiliado: 'prueba',
                    Dane_Dpto: 'prueba',
                    Departamento: 'prueba',
                    Subregion: 'prueba',
                    Dpto_Atencion: 'prueba',
                    Mpio_Atencion: 'prueba',
                    IPS: 'prueba',
                    Sede_Odontologica: 'prueba',
                    Medicofamilia: 'prueba',
                    Etnia: 'prueba',
                    Nivel_Sisben: 'prueba',
                    Laboraen: 'prueba',
                    Mpio_Labora: 'prueba',
                    Direccion_Residencia: 'prueba',
                    Mpio_Residencia: 'prueba',
                    Telefono: 'prueba',
                    Correo: 'prueba',
                    Estrato: 'prueba',
                    Celular: 'prueba',
                    Sexo_Biologico: 'prueba',
                    Tipo_Regimen: 'prueba',
                    Num_Hijos: 'prueba',
                    Vivecon: 'prueba',
                    RH: 'prueba',
                }
            },
            editPaciente(){
                this.edit = true;
                this.dialog = true;
                this.save = false;
            },
            updatePaciente(){
                axios.put(`/api/paciente/edit/${this.data.id}`, this.data)
                    .then(res => {
                        this.emptyData();
                        this.dialog = false;
                        swal({
                            title: "¡Usuario Actualizado!",
                            text: " ",
                            type: "success",
                            timer: 2000,
                            icon: "success",
                            buttons: false
                        });
                    })
                    .catch(err => console.log('err.response.data', err.response.data))
            },
            disablePaciente(paciente){
                swal({
                    title: "¿Está Seguro(a)?",
                    text: "Una vez el usuario esté deshabilitado, ya no podrá ingresar al sistema!",
                    icon: "warning",
                    buttons: ["Cancelar","Confirmar"],
                    dangerMode: true,
                }).then((willDelete) => {
                    if(willDelete){    
                        axios.put(`/api/paciente/available/${paciente.id}`,{ estado_user: 2 })
                        .then(res => {
                            swal("¡Usuario Deshabilitado!",{
                                timer: 2000,
                                icon: "success",
                                buttons: false
                            });
                        })
                        .catch(err => console.log(err.response.data));
                    }
                })

            },
            getPaciente(){
                axios.get(`/api/paciente/getPaciente/${this.search}`)
                    .then(res => {
                            this.edit = false;
                            this.save = false;
                            this.data = res.data;
                            this.dialog = true;
                    })
                    .catch(err => console.log(err.response.data));
            }
        },
    }
</script>
<style lang="scss" scoped>

</style>