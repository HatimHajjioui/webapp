<template>
  <v-app id="inspire">
    <v-app-bar flat>
      <v-container class="mx-auto d-flex align-center justify-center">
        <v-avatar class="me-4" color="grey-darken-1" size="32"></v-avatar>

        <!-- Barra di navigazione -->
        <v-btn to='/' class="mx-2" variant="text">Home</v-btn>
        <v-btn to='/profile' class="mx-2" variant="text">Profile</v-btn>
        <v-btn to='/login' class="mx-2" variant="text">Login</v-btn>
        <v-btn to='/register' class="mx-2" variant="text">Register</v-btn>
        <v-spacer></v-spacer>


      </v-container>
    </v-app-bar>

    <!-- Main Section with Buttons -->
    <v-main class="bg-grey-lighten-3">
      <v-container class="d-flex justify-center align-center" style="height: 40vh;">
        <v-row class="d-flex justify-center align-center" style="width: 100%">
          <!-- Amministratore -->
          <v-col cols="4" class="d-flex justify-center">
            <v-btn
              color="primary"
              large
              class="mx-2 w-100"
              to="/administrator"
            >
              Amministratore
            </v-btn>
          </v-col>

          <!-- Studente -->
          <v-col cols="4" class="d-flex justify-center">
            <v-btn
              color="success"
              large
              class="mx-2 w-100"
              to="/student"
            >
              Studente
            </v-btn>
          </v-col>

          <!-- Docente -->
          <v-col cols="4" class="d-flex justify-center">
            <v-btn
              color="error"
              large
              class="mx-2 w-100"
              to="/teacher"
            >
              Docente
            </v-btn>
          </v-col>
        </v-row>

      </v-container>
      <v-carousel
        height="600"
        show-arrows="hover"
        cycle
        hide-delimiter-background
      >
        <v-carousel-item
          v-for="(slide, i) in slides"
          :key="i"
        >
          <v-sheet
            :color="colors[i]"
            height="100%"
          >
            <v-img
              :src="slide.image"
              alt="Image slide"
              height="100%"
              contain
            />

          </v-sheet>
        </v-carousel-item>
      </v-carousel>

    </v-main>
  </v-app>
</template>


<script setup>

const links = [
  'Sign in',
  'Login',
  'Profile',
  'Register',
];

</script>
<!--<script setup>-->
<!--import { onMounted } from 'vue';-->

<!--onMounted(() => {-->
<!--  fetch('http://localhost:5000/api/test')-->
<!--    .then(response => response.json())-->
<!--    .then(data => console.log('Risposta dal backend:', data))-->
<!--    .catch(error => console.error('Errore:', error));-->
<!--});-->
<!--</script>-->


<script>

export default {
  data() {
    return {
      colors: ['#ffffff', '#ffffff', '#ffffff'], // I colori di sfondo del carousel
      slides: [
        { image: 'src/assets/scuola.jpeg' },
        { image: 'src/assets/scuola.jpg' },
        { image: 'src/assets/scuola1.jpeg' }
      ]
    };
  }
};

</script>

<style scoped>
/* Puoi aggiungere stili personalizzati qui */
</style>
