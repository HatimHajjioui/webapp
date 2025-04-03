<template>
  <v-app id="inspire">
    <v-app-bar flat>
      <v-container class="mx-auto d-flex align-center justify-center">
        <v-avatar class="me-4" color="grey-darken-1" size="32"></v-avatar>

        <v-btn to="/" class="mx-2" variant="text">Home</v-btn>
        <v-btn to="/profile" class="mx-2" variant="text">Profile</v-btn>
        <v-btn to="/login" class="mx-2" variant="text">Login</v-btn>
        <v-btn to="/register" class="mx-2" variant="text">Register</v-btn>

        <v-spacer></v-spacer>
      </v-container>
    </v-app-bar>

    <v-container class="pa-4" max-width="400px">
      <v-card class="pa-4">
        <v-card-title class="text-center">Registrazione</v-card-title>

        <v-alert v-if="errorMessage" type="error" class="mb-3">
          {{ errorMessage }}
        </v-alert>

        <v-form @submit.prevent="register">
          <v-text-field v-model="name" label="Nome" required outlined dense></v-text-field>
          <v-text-field v-model="email" label="Email" type="email" required outlined dense></v-text-field>
          <v-text-field v-model="password" label="Password" type="password" required outlined dense></v-text-field>
          <v-text-field v-model="confirmPassword" label="Conferma Password" type="password" required outlined dense></v-text-field>

          <v-btn :loading="loading" color="primary" block class="mt-3" type="submit">Registrati</v-btn>
        </v-form>

        <v-card-actions class="justify-center mt-3">
          <v-btn variant="text" to="/login">Hai già un account? Accedi</v-btn>
        </v-card-actions>
      </v-card>
    </v-container>
  </v-app>
</template>

<script>
import axios from "axios";
import { useRouter } from "vue-router";

export default {
  data() {
    return {
      name: "",
      email: "",
      password: "",
      confirmPassword: "",
      errorMessage: "",
      loading: false,
    };
  },
  methods: {
    async register() {
      if (!this.name || !this.email || !this.password || !this.confirmPassword) {
        this.errorMessage = "Tutti i campi sono obbligatori!";
        return;
      }
      if (this.password.length < 6) {
        this.errorMessage = "La password deve avere almeno 6 caratteri!";
        return;
      }
      if (this.password !== this.confirmPassword) {
        this.errorMessage = "Le password non coincidono!";
        return;
      }

      this.loading = true;
      this.errorMessage = "";

      try {
        const response = await axios.post("http://localhost:5000/api/register", {
          name: this.name,
          email: this.email,
          password: this.password,
        });

        localStorage.setItem("token", response.data.token);
        this.$router.push("/dashboard");
      } catch (error) {
        this.errorMessage = error.response?.data?.message || "Errore durante la registrazione!";
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>
