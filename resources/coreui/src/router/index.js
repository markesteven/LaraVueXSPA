import Vue from 'vue'
import Router from 'vue-router'
import axios from 'axios';
import VueAxios from 'vue-axios';

// Containers
import Full from '../containers/Full'

// Views
import Dashboard from '../views/Dashboard'
import Charts from '../views/Charts'
import Widgets from '../views/Widgets'


// Views - Components
import Buttons from '../views/components/Buttons'
import SocialButtons from '../views/components/SocialButtons'
import Cards from '../views/components/Cards'
import Forms from '../views/components/Forms'
import Modals from '../views/components/Modals'
import Switches from '../views/components/Switches'
import Tables from '../views/components/Tables'


// Views - Icons
import FontAwesome from '../views/icons/FontAwesome'
import SimpleLineIcons from '../views/icons/SimpleLineIcons'

// Views - Pages
import Page403 from '../views/pages/Page403'
import Page404 from '../views/pages/Page404'
import Page500 from '../views/pages/Page500'
import Login from '../views/pages/Login'
import Register from '../views/pages/Register'


// Admin Entities
import Categories from '../views/categories/Category'
import SubmissionLists from '../views/submissions/SubmissionLists'
import PromoCodes from '../views/promocodes/PromoCode'

// User Management
import Users from '../views/users/Users'
import Roles from '../views/roles/Roles'

import Landing from '../views/pages/Landing'
import Success from '../views/pages/Success'
import Confirmation from '../views/pages/Confirmation'

Vue.use(Router)
Vue.use(VueAxios, axios)
axios.defaults.baseURL = '/api'



export default new Router({
  mode: 'history', // Demo is living in GitHub.io, so required!
  linkActiveClass: 'open active',
  scrollBehavior: () => ({ y: 0 }),
  routes: [


    // {
    //     path: '/',
    //     name: 'Landing',
    //     component:Landing,
    //  },
    //  {
    //    path: '/submission/confirmation',
    //    name: 'Landing',
    //    component:Confirmation,
    //  },
     {
      path: '/',
      name: 'Landing',
      redirect: '/users',
      component: Full,
      forbiddenRedirect: '/403',
      children: [
        // {
        //   path: 'dashboard',
        //   name: 'Dashboard',
        //   component: Dashboard,
        //   meta: {
        //    auth: true,
        //    forbiddenRedirect: '/admin/403'
        //   }
        // },
        {
          path: 'users',
          name: 'Users',
          component: Users,
          meta: {
            auth: true
          }
        },
        {
          path: 'roles',
          name: 'Roles',
          component: Roles,
          meta: {
            auth: true
          }
        },
        // {
        //   path: 'submissions',
        //   name: 'Submissions',
        //   redirect: '/admin/submissions/list',
        //   component: {
        //     render (c) { return c('router-view') }
        //   },
        //   meta: {
        //     auth: true
        //   },
        //   children:
        //     [
        //     {
        //       path: 'list',
        //       name: 'Submission List',
        //       component: SubmissionLists,
        //       meta: {
        //         auth: true
        //       }
        //     },
        //   ]
        // },
        // {
        //   path: 'promocodes',
        //   name: 'Promo Codes',
        //   component: PromoCodes,
        //   meta:{
        //     auth:true
        //   }
        // },
        // {
        //   path: 'categories',
        //   name: 'Categories',
        //   component: Categories,
        //   meta:{
        //     auth:true
        //   }
        // },

      ]
    },
   {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: {
      auth: false
    }
   },
   {
    path: '/register',
    name: 'Register',
    component: Register,
  },
  {
   path: '/success',
   name: 'Success',
   component: Success,
 },
  {
    path: '/404',
    name: '404',
    component: Page404,
  },
  {
    path: '/403',
    name: '403',
    component: Page403,
  },
  {
    path: '*',
    redirect: '/404',
  },
  ]
})
