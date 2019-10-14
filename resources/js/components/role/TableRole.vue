<template>
    <v-card>
        <v-container pa-1>
                <v-container pt-3 pb-1>
                    <v-layout row>
                        <v-dialog v-model="dialog" persistent max-width="600px">
                        <v-card>
                            <v-card-title>
                            <span v-if="save" class="headline">Crear Rol</span>
                            <span v-else class="headline">Editar Rol</span>
                            </v-card-title>
                            <v-card-text>
                            <v-container grid-list-md>
                                <v-layout wrap>
                                <v-flex xs12 sm6 md6>
                                    <v-text-field label="Nombre*" v-model="data.name" required></v-text-field>
                                </v-flex>
                                <v-checkbox
                                v-for="permiso in permissions"
                                :key="permiso.id"
                                v-model="data.permissions"
                                :label="permiso.name"
                                color="green"
                                :value="permiso.name"
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
                            <v-btn v-if="save" color="blue darken-1" flat @click="saveRole()">Guardar</v-btn>
                            <v-btn v-else color="blue darken-1" flat @click="updateRole()">Actualizar</v-btn>
                            </v-card-actions>
                        </v-card>
                        </v-dialog>
                    </v-layout>
                </v-container>
            <v-card-title>
            <v-btn round @click="createRole()" color="primary" dark><v-icon left>person_add</v-icon>Crear Rol</v-btn>
            <v-spacer></v-spacer>
            <v-flex 
            sm5
            xs1
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
                :headers="headers"
                :items="roles"
                :search="search"
                >
                <template v-slot:items="props">
                    <td>{{ props.item.id }}</td>
                    <td class="text-xs-right">{{ props.item.name }}</td>
                    <td class="text-xs-right">
                        <v-btn fab outline   color="warning" small @click="editRole(props.item)"><v-icon>edit</v-icon></v-btn>
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
        name:'TableRole',
        data() {
            return {
                roles: [],
                permissions: [],
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
                        text: '',
                        align: 'right',
                        sortable: false,
                        value: ''
                    }
                ],
                save: true,
                dialog: false,
                data:{
                    name: "admin",
                },
            }
        },
        mounted () {
            this.fetchRoles();
            this.fetchPermissions();
            //this.createRole()
        },
        methods: {
            fetchRoles() {
                axios.get('/api/role/all')
                    .then(res => this.roles = res.data);
            },
            fetchPermissions() {
                axios.get('/api/permiso/all')
                    .then(res => this.permissions = res.data);
            },
            createRole(){
                this.fetchPermissions();
                this.emptyData();
                this.save = true;
                this.dialog = true;
            },
            showError(message){
                swal({
                    title: "¡No puede ser!",
                    text: `${message.name}`,
                    icon: "warning",
                });
            },
            emptyData(){
                this.data = {
                    name: ''
                }
            },
            saveRole(){
                axios.post('/api/role/create',this.data)
                .then(res => {
                    this.emptyData();
                    this.dialog = false;
                    this.fetchRoles();
                    swal({
                        title: "¡Role Creado!",
                        text: " ",
                        type: "success",
                        timer: 2000,
                        icon: "success",
                        buttons: false
                    });
                })
                .catch(err => this.showError(err.response.data))
            },
            editRole(role){
                this.fetchPermissions();
                this.data = {
                    id: role.id,
                    name: role.name,
                    permissions: role.permissions.map(per => per.name)
                };
                this.save = false;
                this.dialog = true;
            },
            updateRole() {
                axios.put(`/api/role/edit/${this.data.id}`,this.data)
                    .then(res => {   
                        this.emptyData();
                        this.dialog = false;
                        this.fetchRoles();   
                        swal({
                            title: "¡Role Actualizado!",
                            text: " ",
                            timer: 2000,
                            icon: "success",
                            buttons: false
                        });
                    })
                    .catch(err => console.log(err.response.data));
            },
        },
    }
</script>
<style lang="scss" scoped>

</style>