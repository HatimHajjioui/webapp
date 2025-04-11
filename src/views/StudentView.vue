<template>
  <v-app>
    <v-app-bar app dark color="primary">
      <v-toolbar-title>Area Studente</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn text to="/profile">Profilo</v-btn>
      <v-btn text @click="logout">Esci</v-btn>
    </v-app-bar>

    <v-main>
      <v-container class="pa-4" fluid>
        <!-- Titolo della pagina -->
        <v-row>
          <v-col cols="12" md="6">
            <v-card class="pa-3">
              <v-card-title class="headline">Benvenuto, {{ student.name }}!</v-card-title>
              <v-card-subtitle>{{ student.email }}</v-card-subtitle>
            </v-card>
          </v-col>
        </v-row>

        <!-- Grafico dei voti -->
        <v-row>
          <v-col cols="12" md="6">
            <v-card>
              <v-card-title>Voti recenti</v-card-title>
              <v-card-subtitle>Una panoramica delle tue performance</v-card-subtitle>
              <v-divider></v-divider>
              <v-card-text>
                <line-chart :chart-data="chartData" />
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>

        <!-- Dettaglio dei voti -->
        <v-row>
          <v-col v-for="(grade, index) in student.grades" :key="index" cols="12" md="4">
            <v-card class="elevation-2" outlined>
              <v-card-title>{{ grade.subject }}</v-card-title>
              <v-card-subtitle>{{ grade.score }} / 10</v-card-subtitle>
              <v-divider></v-divider>
              <v-card-text>
                <v-btn small color="primary" @click="viewDetails(grade.subject)">Dettagli</v-btn>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
// Importa Vue ChartJS per i grafici
import { Line } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale)

export default {
  components: {
    LineChart: Line
  },
  data() {
    return {
      // Dati del profilo studente (in un'app reale verrebbero presi da un'API)
      student: {
        name: 'Giovanni Rossi',
        email: 'giovanni.rossi@email.com',
        grades: [
          { subject: 'Matematica', score: 8 },
          { subject: 'Fisica', score: 7 },
          { subject: 'Inglese', score: 9 },
          { subject: 'Storia', score: 6 },
          { subject: 'Chimica', score: 7 },
        ]
      },
      // Dati per il grafico dei voti
      chartData: {
        labels: ['Settembre', 'Ottobre', 'Novembre', 'Dicembre', 'Gennaio'],
        datasets: [
          {
            label: 'Voti',
            data: [8, 7, 9, 6, 7], // Questi sarebbero i voti mensili dello studente
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            fill: true,
            tension: 0.4
          }
        ]
      }
    }
  },
  methods: {
    logout() {
      // Esegui logout (puoi integrarlo con la logica di autenticazione)
      this.$router.push('/login')
    },
    viewDetails(subject) {
      // Funzione per visualizzare i dettagli di un voto
      alert(`Dettagli del voto per: ${subject}`)
    }
  }
}
</script>

<style scoped>
/* Aggiungi qui le tue personalizzazioni di stile */
</style>
