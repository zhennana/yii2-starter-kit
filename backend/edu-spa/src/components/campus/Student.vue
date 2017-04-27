<template>
  <div>
    <el-cascader
      :options="schoolAndClass"
      @change="schoolClassSlect"
      :props="classProps"
      change-on-select
    ></el-cascader>
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
        <el-form-item label="用户">
          <el-input v-model="lookupData.user_label"></el-input>
        </el-form-item>
        <el-form-item label="学校">
          <el-select v-model="lookupData.school_id" placeholder="请选择">
            <el-option
              v-for="item in selectTotal.school"
              :label="item.school_title"
              :key="item.school_id"
              :value="item.school_id">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="班级id">
          <el-input v-model="lookupData.grade_id"></el-input>
        </el-form-item>
        <el-form-item label="展示标题">
          <el-select v-model="lookupData.user_title_id_at_grade" placeholder="请选择">
            <el-option
              v-for="item in selectTotal.user_title_type"
              :label="item.value"
              :key="item.key"
              :value="item.key">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="状态">
          <el-select v-model="lookupData.statuse" placeholder="请选择">
            <el-option
              v-for="item in selectTotal.status"
              :label="item.value"
              :key="item.key"
              :value="item.key">
            </el-option>
          </el-select>
        </el-form-item>
        <br>
        <el-form-item label="选择查询时间">
          <el-select v-model="lookupData.time_filter" class="choice-mode-time">
            <el-option label="修改时间" value="updated_at"></el-option>
            <el-option label="创建时间" value="created_at"></el-option>
          </el-select>
        </el-form-item>
        <el-date-picker
          class="choice-time"
          v-model="depositTIme"
          type="datetimerange"
          :picker-options="modifyTime"
          placeholder="选择时间范围"
          align="right">
        </el-date-picker>
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
          label="修改时间"
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
            <el-button type="warning" @click="selectData">修改</el-button>
            <el-button type="danger">删除</el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <!--详情-->
    <div class="details-alert">
      <el-dialog title="学生详情" v-model="detailsControl" size="large">
        <el-table :data="detailsData" border style="width: 100%">
          <el-table-column fixed prop="user_to_grade_id" label="user_to_grade_id" width="150"></el-table-column>
          <el-table-column prop="user_id" label="user_id" width="120"></el-table-column>
          <el-table-column prop="school_id" label="school_id" width="120"></el-table-column>
          <el-table-column prop="grade_id" label="grade_id" width="120"></el-table-column>
          <el-table-column prop="user_title_id_at_grade" label="user_title_id_at_grade" width="120"></el-table-column>
          <el-table-column prop="status" label="status" width="120"></el-table-column>
          <el-table-column prop="sort" label="sort" width="120"></el-table-column>
          <el-table-column prop="grade_user_type" label="grade_user_type" width="120"></el-table-column>
          <el-table-column prop="updated_at" label="updated_at" width="120"></el-table-column>
          <el-table-column prop="created_at" label="created_at" width="120"></el-table-column>
          <el-table-column prop="school_label" label="school_label" width="200"></el-table-column>
          <el-table-column prop="grade_label" label="grade_label" width="120"></el-table-column>
          <el-table-column prop="status_label" label="status_label" width="120"></el-table-column>
          <el-table-column prop="grade_user_type_label" label="grade_user_type_label" width="120"></el-table-column>
          <el-table-column prop="user_title_id_at_grade_Label" label="user_title_id_at_grade_Label" width="120"></el-table-column>
          <el-table-column prop="user_label" label="user_label" width="120"></el-table-column>
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
      this.selectData()
    },
    data () {
      return {
        lookupData: {
          user_to_grade_id: '',
          user_label: '',
          school_id: '',
          grade_id: '',
          user_title_id_at_grade: '',
          statuse: '',
          time_filter: 'updated_at',
          start_time: '',
          end_time: ''
        },
        exhibitionData: [],
        detailsData: [],
        toSelectData: {
          type: ''
        },
        modifyTime: {
          shortcuts: [{
            text: '最近一周',
            onClick (picker) {
              const end = new Date()
              const start = new Date()
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 7)
              picker.$emit('pick', [start, end])
            }
          }, {
            text: '最近一个月',
            onClick (picker) {
              const end = new Date()
              const start = new Date()
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 30)
              picker.$emit('pick', [start, end])
            }
          }, {
            text: '最近三个月',
            onClick (picker) {
              const end = new Date()
              const start = new Date()
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 90)
              picker.$emit('pick', [start, end])
            }
          }]
        },
        depositTIme: '',
        selectTotal: [],
        detailsControl: false,
        schoolAndClass: [],
        classProps: {
          label: 'school_title',
          value: 'school_id',
          children: 'grade'
        },
        getSlectClass: {
          type: 6,
          school_id: ''
        }
      }
    },
    methods: {
      lookupCourseware () {
        if (this.depositTIme !== '') {
          this.lookupData.start_time = this.depositTIme[0].getTime() / 1000
          this.lookupData.end_time = this.depositTIme[1].getTime() / 1000
        }
        Student.getstudent(this.lookupData).then(response => {
          if (response.errno === '0') {
            this.exhibitionData = response.result
          }
        }).catch(error => {
          console.log(error)
        })
      },
      detailsAlert (data) {
        this.detailsData = []
        this.detailsData.push(data)
        this.detailsControl = true
      },
      selectData () {
        Student.getSelectData(this.toSelectData).then(response => {
          if (response.errno === '0') {
            this.selectTotal = response.result
            this.schoolAndClass = response.result.school
          }
        }).catch(error => {
          console.log(error)
        })
      },
      schoolClassSlect (val) {
        this.getSlectClass.school_id = val[0]
        Student.getSelectData(this.getSlectClass).then(response => {
          if (response.errno === '0') {
            for (let i = 0; i < this.schoolAndClass.length; i++) {
              if (this.schoolAndClass[i].school_id === val[0]) {
                this.schoolAndClass[i].grade = []
                this.schoolAndClass[i].grade.push(response.result)
              }
            }
          }
        }).catch(error => {
          console.log(error)
        })
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
  .exhibition
    margin-left:30px;
</style>
