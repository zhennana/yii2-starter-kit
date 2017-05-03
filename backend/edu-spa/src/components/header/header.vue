<template>
  <div class="header">
    <div class="logo">
      <router-link to="/Main">
        <img src="../../assets/img/logo.png"/>
      </router-link>

    </div>
    <el-menu theme="dark" :default-active="activeIndex" class="el-menu-demo top-menu" mode="horizontal">
      <el-menu-item v-for="item in topMenuList" :index="item.name" :key="item.name">
        <router-link :to="{path:item.path}">
          {{item.title}}
        </router-link>
      </el-menu-item>
      <el-submenu index="100">
        <template slot="title">设置</template>
        <el-menu-item index="2-1">其他1</el-menu-item>
        <el-menu-item index="2-2">其他2</el-menu-item>
        <el-menu-item index="2-3" @click="logout">退出</el-menu-item>
      </el-submenu>
    </el-menu>

  </div>
</template>

<script type="text/ecmascript-6">
  import Login from '../../api/user/login'

  export default {
    name: 'Header',
    data () {
      return {
        activeIndex: 'School',
        topMenuList: [
          {
            id: '0',
            name: 'campus',
            path: 'campus',
            title: '学校管理'
          },
          {
            id: '0',
            name: 'courseware',
            path: 'courseware',
            title: '课件管理'
          }
        ]
      }
    },
    methods: {
      logout () {
        Login.logout().then(response => {
          if (response.errno === '0') {
            this.$store.commit('clearUserInfo')
            this.$router.push({
              path: '/'
            })
          } else {
            this.showMsg(response.message)
          }
        }).catch(error => {
          console.log(error)
        })
      },
      handleSelect () {}
    }
  }
</script>

<style lang="stylus" type="text/stylus" rel="stylesheet/stylus">
  header-bg-color = #324157;
  *
    padding: 0;
    margin: 0;

  .header
    height 60px;
    position fixed;
    top:0;
    left:0;
    width 100%;
    font-size 0;
    background header-bg-color;
    z-index:1000;
    .logo
      display inline;
      position absolute;
      cursor pointer;
      top: 10px;
      left: 20px;
      img
        width 40px;
        height 40px;
    .top-menu
      margin-left 10%;
      width 90%;
      & > li > a {
        display block
        width 100%;
        height 100%;
        text-decoration none;
      }

</style>
