<template>
    <v-layout
     wrap
     >
        <v-flex 
         v-for="medico in medicos"
         :key="medico.id"
         shrink 
         xs3
         >
            <v-card
                class="mx-1 my-1 elevation-3 border-card"
                style="max-width: 300px;"
                >
                <v-layout>
                    <v-flex xs8>
                        <v-card-title primary-title>
                        <div>
                            <div class="headline">{{ medico.name }} {{ medico.apellido }}</div>
                            <div>Médico General</div>
                            <div>(2013)</div>
                        </div>
                        </v-card-title>
                    </v-flex>
                    <v-img
                        class="shrink ma-2"
                        :src="medico.avatar_url"
                        style="flex-basis: 125px"
                    ></v-img>
                </v-layout>
                <v-divider></v-divider>
                <v-card-actions class="pa-3">
                    <v-spacer></v-spacer>
                    <span class="grey--text text--lighten-2 caption mr-2">
                        ({{ rating }})
                    </span>
                    <v-rating
                      v-model="rating"
                      :length="length"
                      :empty-icon="emptyIcon"
                      :full-icon="fullIcon"
                      :half-icon="halfIcon"
                      :half-increments="halfIncrements"
                      :hover="hover"
                      :readonly="readonly"
                      color="red lighten-3"
                      background-color="grey lighten-1"
                      small
                    >                    
                    </v-rating>
                </v-card-actions>
            </v-card>
        </v-flex>
        

    </v-layout>
</template>

<script>
 
    export default {
        name: 'Medicos',
        components: {
        },
        data(){
            return {
                emptyIcon: 'mdi-heart-outline',
                fullIcon: 'mdi-heart',
                halfIcon: 'mdi-heart-half-full',
                halfIncrements: true,
                hover: true,
                length: 5,
                rating: 2,
                readonly: false,
                medicos: []
            }
        },
        mounted(){
            this.fetchMedicos();
        },
        methods: {
            fetchMedicos(){
                axios.get('/api/user/medicos')
                    .then(res => this.medicos = res.data);
            },            
        },
    }
</script>

<style lang="scss" scoped>
  .border-card{
    border-radius: 1em;
  }
</style>