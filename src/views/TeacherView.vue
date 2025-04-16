<template>
  <div class="docente-view">
    <header class="hero">
      <div class="top-bar">
        <h1>Istituto Galileo Galilei</h1>
        <button class="logout-btn" @click="logout">🔓 Logout</button>
      </div>
      <p>Benvenuto, Prof. {{ docente.nome }} {{ docente.cognome }}</p>
    </header>

    <section class="info-section">
      <div class="info-card blue">
        <h2>Dati Personali</h2>
        <ul>
          <li><strong>Email:</strong> {{ docente.email }}</li>
          <li><strong>Telefono:</strong> {{ docente.telefono }}</li>
          <li><strong>Materia:</strong> {{ docente.materia }}</li>
        </ul>
      </div>

      <div class="info-card green">
        <h2>Classi Assegnate</h2>
        <ul>
          <li v-for="classe in docente.classi" :key="classe">{{ classe }}</li>
        </ul>
      </div>
    </section>

    <section class="voti-section">
      <h2>📋 Registro Voti Inseriti</h2>
      <table>
        <thead>
        <tr>
          <th>Studente</th>
          <th>Classe</th>
          <th>Voto</th>
          <th>Data</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="voto in voti" :key="voto.id">
          <td>{{ voto.studente }}</td>
          <td>{{ voto.classe }}</td>
          <td>{{ voto.voto }}</td>
          <td>{{ voto.data }}</td>
        </tr>
        </tbody>
      </table>
    </section>

    <footer>
      <p>&copy; 2025 Istituto Galileo Galilei - Tutti i diritti riservati</p>
    </footer>
  </div>
</template>

<script>
export default {
  name: "DocenteView",
  data() {
    return {
      docente: {
        nome: "Laura",
        cognome: "Bianchi",
        email: "laura.bianchi@example.com",
        telefono: "987654321",
        materia: "Matematica",
        classi: ["1A", "2B", "3C"]
      },
      voti: [
        { id: 1, studente: "Mario Rossi", classe: "1A", voto: 8, data: "2025-03-20" },
        { id: 2, studente: "Giulia Verdi", classe: "2B", voto: 9, data: "2025-03-22" }
      ]
    };
  },
  methods: {
    logout() {
      localStorage.removeItem('Utente');
      this.$router.push('/');
    }
  }
};
</script>

<style scoped>
@import './styleComune.css';
</style>
