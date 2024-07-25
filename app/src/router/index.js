import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'
import DashboardView from '@/views/DashboardView.vue'
import PrestamosView from '@/views/PrestamosView.vue'
import AjustesView from '@/views/AjustesView.vue'
import PerfilView from '@/views/PerfilView.vue'
import LIbrosView from '@/views/LIbrosView.vue'
import ReportesView from '@/views/ReportesView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: LoginView
    },
    {
      path: '/inicio',
      name: 'home',
      component: HomeView,
      redirect: () => {
        return { name: 'dashboard' }
      },
      children: [
        {
          path: 'dashboard',
          name: 'dashboard',
          component: DashboardView
          // meta: {
          //   requireAuth: true,
          // },
        },
        {
          path: 'prestamos',
          name: 'prestamos',
          component: PrestamosView
          // meta: {
          //   requireAuth: true,
          // },
        },
        {
          path: 'libros',
          name: 'libros',
          component: LIbrosView
          // meta: {
          //   requireAuth: true,
          // },
        },
        {
          path: 'ajustes',
          name: 'ajustes',
          component: AjustesView
          // meta: {
          //   requireAuth: true,
          // },
        },
        {
          path: 'reportes',
          name: 'reportes',
          component: ReportesView
          // meta: {
          //   requireAuth: true,
          // },
        },
        {
          path: 'perfil',
          name: 'perfil',
          component: PerfilView
          // meta: {
          //   requireAuth: true,
          // },
        }
      ]
      // meta: {
      //   requireAuth: true,
      // },
    }
  ]
})

export default router
