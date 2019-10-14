import Vue from 'vue'
import Vuex from 'vuex'

import getters from './getters'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
      menu: {
        title: '',
        items: 0,
        enabled: true
      },
      user: {
        apellido: '',
        celular: '',
        direccion: '',
        email: '',
        estado_user: '',
        fecha_naci: '',
        id: '',
        name: '',
        permissions: [],
        roles: [],
        avatar_url: ''
      },
  },
  modules: {
  },
  getters,
  mutations: {
    setUser: (state, user) => {
      state.user = user;
    },
    setMenu: (state, menu) => {
      state.menu.title = menu.title;
      state.menu.items = menu.items;
      state.menu.enabled = menu.enabled;

    }
  }
})

export default store
