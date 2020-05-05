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

      <div class="box">
        <loading :active.sync="isLoading"
        :is-full-page="false"></loading>
        <div class="box-bg" :style="{backgroundImage: 'url(' + baseUrl + '/static/img/box-bg.png' + ')'}"></div>
        <div class="title">Registration</div>

        <div v-if="is_error" class="alert alert-danger" role="alert">
            {{is_error_msg}}
        </div>

        <form enctype="multipart/form-data" @submit.prevent="register" @keydown="form.errors.clear($event.target.name)">

          <div class="row">


            <label class="full head">All-Access Code</label>
            <input type="text" class="full" :class="form.errors.has('code') ? 'form-control is-invalid' : 'form-control'"
                          v-model="form.code"  placeholder="Enter Code">
            <div v-if="form.errors.has('code')" class="invalid-feedback">
              {{ form.errors.get('code') }}
            </div>
          </div>

          <div class="row">
            <label>Name</label>
            <div class="third">
              <input type="text" :class="form.errors.has('first_name') ? 'form-control is-invalid' : 'form-control' "
                              v-model="form.first_name" placeholder="First">
              <div v-if="form.errors.has('first_name')" class="invalid-feedback">
                {{ form.errors.get('first_name') }}
              </div>
            </div>
            <div class="third">
              <input type="text" :class="form.errors.has('middle_name') ? 'form-control is-invalid' : 'form-control' "
                              v-model="form.middle_name" placeholder="Middle">
              <div v-if="form.errors.has('middle_name')" class="invalid-feedback">
                {{ form.errors.get('middle_name') }}
              </div>
            </div>
            <div class="third">
              <input type="text" :class="form.errors.has('last_name') ? 'form-control is-invalid' : 'form-control' "
                              v-model="form.last_name" placeholder="Last">
              <div v-if="form.errors.has('last_name')" class="invalid-feedback">
                {{ form.errors.get('last_name') }}
              </div>
            </div>
          </div>

          <div class="row">
            <label>Address</label>
            <div class="third">
              <input type="text" :class="form.errors.has('street_name') ? 'form-control is-invalid' : 'form-control' "
                              v-model="form.street_name" placeholder="Street Name">
              <div v-if="form.errors.has('street_name')" class="invalid-feedback">
               {{ form.errors.get('street_name') }}
              </div>
            </div>
            <div class="third">
              <input type="text" :class="form.errors.has('barangay') ? 'form-control is-invalid' : 'form-control' "
                              v-model="form.barangay" placeholder="Barangay/Subdivision">
              <div v-if="form.errors.has('barangay')" class="invalid-feedback">
                {{ form.errors.get('barangay') }}
              </div>
            </div>
            <div class="third">
              <input type="text" :class="form.errors.has('city') ? 'form-control is-invalid' : 'form-control' "
                              v-model="form.city" placeholder="City">
              <div v-if="form.errors.has('city')" class="invalid-feedback">
                {{ form.errors.get('city') }}
              </div>
            </div>
          </div>

          <div class="row">
            <label class="full">Mobile Number</label>
            <input type="text" class="full" :class="form.errors.has('mobile_number') ? 'form-control is-invalid' : 'form-control' "
                            v-model="form.mobile_number" placeholder="+693">
            <div v-if="form.errors.has('mobile_number')" class="invalid-feedback">
              {{ form.errors.get('mobile_number') }}
            </div>
          </div>

          <div class="row">
            <label class="full">Email Address</label>
            <input type="text" class="full" :class="form.errors.has('email_address') ? 'form-control is-invalid' : 'form-control' "
                            v-model="form.email_address" placeholder="Please enter a valid email address">
            <div v-if="form.errors.has('email_address')" class="invalid-feedback">
              {{ form.errors.get('email_address') }}
            </div>
          </div>

          <div class="row">
            <input type="checkbox" id="in-agreement" name="in-radio" v-model="is_agree">
            <label class="agree" for="in-agreement">I agree to the Terms and Conditions and Data Privacy Regulation as stated in the</label>
            <!-- <label class="agree popup-btn" @click="showModal = true">Full mechanics.</label> -->

            <label class="agree popup-btn" @click="showModal = true">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#popup-mechanics">
                Full Mechanics
              </button>
            </label>
            <!-- <button id="show-modal" @click="showModal = true">Show Modal</button> -->

          </div>

          <Mechanics></Mechanics>

          <center class="capcha-cont">
            <template>
              <vue-recaptcha
                ref="recaptcha"
                @verify="onVerify"
                @expired="onExpired"
                :sitekey="sitekey">
              </vue-recaptcha>
            </template>
          </center>

          <center><button :disabled="isDisabled" type="submit" class="cus-btn">Submit</button></center>
        </form>
      </div>

    </div>
  </section>


  <!-- <div class="app flex-row align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card mx-4">
            <div class="card-body p-4">
              <h2>Register</h2>
              <div v-if="is_error" class="alert alert-danger" role="alert">
                  {{is_error_msg}}
              </div>
              <form  enctype="multipart/form-data" @submit.prevent="register" @keydown="form.errors.clear($event.target.name)">
                <div class="form-group row">
                   <label for="code" class="col-sm-3 col-form-label">ALL-ACCESS CODE</label>
                   <div class="col-sm-9">
                     <input type="text" :class="form.errors.has('code') ? 'form-control is-invalid' : 'form-control' "
                                     v-model="form.code"  placeholder="enter code">
                     <div v-if="form.errors.has('code')" class="invalid-feedback">
                       {{ form.errors.get('code') }}
                     </div>
                   </div>
                 </div>

                 <div class="form-group row">
                    <label for="code" class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-3">
                      <input type="text" :class="form.errors.has('first_name') ? 'form-control is-invalid' : 'form-control' "
                                      v-model="form.first_name" placeholder="First">
                      <div v-if="form.errors.has('first_name')" class="invalid-feedback">
                        {{ form.errors.get('first_name') }}
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <input type="text" :class="form.errors.has('middle_name') ? 'form-control is-invalid' : 'form-control' "
                                      v-model="form.middle_name" placeholder="Middle">
                      <div v-if="form.errors.has('middle_name')" class="invalid-feedback">
                        {{ form.errors.get('middle_name') }}
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <input type="text" :class="form.errors.has('last_name') ? 'form-control is-invalid' : 'form-control' "
                                      v-model="form.last_name" placeholder="Last">
                      <div v-if="form.errors.has('last_name')" class="invalid-feedback">
                        {{ form.errors.get('last_name') }}
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                     <label for="code" class="col-sm-3 col-form-label">Address</label>
                     <div class="col-sm-3">
                       <input type="text" :class="form.errors.has('street_name') ? 'form-control is-invalid' : 'form-control' "
                                       v-model="form.street_name" placeholder="Street Name">
                       <div v-if="form.errors.has('street_name')" class="invalid-feedback">
                         {{ form.errors.get('street_name') }}
                       </div>
                     </div>
                     <div class="col-sm-3">
                       <input type="text" :class="form.errors.has('barangay') ? 'form-control is-invalid' : 'form-control' "
                                       v-model="form.barangay" placeholder="Barangay/Subdivision">
                       <div v-if="form.errors.has('barangay')" class="invalid-feedback">
                         {{ form.errors.get('barangay') }}
                       </div>
                     </div>
                     <div class="col-sm-3">
                       <input type="text" :class="form.errors.has('city') ? 'form-control is-invalid' : 'form-control' "
                                       v-model="form.city" placeholder="City">
                       <div v-if="form.errors.has('city')" class="invalid-feedback">
                         {{ form.errors.get('city') }}
                       </div>
                     </div>
                   </div>

                 <div class="form-group row">
                    <label for="code" class="col-sm-3 col-form-label">Mobile Number</label>
                    <div class="col-sm-9">
                      <input type="text" :class="form.errors.has('mobile_number') ? 'form-control is-invalid' : 'form-control' "
                                      v-model="form.mobile_number" placeholder="Mobile Number">
                      <div v-if="form.errors.has('mobile_number')" class="invalid-feedback">
                        {{ form.errors.get('mobile_number') }}
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                     <label for="code" class="col-sm-3 col-form-label">Email Address</label>
                     <div class="col-sm-9">
                       <input type="text" :class="form.errors.has('email_address') ? 'form-control is-invalid' : 'form-control' "
                                       v-model="form.email_address" placeholder="Email Address">
                       <div v-if="form.errors.has('email_address')" class="invalid-feedback">
                         {{ form.errors.get('email_address') }}
                       </div>
                     </div>
                   </div>

                  <div class="form-group">
                    <div class="col-sm-3">
                      <input class="form-check-input" type="checkbox" v-model="is_agree">
                      <label  class="form-check-label">
                        I Agree
                      </label>
                    </div>
                  </div>

                  <template>
                    <vue-recaptcha
                      ref="recaptcha"
                      @verify="onVerify"
                      @expired="onExpired"
                      :sitekey="sitekey">
                    </vue-recaptcha>
                  </template>



                 <div class="form-group row">
                   <div class="col-sm-10">
                     <button :disabled="isDisabled" type="submit" class="btn btn-primary">Sign in</button>
                   </div>
                 </div>



              </form>
          </div>

          </div>
        </div>
      </div>
    </div>
  </div> -->
