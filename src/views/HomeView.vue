<template>
  <div class="home-view">
    <header class="hero">
      <h1>Istituto Superiore Galileo Galilei</h1>
      <p>Innovazione, conoscenza, futuro.</p>
      <div class="actions">
        <RouterLink to="/login" class="btn">Login</RouterLink>
        <RouterLink to="/register" class="btn">Registrati</RouterLink>
      </div>
    </header>

    <section class="carousel">
      <div class="slides">
        <div v-for="(slide, index) in slides" :key="index" class="slide" :class="{ active: index === currentSlide }">
          <img :src="slide.image" :alt="slide.alt" />
          <div class="caption">{{ slide.caption }}</div>
        </div>
      </div>
    </section>

    <section class="info">
      <h2>Chi siamo</h2>
      <p>L'Istituto Galileo Galilei offre un ambiente stimolante e all'avanguardia, con indirizzi scientifici, linguistici e tecnici. Prepariamo gli studenti ad affrontare le sfide del mondo moderno con competenze solide e spirito critico.</p>

      <h2>Offerta formativa</h2>
      <ul>
        <li>Indirizzo Scientifico</li>
        <li>Indirizzo Linguistico</li>
        <li>Indirizzo Informatica</li>
        <li>Laboratori attrezzati e progetti Erasmus+</li>
      </ul>
    </section>

    <footer>
      <p>&copy; 2025 Istituto Galileo Galilei - Tutti i diritti riservati</p>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'HomeView',
  data() {
    return {
      slides: [
        { image: 'src/assets/scuola.jpeg', caption: "Laboratori all'avanguardia", alt: 'Laboratori' },
        { image: 'src/assets/scuola1.jpeg', caption: 'Docenti qualificati e appassionati', alt: 'Docenti' },
        { image: 'src/assets/scuola.jpg', caption: 'Scambi culturali e progetti Erasmus+', alt: 'Erasmus' },
      ],
      currentSlide: 0,
      interval: null,
    }
  },
    mounted() {
      this.interval = setInterval(this.nextSlide, 5000)
    },
    beforeUnmount() {
      clearInterval(this.interval)
    },
    methods: {
      nextSlide() {
        this.currentSlide = (this.currentSlide + 1) % this.slides.length
      },
    }
  }
</script>
;
<style scoped>
.home-view {
  font-family: 'Segoe UI', sans-serif;
  color: #333;
}
.hero {
  background: linear-gradient(to right, #007bff, #00c3ff);
  color: white;
  text-align: center;
  padding: 3rem 1rem;
}
.hero h1 {
  font-size: 3rem;
}
.hero p {
  font-size: 1.2rem;
  margin-bottom: 1rem;
}
.actions .btn {
  margin: 0 10px;
  padding: 0.7rem 1.5rem;
  background: white;
  color: #007bff;
  border-radius: 25px;
  text-decoration: none;
  font-weight: bold;
  transition: background 0.3s;
}
.actions .btn:hover {
  background: #f0f0f0;
}
.carousel {
  margin: 2rem auto;
  max-width: 800px;
  overflow: hidden;
  position: relative;
}
.slides {
  display: flex;
  transition: transform 0.5s ease-in-out;
}
.slide {
  min-width: 100%;
  position: absolute;
  opacity: 0;
  transition: opacity 1s;
}
.slide.active {
  position: relative;
  opacity: 1;
}
.slide img {
  width: 100%;
  border-radius: 12px;
}
.caption {
  background: rgba(0, 0, 0, 0.5);
  color: white;
  padding: 0.5rem;
  text-align: center;
  position: absolute;
  bottom: 10px;
  width: 100%;
  border-radius: 0 0 12px 12px;
}
.info {
  padding: 2rem;
  background-color: #f8f9fa;
}
.info h2 {
  margin-top: 1.5rem;
}
footer {
  text-align: center;
  padding: 1rem;
  background-color: #007bff;
  color: white;
  margin-top: 2rem;
}
</style>
