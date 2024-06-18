import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/main-login.vue';
import Register from '../components/register.vue';
import Game from '../components/main-game.vue';
import ViewData from '../components/view-data.vue';
import AddingData from '../components/adding-data.vue';
import UserPage from '../components/user.vue';

const routes = [
  {
    path: '/',
    redirect: '/login'
  },
  {
    path: '/login',
    component: Login
  },
  {
    path: '/Main',
    name: Game,
    component: Game
  },
  {
    path: '/ViewData',
    name: ViewData,
    component: ViewData
  },
  {
    path: '/AddingData',
    name: AddingData,
    component: AddingData
  },
  {
    path: '/UserPage',
    name: UserPage,
    component: UserPage
  },
  {
    path: '/register',
    component: Register
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
