<template>
    <div>
        <v-navigation-drawer
         :clipped="drawer.clipped"
         :fixed="drawer.fixed"
         :permanent="drawer.permanent"
         :mini-variant="drawer.mini"
         v-model="drawer.open"
         class="secondary"
         width="210"
         app
         >
            <v-list>
                <v-list-tile>
                    <v-list-tile-action>
                        <img 
                         width="50" alt="">
                    </v-list-tile-action>
                    <v-list-tile-content>
                    </v-list-tile-content>
                </v-list-tile>
                <VDivider />

                
                <template v-for="item in items">
                    <v-list-tile :to="item.ruta" :key="item.tittle">
                        <v-tooltip right>
                            <v-list-tile-action slot="activator">
                                    <v-icon>{{ item.icon }}</v-icon>
                            </v-list-tile-action>
                            <span>{{ item.title }}</span>
                        </v-tooltip>

                        <v-list-tile-content>
                            <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <VDivider :key="item.tittle" />
                </template>
            </v-list>
        </v-navigation-drawer>
        <v-toolbar
         class="elevation-1"
         color="primary"
         dark
         app
         height="50"
         :fixed="toolbar.fixed"
         :clipped-left="toolbar.clippedLeft"
         >
            <v-toolbar-side-icon 
                @click.stop="toggleMiniDrawer"
                class="hidden-md-and-up"
            ></v-toolbar-side-icon>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-menu offset-y>
                    <template v-slot:activator="{on}">
                        <v-btn v-on="on" small flat>
                            {{ nameUser }}
                            <v-flex ml-2>
                                <v-avatar size="40">
                                    <img :src="avatar" />
                                </v-avatar>
                            </v-flex>
                        </v-btn>
                    </template>
                    <v-list>
                        <v-list-tile>
                            <v-list-tile-title>Perfil</v-list-tile-title>
                        </v-list-tile>
                        <v-list-tile @click="logout()">
                            <v-list-tile-title>Cerrar Sesión</v-list-tile-title>
                        </v-list-tile>
                    </v-list>
                </v-menu>
            </v-toolbar-items>
        </v-toolbar>
    </div>
</template>
<script>
    import { mapState, mapMutations, mapGetters } from 'vuex';
    export default {
        name: 'Layout',
        data() {
            return {
                items: [
                    { title: 'Inicio', icon: 'home', ruta: '/' },
                    { title: 'Módulo Agenda', icon: 'event_note', ruta: '/agenda' },
                    { title: 'Módulo Citas', icon: 'event', ruta: '/citas' },
                    { title: 'Módulo Administración', icon: 'settings', ruta: '/admin/users' },
                ],
                drawer: {
                    // sets the open status of the drawer
                    open: true,
                    // sets if the drawer is shown above (false) or below (true) the toolbar
                    clipped: false,
                    // sets if the drawer is CSS positioned as 'fixed'
                    fixed: true,
                    // sets if the drawer remains visible all the time (true) or not (false)
                    permanent: true,
                    // sets the drawer to the mini variant, showing only icons, of itself (true) 
                    // or showing the full drawer (false)
                    mini: true
                },
                toolbar: {
                    //
                    fixed: true,
                    // sets if the toolbar contents is leaving space for drawer (false) or not (true)
                    clippedLeft: false
                },
                show: null,
            }
        },
        computed: {
            ...mapState(['user']),
            ...mapGetters(['fullName','can','avatar']),
            nameUser(){ return this.fullName.substring(0,20); },
        },
        methods: {
            // toggles the drawer variant (mini/full)
            toggleMiniDrawer () {
                this.drawer.mini = !this.drawer.mini
            },
            logout(){
                axios.get('/api/auth/logout')
                    .then(res => {
                        localStorage.removeItem('_token');
                        this.goLogin();
                    });
            },
            goLogin() { this.$router.push('/login')},
        },
    }
</script>
<style scope>
</style>