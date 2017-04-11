<template>
  <div>
    <el-col :span="4">
      <el-menu default-active="0" class="el-menu-vertical-demo" theme="dark">
        <router-link :to="{path:'StaticPage'}">
          <el-menu-item index="0">静态页面</el-menu-item>
        </router-link>
        <router-link :to="{path:'Article'}">
          <el-menu-item index="1">文章</el-menu-item>
        </router-link>
        <router-link :to="{path:'ArticleClassification'}">
          <el-menu-item index="2">文章分类</el-menu-item>
        </router-link>
        <router-link :to="{path:'TextComponent'}">
          <el-menu-item index="3">文本组件</el-menu-item>
        </router-link>
        <router-link :to="{path:'MenuComponent'}">
          <el-menu-item index="4">菜单组件</el-menu-item>
        </router-link>
        <router-link :to="{path:'CarouselWidgets'}">
          <el-menu-item index="5">Carousel Widgets</el-menu-item>
        </router-link>
        <router-link :to="{path:'JoinInformation'}">
          <el-menu-item index="6">加盟信息</el-menu-item>
        </router-link>
        <router-link :to="{path:'ContactUs'}">
          <el-menu-item index="7">联系我们</el-menu-item>
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
