<template>
  <div class="admin-view">
    <header class="hero">
      <div class="top-bar">
        <h1>Istituto Galileo Galilei</h1>
        <button class="logout-btn" @click="logout">🔓 Logout</button>
      </div>
      <p>Benvenuto, {{ admin.nome }} {{ admin.cognome }} (Amministratore)</p>
    </header>

    <section class="info-section">
      <div class="info-card purple">
        <h2>Gestione Utenti</h2>
        <ul>
          <li>Totale studenti: {{ stats.studenti }}</li>
          <li>Totale docenti: {{ stats.docenti }}</li>
          <li>Classi attive: {{ stats.classi }}</li>
        </ul>
      </div>

      <div class="info-card yellow">
        <h2>Azioni Rapide</h2>
        <ul>
          <li><a href="#">➕ Aggiungi utente</a></li>
          <li><a href="#">📋 Visualizza report</a></li>
          <li><a href="#">⚙️ Configura sistema</a></li>
        </ul>
      </div>
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
      admin: {
        nome: "Antonio",
        cognome: "Ferrari"
      },
      stats: {
        studenti: 240,
        docenti: 35,
        classi: 15
      }
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
