<template>
  <div>
    <el-row>
      <el-col :span="12" class="header-top clearFix">
        <h2 class="fl">学院管理</h2>
        <el-button type="info" class="fl append el-icon-plus">创建</el-button>
      </el-col>
    </el-row>
    <!-- Form -->
    <el-button type="text" @click="dialogFormVisible = true">打开嵌套表单的 Dialog</el-button>

    <el-dialog title="收货地址" v-model="dialogFormVisible">
      <el-form :model="form">
        <el-form-item label="活动名称" :label-width="formLabelWidth">
          <el-input v-model="form.name" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="活动区域" :label-width="formLabelWidth">
          <el-select v-model="form.region" placeholder="请选择活动区域">
            <el-option label="区域一" value="shanghai"></el-option>
            <el-option label="区域二" value="beijing"></el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取 消</el-button>
        <el-button type="primary" @click="dialogFormVisible = false">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        dialogTableVisible: false,
        dialogFormVisible: false,
        form: {
          name: '',
          region: '',
          date1: '',
          date2: '',
          delivery: false,
          type: [],
          resource: '',
          desc: ''
        },
        formLabelWidth: '120px'
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
</style>
