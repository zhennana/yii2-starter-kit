<template>
  <div>
    <el-row>
      <el-col :span="12" class="header-top clearFix">
        <h2 class="fl">学院管理</h2>
        <el-button type="info" class="fl append el-icon-plus">创建</el-button>
      </el-col>
    </el-row>
    <el-form :label-position="labelPosition" label-width="100px" :model="campus" class="clearFix exhibition-top">
      <el-form-item label="学校ID" class="fl search-above">
        <el-input v-model="campus.id"></el-input>
      </el-form-item>
      <el-form-item label="主校ID" class="fl search-above">
        <el-input v-model="campus.parent_id"></el-input>
      </el-form-item>
      <el-form-item label="学校名称" class="fl search-above">
        <el-input v-model="campus.school_title"></el-input>
      </el-form-item>
      <el-form-item label="学校简称" class="fl search-above">
        <el-input v-model="campus.school_short_title"></el-input>
      </el-form-item>
      <el-form-item label="学校标语" class="fl search-above">
        <el-input v-model="campus.school_slogan"></el-input>
      </el-form-item>
      <el-form-item label="Logo路径" class="fl search-above">
        <el-input v-model="campus.school_logo_path"></el-input>
      </el-form-item>
      <el-form-item label="背景图路径" class="fl search-above">
        <el-input v-model="campus.school_backgroud_path"></el-input>
      </el-form-item>
      <el-form-item label="省" class="fl search-above">
        <el-input v-model="campus.province_id"></el-input>
      </el-form-item>
      <el-form-item label="城市" class="fl search-above">
        <el-input v-model="campus.city_id"></el-input>
      </el-form-item>
      <el-form-item label="区县" class="fl search-above">
        <el-input v-model="campus.region_id"></el-input>
      </el-form-item>
      <el-form-item label="具体地址(街道)" class="fl search-above">
        <el-input v-model="campus.address"></el-input>
      </el-form-item>
      <el-form-item label="是否已经删除" class="fl search-above">
        <el-select v-model="campus.status" placeholder="学校是已否删除">
          <el-option label="未删除" value="0"></el-option>
          <el-option label="已删除" value="1"></el-option>
        </el-select>
      </el-form-item>
      <el-button type="primary" icon="search" class="fl" @click="displaySchool">搜索</el-button>
    </el-form>
    <el-table
      :data="result"
      style="width: 100%">
      <el-table-column
        prop="id"
        label="id"
        width="180">
      </el-table-column>
      <el-table-column
        prop="school_title"
        label="名称"
        width="180">
      </el-table-column>
      <el-table-column
        prop="address"
        label="地址">
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
  import Campus from '../../api/campus'
  export default {
    beforeCreate () {
      console.log('beforeCreate')
    },
    created () {
      console.log('created')
      this.displaySchool()
    },
    beforeMount () {
      console.log('beforeMount')
    },
    mounted () {
      console.log('mounted')
    },
    beforeUpdate () {
      console.log('beforeUpdate')
    },
    updated () {
      console.log('updated')
    },
    activated () {
      console.log('activated')
    },
    deactivated () {
      console.log('deactivated')
    },
    beforeDestroy () {
      console.log('beforeDestroy')
    },
    destroyed () {
      console.log('destroyed')
    },
    data () {
      return {
        labelPosition: 'top',
        campus: {
          id: '',
          parent_id: '',
          school_title: '',
          school_short_title: '',
          school_slogan: '',
          school_logo_path: '',
          school_backgroud_path: '',
          province_id: '',
          city_id: '',
          region_id: '',
          address: '',
          status: ''
        },
        result: []
      }
    },
    methods: {
      displaySchool () {
        Campus.getSchool(this.campus).then(response => {
          if (response.errno === '0') {
            this.result = response.result
          }
        }).catch(error => {
          console.log(error)
        })
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
  li
    list-style:none;
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
  .search-above
    margin-right:10px;
</style>
