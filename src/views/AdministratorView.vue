<template>
  <div class="bg-red-50 p-4 rounded-xl shadow-md">
    <button @click="logout">Esci</button>
    <h2 class="text-xl font-semibold mb-2">Area Amministratore</h2>
    <ul class="list-disc pl-5">
      <li>Gestione utenti</li>
      <li>Gestione corsi e docenti</li>
      <li>Statistiche sistema</li>
    </ul>
  </div>
</template>

<script>
export default {
// Logica admin se serve
  methods: {
    logout() {
      // Rimuove i dati salvati
      localStorage.removeItem('Utente');

      // Reindirizza alla pagina di login
      this.$router.push('/');
    }
  }
}
</script>
