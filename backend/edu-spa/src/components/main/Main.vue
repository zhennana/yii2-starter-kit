<template>
  <div id="app">

    <v-header></v-header>
    <div class="content">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
  import Header from '../../components/header/Header.vue'
  import login from '../../api/login'
  export default {
    name: 'main',
    data () {
      return {
        topMenuList: []
      }
    },
    methods: {
      loginA () {
        console.log(this.userinfo)
        login.Login('wxfjq', '111111').then(response => {
          if (response.errno === 0) {
            this.$store.commit('receivedUserInfoFromRemote', response.result)
          }
          console.log(response)
        }).catch(error => {
          console.log(error)
        })
      },
      exit () {
      }
    },
    components: {
      'v-header': Header
    }
  }
</script>

<style lang="stylus" type="text/stylus">

</style>
