<template>
  <div class="animated fadeIn">

    <loading :active.sync="isLoading"
    :is-full-page="true"></loading>
        <div class="pull-right">
          <button v-on:click="refresh" class="btn btn-success">Refresh</button>
            <download-excel
              v-if="user.can['export_submissions']" 
              class   = "btn btn-primary"
              :data   = "exc_data"
              :fields = "exc_fields"
              type    = "xls"
              :name    = "exc_file_name">
              EXPORT
            </download-excel>
          <hr>
        </div>
        <div class="clearfix">

        </div>
    <div  v-if="!isLoading" class="col-md-12">

     <datatable  v-bind="$data" :total="total" />

    </div>


  </div>
</template>

<script>
import accounting from 'accounting'
import moment from 'moment'
import Vuetable from 'vuetable-2/src/components/Vuetable'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
import Vue from 'vue'
import VueEvents from 'vue-events'
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.min.css';
import Simplert from 'vue2-simplert'
import Form from '../../helper/form.js';

import uniq from 'lodash/uniq'
import orderBy from 'lodash/orderBy'
import FilterTh from './comps/th-Filter'
import IP from './comps/td-IP'
import CreateTimeTD from './comps/td-Createtime'
import Opt from './comps/td-Opt'
import DisplayRow from './comps/nested-DisplayRow'
import downloadExcel from 'vue-json-excel'

Vue.use(VueEvents)

const typeOf = o => Object.prototype.toString.call(o).slice(8, -1).toLowerCase()
const purify = o => JSON.parse(JSON.stringify(o)) // purify data
const amINestedComp = !!this.row


