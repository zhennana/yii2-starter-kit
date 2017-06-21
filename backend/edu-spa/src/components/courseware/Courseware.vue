<template>
  <div>
    <el-col :span="4">
      <el-menu default-active="0" class="el-menu-vertical-demo" theme="dark">
        <el-menu-item v-for="menu in menuList" :index="menu.id" :key="menu.id">
          <router-link :to="{path:menu.path}">
            {{menu.title}}
          </router-link>
        </el-menu-item>
      </el-menu>
    </el-col>
    <div class="child-content">
      <router-view></router-view>
    </div>
  </div>
</template>
<script>
  export default {
    name: 'courseware',
    data () {
      return {
        menuList: [
          {
            id: '0',
            name: 'courseware-list',
            path: 'courseware-list',
            title: '课件列表'
          }
        ]
      }
    }
  }
</script>
<style lang="stylus" type="text/stylus" rel="stylesheet/stylus">
  .el-menu
    & > li > a
      display block
      width 100%
      height 100%
      color #bfcbd9;
      text-decoration none;
    .el-menu-item.is-active
      & a
        color: #20a0ff;

  .child-content
    margin-left 250px
    margin-right 20px
</style>
