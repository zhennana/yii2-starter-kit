<template>
  <div>
    <!--头-->
    <div class="header-classification">
      <el-button type="info" class="append el-icon-plus" @click="appendControlData = true">创建</el-button>
    </div>
    <!--搜索-->
    <div class="search">
      <el-form :inline="true" :model="searchData" class="demo-form-inline">
        <el-form-item label="分类ID">
          <el-input v-model="searchData.grade_category_id"></el-input>
        </el-form-item>
        <span class="search-status">状态</span>
        <el-select v-model="searchData.status" placeholder="请选择" class="search-status-select">
          <el-option
            v-for="item in depositType"
            :label="item.status_label"
            :key="item.status_id"
            :value="item.status_id">
          </el-option>
        </el-select>
        <el-form-item label="分类名">
          <el-input v-model="searchData.name"></el-input>
        </el-form-item>
        <el-form-item label="选择查询时间">
          <el-select v-model="searchData.time_filter" class="choice-mode-time">
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
        :data="exhibition"
        border
        style="width: 100%">
        <el-table-column
          fixed
          prop="grade_category_id"
          label="分类ID"
          width="150">
        </el-table-column>
        <el-table-column
          prop="parent_id"
          label="父分类"
          width="120">
        </el-table-column>
        <el-table-column
          prop="name"
          label="名称"
          width="300">
        </el-table-column>
        <el-table-column
          prop="created_at"
          label="创建时间"
          width="200">
        </el-table-column>
        <el-table-column
          prop="updated_at"
          label="修改时间"
          width="200">
        </el-table-column>
        <el-table-column
          prop="status_label"
          label="状态"
          width="120">
        </el-table-column>
        <el-table-column
          fixed="right"
          label="操作"
          width="200">
          <template scope="scope">
            <el-button type="warning" @click="modifyAlert(scope.row)">修改</el-button>
            <el-button type="danger">删除</el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <!--修改弹出框-->
    <div class="modify-alert">
      <el-dialog title="修改" v-model="dialogFormVisible" size="small" :close-on-click-modal="false">
        <el-form :model="modifyData">
          <el-form-item label="班级父分类" :label-width="formLabelWidth">
            <el-input v-model="modifyData.parent_id" auto-complete="off"></el-input>
          </el-form-item>
          <el-form-item label="分类名" :label-width="formLabelWidth">
            <el-input v-model="modifyData.name" auto-complete="off"></el-input>
          </el-form-item>
          <span class="search-status">状态</span><el-select v-model="modifyData.status" placeholder="请选择">
            <el-option
              v-for="item in depositType"
              :label="item.status_label"
              :key="item.status_id"
              :value="item.status_id">
            </el-option>
          </el-select>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button type="primary" @click="determineModify">确 定</el-button>
          <el-button @click="dialogFormVisible = false">取 消</el-button>
        </div>
      </el-dialog>
    </div>
    <!--创建的弹出框-->
    <div class="append-alert">
      <el-dialog title="创建班级分类" v-model="appendControlData">
        <el-form :model="appendData">
          <el-form-item label="父班级分类" :label-width="formLabelWidth">
            <el-input v-model="appendData.parent_id" auto-complete="off"></el-input>
          </el-form-item>
          <el-form-item label="分类名" :label-width="formLabelWidth">
            <el-input v-model="appendData.name" auto-complete="off"></el-input>
          </el-form-item>
          <span class="search-status">状态</span><el-select v-model="appendData.status" placeholder="请选择">
          <el-option
            v-for="item in depositType"
            :label="item.status_label"
            :key="item.status_id"
            :value="item.status_id">
          </el-option>
        </el-select>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button type="primary" @click="determineCreate">确 定</el-button>
          <el-button @click="appendControlData = false">取 消</el-button>
        </div>
      </el-dialog>
    </div>
    <!--分页-->
    <div class="paging">
      <div class="block">
        <el-pagination
          @size-change="handleSizeChange"
          @current-change="handleCurrentChange"
          :current-page="meta.currentPage"
          :page-size="meta.perPage"
          layout="prev, pager, next, jumper"
          :total="meta.totalCount">
        </el-pagination>
      </div>
    </div>
  </div>
</template>
<script>
  import Classification from '../../api/campus/classification'
  export default {
    created () {
      this.onSubmit()
      this.getSelectStatus()
    },
    data () {
      return {
        // 查找班级分类
        searchData: {
          grade_category_id: '',
          parent_id: 0,
          name: '',
          // 起始时间
          end_time: '',
          // 结束时间
          start_time: '',
          // 查找修改时间还是查找创建时间
          time_filter: 'updated_at',
          status: '',
          page: ''
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
        exhibition: [],
        selectType: {
          type: ''
        },
        depositType: [],
        dialogFormVisible: false,
        modifyData: {
          grade_category_id: '',
          name: '',
          status: '',
          parent_id: 0
        },
        formLabelWidth: '100px',
        appendControlData: false,
        appendData: {
          parent_id: '',
          name: '',
          status: 10
        },
        meta: {}
      }
    },
    methods: {
      onSubmit () {
        if (this.depositTIme !== '') {
          this.searchData.end_time = this.depositTIme[0].getTime() / 1000
          this.searchData.start_time = this.depositTIme[1].getTime() / 1000
        }
        Classification.getClassification(this.searchData).then(response => {
          if (response.errno === '0') {
            this.meta = response._meta
            this.exhibition = response.result
          }
        }).catch(error => {
          console.log(error)
        })
      },
      getSelectStatus () {
        Classification.getSelect(this.selectType.type).then(response => {
          if (response.errno === '0') {
            this.depositType = response.result
          }
        }).catch(error => {
          console.log(error)
        })
      },
      modifyAlert (data) {
        this.modifyData.grade_category_id = data.grade_category_id
        this.modifyData.name = data.name
        this.modifyData.parent_id = data.parent_id
        this.modifyData.status = data.status
        this.dialogFormVisible = true
      },
      determineModify () {
        if (this.modifyData.name !== '' && this.modifyData.status !== '') {
          Classification.modifyClassification(this.modifyData).then(response => {
            if (response.errno === '0') {
              this.dialogFormVisible = false
              this.onSubmit()
              this.$message({
                message: '修改成功',
                type: 'success'
              })
            }
          }).catch(error => {
            console.log(error)
          })
        } else {
          this.$message.error('分类名,状态。不可为空请填写')
        }
      },
      determineCreate () {
        if (this.appendData.name !== '' && this.appendData.status !== '') {
          Classification.createCategories(this.appendData).then(response => {
            if (response.errno === '0') {
              this.$message({
                message: '创建成功',
                type: 'success'
              })
              this.appendControlData = false
              this.onSubmit()
            }
          }).catch(error => {
            console.log(error)
          })
        } else {
          this.$message.error('分类名,状态。不可为空请填写')
        }
      },
      handleSizeChange (val) {
        console.log(`每页 ${val} 条`)
      },
      handleCurrentChange (val) {
        this.searchData.page = val
        this.onSubmit()
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
  .search-status
    text-align: right;
    vertical-align: middle;
    font-size: 14px;
    color: #48576a;
    line-height: 1;
    padding: 11px 12px 11px 0;
    box-sizing: border-box;
    float: none;
    display: inline-block;
  .search-status-select
    width:100px;
  .display-classification
    margin-left:20px;
  .modify-alert
    .search-status
      width:100px;
    .el-form-item__content
      width:500px;
    .el-select
      width:500px;
  .append-alert
    .search-status
      width:100px;
    .el-input
      width:500px;
</style>
