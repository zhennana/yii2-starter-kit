<template>
  <div>
    <el-col :span="4">
      <el-menu default-active="0" class="el-menu-vertical-demo" theme="dark">
        <el-menu-item index="0">
          <router-link :to="{path:'school-college'}">
            学校管理
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
    name: 'school-manager',
    data () {
      return {}
    }
  }
</script>

<style lang="stylus" type="text/stylus" scoped rel="stylesheet/stylus">
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
</style>
