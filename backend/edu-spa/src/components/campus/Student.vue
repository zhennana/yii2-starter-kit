<template>
  <div>
    <!--创建按钮-->
    <div class="header-student clearFix">
      <el-button type="info" class="fl append el-icon-plus" v-on:click="dialogFormVisible = true">创建</el-button>
    </div>
    <!--搜索-->
    <div class="lookup clearFix">
      <el-form :inline="true" :model="lookupData" class="demo-form-inline">
        <el-form-item label="ID">
          <el-input v-model="lookupData.user_to_grade_id"></el-input>
        </el-form-item>
        <el-form-item label="用户ID">
          <el-input v-model="lookupData.user_id"></el-input>
        </el-form-item>
        <el-form-item label="学校id">
          <el-input v-model="lookupData.school_id"></el-input>
        </el-form-item>
        <el-form-item label="班级id">
          <el-input v-model="lookupData.grade_id"></el-input>
        </el-form-item>
        <el-form-item label="用户在班级的描述性展示行">
          <el-input v-model="lookupData.user_title_id_at_grade"></el-input>
        </el-form-item>
        <el-form-item label="状态">
          <el-input v-model="lookupData.statuse"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="lookupCourseware" class="el-icon-search">查询</el-button>
        </el-form-item>
      </el-form>
    </div>
    <!--展示-->
    <div class="exhibition">
      <el-table
        :data="exhibitionData"
        border
        style="width: 100%">
        <el-table-column
          fixed
          prop="school_label"
          label="学校"
          width="150">
        </el-table-column>
        <el-table-column
          prop="grade_label"
          label="	班级"
          width="150">
        </el-table-column>
        <el-table-column
          prop="status_label"
          label="状态"
          width="120">
        </el-table-column>
        <el-table-column
          prop="user_label"
          label="用户"
          width="120">
        </el-table-column>
        <el-table-column
          prop="updated_at"
          label="更新时间"
          width="200">
        </el-table-column>
        <el-table-column
          prop="created_at"
          label="创建时间"
          width="200">
        </el-table-column>
        <el-table-column
          fixed="right"
          label="操作"
          width="270">
          <template scope="scope">
            <el-button type="success" @click="detailsAlert(scope.row)">查看</el-button>
            <el-button type="warning">修改</el-button>
            <el-button type="danger">删除</el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <!--详情-->
    <div class="details-alert">
      <el-dialog title="学生详情" v-model="detailsControl">
        <el-table :data="detailsData">
          <el-table
          :data="detailsData"
          border
          style="width: 100%"
          height="250">
          <el-table-column
            fixed
            prop="detailsData.grade_label"
            label="班级"
            width="150">
          </el-table-column>
        </el-table>
        </el-table>
      </el-dialog>
    </div>
  </div>
</template>
<script>
  import Student from '../../api/campus/student'
  export default {
    created () {
      this.lookupCourseware()
    },
    data () {
      return {
        lookupData: {
          user_to_grade_id: '',
          user_id: '',
          school_id: '',
          grade_id: '',
          user_title_id_at_grade: '',
          statuse: ''
        },
        exhibitionData: [],
        detailsData: [],
        detailsControl: false
      }
    },
    methods: {
      lookupCourseware () {
        Student.getstudent(this.lookupData).then(response => {
          if (response.errno === '0') {
            this.exhibitionData = response.result
          }
        }).catch(error => {
          console.log(error)
        })
      },
      detailsAlert (data) {
        this.detailsData.push(data)
        console.log(this.detailsData)
        this.detailsControl = true
      }
    }
  }
</script>
<style lang="stylus" type="text/stylus" rel="stylesheet/stylus">
  .header-student
    padding-top:10px;
    height:50px;
    .append
      margin-left:10px;
      span
        margin-left:5px;
  .lookup
    height:60px;
  .exhibition
    margin-left:30px;
</style>
