<template src="../../templates/rolesmanagement/users.html"></template>

<script>

import Form from '../../helper/form.js';
import Vuetable from 'vuetable-2/src/components/Vuetable'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
import Vue from 'vue'
import VueEvents from 'vue-events'
import UserDetailRow from './UserDetailRow'
import UserFilterBar from './UserFilterBar'
import Simplert from 'vue2-simplert'
import moment from 'moment'
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.min.css';
import { mapActions, mapState } from 'vuex'


Vue.use(VueEvents)
Vue.component('user-detail-row', UserDetailRow)
Vue.component('user-filter-bar', UserFilterBar)

export default {
  components: {
    Vuetable,
    VuetablePagination,
    VuetablePaginationInfo,
    Simplert,
    Loading,
  },
  data () {
    return {
      user: this.$auth.user(),

      fields: [
        {
          	name: 'id',
          	title: 'Id',
          	titleClass: 'text-right',
          	dataClass: 'text-right',
          	sortField: 'id'
        },
        {
          	name: 'name',
          	title: 'Name',
          	sortField: 'name',
        },
        {
        	name: 'email',
        	title: 'Email',
          sortField: 'email'
        },
        {
        	name: 'roles',
        	title: 'Role',
        	callback: 'getRole',
          // sortField: 'role'
        },
        {
        	name: 'created_at',
        	title: 'Created At',
        	callback: 'formatDate|D/MM/Y',
          sortField: 'created_at'
        },

        '__slot:actions'
      ],

      css: {

        tableClass: 'ui blue selectable celled stackable attached table',
        loadingClass: 'loading',
        ascendingIcon: 'pull-left glyphicon glyphicon-chevron-up',
        descendingIcon: 'pull-left glyphicon glyphicon-chevron-down',

        pagination: {
          wrapperClass: 'pagination pull-right',
          activeClass: 'btn-primary',
          disabledClass: 'disabled',
          pageClass: 'btn btn-border',
          linkClass: 'btn btn-border',
          icons: {
            first: '',
            prev: '',
            next: '',
            last: '',
          }
        }
      },

      sortOrder: [
        { field: 'id', sortField: 'id', direction: 'asc'}
      ],
      moreParams: {}
    }
  },
  created(){
    if (!this.user.can['view_users']) {
      this.$router.push('/403')
    }
    this.$store.commit('users/setLoadingStatus', true);
    setTimeout(()=>{
      this.$store.commit('users/setLoadingStatus', false);
    },1000);
  },
  computed: {
    ...mapState('users', ['form', 'roles', 'isLoading', 'users', 'form']),
    // ...mapGetters('users', ['users'])
  },
  mounted: function(){
    this.fetchRoles();
    // this.fetchUsers();
  },
  methods: {
    ...mapActions({
      fetchRoles: 'users/fetchRoles',
      fetchUsers: 'users/fetchUsers',
      fetchUser: 'users/fetchUser',
      saveUser: 'users/saveUser',
      updateUser: 'users/updateUser',
      deleteUser: 'users/deleteUser',
    }),

    getRole(value){
      return value[0].name
    },

  	formatDate: function(value, fmt) {
      if (value == null) return ''
      fmt = (typeof fmt == 'undefined') ? 'D MMM YYYY' : fmt
      return moment(String(value)).format('MMMM DD, YYYY')
    },

    showAddUserModal()
    {
      this.form.reset();
      $("#add-user").modal('show');
    },

    resetForm(){
      this.form.reset();
    },    

    addNewUser() {
      var self = this;
      this.saveUser().then(function() {
        self.$refs.vuetable.reload();
      });
    },

    editUser(id) {
      var self = this;
      this.updateUser(id).then(function() {
        self.$refs.vuetable.reload();
      });
    },

    removeUser(id) {
      var self = this;
      
      let confirmFn = () =>  {
        this.deleteUser(id).then(function() {
          self.$refs.vuetable.reload();
        });
      }

      let obj = {
        title: 'Warning',
        message: 'Are you sure you want to delete this user?',
        type: 'warning',
        useConfirmBtn: true,
        onConfirm: confirmFn
      }

      this.$refs.deleteconfirmation.openSimplert(obj);
    },

    onPaginationData (paginationData) {
      this.$refs.pagination.setPaginationData(paginationData)
      this.$refs.paginationInfo.setPaginationData(paginationData)
    },

    onChangePage (page) {
      this.$refs.vuetable.changePage(page)
    },

    onCellClicked (data, field, event) {
      console.log('cellClicked: ', field.name)
      this.$refs.vuetable.toggleDetailRow(data.id)
    },
  },
  events: {
    'filter-set' (filterText) {
      this.moreParams = {
        filter: filterText
      }
      Vue.nextTick( () => this.$refs.vuetable.refresh() )
    },
    'filter-reset' () {
      this.moreParams = {}
      Vue.nextTick( () => this.$refs.vuetable.refresh() )
    }
  }
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
