<template>
    <v-tabs 
        v-if="menu.enabled"
        height="60"
        fixed-tabs
        class="elevation-5"
        color="secondary"
        slider-color="primary"
        show-arrows
        >
        <v-flex 
            pl-5
            align-self-center
            >
            <h2 
                >{{ menu.title }} </h2>
        </v-flex>
            
        <v-spacer></v-spacer>
        <v-tab
            v-for="item in menu.items"
            :key="item.name"
            :to="item.path"
            >
            {{ item.name }}
        </v-tab>
    </v-tabs>
</template>

<script>
    export default {
        computed:{
            menu(){
                return this.$store.state.menu;
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>