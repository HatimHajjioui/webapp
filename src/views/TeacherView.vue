<template>
  <div class="bg-blue-50 p-4 rounded-xl shadow-md">
    <button @click="logout">Esci</button>

    <h2 class="text-xl font-semibold mb-2">Area Docente</h2>
    <ul class="list-disc pl-5">
      <li>Gestione corsi</li>
      <li>Inserimento voti</li>
      <li>Visualizzazione studenti</li>
    </ul>
  </div>
</template>


<script>
export default {
// Logica docente se serve
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
