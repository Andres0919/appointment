<template>
    <v-content id="imglogin">
        <v-container fill-height>
            <v-layout align-center justify-center>
                <v-flex xs8 md6>
                    <v-flex xs12>
                        <h1 class="white--text sombra display-1">Bienvenido</h1>
                    </v-flex>
                    <FormLogin />
                </v-flex>
            </v-layout>
        </v-container>
    </v-content>
</template>
<script>
import FormLogin from '../../components/auth/FormLogin'
export default {
    name: 'Login',
    components: {
        FormLogin
    }
}
</script>
<style>
    #imglogin{
        background: rgba(179,220,237,1);
        background: -moz-linear-gradient(-45deg, rgba(179,220,237,1) 0%, rgba(41,184,229,1) 50%, rgba(188,224,238,1) 100%);
        background: -webkit-gradient(left top, right bottom, color-stop(0%, rgba(179,220,237,1)), color-stop(50%, rgba(41,184,229,1)), color-stop(100%, rgba(188,224,238,1)));
        background: -webkit-linear-gradient(-45deg, rgba(179,220,237,1) 0%, rgba(41,184,229,1) 50%, rgba(188,224,238,1) 100%);
        background: -o-linear-gradient(-45deg, rgba(179,220,237,1) 0%, rgba(41,184,229,1) 50%, rgba(188,224,238,1) 100%);
        background: -ms-linear-gradient(-45deg, rgba(179,220,237,1) 0%, rgba(41,184,229,1) 50%, rgba(188,224,238,1) 100%);
        background: linear-gradient(135deg, rgba(179,220,237,1) 0%, rgba(41,184,229,1) 50%, rgba(188,224,238,1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b3dced', endColorstr='#bce0ee', GradientType=1 );
    }
    html{
        overflow-y: auto !important;
        overflow-x: auto !important;
    }
    .sombra{
        box-shadow: 10px
    }
</style>