</template>

<script>
import Form from '../../helper/form.js'
import Loading from 'vue-loading-overlay'
import VueRecaptcha from 'vue-recaptcha'
import Mechanics from '../../views/pages/Mechanics.vue'

export default {
  	components: { VueRecaptcha,Loading,Mechanics },
     data(){
         return {
             sitekey: '6LfAOI0UAAAAADvC1kOW9el8q36OFv0_4RO5IIP5',
             isLoading: false,
             baseUrl: window.Laravel.baseUrl,
             form: new Form({
               code: '',
               first_name: '',
               middle_name: '',
               last_name: '',
               street_name: '',
               barangay: '',
               city: '',
               mobile_number: '',
               email_address: ''
             }),
             is_agree: false,
             is_disabled: true,
             isRecaptchaVerified:false,
             is_error: false,
             is_error_msg: ''
         };
     },
     methods: {
         register(){

           this.isLoading = true
           this.form.post('submissions')
             .then(response => {
               // toastr.success('Submitted Successfully', 'Success Alert', {timeOut: 5000});


               if ( typeof response.error !== 'undefined') {
                 this.is_error = true
                 this.is_error_msg = response.message
                 this.isLoading = false
                 setTimeout(()=>{
                    this.is_error = false
                 },5000);

               }else{

                 setTimeout(()=>{
                   this.form.reset();
                   this.isLoading = false
                   this.$router.push({ name: 'Success', params: { is_success: true , is_confirmed: response.data.is_confirmed } })
                 },1000);


               }


             }).catch( e => {

               this.isLoading = false

               setTimeout(()=>{

                 if (typeof this.form.errors !== 'undefined') {
                   this.form.errors.clear();
                 }

               },5000);


           });
         },
         onVerify: function (response) {
            // console.log('Verify: ' + response)
            this.isRecaptchaVerified = true
          },
          onExpired: function () {
            this.isRecaptchaVerified = false
         },
     },

     computed: {
     	isDisabled(){
      		return   !this.isRecaptchaVerified || !this.is_agree;
     	}
     }
 }
</script>
