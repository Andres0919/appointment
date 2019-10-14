<template>
    <form>
        <v-flex xs9>
            <v-text-field
                v-model="data.email"
                v-validate="'required|email'"
                :error-messages="errors.collect('email')"
                label="Correo Electrónico"
                data-vv-name="email"
                required
                dark
            ></v-text-field>
        </v-flex>
        <v-flex xs9>
            <v-text-field
            v-model="data.password"
            :append-icon="show1 ? 'visibility' : 'visibility_off'"
            :type="show1 ? 'text' : 'password'"
            label="Contraseña"
            @click:append="show1 = !show1"
            required
            dark
            ></v-text-field>
        </v-flex>
        <v-layout justify-center>
        <v-flex xs5>
            <v-btn color="primary" @click="submit">Ingresar</v-btn>            
        </v-flex>
        </v-layout>
    </form>
</template>
<script>
import Vue from 'vue';
import { mapMutations } from 'vuex';
import VeeValidate from 'vee-validate'
import swal from 'sweetalert';

Vue.use(VeeValidate)

    export default {
        name: 'FormLogin',
        $_veeValidate: {
        validator: 'new'
        },

        data: () => ({
            show1: false,
            data: {
                email: 'cristian.alvarez@sumimedical.com',
                password: 'secret',
                remember_me: true
            },
            dictionary: {
                attributes: {
                    email: 'E-mail Address',
                    password: 'password',
                    name
                    // custom attributes
                },
                custom: {
                    email: {
                        required: () => 'Correo electrónico no puede estar vacio',
                    },
                    password: {
                        required: () => 'Contraseña no puede estar vacia',
                    }
                }
            }

        }),

        mounted () {
            this.$validator.localize('es', this.dictionary)
        },
    
        methods: {
            submit () {
                this.$validator.validateAll()
                .then((res) => this.login())
            },
            goHome() { this.$router.push('/')},
            login() {
                axios.post('/api/auth/login', this.data)
                .then((res) => {
                    localStorage.setItem('_token',res.data.access_token);
                    axios.defaults.headers.common['Authorization'] = `${res.data.token_type} ${res.data.access_token}`;
                    this.$store.commit('setUser',res.data.user);
                    swal({
                        title: "¡Bienvenido!",
                        text: " ",
                        type: "success",
                        timer: 2000,
                        icon: "success",
                        buttons: false
                    });
                    this.goHome()
                })
                .catch((err) => this.showError(err.response.data.message));

            },
            showError: (message) => {
                swal({
                    title: "¡No puede ser!",
                    text: `${message}`,
                    icon: "warning",
                });
            }
        }
    }
</script>
