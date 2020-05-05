<style>
.app-header.navbar .navbar-nav {
  flex-direction: row;
  align-items: center;
  margin-right: 50px;
}
</style>
<template>
  <header class="app-header navbar">
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none" type="button" @click="mobileSidebarToggle">&#9776;</button>
    <b-link style="background-size: 100px auto;" class="navbar-brand" to="#"></b-link>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" @click="sidebarMinimize">&#9776;</button>
    <!-- <b-nav is-nav-bar class="d-md-down-none">
      <b-nav-item to="/dashboard" class="px-3">Dashboard</b-nav-item>
      <b-nav-item to="/categories" class="px-3">Categories</b-nav-item>
      <b-nav-item class="px-3">Users</b-nav-item>
      <b-nav-item class="px-3">Settings</b-nav-item>
    </b-nav> -->
    <b-nav is-nav-bar class="ml-auto">
      <!-- <b-nav-item class="d-md-down-none">
        <i class="icon-bell"></i><span class="badge badge-pill badge-danger">5</span>
      </b-nav-item>
      <b-nav-item class="d-md-down-none">
        <i class="icon-list"></i>
      </b-nav-item>
      <b-nav-item class="d-md-down-none">
        <i class="icon-location-pin"></i>
      </b-nav-item> -->
      <b-nav-item-dropdown right>
        <template slot="button-content">
          <!-- <img src="/static/img/elon.jpg" class="img-avatar" alt="profile_image"> -->
          <span class="d-md-down-none">{{ this.$auth.user().name }}</span>
        </template>
        <!-- <b-dropdown-header tag="div" class="text-center"><strong>Account</strong></b-dropdown-header>
        <b-dropdown-item><i class="fa fa-bell-o"></i> Updates<span class="badge badge-info">42</span></b-dropdown-item>
        <b-dropdown-item><i class="fa fa-envelope-o"></i> Messages<span class="badge badge-success">42</span></b-dropdown-item>
        <b-dropdown-item><i class="fa fa-tasks"></i> Tasks<span class="badge badge-danger">42</span></b-dropdown-item>
        <b-dropdown-item><i class="fa fa-comments"></i> Comments<span class="badge badge-warning">42</span></b-dropdown-item>
        <b-dropdown-header tag="div" class="text-center"><strong>Settings</strong></b-dropdown-header>
        <b-dropdown-item><i class="fa fa-user"></i> Profile</b-dropdown-item>
        <b-dropdown-item><i class="fa fa-wrench"></i> Settings</b-dropdown-item>
        <b-dropdown-item><i class="fa fa-usd"></i> Payments<span class="badge badge-default">42</span></b-dropdown-item>
        <b-dropdown-item><i class="fa fa-file"></i> Projects<span class="badge badge-primary">42</span></b-dropdown-item>
        <b-dropdown-divider></b-dropdown-divider>
        <b-dropdown-item><i class="fa fa-shield"></i> Lock Account</b-dropdown-item> -->
        <b-dropdown-item v-if="$auth.check()"  @click.prevent="logout"><i class="fa fa-lock"></i> Logout</b-dropdown-item>
      </b-nav-item-dropdown>
    </b-nav>
    <!-- <button class="navbar-toggler aside-menu-toggler d-md-down-none" type="button" @click="asideToggle">&#9776;</button> -->
  </header>
</template>
<script>
export default {
  name: 'aheader',
  methods: {
    logout(){
      this.$auth.logout({
          makeRequest: true,
          params: {}, // data: {} in axios
          success: function () {},
          error: function () {},
          redirect: '/login',
          // etc...
      });
    },
    sidebarToggle (e) {
      e.preventDefault()
      document.body.classList.toggle('sidebar-hidden')
    },
    sidebarMinimize (e) {
      e.preventDefault()
      document.body.classList.toggle('sidebar-minimized')
    },
    mobileSidebarToggle (e) {
      e.preventDefault()
      document.body.classList.toggle('sidebar-mobile-show')
    },
    asideToggle (e) {
      e.preventDefault()
      document.body.classList.toggle('aside-menu-hidden')
    }
  }
}
</script>
