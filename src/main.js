//import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import axios from "axios";

import App from './App.vue'
import router from './router'

import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
  components,
  directives,
})

const app = createApp(App)
app.config.globalProperties.$axios = axios; // ✅ Rende axios disponibile globalmente
app.use(createPinia())
app.use(router)
app.use(vuetify)
app.mount('#app')
import { useRouter } from "vue-router";

export default {
  setup() {
    const router = useRouter(); // Inizializza il router
    return { router };
  },
  methods: {
    async register() {
      try {
        const response = await axios.post("http://localhost:3306/api/register", {
          name: this.name,
          email: this.email,
          password: this.password,
        });

        localStorage.setItem("token", response.data.token);
        this.router.push("/dashboard"); // Usa `this.router`
      } catch (error) {
        this.errorMessage = "Errore durante la registrazione!";
      }
    },
  },
};
