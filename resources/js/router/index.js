import Vue from 'vue';
import Router from 'vue-router';
import store from './../store';


Vue.use(Router);

import home from './modules/home.js';
import auth from './modules/auth.js';

const routes = [
  home,
  auth,
]

const router =  new Router({
  // mode: 'history', // Require service support
  mode: 'history',
  routes
});

router.beforeEach(async (to, from, next) => {
  
  if(to.path !== '/login' && !localStorage.getItem('_token')){
    next('login');
  }else if(to.path !== '/login' && localStorage.getItem('_token')){
    await axios.get('/api/auth/user')
          .then((res) => next())
          .catch((res) => {
              localStorage.removeItem('_token');
              next('login')
          })
  }else if(to.path === '/login' && localStorage.getItem('_token')){
    next('/')
  }else{
    next();
  }
});

export default router;