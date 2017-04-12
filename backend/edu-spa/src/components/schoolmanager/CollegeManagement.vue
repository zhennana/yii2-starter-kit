<template>
  <el-row>
    <el-col :span="12" class="header-top clearFix">
      <h2 class="fl">学院管理</h2>
      <el-button type="info" class="fl append el-icon-plus">创建</el-button>
    </el-col>
  </el-row>
</template>

<script>

</script>

<style lang="stylus" type="text/stylus" rel="stylesheet/stylus">
  .clearFix:after
    clear:both;
    display :block;
    content: '';
  .clearFix
    zoom:1;
  .fr
    float:right;
  .fl
    float:left;
  .header-top
    margin-top:20px;
    margin-left:20px;
    .append
      margin-left:10px;
      span
        margin-left:5px;
    h2
      font-size:36px;
</style>
