<template>
  <div>
    <!--创建按钮-->
    <div class="header-courseware-list clearFix">
      <el-button type="info" class="fl append el-icon-plus" v-on:click="dialogFormVisible = true">创建</el-button>
    </div>
    <!--查询-->
    <div class="lookup clearFix">
      <el-form :inline="true" :model="lookupData" class="demo-form-inline">
        <el-form-item label="课件ID">
          <el-input v-model="lookupData.courseware_id"></el-input>
        </el-form-item>
        <el-form-item label="课件分类">
          <el-input v-model="lookupData.category_id"></el-input>
        </el-form-item>
        <el-form-item label="标题">
          <el-input v-model="lookupData.title"></el-input>
        </el-form-item>
        <el-form-item label="课件详情">
          <el-input v-model="lookupData.body"></el-input>
        </el-form-item>
        <el-form-item label="状态">
          <el-input v-model="lookupData.status"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="lookupCourseware" class="el-icon-search">查询</el-button>
        </el-form-item>
      </el-form>
    </div>
    <!--展示课件-->
    <div>
      <el-table
        :data="exhibitionCourseware"
        border
        style="width: 100%">
        <el-table-column
          fixed
          prop="parent_id"
          label="父课件"
          width="150">
        </el-table-column>
        <el-table-column
          prop="title"
          label="标题"
          width="120">
        </el-table-column>
        <el-table-column
          prop="body"
          label="教学目标"
          width="120">
        </el-table-column>
        <el-table-column
          prop="tags"
          label="分类"
          width="120">
        </el-table-column>
        <el-table-column
          prop="level"
          label="级别"
          width="300">
        </el-table-column>
        <el-table-column
          prop="zip"
          label="创建者"
          width="120">
        </el-table-column>
        <el-table-column
          prop="file_counts"
          label="附件数"
          width="120">
        </el-table-column>
        <el-table-column
          prop="page_view"
          label="预览数"
          width="120">
        </el-table-column>
        <el-table-column
          prop="tags"
          label="标签"
          width="120">
        </el-table-column>
        <el-table-column
          prop="status"
          label="状态"
          width="120">
        </el-table-column>
        <el-table-column
          prop="created_at"
          label="更新时间"
          width="120">
        </el-table-column>
        <el-table-column
          prop="updated_at"
          label="创建时间"
          width="120">
        </el-table-column>
        <el-table-column
          fixed="right"
          label="操作"
          width="100">
          <template scope="scope">
            <el-button type="text" size="small">查看</el-button>
            <el-button type="text" size="small">编辑</el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>
  </div>
</template>
<script>
  import CoursewareList from '../../api/courseware/coursewareList'
  export default {
    created () {
      this.lookupCourseware()
    },
    data () {
      return {
        lookupData: {
          courseware_id: '',
          category_id: '',
          title: '',
          body: '',
          status: ''
        },
        exhibitionCourseware: []
      }
    },
    methods: {
      lookupCourseware () {
        CoursewareList.getCourseware(this.lookupData).then(response => {
          if (response.errno === '0') {
            this.exhibitionCourseware = response.result
          }
        }).catch(error => {
          console.log(error)
        })
      }
    }
  }
</script>
<style lang="stylus" type="text/stylus" rel="stylesheet/stylus">
  .header-courseware-list
    padding-top:10px;
    .append
      margin-left:10px;
      span
        margin-left:5px;
  .lookup
    margin-left:30px;
</style>
