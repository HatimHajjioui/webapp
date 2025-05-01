<template>
  <div class="teacher-view">
    <!-- Header -->
    <header class="hero">
      <div class="top-bar">
        <h1>Istituto Galileo Galilei</h1>
        <button class="logout-btn" @click="logout">🔓 Logout</button>
      </div>
      <p>Benvenuto, Prof. {{ docente.nome }} {{ docente.cognome }}</p>
    </header>

    <!-- Info docente -->
    <section class="info-section">
      <div class="info-card blue">
        <h2>Dati Personali</h2>
        <ul>
          <li><strong>Email:</strong> {{ docente.email }}</li>
          <li><strong>Telefono:</strong> {{ docente.telefono }}</li>
          <li><strong>Dipartimento:</strong> {{ docente.dipartimento }}</li>
        </ul>
      </div>

      <div class="info-card purple">
        <h2>Materie Insegnate</h2>
        <ul>
          <li v-for="materia in docente.materie" :key="materia.id">
            {{ materia.nome }} - Classe {{ materia.classe }}
          </li>
        </ul>
      </div>
    </section>

    <!-- Gestione Voti -->
    <section class="voti-section">
      <h2>📊 Gestione Voti</h2>

      <label>Classe:</label>
      <select v-model="classeSelezionata">
        <option disabled value="">Seleziona una classe</option>
        <option v-for="classe in classiDisponibili" :key="classe">{{ classe }}</option>
      </select>

      <div v-if="classeSelezionata" class="classe-box">
        <label>Studente:</label>
        <select v-model="studenteSelezionato">
          <option disabled value="">Seleziona uno studente</option>
          <option v-for="s in studentiFiltrati" :key="s.id" :value="s">{{ s.nome }} {{ s.cognome }}</option>
        </select>
      </div>

      <div v-if="studenteSelezionato" class="voti-box">
        <h3>Voti di {{ studenteSelezionato.nome }}</h3>
        <ul>
          <li v-for="voto in studenteSelezionato.voti" :key="voto.id">
            {{ voto.materia }} - {{ voto.voto }} ({{ voto.data }})
          </li>
        </ul>

        <form @submit.prevent="aggiungiVoto">
          <input v-model="nuovoVoto.materia" placeholder="Materia" required />
          <input v-model.number="nuovoVoto.voto" type="number" placeholder="Voto" required />
          <button type="submit">Aggiungi Voto</button>
        </form>
      </div>
    </section>

    <footer>
      <p>&copy; 2025 Istituto Galileo Galilei - Tutti i diritti riservati</p>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'TeacherView',
  data() {
    return {
      docente: {
        nome: "Giulia",
        cognome: "Bianchi",
        email: "giulia.bianchi@scuola.it",
        telefono: "321654987",
        dipartimento: "Matematica",
        materie: [
          { id: 1, nome: "Matematica", classe: "2A" },
          { id: 2, nome: "Fisica", classe: "3B" }
        ]
      },
      classiDisponibili: ["2A", "3B"],
      classeSelezionata: "",
      studenteSelezionato: null,
      studenti: [
        {
          id: 1,
          nome: "Mario",
          cognome: "Rossi",
          classe: "2A",
          voti: [{ id: 1, materia: "Matematica", voto: 7, data: "2025-03-01" }]
        },
        {
          id: 2,
          nome: "Luisa",
          cognome: "Verdi",
          classe: "3B",
          voti: []
        }
      ],
      nuovoVoto: {
        materia: "",
        voto: null
      }
    }
  },
  computed: {
    studentiFiltrati() {
      return this.studenti.filter(s => s.classe === this.classeSelezionata)
    }
  },
  methods: {
    logout() {
      localStorage.removeItem('Utente')
      this.$router.push('/')
    },
    aggiungiVoto() {
      const nuovo = {
        id: Date.now(),
        materia: this.nuovoVoto.materia,
        voto: this.nuovoVoto.voto,
        data: new Date().toISOString().split('T')[0]
      }
      this.studenteSelezionato.voti.push(nuovo)
      this.nuovoVoto = { materia: '', voto: null }
    }
  }
}
</script>

<style scoped>
.teacher-view {
  font-family: 'Segoe UI', sans-serif;
  color: #333;
}

.hero {
  background: linear-gradient(to right, #007bff, #00c3ff);
  color: white;
  text-align: center;
  padding: 2rem 1rem 3rem;
  position: relative;
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
  transition: background 0.3s;
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

.voti-section {
  background: #fff8dc;
  padding: 2rem;
  margin: 2rem auto;
  max-width: 900px;
  border-radius: 12px;
}
.voti-section select, .voti-section input {
  margin: 0.5rem 0;
  padding: 0.5rem;
  width: 100%;
  max-width: 400px;
  border: 1px solid #ccc;
  border-radius: 8px;
}
.voti-section button {
  margin-top: 1rem;
  padding: 0.5rem 1rem;
  border: none;
  background-color: #007bff;
  color: white;
  border-radius: 8px;
  cursor: pointer;
}
.voti-section button:hover {
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
