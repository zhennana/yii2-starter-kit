<template>
  <div id="app">

    <v-header></v-header>
    <div class="content">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
  import Header from './components/header/Header.vue'
  export default {
    name: 'app',
    data () {
      return {
        topMenuList: []
      }
    },
    components: {
      'v-header': Header
    }
  }
</script>

<style lang="stylus" type="text/stylus">

</style>
