import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import AboutView from "@/views/AboutView.vue";
import LoginView from "@/views/LoginView.vue";
import CadastroView from "@/views/CadastroView.vue";
import ProfileView from "@/views/ProfileView.vue";
import SingleView from "@/views/SingleView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/about',
      name: 'about',
      component: AboutView,
    },
    {
      path: '/login',
      name: 'Login',
      component: LoginView,
    },
    {
      path: '/cadastro',
      name: 'Cadastro',
      component: CadastroView,
    },
    {
      path: '/view-profile',
      name: 'View Profile',
      component: ProfileView,
    },
    {
      path: '/view-single',
      name: 'View Single',
      component: SingleView,
    },
  ],
})

export default router
