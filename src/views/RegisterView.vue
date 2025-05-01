<template>
  <div class="register-view">
    <header class="hero">
      <h1>Crea il tuo account</h1>
      <p>Unisciti alla nostra comunità scolastica!</p>
    </header>

    <main class="form-container">
      <div class="form-box">
        <h2>Registrazione</h2>

        <v-alert v-if="errorMessage" type="error" class="mb-3">
          {{ errorMessage }}
        </v-alert>

        <v-form @submit.prevent="register">
          <v-text-field v-model="nome" label="Nome" required outlined dense></v-text-field>
          <v-text-field v-model="cognome" label="Cognome" required outlined dense></v-text-field>
          <v-text-field v-model="data_nascita" label="Data di nascita" required outlined dense></v-text-field>
          <v-text-field v-model="indirizzo" label="Indirizzo" required outlined dense></v-text-field>
          <v-text-field v-model="telefono" label="Telefono" required outlined dense></v-text-field>
          <v-text-field v-model="email" label="Email" type="email" required outlined dense></v-text-field>
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
          <v-text-field
            v-model="confirmPassword"
            :type="showConfirmPassword ? 'text' : 'password'"
            label="Conferma Password"
            outlined
            dense
            required
            :append-icon="showConfirmPassword ? 'mdi-eye-off' : 'mdi-eye'"
            @click:append="showConfirmPassword = !showConfirmPassword"
          />
          <v-select v-model="type" label="Tipo Utente" :items="['Docente', 'Studente']" outlined dense required></v-select>

          <v-btn :loading="loading" color="primary" block class="mt-4" type="submit">Registrati</v-btn>
        </v-form>

        <div class="extra-links mt-4">
          <RouterLink to="/login">Hai già un account? Accedi</RouterLink>
          <br />
          <RouterLink to="/">
            <v-btn color="secondary" variant="outlined" class="mt-2">Torna alla Home</v-btn>
          </RouterLink>
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
      nome: '',
      cognome: '',
      data_nascita: '',
      indirizzo: '',
      telefono: '',
      email: '',
      password: '',
      confirmPassword: '',
      type: '',
      errorMessage: '',
      loading: false,
      showPassword: false,
      showConfirmPassword: false,
    }
  },
  methods: {
    async register() {
      if (
        !this.nome || !this.cognome || !this.data_nascita || !this.indirizzo ||
        !this.telefono || !this.email || !this.password || !this.confirmPassword || !this.type
      ) {
        this.errorMessage = 'Tutti i campi sono obbligatori!'
        return
      }

      if (this.password.length < 6) {
        this.errorMessage = 'La password deve avere almeno 6 caratteri!'
        return
      }

      if (this.password !== this.confirmPassword) {
        this.errorMessage = 'Le password non coincidono!'
        return
      }

      this.loading = true
      this.errorMessage = ''

      try {
        const response = await axios.post('http://localhost:8080/register', {
          nome: this.nome,
          cognome: this.cognome,
          data_nascita: this.data_nascita,
          indirizzo: this.indirizzo,
          telefono: this.telefono,
          email: this.email,
          password: this.password,
          type: this.type,
        })

        const utente = response.data.utente
        localStorage.setItem('token', response.data.token)
        localStorage.setItem('Utente', JSON.stringify(utente))

        const tipo = utente.Tipo_Utente
        if (tipo === 2) this.$router.push('/teacher')
        else if (tipo === 3) this.$router.push('/student')
        else if (tipo === 1) this.$router.push('/administrator')

      } catch (error) {
        this.errorMessage = error.response?.data?.message || 'Errore durante la registrazione!'
      } finally {
        this.loading = false
      }
    },
  },
}
</script>

<style scoped>
.register-view {
  font-family: 'Segoe UI', sans-serif;
  background: linear-gradient(to right, #00c9ff, #92fe9d);
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
  padding: 2rem 1rem;
}

.form-box {
  background: white;
  padding: 2rem;
  border-radius: 16px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  width: 100%;
  max-width: 450px;
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
