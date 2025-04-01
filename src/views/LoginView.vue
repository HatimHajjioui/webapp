<template>
  <v-app id="inspire">
    <v-app-bar flat>
      <v-container class="mx-auto d-flex align-center justify-center">
        <v-avatar class="me-4" color="grey-darken-1" size="32"></v-avatar>

        <!-- Barra di navigazione -->
        <v-btn to='/' class="mx-2" variant="text">Home</v-btn>
        <v-btn to='/profile' class="mx-2" variant="text">Profile</v-btn>
        <v-btn to='/login' class="mx-2" variant="text">Login</v-btn>
        <v-spacer></v-spacer>


      </v-container>
    </v-app-bar>
  <v-container class="pa-4" max-width="400px">
    <v-row class="d-flex justify-center">
      <v-col cols="12">
        <v-avatar size="120" class="mb-4">
          <!-- Logo o immagine del profilo -->
          <img src="https://via.placeholder.com/150" alt="Logo" />
        </v-avatar>
      </v-col>
    </v-row>

    <!-- Modulo di login -->
    <v-row>
      <v-col cols="12">
        <v-text-field
          label="Email"
          v-model="email"
          type="email"
          outlined
          dense
          required
        ></v-text-field>
      </v-col>

      <v-col cols="12">
        <v-text-field
          label="Password"
          v-model="password"
          type="password"
          outlined
          dense
          required
        ></v-text-field>
      </v-col>
    </v-row>

    <!-- Pulsante di login -->
    <v-row>
      <v-col cols="12" class="d-flex justify-center">
        <v-btn color="primary" @click="login">Accedi</v-btn>
      </v-col>
    </v-row>


  </v-container>
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      email: '',
      password: '',
    };
  },
  methods: {
    login() {
      if (this.email && this.password) {
        // Logica per il login (ad esempio chiamata a un'API)
        alert(`Login eseguito con successo! Email: ${this.email}`);
      } else {
        alert("Per favore, inserisci email e password.");
      }
    },
  },
};
</script>

<style scoped>
/* Puoi aggiungere stili personalizzati qui */
</style>
