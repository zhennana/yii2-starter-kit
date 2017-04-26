<template>
  <div>
    <!--头-->
    <div class="header-classification">
      <el-button type="info" class="append el-icon-plus">创建</el-button>
    </div>
    <!--搜索-->
    <div class="search">
      <el-form :inline="true" :model="searchData" class="demo-form-inline">
        <el-form-item label="分类ID">
          <el-input v-model="searchData.grade_category_id"></el-input>
        </el-form-item>
        <el-form-item label="状态">
          <el-select v-model="searchData.status" placeholder="活动区域">
            <el-option label="区域一" value="shanghai"></el-option>
            <el-option label="区域二" value="beijing"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="分类名">
          <el-input v-model="searchData.name"></el-input>
        </el-form-item>
        <el-form-item label="选择查询时间">
          <el-select v-model="searchData.times" class="choice-mode-time">
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
          <el-button type="primary" @click="onSubmit" class="el-icon-search">搜索</el-button>
        </el-form-item>
      </el-form>
    </div>
    <!--展示-->
    <div class="display-classification">
      <el-table
        :data="tableData"
        border
        style="width: 100%">
        <el-table-column
          fixed
          prop="date"
          label="分类ID"
          width="150">
        </el-table-column>
        <el-table-column
          prop="name"
          label="父分类"
          width="120">
        </el-table-column>
        <el-table-column
          prop="province"
          label="创建者"
          width="120">
        </el-table-column>
        <el-table-column
          prop="city"
          label="状态"
          width="120">
        </el-table-column>
        <el-table-column
          prop="address"
          label="名称"
          width="300">
        </el-table-column>
        <el-table-column
          prop="zip"
          label="更新时间"
          width="120">
        </el-table-column>
        <el-table-column
          fixed="right"
          label="操作"
          width="100">
          <template scope="scope">
            <el-button @click="handleClick" type="text" size="small">查看</el-button>
            <el-button type="text" size="small">编辑</el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>
  </div>
</template>
<script>
  import Classification from '../../api/classification'
  export default {
    data () {
      return {
        // 查找学校
        searchData: {
          grade_category_id: '',
          parent_id: 0,
          name: '',
          // 起始时间
          end_time: '',
          // 结束时间
          start_time: '',
          // 查找修改时间还是查找创建时间
          times: 'updated_at',
          status: ''
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
        tableData: [{
          date: '2016-05-03',
          name: '王小虎',
          province: '上海',
          city: '普陀区',
          address: '上海市普陀区金沙江路 1518 弄',
          zip: 200333
        }, {
          date: '2016-05-02',
          name: '王小虎',
          province: '上海',
          city: '普陀区',
          address: '上海市普陀区金沙江路 1518 弄',
          zip: 200333
        }, {
          date: '2016-05-04',
          name: '王小虎',
          province: '上海',
          city: '普陀区',
          address: '上海市普陀区金沙江路 1518 弄',
          zip: 200333
        }, {
          date: '2016-05-01',
          name: '王小虎',
          province: '上海',
          city: '普陀区',
          address: '上海市普陀区金沙江路 1518 弄',
          zip: 200333
        }]
      }
    },
    methods: {
      onSubmit () {
        if (this.depositTIme === !'') {
          this.searchData.end_time = this.depositTIme[0].getTime() / 1000
          this.searchData.start_time = this.depositTIme[1].getTime() / 1000
        }
        Classification.getClassification(this.searchData).then(response => {
          if (response.errno === '0') {
            console.log(response.result)
          }
        }).catch(error => {
          console.log(error)
        })
      }
    }
  }
</script>
<style lang="stylus" type="text/stylus" rel="stylesheet/stylus">
  .header-classification
    margin-left:20px;
    padding-top:10px;
    .append
      margin-left:10px;
      span
        margin-left:5px;
  .search
    margin-top:20px;
  .choice-mode-time
    width:150px
  .choice-time
    margin-left:35px;
</style>
