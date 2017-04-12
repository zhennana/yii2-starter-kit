<template>
  <div id="app">
    <router-view></router-view>
    <div v-permission="{display:'inline-block'}">aaaa</div>
  </div>
</template>

<script>
  export default {
    name: 'app',
    data () {
      return {}
    }
  }
</script>

<style lang="stylus" type="text/stylus">

</style>
