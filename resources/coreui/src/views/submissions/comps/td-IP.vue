<template>
 <router-link to="/admin/dashboard"><span class="badge badge-secondary">{{ value }}</span></router-link>
</template>
<script>
export default {
  props: ['value']
}
</script>
