<template>
  <li class="nav-title" v-bind:class="classes" :hidden="auth && !this.$auth.user().can[this.auth.permissions[0]]">
    <template v-if="wrapper && wrapper.element">
      <component v-bind:is="wrapper.element" v-bind="wrapper.attributes">
        {{name}}
      </component>
    </template>
    <template v-else>
      {{name}}
    </template>
  </li>
</template>

<script>
export default {
  props: {
    name: {
      type: String,
      default: ''
    },
    classes: {
      type: String,
      default: ''
    },
    wrapper: {
      type: Object,
      default: () => {}
    },
    auth: {
      type: Object
    }
  }
}
</script>
