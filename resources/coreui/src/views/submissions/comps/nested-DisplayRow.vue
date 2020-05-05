<template>
  <div class="-nested-dsp-row-comp">
    <button class="btn btn-xs btn-link -nested-dsp-row-close-btn"
      @click="nested.$toggle(false)">
      <i class="fa fa-times fa-lg"></i>
    </button>
    <dl class="dl-horizontal">
    <div class="row">
      <template v-for="(val, key) in row">


            <div  class="col-md-2" v-if="key != 'email_address' && key != 'full_name' && key != 'created_at' && key != 'id' && key != 'promocodesbyemail' ">
              <div v-if="key == 'options'">
              <dt class="nested-key">Hear About</dt>
              </div>
              <div v-else>
                <dt class="nested-key">{{ key.replace("_", " ") }}</dt>
              </div>

              <dd>

                <div v-if="key == 'promocodes' || key == 'vehicle_types' || key == 'options'">
                   <ul>
                     <div v-if="key == 'promocodes'" >
                       <li v-for="item in val">
                          {{ item.code }}
                        </li>
                     </div>
                     <div v-if="key == 'vehicle_types'">
                       <li v-for="item in val">
                          {{ item.vehicle_type }}
                        </li>
                     </div>
                     <div v-if="key == 'options'">
                       <li v-for="item in val">
                          {{ item.option_name }}
                        </li>
                     </div>


                   </ul>
                </div>
                <div v-else>
                    {{ val }}
                </div>


              </dd>
          </div>
      </template>
    </div>
    </dl>
  </div>
</template>
<script>
export default {
  props: ['row', 'nested']
}
</script>
<style>
.-nested-dsp-row-comp {
  position: relative;
  padding: 10px;
}
.-nested-dsp-row-close-btn {
  position: absolute;
  top: 5px;
  right: 5px;
}
.nested-key{
  text-transform: capitalize;
}
</style>
