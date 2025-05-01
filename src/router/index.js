import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },

    {
      path: '/profile',
      name: 'profile',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/ProfileView.vue'),
    },
    {
      path: '/login',
      name: 'login',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/LoginView.vue'),
    },
    {
      path: '/register',
      name: 'register',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/RegisterView.vue'),
    },
    {
      path: '/student',
      name: 'student',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/StudentView.vue'),
    },
    {
      path: '/teacher',
      name: 'teacher',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/TeacherView.vue'),
    },
    {
      path: '/administrator',
      name: 'administrator',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AdministratorView.vue'),
    },
  ],
})

/*
const register = async () => {
  try {
    const response = await axios.post('https://api.example.com/register', {
      name,
      email,
      password,
    })

    localStorage.setItem('token', response.data.token)
    router.push('/dashboard') // 🔥 Sposta l'utente sulla pagina della dashboard
  } catch (error) {
    errorMessage.value = 'Errore durante la registrazione!'
  }
}
*/
export default router
