<template>
  <div>
    <loading :active.sync="isLoading"
             :can-cancel="false"
             :is-full-page="true"></loading>
    <div class="app flex-row align-items-center">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-5">
            <div class="card-group mb-0">
              <div class="card p-4">
                <div class="card-body">
                  <h1>Login</h1>
                  <p class="text-muted">Sign In to your account</p>
                  <form autocomplete="off" @submit.prevent="login">
                    <div class="input-group mb-3">
                      <span class="input-group-addon"><i class="icon-user"></i></span>
                      <input v-model="email" type="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="input-group mb-4">
                      <span class="input-group-addon"><i class="icon-lock"></i></span>
                      <input v-model="password" type="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <button type="submit" class="btn btn-primary px-4">Login</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Loading from 'vue-loading-overlay';
  import 'vue-loading-overlay/dist/vue-loading.min.css';

  export default {
    data(){
      return {
        email: null,
        password: null,
        error: false,
        isLoading: false
      }
    },
    components: {
      Loading
    },
    methods: {
      login(){
        var app = this
        this.isLoading = true;
        this.$auth.login({
            method :'POST',
            data: {
              email: app.email,
              password: app.password
            },
            success: function () {
            },
            error: function () {
              this.isLoading = false
            },
            rememberMe: true,
            redirect: '/users',
            fetchUser: true,
        });
      },
    }
  }
</script>
