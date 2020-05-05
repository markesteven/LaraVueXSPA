// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import App from './App'
import router from './router'
import VueProgressBar from 'vue-progressbar'
import store from './store/index'



Vue.router = router
Vue.use(require('@websanova/vue-auth'), {
   auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
   http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
   router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
   rolesVar: 'role',
   authRedirect: '/login',
   forbiddenRedirect: '/403',
   notFoundRedirect: '/404',
   refreshData: { enabled: false, interval: 0},
});

App.router = Vue.router

try {
    window.$ = window.jQuery = require('jquery');
} catch (e) {}

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axios.interceptors.response.use(function (response) {
    return response;
  }, function (error,response) {
    // Do something with response error
    console.log(response);
    return Promise.reject(error);
  });



const options = {
  color: '#236aff',
  failedColor: '#874b4b',
  thickness: '5px',
  transition: {
    speed: '0.2s',
    opacity: '0.1s',
    termination: 300
  },
  autoRevert: false,
  location: 'top',
  inverse: false
}

let originalVueComponent = Vue.component
Vue.component = function (name, definition) {
  if (Array.isArray(definition.components) && definition.components.length === 1) {
    definition.components = {[name]: definition.components[0]}
  }
  originalVueComponent.apply(this, [name, definition])
}



import Datatable from 'vue2-datatable-component'
Vue.use(Datatable)

Vue.use(VueProgressBar, options)
Vue.use(BootstrapVue)

Vue.component = originalVueComponent

router.beforeEach((to, from, next) => {
  document.title = `Project | ${to.name}`
  next()
})

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: {
    App
  }
})
