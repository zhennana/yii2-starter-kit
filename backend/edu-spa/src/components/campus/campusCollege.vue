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
      <el-form :label-position="labelPosition" label-width="60" class="clearFix exhibition-top">
          <el-form-item label="学校ID" class="fl search-above">
            <el-input v-model="campus.id" class="search-above"></el-input>
          </el-form-item>
          <el-form-item label="主校ID" class="fl search-above">
            <el-input v-model="campus.parent_id" class="search-above"></el-input>
          </el-form-item>
          <el-form-item label="学校名称" class="fl search-above">
            <el-input v-model="campus.school_title" class="search-above"></el-input>
          </el-form-item>
          <el-form-item label="学校简称" class="fl search-above">
            <el-input v-model="campus.school_short_title" class="search-above"></el-input>
          </el-form-item>
          <el-form-item label="学校标语" class="fl search-above">
            <el-input v-model="campus.school_slogan" class="search-above"></el-input>
          </el-form-item>
          <el-form-item label="Logo路径" class="fl search-above">
            <el-input v-model="campus.school_logo_path" class="search-above"></el-input>
          </el-form-item>
          <el-form-item label="背景图路径" class="fl search-above">
            <el-input v-model="campus.school_backgroud_path" class="search-above"></el-input>
          </el-form-item>
          <el-form-item label="省" class="fl search-above">
            <el-input v-model="campus.province_id" class="search-above"></el-input>
          </el-form-item>
          <el-form-item label="城市" class="fl search-above">
            <el-input v-model="campus.city_id" class="search-above"></el-input>
          </el-form-item>
          <el-form-item label="区县" class="fl search-above">
            <el-input v-model="campus.region_id" class="search-above"></el-input>
          </el-form-item>
          <el-form-item label="具体地址" class="fl search-above">
            <el-input v-model="campus.address" class="search-above"></el-input>
          </el-form-item>
        <!--三级联动-->
        <threeLevel-linkage></threeLevel-linkage>
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
    <!--创建学校的弹出框-->
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
  </div>
</template>

<script>
  import Vue from 'vue'
  import Campus from '../../api/campus'
  export default {
    created () {
      this.displaySchool()
      this.threeLevelLinkage()
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
        }
      }
    },
    methods: {
      // 展示学校
      displaySchool () {
        Campus.getSchool(this.campus).then(response => {
          if (response.errno === '0') {
            this.campusResult = response.result
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
  Vue.component('threeLevel-linkage', {
    template: ` <div>
          <el-select v-model="getCity.id" placeholder="省份" v-on:change="obtainCity()">
            <el-option v-for="(val, key, index) in depositProvince" :label="val.province_name" :value="val.province_id" :key="val.province_id"></el-option>
          </el-select>
          <el-select v-model="getCounty.id" placeholder="市" v-on:change="obtainCounty()">
            <el-option v-for="(val, key, index) in depositCity" :label="val.city_name" :value="val.city_id" :key="val.city_id"></el-option>
          </el-select>
          <el-select v-model="countySelect" placeholder="县（区）">
            <el-option v-for="(val, key, index) in urbanCounty" :label="val.region_name" :value="val.region_id" :key="val.region_id"></el-option>
          </el-select>
        </div>`,
    created () {
      this.threeLevelLinkage()
    },
    data () {
      return {
        // 存放省份的数据
        depositProvince: [],
        // 获取市的数据
        getCity: {
          type_id: '1',
          id: ''
        },
        // 存放市的数据
        depositCity: [],
        // 获取县的数据
        getCounty: {
          type_id: '2',
          id: ''
        },
        // 存放县的数据
        urbanCounty: [],
        // 绑定到县select的数据
        countySelect: ''
      }
    },
    methods: {
//     三级联动   获取省
      threeLevelLinkage () {
        Campus.provinceCity(this.depositProvince).then(response => {
          if (response.errno === '0') {
            this.depositProvince = response.result
          }
        }).catch(error => {
          console.log(error)
        })
      },
//    三级联动  获取市
      obtainCity () {
        Campus.provinceCity(this.getCity).then(response => {
          if (response.errno === '0') {
            this.getCounty.id = ''
            this.depositCity = []
            this.depositCity = response.result
          }
        }).catch(error => {
          console.log(error)
        })
      },
//   三级联动 获取县
      obtainCounty () {
        Campus.provinceCity(this.getCounty).then(response => {
          if (response.errno === '0') {
            this.countySelect = ''
            this.urbanCounty = []
            this.urbanCounty = response.result
          }
        }).catch(error => {
          console.log(error)
        })
      }
    }
  })
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
    margin-right:5px;
  .el-dialog--small
    width:80%;
  .search-school
    .button-display-school
      margin-top:23px;
      margin-left:20px;
  /*三级联动的样式*/
  .myAddress
    width: 100%;
    background-color: white;
    border-top: 4px solid rgba(245,245,245,1);
    color:#333;
  .myAddress .cont
    border-bottom: 1px solid rgba(245,245,245,0.8);
  .myAddress .cont span
    display: inline-block;
    font-size: 0.28rem;
    color: #333;
    line-height: 0.88rem;
    margin-left: 0.32rem;
  .myAddress .cont section
    float:left;
  .myAddress .cont p
    display: inline-block;
    font-size: 0.28rem;
    color: #333333;
    line-height: 0.88rem;
    margin-left: 1rem;
  .myAddress .cont .pic2
    float: right;
    width: 0.14rem;
    height: 0.24rem;
    margin: 0.32rem 0.32rem 0.32rem 0;
  .myAddress .cont p.text
    margin-left: 0.72rem;
  .showChose
    width:100%;
    height:100%;
    position:fixed;
    top:0;
    left:0;
    z-index:120;
    background:rgba(77,82,113,0.8);
  .address
    position:absolute;
    bottom:0;
    left:0;
    z-index:121;
    background:#fff;
    width:100%;
  .title h4
    display:inline-block;
    margin-left:3.2rem;
    font-size:0.32rem;
    line-height:0.88rem;
    font-weight:normal;
    color:#999;
  .title span
    margin:0.42rem 0 0 2.2rem;
    font-size:0.45rem;
    line-height:0.34rem;
    color:#D8D8D8;
  .area
    display:inline-block;
    font-size:0.24rem;
    line-height:0.88rem;
    margin-left:0.42rem;
    color:#333;
  .addList
    width:100%;
    padding-left:0.32rem;
    font-size:0.34rem;
    line-height:0.88rem;
    color:#333;
  /* 修改的格式 */
  .address ul
    width:95%;
    height:100%;
    max-height: 4.4rem;
    overflow:auto;
  .address ul li
    margin-left:5%;
  .address .title .active
    color:#0071B8;
    border-bottom:0.02rem solid #0071B8;
  .address ul .active
    color:#0071B8;
</style>
