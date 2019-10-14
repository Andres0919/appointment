<template>
    <v-card min-height="100%">
        <v-container pa-1>
            <v-container pt-3 pb-1>
                <v-layout row>
                    <v-dialog v-model="dialog" persistent max-width="976px">
                    <v-card>
                        <v-card-title>
                        <span v-if="save" class="headline">Crear Usuario</span>
                        <span v-else class="headline">Editar Usuario</span>
                        </v-card-title>
                        <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                            <v-flex xs12 sm6 md6>
                                <v-text-field label="Nombre*" v-model="data.name" required></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6 md6>
                                <v-text-field label="Apellido" v-model="data.apellido" ></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6 md6>
                                <v-text-field label="Número de Cédula" v-model="data.cedula" ></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6 md6>
                                <v-text-field label="Correo Electrónico*" v-model="data.email" required></v-text-field>
                            </v-flex>
                            <v-flex xs12 v-if="save">
                                <v-text-field label="Contraseña*" v-model="data.password" type="password" required></v-text-field>
                            </v-flex>
                            <v-flex xs12 v-if="save">
                                <v-text-field label="Confirmar contraseña*" v-model="data.password_confirmation" type="password" required></v-text-field>
                            </v-flex>
                            <v-checkbox
                            v-for="role in roles"
                            :key="role.id"
                            v-model="data.roles"
                            :label="role.name"
                            color="green"
                            :value="role.name"
                            hide-details
                            multiple
                            ></v-checkbox>
                            <!-- <pre>{{data}}</pre> -->
                            </v-layout>
                        </v-container>
                        </v-card-text>
                        <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" flat @click="dialog = false">Cancelar</v-btn>
                        <v-btn v-if="save" color="blue darken-1" flat @click="registerUser()">Guardar</v-btn>
                        <v-btn v-else color="blue darken-1" flat @click="updateUser()">Actualizar</v-btn>
                        </v-card-actions>
                    </v-card>
                    </v-dialog>
                </v-layout>
            </v-container>
            <v-card-title>
                <v-btn round color="primary" @click="createUser()" dark><v-icon left>person_add</v-icon>Crear usuario</v-btn>
                <v-spacer></v-spacer>
                <v-flex 
                 xs12
                 sm5
                 >
                    <v-text-field
                        v-model="search"
                        append-icon="search"
                        label="Buscar..."
                        single-line
                        hide-details
                    ></v-text-field>
                </v-flex>
            </v-card-title>
            <v-data-table
                class="elevation-1"
                :headers="headers"
                :items="users"
                :search="search"
                >
                <template v-slot:items="props">
                    <td>{{ props.item.id }}</td>
                    <td class="text-xs-right">{{ props.item.name }}</td>
                    <td class="text-xs-right">{{ props.item.email }}</td>
                    <td class="text-xs-right">{{ props.item.estado_user | estado_u }}</td>
                    <td class="text-xs-right">
                        <v-tooltip top>
                            <template v-slot:activator="{ on }">
                                <v-btn fab outline color="warning" small v-on="on" @click="editUser(props.item)"><v-icon>edit</v-icon></v-btn>
                            </template>
                            <span>Editar</span>
                        </v-tooltip>
                        <v-tooltip top>
                            <template v-slot:activator="{ on }">
                                <v-btn fab outline color="error" small v-on="on" @click="disableUser(props.item)"><v-icon>person_add_disabled</v-icon></v-btn>
                            </template>
                            <span>Inactivar</span>
                        </v-tooltip>
                        
                    </td>                
                </template>
                <v-alert v-slot:no-results :value="true" color="error" icon="warning">
                    Your search for "{{ search }}" found no results.
                </v-alert>
            </v-data-table>
        </v-container>
    </v-card>
</template>

<script>
    export default {
        data() {
            return {
                users: [],
                search: '',
                headers: [
                    {
                        text: 'id',
                        align: 'left',
                        value: 'id'
                    },
                    {
                        text: 'Nombre',
                        align: 'right',
                        sortable: false,
                        value: 'name'
                    },
                    { 
                        text: 'Correo Electrónico',
                        align: 'right', 
                        sortable: false,
                        value: 'email' 
                    },
                    { 
                        text: 'Estado',
                        align: 'right',
                        sortable: false,
                        value: 'estado_user' 
                    },
                    { 
                        text: '',
                        align: 'right',
                        sortable: false,
                        value: 'actions' 
                    },
                ],
                dialog: false,
                save: true,
                data:{
                    name: '',
                    apellido: '',
                    cedula: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    roles: null
                },
                roles: null
            }
        },
        filters: {
            estado_u: function(value) {
                if(value == 1){
                    return 'Activo'
                }else if(value !== 2){
                    return 'Inactivo';
                }
            }
        },
        mounted () {
            this.fetchUsers();
            this.getRoles()
            //this.createRole()
        },
        methods: {
            fetchUsers() {
                axios.get('/api/user/all')
                    .then(res => this.users = res.data);
            },
            createUser(){
                this.emptyData();
                this.dialog = true;
                this.save = true;
            },
            registerUser() {
                axios.post('/api/user/create', this.data)
                    .then((res) => {
                        this.emptyData();
                        this.dialog = false;
                        this.fetchUsers()
                        swal({
                            title: "¡Usuario Creado!",
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
                    title: "¡No puede ser!",
                    text: `${message.email}`,
                    icon: "warning",
                });
            },
            emptyData(){
                this.data = {
                    name: '',
                    apellido: '',
                    cedula: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    roles: null
                }
            },
            getRoles(){
                axios.get('/api/role/all')
                .then(res => this.roles = res.data)
                .catch(err => console.log('err.response.data :', err.response.data))
            },
            editUser(row){
                this.data = {
                    id: row.id,
                    name: row.name,
                    apellido: row.apellido,
                    email: row.email,
                    roles: row.roles.map(rol => rol.name)
                }
                this.dialog = true;
                this.save = false;
            },
            updateUser(){
                axios.put(`/api/user/edit/${this.data.id}`, this.data)
                    .then(res => {
                        this.emptyData();
                        this.dialog = false;
                        this.fetchUsers();
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
            disableUser(user){
                swal({
                    title: "¿Está Seguro(a)?",
                    text: "Una vez el usuario esté deshabilitado, ya no podrá ingresar al sistema!",
                    icon: "warning",
                    buttons: ["Cancelar","Confirmar"],
                    dangerMode: true,
                }).then((willDelete) => {
                    if(willDelete){    
                        axios.put(`/api/user/available/${user.id}`,{ estado_user: 2 })
                        .then(res => {
                            this.fetchUsers();
                            swal("¡Usuario Deshabilitado!",{
                                timer: 2000,
                                icon: "success",
                                buttons: false
                            });
                        })
                        .catch(err => console.log(err.response.data));
                    }
                })

            }
        },
    }
</script>
<style scoped>
table.v-table tbody td, table.v-table tbody th {
    height: 19px;
}
</style>