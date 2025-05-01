  <template>
    <div class="studente-view">
      <!-- Header con Logout -->
      <header class="hero">
        <div class="top-bar">
          <h1>Istituto Galileo Galilei</h1>
          <button class="logout-btn" @click="logout">🔓 Logout</button>
        </div>
        <p>Benvenuto, {{ studente.Nome }} {{ studente.Cognome }}</p>
      </header>

      <!-- Info anagrafiche + Classe -->
      <section class="info-section">
        <div class="info-card blue">
          <h2>Dati Personali</h2>
          <ul>
            <li><strong>Email:</strong> {{ studente.Email }}</li>
            <li><strong>Data di Nascita:</strong> {{ studente.Data_Nascita }}</li>
            <li><strong>Indirizzo:</strong> {{ studente.indirizzo }}</li>
            <li><strong>Telefono:</strong> {{ studente.Telefono }}</li>
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
  import axios from 'axios';
  axios.defaults.baseURL = 'http://localhost:8080'; // o la porta del tuo server PHP
  export default {
    name: "StudenteView",
    data() {
      return {
        studente: {
          Nome: "",
          Cognome: "",
          Email: "",
          Data_Nascita: "",
          Indirizzo: "",
          Telefono: "",
          classe: "",
          anno: "",
          indirizzo_studio: ""
        },
        materie: [],
        voti: [],
        isLoading: true
      };
    },
    async created() {
      try {
        // 1. Prima recupera l'utente dal localStorage
        const userData = localStorage.getItem('Utente');

        if (!userData) {
          this.$router.push('/login');
          return;
        }

        // 2. Parsa i dati
        const utente = JSON.parse(userData);
        console.log('Utente dal localStorage:', utente); // Debug

        // 3. Verifica i campi necessari
        if (!utente || utente.ID_Ruolo !== 3) {
          this.$router.push('/login');
          return;
        }

        if (!utente.ID_Studente) {
          console.error('ID Studente mancante nel localStorage');
          this.$router.push('/login');
          return;
        }

        // 4. Ora procedi con le chiamate API
        await this.caricaDatiStudente(utente.ID_Studente);
        await this.caricaMaterie(utente.ID_Studente);
        await this.caricaVoti(utente.ID_Studente);

      } catch (error) {
        console.error("Errore durante il caricamento:", error);
        this.$router.push('/login');
      } finally {
        this.isLoading = false;
      }
    },
    methods: {
      async caricaDatiStudente(studenteId) {
        try {
          const response = await axios.get(`http://localhost:8080/api/studenti/${studenteId}`);
          const dati = response.data;

          // Debug: verifica la struttura della risposta
          console.log('Dati studente:', dati);

          this.studente = {
            Nome: dati.Nome,
            Cognome: dati.Cognome,
            Email: dati.Email,
            Data_Nascita: this.formattaData(dati.Data_Nascita),
            Indirizzo: dati.Indirizzo,
            Telefono: dati.Telefono,
            classe: dati.classe,
            anno: dati.anno,
            indirizzo_studio: dati.indirizzo_studio
          };
        } catch (error) {
          console.error("Errore nel caricamento dati studente:", error);
          this.$router.push('/login');
        }
      },
      async caricaMaterie(studenteId) {
        try {
          const response = await axios.get(`http://localhost:8080/api/studenti/${studenteId}/materie`);

          // Gestione più robusta della risposta
          let materieData = response.data?.data || response.data || [];

          if (!Array.isArray(materieData)) {
            materieData = [];
          }

          this.materie = materieData.map(m => ({
            id: m.ID_Materia,
            nome: m.nome_materia || m.Nome_Materia
          }));
        } catch (error) {
          console.error("Errore nel caricamento materie:", error);
          this.materie = [];
        }
      },
      async caricaVoti(studenteId) {
        try {
          const response = await axios.get(`http://localhost:8080/api/studenti/${studenteId}/voti`);
          let datiVoti = Array.isArray(response.data) ? response.data : [];

          this.voti = datiVoti.map(v => ({
            id: v.ID_Voto,
            materia: v.materia || v.Nome_Materia,
            docente: v.docente,
            voto: v.Voto,
            data: this.formattaData(v.data_voto)
          }));
        } catch (error) {
          console.error("Errore nel caricamento voti:", error);
          this.voti = [];
        }
      },
      formattaData(data) {
        return new Date(data).toLocaleDateString('it-IT');
      },
      logout() {
        localStorage.removeItem('Utente');
        this.$router.push('/login');
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
