<template src="../../templates/rolesmanagement/roles.html"></template>

<script>

import Form from '../../helper/form.js';
import Vue from 'vue'
import Simplert from 'vue2-simplert'
import moment from 'moment'
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.min.css';
import { mapActions, mapState } from 'vuex'

export default {
  components: {
    Simplert,
    Loading
  },
  data () {
    return {
      user: this.$auth.user(),
    }
  },
  computed: {
    ...mapState('roles', ['checkRole', 'form', 'isLoading', 'permissions', 'roleHasPermission', 'roles']),
  },
  mounted: function(){
    if (!this.user.can['view_roles']) {
      this.$router.push('/403')
    }
    this.$store.commit('roles/setLoadingStatus', true);
    setTimeout(()=>{
      this.$store.commit('roles/setLoadingStatus', false);
    },1000);
    this.fetchRoles();
    this.fetchPermissions();
  },
  methods: {
    ...mapActions({
      fetchRoles: 'roles/fetchRoles',
      fetchPermissions: 'roles/fetchPermissions',
      fetchUser: 'roles/fetchUser',
      saveRole: 'roles/saveRole',
      updateRole: 'roles/updateRole',
      deleteRole: 'roles/deleteRole',
    }),

    resetForm(){
      this.form.reset();
    },

    addRole(){
      $("#add-role").modal('show');
    },

    // CREATE ROLE
    addNewRole(){
      var self = this;
      this.saveRole();
    },

     // UPDATE ROLE PERMISSIONS
    editRole(id, index){
      var self = this;
      this.updateRole({id, index});
    },

    removeRole(id){
      var self = this;
      
      let confirmFn = () =>  {
        this.deleteRole(id);
      }

      let obj = {
          title: 'Warning',
          message: 'Are you sure you want to delete this role (includes the permissions)?',
          type: 'warning',
          useConfirmBtn: true,
          onConfirm: confirmFn
      }

      this.$refs.deleteconfirmation.openSimplert(obj)
    },
  },
}
</script>
<style>
.sort-icon {
    float: left !important;
    padding-right: 10px;
    margin-top: 4px;
    color:#dd4b39;
}
</style>
