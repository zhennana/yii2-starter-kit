<template>
  <div>
    <el-col :span="4">
      <el-menu default-active="0" class="el-menu-vertical-demo" theme="dark">
        <router-link :to="{path:'CoursewareList'}">
          <el-menu-item index="0">课件列表</el-menu-item>
        </router-link>
        <router-link :to="{path:'CoursewareAccessories'}">
          <el-menu-item index="1">课件附件</el-menu-item>
        </router-link>
        <router-link :to="{path:'CoursewareClassification'}">
          <el-menu-item index="2">课件分类</el-menu-item>
        </router-link>
        <router-link :to="{path:'CoursewareRelation'}">
          <el-menu-item index="3">课件关系</el-menu-item>
        </router-link>
        <router-link :to="{path:'AttachmentManagement'}">
          <el-menu-item index="4">附件管理</el-menu-item>
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
