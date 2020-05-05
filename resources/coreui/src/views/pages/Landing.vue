<template>

<div style="height:100vh !important">
  <div class="overlay"></div>
  <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
    <source src="mp4/__bg.mp4" type="video/mp4">
  </video>

  <div class="masthead">
    <div class="masthead-bg"></div>
    <div class="container h-100">
      <div class="row h-100">
        <div class="col-12 my-auto">
          <div style="text-align:center" class="masthead-content text-white py-5 py-md-0">
            <h2 style="color:#fe9004;"><b>MARKET</b>HAZE.CO</h2>
            <h1 class="mb-3">Coming Soon!</h1>
            <p class="mb-5">We're working hard to finish the development of this site. Our target launch date is
              <strong>December 2019</strong>! Sign up for updates using the form below!</p>
            <div class="input-group input-group-newsletter">
              <input type="email" class="form-control" placeholder="Enter email..." aria-label="Enter email..." aria-describedby="basic-addon">
              <div class="input-group-append">
                <button class="btn btn-secondary" type="button">Notify Me!</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="social-icons">
    <ul class="list-unstyled text-center mb-0">
      <li class="list-unstyled-item">
        <a href="#">
          <i class="fab fa-twitter"></i>
        </a>
      </li>
      <li class="list-unstyled-item">
        <a href="#">
          <i class="fab fa-facebook-f"></i>
        </a>
      </li>
      <li class="list-unstyled-item">
        <a href="#">
          <i class="fab fa-instagram"></i>
        </a>
      </li>
    </ul>
  </div>



</div>



</template>

<script>
export default {
  name: 'Landing',
  data(){
    return{
      baseUrl:''
    }
  },
  mounted(){
    this.baseUrl = window.Laravel.baseUrl
  }
}
</script>
