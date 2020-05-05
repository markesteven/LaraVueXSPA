<template>
  <div @click="onClick">
    <div class="inline field">
      <label>Code: </label>
      <span>{{rowData.code}}</span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    rowData: {
      type: Object,
      required: true
    },
    rowIndex: {
      type: Number
    }
  },
  methods: {
    onClick (event) {
      // console.log('promo-code-detail-row: on-click', event.target)
    }
  },
}
</script>
