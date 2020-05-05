<template>
  <section class="landing" :style="{backgroundImage: 'url(' + baseUrl + '/static/img/main-bg.png' + ')'}">
    <div class="gradient"  :style="{backgroundImage: 'url(' + baseUrl + '/static/img/main-bg.png' + ')'}"></div>
    <div class="cont">
      <div class="logos">
        <div class="tri">

          <img :src="baseUrl + '/static/img/espn-logo.png'" width="100px">
          <img :src="baseUrl + '/static/img/nba-logo.png'" height="100px">
          <img :src="baseUrl + '/static/img/all-access-logo.png'" width="100px">
        </div>
      <center><img :src="baseUrl + '/static/img/sports-center-logo.png'" width="250px"></center>
      </div>

      <div class="box message">
      <div class="box-bg" :style="{backgroundImage: 'url(' + baseUrl + '/static/img/box-bg.png' + ')'}"></div>
        <div v-if="is_confirmed === true" class="title">YOUR ENTRY IS VALID,<br>Thank you for joining!</div>
        <div v-else class="title">CHECK YOUR EMAIL TO VALIDATE YOUR ENTRY,<br>Thank you for joining!</div>
        <!-- <div class="desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div> -->
        <!-- <center><router-link to="register" class="cus-btn" >Register</router-link></center> -->
      </div>

    </div>
  </section>

  <!-- <div class="app flex-row align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">

        <div class="card">
          <div class="card-header">
            Featured
          </div>
          <div class="card-body">
            <h4 class="card-title">YOUR ENTRY IS VALID</h4>
            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          </div>
        </div>

        </div>
      </div>
    </div>
  </div> -->
</template>

<script>
export default {
  name: 'Success',
  data(){
      return {
        is_confirmed: true,
        baseUrl: window.Laravel.baseUrl
    }
  },
  mounted(){
    if (this.$route.params.is_success != true) {
      window.history.length > 1
        ? this.$router.go(-1)
        : this.$router.push('/')
    }else{
      this.is_confirmed = this.$route.params.is_confirmed
    }
  },
}
</script>
