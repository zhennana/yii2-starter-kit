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
    </el-menu>

  </div>
</template>

<script type="text/ecmascript-6">
  export default {
    name: 'Header',
    data () {
      return {
        activeIndex: 'School',
        topMenuList: [
          {
            id: '0',
            name: 'School',
            path: 'School',
            title: '学校管理'
          }
        ]
      }
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
    position relative;
    width 100%;
    font-size 0;
    background header-bg-color;
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
        padding: 0 7px;
        text-decoration none;
      }

</style>