export default {
  props: ['row'], // from the parent FriendsTable (if exists)
  components: {
    Vuetable,
    VuetablePagination,
    VuetablePaginationInfo,
    Loading,
    Simplert,
    FilterTh ,IP,CreateTimeTD,Opt,DisplayRow,
    downloadExcel,
  },
  data () {
    return {
      form: new Form({
        name: ''
      }),
      user: this.$auth.user(),
      exc_file_name :'',
      exc_fields:{},
      exc_data:[],
      isLoading: false,
      HeaderSettings:false,
      supportBackup: false,
      supportNested: true,
      tblClass: 'table-bordered',
      tblStyle: 'color: #666',
      pageSizeOptions: [1, 10, 15, 20],
      columns: (() => {
        const cols = [
          { title: 'ID', field: 'id', label: 'ID', sortable: true },
          { title: 'Code', field: 'code',  thComp: 'FilterTh' },
          { title: 'First Name', field: 'first_name',  thComp: 'FilterTh' },
          { title: 'Middle Name', field: 'middle_name',  thComp: 'FilterTh' },
          { title: 'Last Name', field: 'last_name',  thComp: 'FilterTh' },
          { title: 'Street Name', field: 'street_name',  thComp: 'FilterTh' },
          { title: 'Barangay', field: 'barangay',  thComp: 'FilterTh' },
          { title: 'City', field: 'city',  thComp: 'FilterTh' },
          { title: 'Mobile Number', field: 'mobile_number',  thComp: 'FilterTh' },
          { title: 'Email', field: 'email_address',  thComp: 'FilterTh' },
          { title: 'Valid', field: 'is_valid', thComp: 'FilterTh'},
          { title: 'Confirmed', field: 'is_confirmed', thComp: 'FilterTh' },
          { title: 'Submitted On', field: 'created_at',  sortable: true, tdComp: 'CreateTimeTD' },

          // { title: 'Country', field: 'country', thComp: 'FilterTh', thStyle: { fontWeight: 'normal' } },
          // { title: 'IP', field: 'ip', visible: false, tdComp: 'IP' },
          // { title: 'Age', field: 'age', sortable: true, thClass: 'text-info', tdClass: 'text-success' },
          // { title: 'Create time', field: 'createTime', sortable: true, colClass: 'w-240', thComp: 'CreatetimeTh', tdComp: 'CreatetimeTd' },
          // { title: 'Color', field: 'color', explain: 'Favorite color', visible: false, tdComp: 'Color' },
          // { title: 'Language', field: 'lang', visible: false, thComp: 'FilterTh' },
          // { title: 'PL', field: 'programLang', explain: 'Programming Language', visible: false, thComp: 'FilterTh' },
          // { title: 'Operation', tdComp: 'Opt', visible: 'true' }
        ]
        const groupsDef = {
          Normal: ['Email', 'Username', 'Country', 'IP'],
          Sortable: ['UID', 'Age', 'Create time'],
          Extra: ['Operation', 'Color', 'Language', 'PL']
        }
        return cols.map(col => {
          Object.keys(groupsDef).forEach(groupName => {
            if (groupsDef[groupName].includes(col.title)) {
              col.group = groupName
            }
          })
          return col
        })
      })(),
       data: [],
       total: 0,
       query: {},
       allRows: [],
        query: amINestedComp ? { uid: this.row } : {},
       xprops: {
        eventbus: new Vue()
      }
    }
  },

  created(){
      // console.log(window.Laravel.baseUrl)

      if (!this.$auth.user().can['view_submissions']) {
        this.$router.push('/403')
      }

      this.isLoading = true
      axios.get('submissions')
         .then(response => {
           // JSON responses are automatically parsed.
           // this.posts = response.data
           this.isLoading = false
           this.allRows = response.data;
           this.total = this.allRows.length;
           this.data = this.allRows.slice(0, 10);

           var now = new Date();
           this.exc_file_name =  'submissionreports-'+ now.getFullYear() + "-"+ now.getMonth() + "-" + now.getDate() +'.xls'
           // this.exc_fields = this.columns
           // this.exc_data = this.data
           for (var i = 0; i < this.columns.length; i++) {
             if (typeof this.columns[i]['visible'] !== 'undefined' && this.columns[i]['visibility']==false) {
               //do nothing
             }else{
               if (this.columns[i]['title'] != 'Operation') {
                 this.exc_fields[this.columns[i]['title']]  = this.columns[i]['field']
               }
             }
           }



         })
         .catch(e => {
           this.errors.push(e)
           this.isLoading = false
         })




  },

  methods: {
    formatDate (value, fmt = 'D MMM YYYY') {
      return (value == null)
        ? ''
        : moment(value, 'YYYY-MM-DD HH:mm').format(fmt)
    },
    onPaginationData (paginationData) {
      this.$refs.pagination.setPaginationData(paginationData)
      this.$refs.paginationInfo.setPaginationData(paginationData)
    },
    onChangePage (page) {
      this.$refs.vuetable.changePage(page)
    },
    onCellClicked (data, field, event) {
      this.$refs.vuetable.toggleDetailRow(data.id)
    },

    refresh(){
      this.isLoading = true
      axios.get('submissions')
         .then(response => {
           // JSON responses are automatically parsed.
           // this.posts = response.data
           this.isLoading = false
           this.allRows = response.data;
           this.total = this.allRows.length;
           this.data = this.allRows.slice(0, 10);

         })
         .catch(e => {
           this.errors.push(e)
           this.isLoading = false
         })

    }

  },

  watch: {
    query: {
        handler (query) {
          query = purify(query)
          const { limit = 10, offset = 0, sort = '', order = '' } = query

          // this.data = this.allRows.slice(query.offset, query.offset + query.limit)
          let rows = this.allRows;

            // custom query conditions
            ['code','email_address','first_name','last_name','middle_name','street_name','barangay',
                 'city','mobile_number','is_valid','is_confirmed'].forEach(field => {
              switch (typeOf(query[field])) {

                case 'array':
                  rows = rows.filter(row => query[field].includes(row[field]))
                  break
                case 'string':

                    if (field=="is_valid" || field == "is_confirmed") {
                      rows = rows.filter(row => row[field].toString().includes(query[field].toString()))
                    }
                    else{
                      rows = rows.filter(row => row[field].toLowerCase().includes(query[field].toLowerCase()))
                    }


                  break
                default:
                  // nothing to do
                  break
              }
            })

            if (query.sort) {
              rows = orderBy(rows, sort, order)
            }

            const res = {
              rows: rows.slice(offset, offset + limit),
              total: rows.length,

            }

            this.data = rows.slice(offset, offset + limit)

            this.exc_data = rows

            this.total = rows.length


        },
              deep: true
          },


              columns:{
                handler () {
                  this.exc_fields={}
                  for (var i = 0; i < this.columns.length; i++) {
                    if (typeof this.columns[i]['visible'] !== 'undefined' && this.columns[i]['visible']==false) {
                      //do nothing
                    }else{
                      if (this.columns[i]['title'] != 'Operation') {
                        this.exc_fields[this.columns[i]['title']]  = this.columns[i]['field']
                      }
                    }


                  }
                }
              }
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
.table{
  background: #fff;
}
.pagination {
  margin: 0;
  float: right;
}
.pagination a.page {
  border: 1px solid lightgray;
  border-radius: 3px;
  padding: 5px 10px;
  margin-right: 2px;
}
.pagination a.page.active {
  color: white;
  background-color: #337ab7;
  border: 1px solid lightgray;
  border-radius: 3px;
  padding: 5px 10px;
  margin-right: 2px;
}
.pagination a.btn-nav {
  border: 1px solid lightgray;
  border-radius: 3px;
  padding: 5px 7px;
  margin-right: 2px;
}
.pagination a.btn-nav.disabled {
  color: lightgray;
  border: 1px solid lightgray;
  border-radius: 3px;
  padding: 5px 7px;
  margin-right: 2px;
  cursor: not-allowed;
}
.pagination-info {
  float: left;
}
</style>
