<template>
  <div>
    <el-row>
      <el-col :span="12" class="header-top clearFix">
        <h2 class="fl">学院管理</h2>
        <el-button type="info" class="fl append el-icon-plus">创建</el-button>
      </el-col>
    </el-row>

    <!--<div style="margin: 20px;"></div>
    <el-form :label-position="labelPosition" label-width="100px" :model="formLabelAlign" class="clearFix exhibition-top">
      <el-form-item label="主校ID" class="fl">
        <el-input v-model="formLabelAlign.name"></el-input>
      </el-form-item>
      <el-form-item label="学校名称" class="fl">
        <el-input v-model="formLabelAlign.region"></el-input>
      </el-form-item>
      <el-form-item label="学校简称" class="fl">
        <el-input v-model="formLabelAlign.type"></el-input>
      </el-form-item>
      <el-form-item label="学校标语" class="fl">
        <el-input v-model="formLabelAlign.type"></el-input>
      </el-form-item>
      <el-form-item label="Logo路径" class="fl">
        <el-input v-model="formLabelAlign.type"></el-input>
      </el-form-item>
      <el-form-item label="背景图路径" class="fl">
        <el-input v-model="formLabelAlign.type"></el-input>
      </el-form-item>
      <el-form-item label="省" class="fl">
        <el-input v-model="formLabelAlign.type"></el-input>
      </el-form-item>
      <el-form-item label="城市" class="fl">
        <el-input v-model="formLabelAlign.type"></el-input>
      </el-form-item>
      <el-form-item label="区县" class="fl">
        <el-input v-model="formLabelAlign.type"></el-input>
      </el-form-item>
      <el-form-item label="具体地址" class="fl">
        <el-input v-model="formLabelAlign.type"></el-input>
      </el-form-item>
      <el-form-item label="status	" class="fl">
        <el-input v-model="formLabelAlign.type"></el-input>
      </el-form-item>-->
    </el-form>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        labelPosition: 'top',
        campus: {
          parent_id: '',
          region: '',
          type: ''
        }
      }
    }
  }
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
  .el-form-item__content
    width:100px;
  .exhibition-top
    text-align :center;
</style>
