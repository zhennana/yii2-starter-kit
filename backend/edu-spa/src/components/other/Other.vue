<template>
  <div>
    <el-col :span="4">
      <el-menu default-active="0" class="el-menu-vertical-demo" theme="dark">
        <el-submenu index="0">
          <template slot="title">国际化</template>
          <el-menu-item-group>
            <router-link :to="{path:'InternationalSourceInformation'}">
              <el-menu-item index="0-1">国际化源信息</el-menu-item>
            </router-link>
            <router-link :to="{path:'InternationalInformation'}">
              <el-menu-item index="0-2">国际化信息</el-menu-item>
            </router-link>
          </el-menu-item-group>
        </el-submenu>
        <router-link :to="{path:'jsonStorage'}">
          <el-menu-item index="1">键值存储</el-menu-item>
        </router-link>
        <router-link :to="{path:'FileStore'}">
          <el-menu-item index="2">文件存储</el-menu-item>
        </router-link>
        <router-link :to="{path:'Cache'}">
          <el-menu-item index="3">缓存</el-menu-item>
        </router-link>
        <router-link :to="{path:'FileManagement'}">
          <el-menu-item index="4">文件管理</el-menu-item>
        </router-link>
      </el-menu>
    </el-col>
    <div class="child-content">
      <router-view></router-view>
    </div>
  </div>
</template>
<script>

</script>
<style lang="stylus" type="text/stylus" rel="stylesheet/stylus">

</style>
