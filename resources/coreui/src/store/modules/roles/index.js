import Form from '../../../helper/form.js';

// state
const state = () => ({
  checkRole: false,
  isLoading: false,
  permissions: [],
  roleHasPermission: [],
  roles: [],
  form: new Form({
    name: '',
    rolePermissions: [],
  }),
})

// mutations
const mutations = {
  setLoadingStatus(state, status) {
    state.isLoading = status
  },

  setPermissions(state, permissions) {
    state.permissions = permissions
  },

  setRoles(state, roles) {
    state.roles = roles
  },

  setcheckRole(state, checkRole) {
    state.checkRole = checkRole
  },

  setRoleHasPermission(state, roleHasPermission) {
    state.roleHasPermission = roleHasPermission
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
  fetchRoles(context) {
    context.state.form.get('roles').then(response => {
      context.commit('setRoles', response);
      context.commit('setcheckRole', true);
    });
  },

  fetchPermissions(context){
    context.state.form.get('permissions').then(response => {
      context.commit('setPermissions', response);
      context.dispatch('checkPermissions');
    });
  },

  checkPermissions(context){
    context.state.form.get('role_permissions').then(response => {
      context.commit('setRoleHasPermission', response);
      // this.selected = this.roleHasPermission[0];
      context.commit('setLoadingStatus', false);
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
  saveRole(context){
    return new Promise((resolve, reject) => {
      context.state.form.post('roles').then(response => {
        toastr.success('Role Added Successfully', 'Success Alert', {timeOut: 5000});
        context.dispatch('fetchRoles');
        context.dispatch('fetchPermissions');
        $("#add-role").modal('hide');
         resolve(response);
      }).catch(error => {
        setTimeout(()=>{
          context.state.form.errors.clear();
        },5000);
        reject(error);
      });
    });
  },

  updateRole(context, { id, index }){
    return new Promise((resolve, reject) => {
      context.commit('setFormValues', { key: 'rolePermissions', value: context.state.roleHasPermission[index] });
      context.state.form.patch('roles/'+id).then(response => {
        if(response.role) {
          toastr.success(response.role.bold() + ' permissions was successfully updated',  'Success Alert', {timeOut: 5000});
          context.dispatch('fetchRoles');
        }
        else {
          toastr.error('Role with id ' + response.id.bold() + ' note found.', 'Error Alert', {timeOut: 5000});
        }
        resolve(response);
      }).catch( error => {
        setTimeout(()=>{
          context.state.form.errors.clear();
        },5000);
        reject(error);
      });
    });
  },

  deleteRole(context, id){
    return new Promise((resolve, reject) => {
      return context.state.form.delete('roles/'+id).then(response => {
        if(response.fail)
          toastr.error(response.fail.bold(), 'Error Alert', {timeOut: 5000});
        else{
          context.dispatch('fetchRoles');
          toastr.success('Role Deleted Successfully', 'Success Alert', {timeOut: 5000});
        }
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