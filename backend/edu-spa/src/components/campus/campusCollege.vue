<template>
  <div>
    <!--头-->
    <el-row>
      <el-col :span="12" class="header-top clearFix">
        <h2 class="fl">学院管理</h2>
        <!--创建学校按钮-->
        <el-button type="info" class="fl append el-icon-plus" v-on:click="dialogFormVisible = true">创建</el-button>
      </el-col>
    </el-row>
    <!--搜素学校-->
    <div class="search-school clearFix">
      <el-form :label-position="labelPosition" label-width="60" class="clearFix exhibition-top">
        <el-form-item label="学校名" class="fl search-above">
          <el-select v-model="campus.id" placeholder="学校名">
            <el-option v-for="item in dischargeState.school" :label="item.school_title" :value="item.school_id" :key="item.school_id"></el-option>
          </el-select>
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
        <div>
        </div>
        <el-form-item label="学校是否开启" class="fl search-above" >
        <el-select v-model="campus.status" placeholder="">
          <el-option v-for="item in dischargeState.status" :label="item.status_label" :value="item.status_id" :key="item.status_id">
          </el-option>
        </el-select>
        </el-form-item>
        <!--三级联动-->
        <threeLevel-linkage class="fl" v-on:obtainCity="incrementTotal"></threeLevel-linkage>
          <el-form-item label="具体地址" class="fl search-above">
            <el-input v-model="campus.address" class="search-above"></el-input>
          </el-form-item>
        <el-button type="primary" icon="search" class="fl button-display-school" @click="displaySchool">搜索</el-button>
      </el-form>
    </div>
    <!--展示学校-->
    <div class="display-school">
      <el-table :data="campusResult" border style="width: 100%">
        <el-table-column fixed prop="id" label="学校ID" width="100"></el-table-column>
        <el-table-column prop="school_title" label="名称" width="120"></el-table-column>
        <el-table-column prop="province" label="省份" width="120"></el-table-column>
        <el-table-column prop="city" label="市区" width="120"></el-table-column>
        <el-table-column prop="region" label="县区" width="120"></el-table-column>
        <el-table-column prop="address" label="地址" width="300"></el-table-column>
        <el-table-column prop="status_label" label="学校是否开启" width="150"></el-table-column>
        <el-table-column fixed="right" label="操作" width="300" style="display:none">
          <template scope="scope">
            <el-button type="info" v-on:click="lookDetails(scope.row)">查看</el-button>
            <el-button type="success" v-on:click="modifyAlert(scope.$index, campusResult)">修改</el-button>
            <el-button type="danger">删除</el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <!--展示学校详情-->
    <div class="dischargeState">
      <el-dialog title="学校详情" v-model="dialogVisible">
        <el-table :data="exhibitionDetails" border style="width: 100%">
          <el-table-column fixed prop="id" label="学校ID" width="150"></el-table-column>
          <el-table-column prop="parent_id" label="主校ID" width="120"></el-table-column>
          <el-table-column prop="school_title" label="学校名称" width="120"></el-table-column>
          <el-table-column prop="school_short_title" label="学校简称" width="120"></el-table-column>
          <el-table-column prop="school_slogan" label="学校标语" width="120"></el-table-column>
          <el-table-column prop="school_logo_path" label="Logo路径" width="120"></el-table-column>
          <el-table-column prop="school_backgroud_path" label="背景图路径" width="120"></el-table-column>
          <el-table-column prop="province" label="省" width="120"></el-table-column>
          <el-table-column prop="city" label="城市" width="120"></el-table-column>
          <el-table-column prop="region" label="区县" width="120"></el-table-column>
          <el-table-column prop="address" label="详情地址" width="200"></el-table-column>
          <el-table-column prop="status_label" label="状态" width="120"></el-table-column>
        </el-table>
      </el-dialog>
    </div>
    <!--修改学校-->
    <div class="modify">
      <el-dialog title="修改学校" v-model="modify">
        <el-form :model="modifyData" :label-position="modifyLabelStatus">
          <el-form-item label="主校ID" :label-width="formLabelWidth" class="modify-increase-width">
            <el-input v-model="modifyData.parent_id" auto-complete="off"></el-input>
          </el-form-item>
          <el-form-item label="学校名称" :label-width="formLabelWidth" class="modify-increase-width">
            <el-input v-model="modifyData.school_title" auto-complete="off"></el-input>
          </el-form-item>
          <el-form-item label="学校简称" :label-width="formLabelWidth" class="modify-increase-width">
            <el-input v-model="modifyData.school_short_title" auto-complete="off"></el-input>
          </el-form-item>
          <el-form-item label="学校标语" :label-width="formLabelWidth" class="modify-increase-width">
            <el-input v-model="modifyData.school_slogan" auto-complete="off"></el-input>
          </el-form-item>
          <el-form-item label="Logo路径" :label-width="formLabelWidth" class="modify-increase-width">
            <el-input v-model="modifyData.school_logo_path" auto-complete="off"></el-input>
          </el-form-item>
          <el-form-item label="背景图路径" :label-width="formLabelWidth" class="modify-increase-width">
            <el-input v-model="modifyData.school_backgroud_path" auto-complete="off"></el-input>
          </el-form-item>
          <!--三级联动-->
          <div class="clearFix">
            <div class="select-top-boss fl">
              <div class="select-top">省</div>
              <el-select v-model="modifyData.province" :value="getCity.id" placeholder="省份" v-on:change="obtainCity()">
                <el-option v-for="(val, key, index) in depositProvince" :label="val.province_name" :value="val.province_id" :key="val.province_id" ></el-option>
              </el-select>
            </div>
            <div class="fl">
              <div class="select-top">市</div>
              <el-select v-model="modifyData.city" :value="getCounty.id" placeholder="市" v-on:change="obtainCounty()">
                <el-option v-for="(val, key, index) in depositCity" :label="val.city_name" :value="val.city_id" :key="val.city_id"></el-option>
              </el-select>
            </div>
            <div class="fl">
              <div class="select-top">县</div>
              <el-select v-model="modifyData.region" :value="depositCounty.id" placeholder="县（区）">
                <el-option v-for="(val, key, index) in urbanCounty" :label="val.region_name" :value="val.region_id" :key="val.region_id"></el-option>
              </el-select>
            </div>
          </div>
          <el-form-item label="具体地址" :label-width="formLabelWidth" class="modify-increase-width">
            <el-input v-model="modifyData.address" auto-complete="off"></el-input>
          </el-form-item>
          <el-form-item label="状态" class="search-above modify-increase-width">
            <el-select v-model="modifyData.status" placeholder="">
              <el-option v-for="item in dischargeState.status" :label="item.status_label" :value="item.status_id" :key="item.status_id">
              </el-option>
            </el-select>
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button type="primary" @click="modifySchool">确 定</el-button>
          <el-button @click="modify = false">取 消</el-button>
        </div>
      </el-dialog>
    </div>
    <!--创建学校的弹出框-->
    <div class="create-school">
      <el-dialog title="创建学校" v-model="dialogFormVisible">
        <el-form :model="build" class="clearFix">
          <el-form-item label="主校ID" class="create-school-input create-school-select">
            <el-select v-model="build.parent_id" placeholder="可不填">
              <el-option v-for="item in dischargeState.school" :label="item.school_title" :value="item.school_id" :key="item.school_id"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="学校名称" class="create-school-input">
            <el-input v-model="build.school_title" placeholder="必填"></el-input>
          </el-form-item>
          <el-form-item label="学校简称" class="create-school-input">
            <el-input v-model="build.school_short_title" placeholder="可不填"></el-input>
          </el-form-item>
          <el-form-item label="学校标语" class="create-school-input">
            <el-input v-model="build.school_slogan" placeholder="可不填"></el-input>
          </el-form-item>
          <el-form-item label="Logo路径" class="create-school-input">
            <el-input v-model="build.school_logo_path" placeholder="可不填"></el-input>
          </el-form-item>
          <el-form-item label="背景图路径" class="create-school-input">
            <el-input v-model="build.school_backgroud_path" placeholder="可不填"></el-input>
          </el-form-item>
          <threeLevel-linkage v-on:obtainCity="createProvinces"></threeLevel-linkage>
          <el-form-item label="详细地址" class="create-school-input">
            <el-input v-model="build.address" placeholder="可不填"></el-input>
          </el-form-item>
          <el-form-item label="排序" class="create-school-input">
            <el-input v-model="build.sort" placeholder="必填"></el-input>
          </el-form-item>
          <el-form-item label="学校是否开启" class="create-school-input">
            <el-select v-model="build.status" placeholder="必选">
              <el-option label="开启" value="0"></el-option>
              <el-option label="未开启" value="1"></el-option>
            </el-select>
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button type="primary" v-on:click="createSchool">确 定</el-button>
          <el-button @click="dialogFormVisible = false">取 消</el-button>
        </div>
      </el-dialog>
    </div>
  </div>
