<template>
  <div>
    <el-col :span="4">
      <el-menu default-active="0" class="el-menu-vertical-demo" theme="dark">
        <router-link :to="{path:'Curriculum'}">
          <el-menu-item index="0">课程设置</el-menu-item>
        </router-link>
        <router-link :to="{path:'AttendanceManagement'}">
          <el-menu-item index="1">签到管理</el-menu-item>
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

<style>

</style>
