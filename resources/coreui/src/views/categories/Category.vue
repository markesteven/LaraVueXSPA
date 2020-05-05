<template>
  <div class="animated fadeIn"> <!-- DONT REMOVE THIS DIV -->

    <div class="row">
      <div class="col-md-6">
         <b-card>
            <div slot="header">
              <strong>Categories</strong>
            </div>

            <filter-bar-category></filter-bar-category>

            <vuetable ref="vuetable" :http-options="{ headers: {Authorization: `Bearer ${this.$auth.token()}`} }" api-url="/api/categories"
              :fields="fields"
              pagination-path=""
              :css="css"
              :sort-order="sortOrder"
              :multi-sort="true"
              detail-row-component="my-detail-row"
              :append-params="moreParams"
              @vuetable:cell-clicked="onCellClicked"
              @vuetable:pagination-data="onPaginationData">

                <!-- Template for edit and delete button in action column -->
                <template slot="actions" slot-scope="props">
                  <div class="table-button-container">
                    <div class="custom-actions">
                      <b-button size="sm" variant="primary"  data-toggle="modal"  @click='fetchCategory(props.rowData.id)'><i class="fa fa-pencil-square"></i></b-button>
                      <b-button size="sm" variant="danger"  @click='deleteCategory(props.rowData.id)'><i class="fa fa-trash"></i></b-button>
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
        <form enctype="multipart/form-data" @submit.prevent="updateCategory(formUpdate.id)" @keydown="formUpdate.errors.clear($event.target.name)">
        <div class="modal fade modal-primary" id="edit-category" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit Category - {{formUpdate.name}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div v-if="!imageUpdate">
                    <h5>Select an image</h5>
                    <input type="file" name="imageUpdate" id="imageUpdate"  v-on:change="onFileChangeUpdate" >
                </div>
                <div v-else>
                  <img height="300" width="300" :src="imageUpdate" />
                  <button @click="removeImageUpdate">Remove image</button>
                </div><hr>
                  <b-form-fieldset
                    label="Name"
                    description="Please enter the category name."
                    :label-cols="2"
                    :horizontal="true">
                    <b-form-input type="text" :class="formUpdate.errors.has('name') ? 'is-invalid' : '' " v-model="formUpdate.name" ></b-form-input>
                    <div v-if="formUpdate.errors.has('name')" class="invalid-feedback">
                      {{ formUpdate.errors.get('name') }}
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
              <strong>Create</strong> Category
            </div>
            <form  enctype="multipart/form-data" @submit.prevent="addNewCategory" @keydown="form.errors.clear($event.target.name)">

              <div v-if="!image">
                  <h5>Select an image</h5>
                  <input type="file" name="image" id="image"  v-on:change="onFileChange" >
              </div>
              <div v-else>
                <img height="300" width="300" :src="image" />
                <button @click="removeImage">Remove image</button>
              </div><hr>

              <b-form-fieldset
                label="Name"
                description="Please enter the category name."
                :label-cols="2"
                :horizontal="true">
                <b-form-input type="text" :class="form.errors.has('name') ? 'is-invalid' : '' " v-model="form.name" ></b-form-input>
                <div v-if="form.errors.has('name')" class="invalid-feedback">
                  {{ form.errors.get('name') }}
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

import Form from '../../helper/form.js';
import Vuetable from 'vuetable-2/src/components/Vuetable'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
import Vue from 'vue'
import VueEvents from 'vue-events'
import DetailRow from './CategoryDetailRow'
import FilterBar from './CategoryFilterBar'
import Simplert from 'vue2-simplert'

Vue.use(VueEvents)
Vue.component('my-detail-row', DetailRow)
Vue.component('filter-bar-category', FilterBar)

export default {
  components: {
    Vuetable,
    VuetablePagination,
    VuetablePaginationInfo,
    Simplert,
  },
  mounted: function(){
    //
  },
  data () {
    return {
      image:'',
      imageUpdate:'',
      isImageUpdated:false,
      form: new Form({
        name: '',
        image: ''
      }),
      formUpdate: new Form({
        id: '',
        name: '',
        image: ''
      }),

      fields: [
        {
          name: '__sequence',
          title: '#',
          titleClass: 'text-right',
          dataClass: 'text-right'
        },
        {
          name: 'name',
          sortField: 'name',
          callback: 'allcap',
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
  methods: {

    // USED FOR VUETABLE FIELD CALLBACK
    allcap (value) {
      return value.toUpperCase()
    },


    clearForm () {
      return value.toUpperCase()
    },

    // FETCH A CATEGORY TO BE FILL UP FOR EDITING
    fetchCategory: function(id){

    this.isImageUpdated = false;

     this.formUpdate.get('categories/'+id).then(response => {
        this.formUpdate.originalData = response;
        this.formUpdate.sync();
        this.imageUpdate=response.image;
      });

        $("#edit-category").modal('show');
    },

    // CREATE CATEGORY
    addNewCategory(){

      this.form.image = this.image;
      this.form.post('categories')
        .then(response => {
          toastr.success('Category Created Successfully', 'Success Alert', {timeOut: 5000});
          this.$refs.vuetable.refresh();

          this.form.reset();
          this.image = "";
        }).catch( e => {

          setTimeout(()=>{
              console.log(e)
            if (typeof this.form.errors !== 'undefined') {
              this.form.errors.clear();
            }

          },5000);


      });
    },

     // UPDATE A CATEGORY
    updateCategory(id){

       if (this.isImageUpdated==true) {
         this.formUpdate.image = this.imageUpdate;
       }else{
          // this.formUpdate.image = "";
       }

        this.formUpdate.patch('categories/'+id).then(response=>{
        this.$refs.vuetable.refresh();
        this.imageUpdate='';
        $("#edit-category").modal('hide');
        toastr.success('Category Updated Successfully', 'Success Alert', {timeOut: 5000});
      }).catch( e => {
        setTimeout(()=>{
          this.formUpdate.errors.clear();
        },5000);
      });;

    },

    // DELETE A CATEGORY
    deleteCategory(id){


        let confirmFn = () =>  {
          this.form.delete('categories/'+id).then(response => {
            this.$refs.vuetable.refresh();
            toastr.success('Category Deleted Successfully', 'Success Alert', {timeOut: 5000});
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

    onFileChange(event) {

           this.errors = {};

           let files = event.target.files || event.dataTransfer.files;

           if (!files.length) {
               return;
           }

          this.createImage(files[0]);


       },

     onFileChangeUpdate(event) {

            this.errors = {};

            let files = event.target.files || event.dataTransfer.files;

            if (!files.length) {
                return;
            }

           this.createImageUpdate(files[0]);
           this.isImageUpdated = true;



        },

       createImage(file) {
         var image = new Image();
         var reader = new FileReader();
         var vm = this;

         reader.onload = (e) => {
           vm.image = e.target.result;
           this.form.image = e.target.result;
         };
         reader.readAsDataURL(file);
       },

       createImageUpdate(file) {
         var imageUpdate = new Image();
         var reader = new FileReader();
         var vm = this;

         reader.onload = (e) => {
           vm.imageUpdate  = e.target.result;
           this.formUpdate.image = e.target.result;
         };
         reader.readAsDataURL(file);
       },

    removeImage: function (e) {
        if (e) e.preventDefault()
          this.image = '';
          this.form.image= '';
      },
      removeImageUpdate: function (e) {
          if (e) e.preventDefault()
          this.imageUpdate = '';
          this.formUpdate.image = '';
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
