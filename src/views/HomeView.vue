<template>
  <v-app id="inspire">
    <v-app-bar flat>
      <v-container class="mx-auto d-flex align-center justify-center">
        <v-avatar class="me-4" color="grey-darken-1" size="32"></v-avatar>

        <!-- Barra di navigazione -->
        <v-btn to='/' class="mx-2" variant="text">Home</v-btn>
        <v-btn to='/profile' class="mx-2" variant="text">Profile</v-btn>
        <v-btn to='/login' class="mx-2" variant="text">Login</v-btn>
        <v-spacer></v-spacer>


      </v-container>
    </v-app-bar>

    <!-- Main Section with Buttons -->
    <v-main class="bg-grey-lighten-3">
      <v-container class="d-flex justify-center align-center" style="height: 100vh;">
        <v-row class="d-flex justify-center align-center" style="width: 100%">
          <!-- Profilo -->
          <v-col cols="4" class="d-flex justify-center">
            <v-btn
              color="primary"
              large
              class="mx-2 w-100"
              to="/profile"
            >
              Profile
            </v-btn>
          </v-col>

          <!-- Login -->
          <v-col cols="4" class="d-flex justify-center">
            <v-btn
              color="success"
              large
              class="mx-2 w-100"
              to="/login"
            >
              Login
            </v-btn>
          </v-col>

          <!-- Sign Up -->
          <v-col cols="4" class="d-flex justify-center">
            <v-btn
              color="error"
              large
              class="mx-2 w-100"
              to="/signup"
            >
              Sign Up
            </v-btn>
          </v-col>
        </v-row>

      </v-container>

        <v-carousel
          height="400"
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
              <div class="d-flex fill-height justify-center align-center">
                <div class="text-h2">
                  {{ slide }} Slide
                </div>
              </div>
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
]
</script>

<script>
export default {
  data: () => ({
    links: [
      'Sign in',
      'Login',
      'Profile',
    ],
  }),
}
</script>

<style scoped>
/* Puoi aggiungere stili personalizzati qui */
</style>
