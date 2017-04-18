<template>
  <div>
    <el-row>
      <el-col :span="12" class="header-top clearFix">
        <h2 class="fl">学院管理</h2>
        <!--创建学校按钮-->
        <el-button type="info" class="fl append el-icon-plus" v-on:click="dialogFormVisible = true">创建</el-button>
      </el-col>
    </el-row>

    <!--搜素学校-->
    <div class="search-school">
      <el-form :label-position="labelPosition" label-width="100px" class="clearFix exhibition-top">
        <div class="clearFix">
          <div v-for="(val, key, index) in promptText" class="fl" style="width:100px;">{{val}}</div>
        </div>
        <div class="clearFix">
          <el-input v-model="campus[key]" v-for="(val, key, index) in campus" class="fl" style="width:100px;"></el-input>
        </div>
        <!--<div v-for="(val, key, index) in campus">{{val}}</div>-->
        <!--<div class="block fl">
          <span class="demonstration">省、市、县</span>
          <el-cascader placeholder="选择：省、市、县" :options="options" filterable change-on-select></el-cascader>
        </div>-->
        <el-form-item label="学校是否开启" class="fl search-above" >
          <el-select v-model="campus.status" placeholder="可不选">
            <el-option label="未删除" value="0"></el-option>
            <el-option label="已删除" value="1"></el-option>
          </el-select>
        </el-form-item>
        <el-button type="primary" icon="search" class="fl button-display-school" @click="displaySchool">搜索</el-button>
      </el-form>
    </div>
    <!--展示学校-->
    <div class="display-school">
      <el-table :data="campusResult" style="width: 100%">
        <el-table-column prop="id" label="学校ID" width="180"></el-table-column>
        <el-table-column prop="school_title" label="名称" width="180"></el-table-column>
        <el-table-column prop="province" label="省份" width="120"></el-table-column>
        <el-table-column prop="city" label="市" width="120"></el-table-column>
        <el-table-column prop="region" label="县区" width="120"></el-table-column>
        <el-table-column prop="address" label="地址"></el-table-column>
        <el-table-column prop="status_label" label="学校是否开启"></el-table-column>
      </el-table>
    </div>

    <el-dialog title="创建学校" v-model="dialogFormVisible">
      <el-form :model="build" class="clearFix">
        <el-form-item label="主校ID" :label-width="formLabelWidth" class="fl" >
          <el-input v-model="build.parent_id" auto-complete="off" placeholder="可不填"></el-input>
        </el-form-item>
        <el-form-item label="学校名称" :label-width="formLabelWidth" class="fl">
          <el-input v-model="build.school_title" auto-complete="off" placeholder="必填"></el-input>
        </el-form-item>
        <el-form-item label="学校简称" :label-width="formLabelWidth" class="fl">
          <el-input v-model="build.school_short_title" auto-complete="off" placeholder="可不填"></el-input>
        </el-form-item>
        <el-form-item label="学校标语" :label-width="formLabelWidth" class="fl">
          <el-input v-model="build.school_slogan" auto-complete="off" placeholder="可不填"></el-input>
        </el-form-item>
        <el-form-item label="Logo路径" :label-width="formLabelWidth" class="fl">
          <el-input v-model="build.school_logo_path" auto-complete="off" placeholder="可不填"></el-input>
        </el-form-item>
        <el-form-item label="背景图路径" :label-width="formLabelWidth" class="fl">
          <el-input v-model="build.school_backgroud_path" auto-complete="off" placeholder="可不填"></el-input>
        </el-form-item>
        <el-form-item label="省份" :label-width="formLabelWidth" class="fl">
          <el-input v-model="build.province_id" auto-complete="off" placeholder="必填"></el-input>
        </el-form-item>
        <el-form-item label="城市" :label-width="formLabelWidth" class="fl">
          <el-input v-model="build.city_id" auto-complete="off" placeholder="必填"></el-input>
        </el-form-item>
        <el-form-item label="区县" :label-width="formLabelWidth" class="fl">
          <el-input v-model="build.region_id" auto-complete="off" placeholder="必填"></el-input>
        </el-form-item>
        <el-form-item label="详细地址" :label-width="formLabelWidth" class="fl">
          <el-input v-model="build.address" auto-complete="off" placeholder="可不填"></el-input>
        </el-form-item>
        <el-form-item label="学校是否开启" :label-width="formLabelWidth" class="fl">
          <el-select v-model="build.status" placeholder="可不选">
            <el-option label="未删除" value="0"></el-option>
            <el-option label="已删除" value="1"></el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button type="primary" @click="dialogFormVisible = false">确 定</el-button>
        <el-button @click="dialogFormVisible = false">取 消</el-button>
      </div>
    </el-dialog>

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

    created () {
      this.displaySchool()
    },
    data () {
      return {
        labelPosition: 'top',
        // 展示学校的数据
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

        promptText: [
          '学校ID',
          '主校ID',
          '学校名称',
          '学校简称',
          '学校标语',
          'Logo路径',
          '背景图路径',
          '省',
          '城市',
          '区县',
          '具体地址(街道)',
          'status'
        ],
        campusResult: [],
        // 创建学校的数据
        dialogFormVisible: false,
        build: {
          parent_id: '',
          school_title: '',
          school_short_title: '',
          school_slogan: '',
          school_logo_path: '',
          school_backgroud_path: '',
          province_id: '',
          region_id: '',
          address: '',
          status: ''
        },
        formLabelWidth: '120px'
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

      },
//       创建学校
      createSchool () {
        Campus.appendSchool(this.build).then(response => {
          if (response.errno === '0') {
          }
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
  .display-school
    margin-left:20px;
  .exhibition-top
    text-align :center;

    margin-left:20px;
  .search-above
    margin-right:10px;
  .el-dialog--small
    width:80%;
  .search-school
    .button-display-school
      margin-top:23px;

</style>
