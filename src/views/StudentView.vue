  <template>
    <div class="studente-view">
      <!-- Header con Logout -->
      <header class="hero">
        <div class="top-bar">
          <h1>Istituto Galileo Galilei</h1>
          <button class="logout-btn" @click="logout">🔓 Logout</button>
        </div>
        <p>Benvenuto, {{ studente.nome }} {{ studente.cognome }}</p>
      </header>

      <!-- Info anagrafiche + Classe -->
      <section class="info-section">
        <div class="info-card blue">
          <h2>Dati Personali</h2>
          <ul>
            <li><strong>Email:</strong> {{ studente.email }}</li>
            <li><strong>Data di Nascita:</strong> {{ studente.data_nascita }}</li>
            <li><strong>Indirizzo:</strong> {{ studente.indirizzo }}</li>
            <li><strong>Telefono:</strong> {{ studente.telefono }}</li>
          </ul>
        </div>
        <div class="info-card purple">
          <h2>Classe e Indirizzo</h2>
          <ul>
            <li><strong>Classe:</strong> {{ studente.classe }}</li>
            <li><strong>Anno Scolastico:</strong> {{ studente.anno }}</li>
            <li><strong>Indirizzo di Studio:</strong> {{ studente.indirizzo_studio }}</li>
          </ul>
        </div>
      </section>

      <!-- Materie -->
      <section class="materie-section">
        <h2>📘 Materie della tua Classe</h2>
        <ul>
          <li v-for="materia in materie" :key="materia.id">{{ materia.nome }}</li>
        </ul>
      </section>

      <!-- Voti -->
      <section class="voti-section">
        <h2>📊 I tuoi Voti</h2>
        <table>
          <thead>
          <tr>
            <th>Materia</th>
            <th>Docente</th>
            <th>Voto</th>
            <th>Data</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="voto in voti" :key="voto.id">
            <td>{{ voto.materia }}</td>
            <td>{{ voto.docente }}</td>
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
          { id: 1, materia: "Fisica", docente: "Giulia Bianchi", voto: 10, data: "2025-03-26" },
          { id: 2, materia: "Matematica", docente: "Luca Verdi", voto: 9, data: "2025-03-20" }
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
  .studente-view {
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

  .materie-section {
    background: #f2f9ff;
    padding: 2rem;
    margin: 2rem auto;
    max-width: 900px;
    border-radius: 12px;
  }
  .materie-section ul {
    list-style: disc;
    padding-left: 1.5rem;
  }

  .voti-section {
    background: #fff8dc;
    padding: 2rem;
    margin: 2rem auto;
    max-width: 900px;
    border-radius: 12px;
  }
  .voti-section table {
    width: 100%;
    border-collapse: collapse;
  }
  .voti-section th, .voti-section td {
    padding: 0.8rem;
    border: 1px solid #ddd;
    text-align: left;
  }
  .voti-section th {
    background-color: #ffe17a;
    color: #333;
  }

  footer {
    text-align: center;
    padding: 1rem;
    background-color: #007bff;
    color: white;
    margin-top: 2rem;
  }
  </style>
