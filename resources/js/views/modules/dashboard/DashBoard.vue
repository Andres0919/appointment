<template>
    <v-container fill-height>
        <v-layout row wrap>
            <v-flex
                v-for="card in cards"
                :key="card.title"
                xs3
                xl3
                md3
                >
                <v-hover>
                    <v-card
                    slot-scope="{ hover }"
                    :class="`elevation-${hover ? 24 : 2} mx-auto border-card`"
                    class="primary--text"
                    :to="card.path"
                    width="70%"
                    >
                        <v-layout 
                            justify-center
                            >
                            <v-flex 
                                text-xs-center
                                py-0
                                >
                            
                                <v-img
                                    class="border-top"
                                    height="150"
                                    size="150"
                                    :src="card.src">
                                </v-img>
                            </v-flex>
                        </v-layout>
                        <v-layout 
                            row 
                            wrap
                            justify-center
                            >          
                                <v-card-title>
                                    <div>
                                        <span class="headline home--text">{{ card.title }}</span>
                                    </div>
                                </v-card-title>
                        </v-layout>
                    </v-card>
                </v-hover>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
export default {
    name: 'DashBoard',
    data () {
      return {
        e1: 0,
        cards: [
            { title: 'Agendamiento', src: '/storage/images/agendamiento.jpg', flex: 12 },
            { title: 'Citas', src: '/storage/images/citas.jpg', flex: 12 },
            { title: 'Administración', src: '/storage/images/administracion.jpg', flex: 12, path: '/admin/users' },
        ]
      }
    },
    mounted(){
        this.setMenu();
    },
    methods:{
        setMenu(){
            this.$store.commit('setMenu', {
                title: 'Inicio',
                items: 0,
                enabled: false
            })
        }
    }
}
</script>
<style scope>
     .border-card{
         border-radius: 3%;
     }
     .border-top{
         border-radius: 3% 3% 0 0;
     }

</style>