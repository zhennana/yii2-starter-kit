<template>
  <div class="login-wrapper">
    <div class="login-form">
      <h2>
        登 录
      </h2>
      <el-input
        type="text"
        placeholder="用户名"
        icon="search"
        v-model="username">
      </el-input>

      <el-input
        class="pwd"
        type="password"
        placeholder="密码"
        icon="search"
        v-model="password">
      </el-input>
      <el-button class="login-btn" type="primary" @click="login">点我登录</el-button>
      <el-button type="primary" @click="exit">模拟退出登录 之后换地方</el-button>
      <el-button type="primary" @click="go">测试是否可以进入 main</el-button>

    </div>
  </div>

</template>

<script>
  import Login from '../../api/login'
  export default {
    name: 'login',
    data () {
      return {
        topMenuList: [],
        username: 'changshaoshuai',
        password: 'wakoo518'
      }
    },
    methods: {
      login () {
        Login.login(this.username, this.password).then(response => {
          if (response.errno === '0') {
            this.$store.commit('receivedUserInfoFromRemote', response.result)
            this.$router.push({
              path: '/main'
            })
          } else {
            this.showMsg(response.message)
          }
        }).catch(error => {
          console.log(error)
        })
      },
      exit () {
        this.$store.commit('clearUserInfo')
      },
      go () {
        this.$router.push({
          path: 'main'
        })
      },
      showMsg (errorMsg) {
        this.$alert(errorMsg, '提示', {
          confirmButtonText: '确定'
        })
      }
    }
  }
</script>

<style lang="stylus" type="text/stylus" rel="stylesheet/stylus">

  body
    background-color: #d2d6de;
    .login-wrapper
      width 360px;
      margin 12% auto;
      .login-form
        background-color #fff;
        padding 20px;
        color #666666;
        h2
          height 40px;
          line-height 40px;
          text-align center;
        .pwd
          margin-top 15px;
        .el-input__icon
          left 0
        .el-input__inner
          padding-left 35px;
        .el-button
          width 100%;
          margin 15px 0 0 0;
</style>
