<template>
  <div class="admin-view">
    <!-- Header -->
    <header class="hero">
      <div class="top-bar">
        <h1>Istituto Galileo Galilei</h1>
        <button class="logout-btn" @click="logout">🔓 Logout</button>
      </div>
      <p>Benvenuto, {{ amministratore.nome }} {{ amministratore.cognome }}</p>
    </header>

    <!-- Info -->
    <section class="info-section">
      <div class="info-card blue">
        <h2>Dati Amministratore</h2>
        <ul>
          <li><strong>Email:</strong> {{ amministratore.email }}</li>
          <li><strong>Telefono:</strong> {{ amministratore.telefono }}</li>
        </ul>
      </div>

      <div class="info-card purple">
        <h2>Gestione Utenti</h2>
        <ul>
          <li><strong>Totale Utenti:</strong> {{ utenti.length }}</li>
        </ul>
      </div>
    </section>

    <!-- Lista Utenti -->
    <section class="utenti-section">
      <h2>👥 Utenti Registrati</h2>
      <table>
        <thead>
        <tr>
          <th>Nome</th>
          <th>Cognome</th>
          <th>Ruolo</th>
          <th>Email</th>
          <th>Azioni</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="utente in utenti" :key="utente.id">
          <td>{{ utente.nome }}</td>
          <td>{{ utente.cognome }}</td>
          <td>{{ utente.ruolo }}</td>
          <td>{{ utente.email }}</td>
          <td>
            <button @click="rimuoviUtente(utente.id)">🗑️</button>
          </td>
        </tr>
        </tbody>
      </table>
    </section>

    <!-- Aggiungi Utente -->
    <section class="aggiungi-section">
      <h2>➕ Aggiungi Utente</h2>
      <form @submit.prevent="aggiungiUtente">
        <input v-model="nuovoUtente.nome" placeholder="Nome" required />
        <input v-model="nuovoUtente.cognome" placeholder="Cognome" required />
        <input v-model="nuovoUtente.email" placeholder="Email" required />
        <select v-model="nuovoUtente.ruolo" required>
          <option disabled value="">Ruolo</option>
          <option>Studente</option>
          <option>Docente</option>
          <option>Amministratore</option>
        </select>
        <button type="submit">Aggiungi</button>
      </form>
    </section>

    <footer>
      <p>&copy; 2025 Istituto Galileo Galilei - Tutti i diritti riservati</p>
    </footer>
  </div>
</template>

<script>
export default {
  name: "AdminView",
  data() {
    return {
      amministratore: {
        nome: "Franco",
        cognome: "Neri",
        email: "admin@galilei.it",
        telefono: "987654321"
      },
      utenti: [
        { id: 1, nome: "Mario", cognome: "Rossi", ruolo: "Studente", email: "mario.rossi@scuola.it" },
        { id: 2, nome: "Luca", cognome: "Verdi", ruolo: "Docente", email: "luca.verdi@scuola.it" }
      ],
      nuovoUtente: {
        nome: '',
        cognome: '',
        email: '',
        ruolo: ''
      }
    }
  },
  methods: {
    logout() {
      localStorage.removeItem('Utente')
      this.$router.push('/')
    },
    aggiungiUtente() {
      const nuovo = {
        id: Date.now(),
        ...this.nuovoUtente
      }
      this.utenti.push(nuovo)
      this.nuovoUtente = { nome: '', cognome: '', email: '', ruolo: '' }
    },
    rimuoviUtente(id) {
      this.utenti = this.utenti.filter(u => u.id !== id)
    }
  }
}
</script>

<style scoped>
.admin-view {
  font-family: 'Segoe UI', sans-serif;
  color: #333;
}

.hero {
  background: linear-gradient(to right, #007bff, #00c3ff);
  color: white;
  text-align: center;
  padding: 2rem 1rem 3rem;
}

.top-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
  padding: 0 1rem;
}

.logout-btn {
  background: white;
  color: #007bff;
  padding: 0.6rem 1.2rem;
  border-radius: 25px;
  font-weight: bold;
  border: none;
  cursor: pointer;
}
.logout-btn:hover {
  background: #f0f0f0;
}

.info-section {
  display: flex;
  flex-wrap: wrap;
  gap: 1.5rem;
  justify-content: center;
  margin: 2rem auto;
  max-width: 1000px;
}

.info-card {
  flex: 1 1 300px;
  padding: 1.5rem;
  border-radius: 16px;
  color: #fff;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.info-card ul {
  list-style: none;
  padding-left: 0;
}
.info-card li {
  margin: 0.3rem 0;
}
.blue {
  background-color: #4da5ff;
}
.purple {
  background-color: #9c7ee3;
}

.utenti-section, .aggiungi-section {
  background: #f8f9fa;
  padding: 2rem;
  margin: 2rem auto;
  max-width: 900px;
  border-radius: 12px;
}

.utenti-section table {
  width: 100%;
  border-collapse: collapse;
}
.utenti-section th, .utenti-section td {
  padding: 0.8rem;
  border: 1px solid #ddd;
  text-align: left;
}
.utenti-section th {
  background-color: #dceeff;
}

.aggiungi-section form {
  display: flex;
  flex-direction: column;
  gap: 0.8rem;
  max-width: 400px;
}
.aggiungi-section input,
.aggiungi-section select {
  padding: 0.6rem;
  border-radius: 8px;
  border: 1px solid #ccc;
}
.aggiungi-section button {
  padding: 0.6rem;
  border-radius: 8px;
  border: none;
  background-color: #007bff;
  color: white;
  font-weight: bold;
  cursor: pointer;
}
.aggiungi-section button:hover {
  background-color: #0056b3;
}

footer {
  text-align: center;
  padding: 1rem;
  background-color: #007bff;
  color: white;
  margin-top: 2rem;
}
</style>
