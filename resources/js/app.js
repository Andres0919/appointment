import './bootstrap';
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import '@mdi/font/css/materialdesignicons.css'

import Vue from 'vue';
import VeeValidate, { Validator } from 'vee-validate';
import es from 'vee-validate/dist/locale/es';

import store from './store'
import router from './router'

import Vuetify from 'vuetify';
Vue.use(Vuetify,{
    theme:{
        primary: '#01c0c8', //'#0064ff',   //'#01c0c8', // #E53935
        secondary: '#ffffff',
        accent: '#f4f4f4', //'#eeeeee',
        home: '#333333', 
        nav_hc: '#457aff',
        iconfont: 'md'
    },

})

Vue.use(VeeValidate);

Validator.localize("es", es);

import '../stylus/main.styl'
import 'vuetify/dist/vuetify.min.css'


import App from './views/App.vue';



const app = new Vue({
    el: '#app',
    store,
    router,
    component: App,
    render: (h) => h(App),
});
