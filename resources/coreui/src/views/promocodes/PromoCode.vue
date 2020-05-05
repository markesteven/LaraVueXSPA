<template>
  <div class="animated fadeIn"> <!-- DONT REMOVE THIS DIV -->

    <div class="row">
      <div class="col-md-6">
         <b-card>
            <div slot="header">
              <strong>Promo Codes</strong>
            </div>

            <filter-bar-promo-code></filter-bar-promo-code>

            <vuetable ref="vuetable" :api-url="vuetable.apiUrl"
              :fields="fields"
              :http-fetch="myFetch"
              pagination-path=""
              :css="css"
              :sort-order="sortOrder"
              :multi-sort="true"
              detail-row-component="promo-code-detail-row"
              :append-params="moreParams"
              @vuetable:cell-clicked="onCellClicked"
              @vuetable:pagination-data="onPaginationData">

                <!-- Template for edit and delete button in action column -->
                <template slot="actions" slot-scope="props">
                  <div class="table-button-container">
                    <div class="custom-actions">
                      <b-button size="sm" variant="primary"  data-toggle="modal"  @click='fetchPromoCode(props.rowData.id)'><i class="fa fa-pencil-square"></i></b-button>
                      <b-button size="sm" variant="danger"  @click='deletePromoCode(props.rowData.id)'><i class="fa fa-trash"></i></b-button>
                    </div>
                  </div>
                </template>

            </vuetable>

            <simplert ref="deleteconfirmation"> </simplert>

            <div class="vuetable-pagination">
              <vuetable-pagination-info ref="paginationInfo"
                info-class="pagination-info"
              ></vuetable-pagination-info>
              <vuetable-pagination ref="pagination"
                :css="css.pagination"
                @vuetable-pagination:change-page="onChangePage"
              ></vuetable-pagination>
            </div>
         </b-card>

        <!-- Modal for updating -->
        <form enctype="multipart/form-data" @submit.prevent="updatePromoCode(formUpdate.id)" @keydown="formUpdate.errors.clear($event.target.code)">
        <div class="modal fade modal-primary" id="edit-promoCode" tabindex="-1" role="dialog" aria-labelledby="editPromoCodeModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editPromoCodeModalLabel">Edit PromoCode - {{formUpdate.code}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                  <b-form-fieldset
                    label="Date"
                    description="Please enter the Date."
                    :label-cols="2"
                    :horizontal="true">
                    <date-picker width="100%" :class="formUpdate.errors.has('date') ? 'form-control is-invalid' : 'form-control' " format="YYYY/MM/DD" v-model="formUpdate.date"   lang="en"></date-picker>
                    <div v-if="formUpdate.errors.has('date')" class="invalid-feedback">
                      {{ formUpdate.errors.get('date') }}
                    </div>
                  </b-form-fieldset>
                  <b-form-fieldset
                    label="Code"
                    description="Please enter the code."
                    :label-cols="2"
                    :horizontal="true">
                    <b-form-input type="text" :class="formUpdate.errors.has('code') ? 'is-invalid' : '' " v-model="formUpdate.code" ></b-form-input>
                    <div v-if="formUpdate.errors.has('code')" class="invalid-feedback">
                      {{ formUpdate.errors.get('code') }}
                    </div>
                  </b-form-fieldset>
              </div>
              <div class="modal-footer">
                <button    type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </div>
        </div>
      </form>
      </div>

      <div class="col-md-6">
          <b-card>
            <div slot="header">
              <strong>Create</strong> PromoCode
            </div>
            <form  enctype="multipart/form-data" @submit.prevent="addNewPromoCode" @keydown="form.errors.clear($event.target.code)">

              <b-form-fieldset
                label="Date"
                description="Please enter the Date."
                :label-cols="2"
                :horizontal="true">
                <date-picker width="100%" :class="form.errors.has('date') ? 'form-control is-invalid' : 'form-control' " format="YYYY/MM/DD" v-model="form.date"   lang="en"></date-picker>
                <div v-if="form.errors.has('date')" class="invalid-feedback">
                  {{ form.errors.get('date') }}
                </div>
              </b-form-fieldset>
              <b-form-fieldset
                label="Code"
                description="Please enter the Promo Code."
                :label-cols="2"
                :horizontal="true">
                <b-form-input type="text" :class="form.errors.has('code') ? 'is-invalid' : '' " v-model="form.code" ></b-form-input>
                <div v-if="form.errors.has('code')" class="invalid-feedback">
                  {{ form.errors.get('code') }}
                </div>
              </b-form-fieldset>


              <div slot="footer" class="pull-right">
                <b-button type="submit" size="sm" variant="primary"><i class="fa fa-dot-circle-o"></i> Create</b-button>
                <b-button  @click="clearForm" type="reset" size="sm" variant="danger"><i class="fa fa-ban"></i> Clear</b-button>
              </div>
            </form>
          </b-card>
      </div><!--/.col-->

  </div><!--/.row-->
  </div>
</template>

<style lang="css">
</style>




<script>

import moment from 'moment'
import Form from '../../helper/form.js';
import Vuetable from 'vuetable-2/src/components/Vuetable'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
import Vue from 'vue'
import VueEvents from 'vue-events'
import DetailRow from './PromoCodeDetailRow'
import FilterBar from './PromoCodeFilterBar'
import Simplert from 'vue2-simplert'
import DatePicker from 'vue2-datepicker';

Vue.use(VueEvents)
Vue.component('promo-code-detail-row', DetailRow)
Vue.component('filter-bar-promo-code', FilterBar)

export default {
  components: {
    Vuetable,
    VuetablePagination,
    VuetablePaginationInfo,
    Simplert,
    DatePicker,
  },
  mounted: function(){

    if (!this.$auth.user().can['view_promocodes']) {
      this.$router.push('/403')
    }

  },
  data () {
    return {
      form: new Form({
        code: '',
        date: moment.now()
      }),
      formUpdate: new Form({
        id: '',
        code: '',
        date: ''
      }),

     vuetable: {apiUrl: 'promocodes'},

     user: this.$auth.user(),

      fields: [
        {
          name: '__sequence',
          title: '#',
          titleClass: 'text-right',
          dataClass: 'text-right'
        },
        {
          name: 'code',
          sortField: 'code',
          // callback: 'allcap',
        },
        {
          name: 'date',
          sortField: 'date'
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
        { field: 'id', sortField: 'date', direction: 'asc'}
      ],
      moreParams: {}
    }
  },
  methods: {



    myFetch(apiUrl, httpOptions) {
      return axios.get(apiUrl, httpOptions)
    },

    // USED FOR VUETABLE FIELD CALLBACK
    allcap (value) {
      return value.toUpperCase()
    },


    clearForm () {
      return value.toUpperCase()
    },

    // FETCH A CATEGORY TO BE FILL UP FOR EDITING
    fetchPromoCode: function(id){


     this.formUpdate.get('promocodes/'+id).then(response => {
        this.formUpdate.originalData = response;
        this.formUpdate.sync();
      });

        $("#edit-promoCode").modal('show');
    },

    // CREATE PROMOCODE
    addNewPromoCode(){
      this.form.date = moment(this.form.date).format("YYYY-MM-DD");
      this.form.post('promocodes')
        .then(response => {
          toastr.success('PromoCode Created Successfully', 'Success Alert', {timeOut: 5000});
          this.$refs.vuetable.refresh();

          this.form.reset();
        }).catch( e => {

          setTimeout(()=>{
            if (typeof this.form.errors !== 'undefined') {
              this.form.errors.clear();
            }

          },5000);


      });
    },

     // UPDATE A PROMOCODE
    updatePromoCode(id){

        this.formUpdate.date = moment(this.formUpdate.date).format("YYYY-MM-DD");
        this.formUpdate.patch('promocodes/'+id).then(response=>{
        this.$refs.vuetable.refresh();
        $("#edit-promoCode").modal('hide');
        toastr.success('PromoCode Updated Successfully', 'Success Alert', {timeOut: 5000});
      }).catch( e => {
        setTimeout(()=>{
          this.formUpdate.errors.clear();
        },5000);
      });;

    },

    // DELETE A PROMOCODE
    deletePromoCode(id){


        let confirmFn = () =>  {
          this.form.delete('promocodes/'+id).then(response => {
            this.$refs.vuetable.refresh();
            toastr.success('PromoCode Deleted Successfully', 'Success Alert', {timeOut: 5000});
          });
        }

        let obj = {
            title: 'Warning',
            message: 'Are you sure you want to delete?',
            type: 'warning',
            useConfirmBtn: true,
            onConfirm: confirmFn
        }

        this.$refs.deleteconfirmation.openSimplert(obj)



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
