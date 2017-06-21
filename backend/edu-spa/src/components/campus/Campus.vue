<template>
  <div>
    <el-col :span="3">
      <el-menu default-active="0" class="el-menu-vertical-demo nav-campus" v-bind:style="{height: visibleAreaHeight.height + 'px'}" theme="dark">
        <div class="user-information el-icon-menu" @click="showUserFunction">
          用户信息
        </div>
        <el-menu-item v-for="menu in menuList" :index="menu.id" :key="menu.id">
          <router-link :to="{path:menu.path}">
            {{menu.title}}
          </router-link>
        </el-menu-item>
      </el-menu>
    </el-col>
    <div class="user-function" v-bind:class="{user_function_none: ifUserFunctionNone}">
      <ul>
        <li>
          <el-button :plain="true" type="info" class="user-function-button">更换头像</el-button>
        </li>
        <li>
          <el-button :plain="true" type="info" class="user-function-button">修改密码</el-button>
        </li>
        <li>
          <el-button :plain="true" type="info" class="user-function-button">退出登录</el-button>
        </li>
      </ul>
    </div>
    <div class="child-content">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
  import Vue from 'vue'
  import Vuex from 'vuex'
  Vue.use(Vuex)
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
        },
        ifUserFunctionNone: true
      }
    },
    methods: {
      showUserFunction () {
        this.ifUserFunctionNone = !this.ifUserFunctionNone
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
    z-index:500;
    width:200px;
  .user-information
    padding:20px 0 20px 20px;
    width:180px;
    border-bottom:1px solid #dfdfdf;
    cursor:pointer;
    color:#58B7FF;
  .user-function
    font-size:16px;
    position:fixed;
    top:61px;
    left:210px;
    width:231px;
    z-index: 500;
    background:#324157;
    .user-function-button
      width:100%
      margin-top:10px;
      border:none;
      font-size:16px;
      background:#324157;
      color:#fff;
      text-align: left;
  .user_function_none
    display:none;
</style>
