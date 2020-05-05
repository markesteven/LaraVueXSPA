import Form from '../../../helper/form.js';

// state
const state = () => ({
  form: new Form({
    id: '',
    name: '',
    email: '',
    password: '',
    roles: '',
  }),
  isLoading: false,
  users: [],
  roles: []
})

// mutations
const mutations = {
  setLoadingStatus(state, status) {
    state.isLoading = status
  },

  setUsers(state, users) {
    state.users = users
  },

  setRoles(state, roles) {
    state.roles = roles
  },

  setFormValues(state, { key, value }) {
    state.form[key] = value
  },

  resetForm(state) {
    state.form.reset();
  }
}

// actions
const actions = {
  fetchUsers(context) {
    context.state.form.get('users').then(response => {
      context.commit('setUsers', response.data);
    });
  },

  fetchRoles(context) {
    context.state.form.get('roles').then(response => {
      context.commit('setRoles', response);
    });
  },

  fetchUser(context, id){
    context.state.form.get('users/'+id).then(response => {
      context.state.form.originalData = response;
      context.state.form.sync();
      context.commit('setFormValues', { key: 'roles', value: response.roles[0].id });

      $("#edit-user").modal('show');
    });
  },

  // CREATE USER
  saveUser(context){
    return new Promise((resolve, reject) => {
      context.state.form.post('users').then(response => {
        toastr.success('User Created Successfully', 'Success Alert', {timeOut: 5000});
        // this.page = 'view_list';
        context.commit('resetForm');
         $("#add-user").modal('hide');
         resolve(response);
      }).catch(error => {
        setTimeout(()=>{
          context.state.form.errors.clear();
        },5000);
        reject(error);
      });
    });
  },

  updateUser(context, id){
    return new Promise((resolve, reject) => {
      context.commit('setFormValues', { key: 'pass', value: context.state.form.password });
      context.state.form.pass = context.state.form.password;
      context.state.form.patch('users/'+id).then(response => {
        toastr.success('User Updated Successfully', 'Success Alert', {timeOut: 5000});
        $("#edit-user").modal('hide');
        resolve(response);
      }).catch( error => {
        setTimeout(()=>{
          context.state.form.errors.clear();
        },5000);
        reject(error);
      });
    });
  },

  deleteUser(context, id){
    return new Promise((resolve, reject) => {
      return context.state.form.delete('users/'+id).then(response => {
        // if(response.fail)
        //   toastr.success(response.fail, 'Success Alert', {timeOut: 5000});
        // else{
        //   toastr.error('Role with id ' + response.id + ' note found.', 'Error Alert', {timeOut: 5000});
        //   this.$refs.vuetable.refresh();
        // }
        toastr.success('User Deleted Successfully', 'Success Alert', {timeOut: 5000});
        resolve(response);
      }).catch( error => {
        reject(error);
      });;
    });
  },
}

// getters
const getters = {
  users (state) {
    return state.users
  },

  roles (state) {
    return state.roles
  },
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}