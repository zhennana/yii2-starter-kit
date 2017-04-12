<template>
  <div id="app">

    <v-header></v-header>
    <div class="content">
      <router-view></router-view>
    </div>

    <button @click="loginA">点我试试</button>
  </div>
</template>

<script>
  import Header from './components/header/Header.vue'
  import login from './api/login'
  export default {
    name: 'app',
    data () {
      return {
        topMenuList: []
      }
    },
    methods: {
      loginA () {
        login.Login('wxfjq', '111111').then(response => {
          console.log(111)
          console.log(response)
        }).catch(error => {
          console.log(error)
        })
      }
    },
    components: {
      'v-header': Header
    }
  }
</script>

<style lang="stylus" type="text/stylus">

</style>
