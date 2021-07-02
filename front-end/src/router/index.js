import { createRouter, createWebHashHistory } from 'vue-router';
import Register from '@/views/Register.vue';
import Login from '@/views/Login.vue';
import Home from '@/views/Home.vue';
import authService from '@/services/auth';
import store from '@/store';

const routes = [
  {
    path: '/register',
    name: 'Register',
    component: Register,
    meta: {
      noRequiereAutentificacion: true
    }
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: {
      noRequiereAutentificacion: true
    }
  },
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: {
      requiereAutenticacion: true
    }
  },
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(route => route.meta.requiereAutenticacion === true)) {

      authService.verificarAutenticacion()
        .then(res => {
          if (res === null) {
              next({
                  path: '/login'
              });
          } else {
              next();
          }
        });
      
  } else if (to.matched.some(route => route.meta.noRequiereAutentificacion === true)) {
      authService.verificarAutenticacion()
        .then(res => {
          if (res !== null) {
              next({
                  path: '/'
              });
          } else {
              next();
          }
        });
  }
});

export default router
