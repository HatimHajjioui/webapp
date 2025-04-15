<template>
  <v-container class="mx-auto d-flex align-center justify-center">
    <v-avatar class="me-4" color="grey-darken-1" size="32"></v-avatar>

    <v-btn to="/" class="mx-2" variant="text">Home</v-btn>
    <v-btn to="/profile" class="mx-2" variant="text">Profile</v-btn>
    <v-btn to="/login" class="mx-2" variant="text">Login</v-btn>
    <v-btn to="/register" class="mx-2" variant="text">Register</v-btn>

    <v-spacer></v-spacer>
  </v-container>
  <v-container class="pa-4 mx-auto" max-width="500px">
    <v-card class="pa-4">
      <v-card-title class="text-center">Accedi</v-card-title>

      <v-alert v-if="successMessage" type="success" class="mb-3">{{ successMessage }}</v-alert>
      <v-alert v-if="errorMessage" type="error" class="mb-3">{{ errorMessage }}</v-alert>

      <v-form @submit.prevent="login">
        <v-text-field v-model="email" label="Email" type="email" outlined dense required />
        <v-text-field v-model="password" label="Password" type="password" outlined dense required />
        <v-btn :loading="loading" type="submit" color="primary" block class="mt-4"> Accedi </v-btn>
      </v-form>
    </v-card>
  </v-container>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      email: '',
      password: '',
      Tipo_Utente: '',
      loading: false,
      errorMessage: '',
      successMessage: '',
    }
  },
  methods: {
    async login() {
      this.errorMessage = ''
      this.successMessage = ''
      this.loading = true

      if (!this.email || !this.password) {
        this.errorMessage = 'Email e password sono obbligatori'
        this.loading = false
        return
      }

      try {
        const response = await axios
          .post('http://localhost:8080/login', {
            email: this.email,
            password: this.password,
          })

            console.log(response.data.utente.Tipo_Utente)
            if (response.data.messaggio) {
              this.successMessage = response.data.messaggio
              console.log('utente:', response.data.utente)

              // Salva l'utente nel localStorage (opzionale)
              localStorage.setItem('Utente', JSON.stringify(response.data.utente))
              if (response.data.utente.Tipo_Utente === 2) {
                this.$router.push('/teacher')
              } else if (response.data.utente.Tipo_Utente === 3) {
                this.$router.push('/student')
              } else if (response.data.utente.Tipo_Utente === 1) {
                this.$router.push('/administrator')
              }
            } else {
              this.errorMessage = response.data.errore || 'Credenziali errate'
            }

      } catch (err) {
        this.errorMessage = err.response?.data?.errore || 'Errore durante il login'
      } finally {
        this.loading = false
      }
    },
  },
}
</script>
