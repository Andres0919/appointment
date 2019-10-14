<template>
    <v-app>
        <Layout />
        <v-content>
            <Tabs />
            <v-container class="accent" fluid fill-height>
                <RouterView />
            </v-container>
            <Footer />
        </v-content>
    </v-app>
</template> 
<script>
    import Layout from '../../components/layout/Layout'
    import Tabs from '../../components/layout/Tabs'
    import Footer from '../../components/layout/Footer'
    import {EventBus} from '../../event-bus.js';


    export default {
        name: 'Home',
        components:{
            Layout,
            Tabs,
            Footer,
        },
        data () {
            return {
                hc: false,
                paciente: null,
                nameDialog: '',
                dialogOpen: false

            }
        },
        mounted(){
            this.getUserInfo();
        },
        methods:{
            getUserInfo(){
                axios.get('/api/auth/user')
                        .then((res) => this.$store.commit('setUser',res.data.user))
                        .catch((res) => {
                            localStorage.removeItem('_token');
                            this.goLogin();
                        })
            },
            goLogin() { this.$router.push('/login')},
            opendialog(nameDialog) {
                this.nameDialog =nameDialog
                this.dialogOpen = true;
            }
        }
    }
</script>
<style scope>
    .buttom-nav-hc{
        width: 50% !important;
        margin: 0 25% !important;
        border-radius: 25px;
        /* border-radius: 25px 25px 0 0; */
    }

    
</style>