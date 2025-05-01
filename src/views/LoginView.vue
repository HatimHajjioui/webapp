<template>
  <div class="login-view">
    <header class="hero">
      <h1>Accedi al Portale Studenti</h1>
      <p>Benvenuto! Inserisci le tue credenziali per continuare.</p>
    </header>

    <main class="form-container">
      <div class="form-box">
        <h2>Login</h2>

        <v-alert v-if="successMessage" type="success" class="mb-3">{{ successMessage }}</v-alert>
        <v-alert v-if="errorMessage" type="error" class="mb-3">{{ errorMessage }}</v-alert>

        <v-form @submit.prevent="login">
          <v-text-field v-model="email" label="Email" type="email" outlined dense required />
          <v-text-field
            v-model="password"
            :type="showPassword ? 'text' : 'password'"
            label="Password"
            outlined
            dense
            required
            :append-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
            @click:append="showPassword = !showPassword"
          />
          <v-btn :loading="loading" type="submit" color="primary" block class="mt-4">
            Accedi
          </v-btn>
        </v-form>
        <v-card-actions class="justify-center mt-4">
          <RouterLink to="/">
            <v-btn color="secondary" variant="outlined">Torna alla Home</v-btn>
          </RouterLink>
        </v-card-actions>


        <div class="extra-links mt-4">
          <RouterLink to="/register">Non hai un account? Registrati</RouterLink>
        </div>
      </div>
    </main>

    <footer>
      <p>&copy; 2025 Istituto Galileo Galilei - Tutti i diritti riservati</p>
    </footer>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      email: '',
      password: '',
      loading: false,
      errorMessage: '',
      successMessage: '',
      showPassword: false,
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
        const response = await axios.post('http://localhost:8080/login', {
          email: this.email,
          password: this.password,
        })

        if (response.data.messaggio) {
          this.successMessage = response.data.messaggio
          // Aggiungi l'ID_Studente all'oggetto utente prima di salvarlo
          // In LoginView.vue, modifica la parte di salvataggio
          localStorage.setItem('Utente', JSON.stringify({
            ...response.data.utente,
            ID_Studente: response.data.utente.ID_Studente
          }));

          const tipo = response.data.utente.ID_Ruolo
          if (tipo === 2) this.$router.push('/teacher')
          else if (tipo === 3) this.$router.push('/student')
          else if (tipo === 1) this.$router.push('/administrator')
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

<style scoped>
.login-view {
  font-family: 'Segoe UI', sans-serif;
  color: #333;
  background: linear-gradient(to right, #00b4db, #0083b0);
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.hero {
  text-align: center;
  color: white;
  padding: 3rem 1rem 2rem;
}
.hero h1 {
  font-size: 2.5rem;
}
.hero p {
  font-size: 1.2rem;
  margin-top: 0.5rem;
}

.form-container {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-grow: 1;
}

.form-box {
  background: white;
  padding: 2rem;
  border-radius: 16px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  width: 100%;
  max-width: 400px;
}

.form-box h2 {
  text-align: center;
  margin-bottom: 1.5rem;
  font-size: 1.8rem;
  color: #007bff;
}

.extra-links {
  text-align: center;
}
.extra-links a {
  color: #007bff;
  text-decoration: none;
  font-weight: bold;
}
.extra-links a:hover {
  text-decoration: underline;
}

footer {
  text-align: center;
  padding: 1rem;
  background-color: #007bff;
  color: white;
}
</style>
