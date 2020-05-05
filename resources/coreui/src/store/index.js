import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

import users from './modules/users/index'
import roles from './modules/roles/index'

export default new Vuex.Store({
  modules: {
    users,
    roles
  }
})