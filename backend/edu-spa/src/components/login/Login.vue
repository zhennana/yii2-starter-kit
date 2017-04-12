<template>
  <div>
    <button @click="loginA">点我试试</button>
    <button @click="exit">退出登录 清除localStorage and Cookie</button>
    <button v-permission.a="'adad'" @click="go">goMain</button>
  </div>
</template>

<script>
  import login from '../../api/login'
  export default {
    name: 'login',
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
      },
      go () {
        this.$router.push({
          path: 'main'
        })
      }
    }
  }
</script>

<style>

</style>
