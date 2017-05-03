<template>
  <div>
    <el-col :span="3">
      <el-menu default-active="0" class="el-menu-vertical-demo nav-campus" v-bind:style="{height: visibleAreaHeight.height + 'px'}" theme="dark">
        <div class="user-information el-icon-menu">
          用户信息
        </div>
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
    name: 'campus-manager',
    data () {
      return {
        menuList: [
          {
            id: '0',
            name: 'campus',
            path: 'campus',
            title: '学校管理'
          },
          {
            id: '1',
            name: 'class',
            path: 'class',
            title: '班级管理'
          },
          {
            id: '2',
            name: 'classification',
            path: 'classification',
            title: '班级分类管理'
          },
          {
            id: '3',
            name: 'student',
            path: 'student',
            title: '学员管理'
          }
        ],
        visibleAreaHeight: {
          height: document.documentElement.clientHeight
        }
      }
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
    margin-left 200px;
    margin-top:60px;
  .nav-campus
    position:fixed;
    left:0;
    top:60px;
    z-index:1000;
    width:200px;
  .user-information
    padding:20px 0 20px 20px;
    width:180px;
    border-bottom:1px solid #dfdfdf;
    cursor:pointer;
    color:#58B7FF;
</style>
