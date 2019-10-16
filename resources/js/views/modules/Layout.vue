<template>
  <v-app>
    <Layout />
    <v-content>
      <Hclinica v-if="hc" :paciente="paciente" class="top-nav-hc" />
      <Tabs />
      <v-container class="accent" fluid fill-height>
        <Dialogs :dialogOpen="dialogOpen" :paciente="paciente" :nameDialog="nameDialog"></Dialogs>
        <RouterView />
        <!-- <v-btn fixed dark fab bottom right color="pink" @click="hc = !hc">
		  <v-icon>expand_less</v-icon>
        </v-btn>-->
      </v-container>
      <v-layout row wrap justify-center>
        <v-flex xs12>
          <v-bottom-nav
            class="buttom-nav-hc"
            color="nav_hc"
            :value="true"
            fixed
            dark
            shift
            v-if="hc"
          >
            <v-btn dark v-on:click="opendialog('Historial Examenes')">
              <span>Historial examenes</span>
              <v-icon>assignment_turned_in</v-icon>
            </v-btn>

            <v-btn dark v-on:click="opendialog('Historial Medicamentos')">
              <span>Historial medicamentos</span>
              <v-icon>mdi-pill</v-icon>
            </v-btn>

            <v-btn dark v-on:click="opendialog('Ordenamiento')">
              <span>Ordenamiento</span>
              <v-icon>add_shopping_cart</v-icon>
            </v-btn>

            <v-btn dark v-on:click="opendialog('Historial Consulta')">
              <span>Historial consultas</span>
              <v-icon>assignment_ind</v-icon>
            </v-btn>

            <v-btn dark v-on:click="opendialog('Historial Imagenología')">
              <span>Historial imagenología</span>
              <v-icon>assignment_ind</v-icon>
            </v-btn>
          </v-bottom-nav>
        </v-flex>
      </v-layout>
      <Footer />
    </v-content>
  </v-app>
</template> 
<script>
import Layout from "../../components/layout/Layout";
import Tabs from "../../components/layout/Tabs";
import Footer from "../../components/layout/Footer";
import Hclinica from "../../components/layout/Hclinica";
import Dialogs from "../../components/historia_clinica/Dialogs";
import { EventBus } from "../../event-bus.js";
import { setTimeout } from "timers";

export default {
  name: "Home",
  components: {
    Layout,
    Tabs,
    Footer,
    Hclinica,
    Dialogs
  },
  data() {
    return {
      hc: false,
      paciente: null,
      nameDialog: "",
      Diagnostico: '',
      path: '',
      dialogOpen: false
    };
  },
  created() {
    EventBus.$on("informacion-paciente-layout", paciente => {
      this.paciente = paciente;
      this.hc = true;
    });

    EventBus.$on("disable-layout-hc", () => {
      this.hc = false;
    });

    EventBus.$on("enviar-paciente", nameEvent => {
      EventBus.$emit(nameEvent, this.paciente);
    });

    EventBus.$on("close-dialog", () => {
      this.dialogOpen = false;
      this.nameDialog = "";
      // this.$router.go();
    });

    EventBus.$on("call-order", paciente => {
      setTimeout(() => {
        this.opendialog((this.nameDialog = "Ordenamiento"));
        if (paciente) {
          EventBus.$emit("informacion-paciente-layout", paciente);
        }
      }, 2000);
    });
    
  },
  mounted() {
    this.getUserInfo();
  },
  methods: {
    getUserInfo() {
      axios
        .get("/api/auth/user")
        .then(res => {
          this.$store.commit("setUser", res.data.user);
        })
        .catch(res => {
          localStorage.removeItem("_token");
          this.goLogin();
        });
    },
    goLogin() {
      this.$router.push("/login");
    },
    opendialog(nameDialog) {
      this.getLocalStorage();
      if (nameDialog == "Ordenamiento" && this.Diagnostico == '' && this.path.includes('historiaclinica')) {
        swal({
          title: "Conducta",
          text:
          "Por favor ingrese un diagnostico principal!",
          timer: 2000,
          icon: "error",
          buttons: false
        });
        return;
      }

      this.nameDialog = nameDialog;
      this.dialogOpen = true;
    },
    getLocalStorage() {
      this.path = this.$route.path;
      let Diagnostico = JSON.parse(localStorage.getItem("Diagnostico"));
      if (Diagnostico) {
        this.Diagnostico = Diagnostico;
      }
    }
  }
};
</script>
<style scope>
.buttom-nav-hc {
  width: 50% !important;
  margin: 0 25% !important;
  border-radius: 25px;
  /* border-radius: 25px 25px 0 0; */
}
</style>