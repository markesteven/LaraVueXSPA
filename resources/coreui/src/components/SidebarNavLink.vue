<template>
  <router-link :to="url" class="nav-link" :hidden="auth && !this.$auth.user().can[this.auth.permissions[0]]">
    <i :class="icon"></i> {{name}}
    <b-badge v-if="badge.text" :variant="badge.variant">{{badge.text}}</b-badge>
  </router-link>
</template>

<script>
export default {
  name: 'sidebar-nav-link',
  props: {
    name: {
      type: String,
      default: ''
    },
    url: {
      type: String,
      default: ''
    },
    icon: {
      type: String,
      default: ''
    },
    badge: {
      default: ''
    },
    auth: {
      type: Object
    }
  },

  mounted(){
    // console.log(this.$auth.user().can['view_roles'])
  }
}
</script>
