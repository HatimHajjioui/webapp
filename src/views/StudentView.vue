<template>
  <button @click="logout">Esci</button>
  <div class="min-h-screen bg-gradient-to-br from-blue-100 to-purple-200 p-6">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl p-6">
      <h1 class="text-3xl font-bold text-center mb-4">Benvenuto, {{ studente.nome }} {{ studente.cognome }}</h1>

      <div class="grid md:grid-cols-2 gap-6">
        <!-- Info Anagrafiche -->
        <div class="bg-blue-50 p-4 rounded-xl shadow">
          <h2 class="text-xl font-semibold mb-2">Dati Personali</h2>
          <p><strong>Email:</strong> {{ studente.email }}</p>
          <p><strong>Data di Nascita:</strong> {{ studente.data_nascita }}</p>
          <p><strong>Indirizzo:</strong> {{ studente.indirizzo }}</p>
          <p><strong>Telefono:</strong> {{ studente.telefono }}</p>
        </div>

        <!-- Classe e indirizzo -->
        <div class="bg-purple-50 p-4 rounded-xl shadow">
          <h2 class="text-xl font-semibold mb-2">Classe e Indirizzo</h2>
          <p><strong>Classe:</strong> {{ studente.classe }}</p>
          <p><strong>Anno Scolastico:</strong> {{ studente.anno }}</p>
          <p><strong>Indirizzo di Studio:</strong> {{ studente.indirizzo_studio }}</p>
        </div>
      </div>

      <!-- Materie -->
      <div class="mt-8 bg-green-50 p-4 rounded-xl shadow">
        <h2 class="text-xl font-semibold mb-2">Materie della tua Classe</h2>
        <ul class="list-disc ml-5">
          <li v-for="materia in materie" :key="materia.id">{{ materia.nome }}</li>
        </ul>
      </div>

      <!-- Voti -->
      <div class="mt-8 bg-yellow-50 p-4 rounded-xl shadow">
        <h2 class="text-xl font-semibold mb-2">I tuoi Voti</h2>
        <table class="w-full text-left table-auto">
          <thead>
          <tr class="bg-yellow-200">
            <th class="p-2">Materia</th>
            <th class="p-2">Docente</th>
            <th class="p-2">Voto</th>
            <th class="p-2">Data</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="voto in voti" :key="voto.id" class="border-t">
            <td class="p-2">{{ voto.materia }}</td>
            <td class="p-2">{{ voto.docente }}</td>
            <td class="p-2">{{ voto.voto }}</td>
            <td class="p-2">{{ voto.data }}</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "StudenteView",
  data() {
    return {
      studente: {
        nome: "Mario",
        cognome: "Rossi",
        email: "mario.rossi@example.com",
        data_nascita: "2000-05-10",
        indirizzo: "Via Roma 1",
        telefono: "123456789",
        classe: "2A",
        anno: "2024/2025",
        indirizzo_studio: "Scientifico"
      },
      materie: [
        { id: 1, nome: "Matematica" },
        { id: 2, nome: "Fisica" }
      ],
      voti: [
        { id: 1, materia: "Fisica", docente: "Giulia Bianchi", voto: 10, data: "2025-03-26" }
      ]
    };
  },
  methods: {
    logout() {
      // Rimuove i dati salvati
      localStorage.removeItem('Utente');

      // Reindirizza alla pagina di login
      this.$router.push('/');
    }
  }
};
</script>

<style scoped>
/* Aggiungi qui se vuoi altri effetti personalizzati */
</style>