</template>

<script>
  import Campus from '../../api/campus'
  import ThreeLevelLinkage from './ThreeLevelLinkage'
  export default {
    created () {
      this.displaySchool()
      this.schoolState()
      this.threeLevelLinkage()
    },
    mounted () {
    },
    data () {
      return {
        msg: '333333',
        labelPosition: 'top',
        modifyLabelStatus: 'left',
        // 搜索学校的数据
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
        // 展示学校的数据
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
          status: '',
          sort: ''
        },
        formLabelWidth: '100px',
        // 省市县三个组合
        threeCombinations: {
          // 存放省的数据 用来获取市
          province: {
            type_id: '1',
            id: ''
          },
          // 存放市的数据 用来获取县
          city: {
            type_id: '2',
            id: ''
          },
          // 存放县的数据
          county: {
            type_id: '3',
            id: ''
          }
        },
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
        depositCounty: {
          type_id: '3',
          id: ''
        },
        // 存放县的数据
        urbanCounty: [],
        // 绑定到县select的数据
        countySelect: '',
        // 获取学校状态数据
        campusState: {
          type: ''
        },
        // 存放所有校区和学校状态
        dischargeState: {},
        // 展示学校详情的数据
        exhibitionDetails: [],
        // 学校详情弹出框控制的数据
        dialogVisible: false,
        // 修改学校弹出框控制的数据
        modify: false,
        // 更改学校的数据
        modifyData: {},
        initData: {}
      }
    },
    components: { ThreeLevelLinkage },
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
      // 查看学校详情
      lookDetails (campusResult) {
        this.exhibitionDetails = []
        this.dialogVisible = true
        this.exhibitionDetails.push(campusResult)
      },
      // 修改学校打开弹出框
      modifyAlert (index, campusResult) {
        this.modify = true
        this.modifyData = campusResult[index]
        this.threeCombinations.county.id = campusResult[index].region_id
        this.threeCombinations.province.id = campusResult[index].province_id
        this.threeCombinations.city.id = campusResult[index].city_id
      },
      // 修改学校
      modifySchool () {
        if (this.modifyData.school_title !== '' && this.modifyData.province_id !== '' && this.modifyData.city_id !== '' && this.modifyData.region_id !== '' && this.modifyData.status !== '' && this.modifyData.sort !== '') {
          Campus.modifyCampus(this.modifyData).then(response => {
            if (response.errno === '0') {
              this.displaySchool()
              console.log(this.modifyData)
              this.modify = false
            }
          }).catch(error => {
            console.log(error)
          })
        } else {
          alert('学校名称 省 城市 区县 学校是否开启 排序 不可为空，请填写')
        }
      },
      // 创建学校
      createSchool () {
        if (this.build.school_title !== '' && this.build.province_id !== '' && this.build.city_id !== '' && this.build.region_id !== '' && this.build.status !== '' && this.build.sort !== '') {
          Campus.appendSchool(this.build).then(response => {
            if (response.errno === '0') {
              for (let key in this.build) {
                this.build[key] = ''
              }
              this.dialogFormVisible = false
            }
          }).catch(error => {
            console.log(error)
          })
        } else {
          this.$message.error('学校名称 省  城市 区县 学校是否开启 排序 不可为空，请填写')
        }
      },
      incrementTotal (threeCombinations) {
        // 给所搜省赋值
        this.campus.province_id = threeCombinations.province.id
        // 给所搜市赋值
        this.campus.city_id = threeCombinations.city.id
        // 给所搜县赋值
        this.campus.region_id = threeCombinations.county.id
      },
      createProvinces (threeCombinations) {
        // 给创建省赋值
        this.build.province_id = threeCombinations.province.id
        // 给创建市赋值
        this.build.city_id = threeCombinations.city.id
        // 给创建县赋值
        this.build.region_id = threeCombinations.county.id
      },
      schoolState () {
        Campus.getSchoolState(this.campusState.type).then(response => {
          if (response.errno === '0') {
            this.dischargeState = response.result
          }
        }).catch(error => {
          console.log(error)
        })
      },
      // 三级联动   获取省
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
        this.getCity.id = this.modifyData.province
        Campus.provinceCity(this.getCity).then(response => {
          if (response.errno === '0') {
            if (this.modify === true) {
              this.modifyData.city = ''
              this.modifyData.region = ''
            }
            this.depositCity = []
            this.depositCity = response.result
          }
        }).catch(error => {
          console.log(error)
        })
      },
//   三级联动 获取县
      obtainCounty () {
        this.getCounty.id = this.modifyData.city
        Campus.provinceCity(this.getCounty).then(response => {
          if (response.errno === '0') {
            if (this.modify === true) {
              this.modifyData.region = ''
            }
            this.urbanCounty = []
            this.urbanCounty = response.result
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
  .dischargeState
    .el-dialog--small
      width:1500px;
  .modify-threeLevel
    margin-bottom:20px;
  .modify-increase-width
    .el-form-item__content
      width:600px;
      .el-select
        .el-input
          width:600px;
  .hidden
    display:none;
  .create-school
    .create-school-input
    .create-school-select
      .el-form-item__label
        float:left;
      .el-form-item__content
        float:left;
      .el-input
        margin-left:-100;
        width:600px;
</style>
