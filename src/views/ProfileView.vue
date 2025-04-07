<template>
  <v-app id="inspire">
    <v-app-bar flat>
      <v-container class="mx-auto d-flex align-center justify-center">
        <v-avatar class="me-4" color="grey-darken-1" size="32"></v-avatar>

        <!-- Barra di navigazione -->
        <v-btn to="/" class="mx-2" variant="text">Home</v-btn>
        <v-btn to="/profile" class="mx-2" variant="text">Profile</v-btn>
        <v-btn to="/login" class="mx-2" variant="text">Login</v-btn>
        <v-btn to="/register" class="mx-2" variant="text">Register</v-btn>

        <v-spacer></v-spacer>
      </v-container>
    </v-app-bar>
    <v-container class="pa-4" max-width="800px">
      <v-row>
        <v-col cols="12" class="d-flex justify-center">
          <!-- Foto del profilo -->
          <v-avatar size="120" class="mb-4">
            <img src="https://via.placeholder.com/150" alt="User Avatar" />
          </v-avatar>
        </v-col>
      </v-row>

      <!-- Informazioni del profilo -->
      <v-row>
        <v-col cols="12" sm="6">
          <v-text-field label="Nome" v-model="user.name" outlined dense></v-text-field>
        </v-col>
        <v-col cols="12" sm="6">
          <v-text-field label="Email" v-model="user.email" outlined dense></v-text-field>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12">
          <v-textarea label="Bio" v-model="user.bio" outlined dense rows="4"></v-textarea>
        </v-col>
      </v-row>

      <!-- Sezione per cambiare la password -->
      <v-divider class="my-4"></v-divider>

      <v-row>
        <v-col cols="12" sm="6">
          <v-text-field
            label="Nuova password"
            v-model="user.newPassword"
            type="password"
            outlined
            dense
          ></v-text-field>
        </v-col>
        <v-col cols="12" sm="6">
          <v-text-field
            label="Conferma password"
            v-model="user.confirmPassword"
            type="password"
            outlined
            dense
          ></v-text-field>
        </v-col>
      </v-row>

      <!-- Bottone per salvare -->
      <v-row>
        <v-col cols="12" class="d-flex justify-center">
          <v-btn color="primary" @click="saveProfile">Salva Profilo</v-btn>
        </v-col>
      </v-row>
    </v-container>
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      user: {
        name: 'Giovanni Rossi',
        email: 'giovanni@example.com',
        bio: 'Sviluppatore web appassionato di Vue.js e Vuetify.',
        newPassword: '',
        confirmPassword: '',
      },
    }
  },
  methods: {
    saveProfile() {
      // Logica per salvare il profilo (per esempio, invio dati a un server)
      if (this.user.newPassword !== this.user.confirmPassword) {
        alert('Le password non corrispondono!')
      } else {
        alert('Profilo salvato correttamente!')
      }
    },
  },
}
</script>

<style scoped>
/* Puoi aggiungere stili personalizzati qui */
</style>
