<template>
  <div class="header">
    <div class="logo">
      <router-link to="/Main">
        <img src="../../assets/img/logo.png"/>
      </router-link>

    </div>
    <el-menu theme="dark" :default-active="activeIndex" class="el-menu-demo top-menu" mode="horizontal">
      <el-menu-item v-for="item in topMenuList" :index="item.name" :key="item.name">
        <router-link :to="{path:item.path}">
          {{item.title}}
        </router-link>
      </el-menu-item>
      <el-submenu index="100">
        <template slot="title">设置</template>
        <el-menu-item index="2-1">其他1</el-menu-item>
        <el-menu-item index="2-2">其他2</el-menu-item>
        <el-menu-item index="2-3" @click="logout">退出</el-menu-item>
      </el-submenu>
    </el-menu>
    <div class="switch-school" @click="openElasticLayer">切换学校</div>
    <div class="elastic-layer" v-bind:style="layerStyle" v-bind:class="{elastic_layer: isElastic_layer}">
      <div class="elastic-layer-option">
        <el-checkbox :indeterminate="isIndeterminate" v-model="checkAll" @change="handleCheckAllChange">全选</el-checkbox>
        <el-checkbox-group v-model="checkedCities" @change="handleCheckedCitiesChange">
          <el-checkbox v-for="city in cities" :label="city.school_id" :value="city" :key="city">{{city.school_title}}</el-checkbox>
        </el-checkbox-group>
        <el-button type="success" @click="Close">确定</el-button>
        <el-button type="warning" @click="Close">取消</el-button>
      </div>
      </div>
  </div>
</template>

<script type="text/ecmascript-6">
  import Login from '../../api/user/login'
  import Campus from '../../api/campus/campus'
  const cityOptions = []
  export default {
    name: 'Header',
    created () {
      console.log(this.layerStyle)
      this.ChoiceSchool()
    },
    data () {
      return {
        activeIndex: 'School',
        topMenuList: [
          {
            id: '0',
            name: 'campus',
            path: 'campus',
            title: '教务管理'
          },
          {
            id: '0',
            name: 'courseware',
            path: 'courseware',
            title: '课件管理'
          }
        ],
        layerStyle: {
          marginTop: -document.documentElement.clientHeight / 2 + 'px',
          marginLeft: -document.documentElement.clientWidth / 2 + 'px',
          width: document.documentElement.clientWidth + 'px',
          height: document.documentElement.clientHeight + 'px'
        },
        checkAll: true,
        checkedCities: [],
        cities: cityOptions,
        isIndeterminate: true,
        isElastic_layer: true,
        schoolId: ''
      }
    },
    methods: {
      logout () {
        Login.logout().then(response => {
          if (response.errno === '0') {
            this.$store.commit('clearUserInfo')
            this.$router.push({
              path: '/'
            })
          } else {
            this.showMsg(response.message)
          }
        }).catch(error => {
          console.log(error)
        })
      },
      handleSelect () {},
      handleCheckAllChange (event) {
        this.checkedCities = event.target.checked ? cityOptions : []
        this.isIndeterminate = false
      },
      handleCheckedCitiesChange (value) {
        console.log(value)
        let checkedCount = value.length
        this.checkAll = checkedCount === this.cities.length
        this.isIndeterminate = checkedCount > 0 && checkedCount < this.cities.length
      },
      Close () {
        this.isElastic_layer = true
      },
      openElasticLayer () {
        this.isElastic_layer = false
      },
      ChoiceSchool () {
        Campus.getSchool(this.schoolId).then(response => {
          if (response.errno === '0') {
            for (let i = 0; i < response.result.length; i++) {
              cityOptions.push({school_title: response.result[i].school_title,
                school_id: response.result[i].school_id})
            }
            console.log(cityOptions)
          }
        }).catch(error => {
          console.log(error)
        })
      }
    }
  }
</script>

<style lang="stylus" type="text/stylus" rel="stylesheet/stylus">
  header-bg-color = #324157;
  *
    padding: 0;
    margin: 0;

  .header
    height 60px;
    position fixed;
    top:0;
    left:0;
    width 100%;
    font-size 0;
    background header-bg-color;
    z-index:1000;
    .logo
      display inline;
      position absolute;
      cursor pointer;
      top: 10px;
      left: 20px;
      img
        width 40px;
        height 40px;
    .top-menu
      margin-left 10%;
      width 90%;
      & > li > a {
        display block
        width 100%;
        height 100%;
        text-decoration none;
      }
  .switch-school
    position: absolute;
    right:50px;
    top:25px;
    z-index:3000;
    font-size:16px;
    cursor:pointer;
  .elastic-layer
    position:fixed;
    left:50%;
    top:50%;
    background-color:rgba(0, 0, 0, 0.3);
    z-index: 3000;
    .el-checkbox-group
      .el-checkbox
        color:#fff;
    .el-checkbox
      .el-checkbox__label
        color:#fff;
  .elastic-layer-option
    position:absolute;
    top:60px;
    right:30px;
    .el-checkbox-group
      overflow hidden;
      margin-top:20px;
      .el-checkbox
        overflow hidden;
        display:block;
        margin-left:0;
        .el-checkbox__inner
          display:inline-block;
          margin-top:-5px;
        .el-checkbox__label
          display:inline-block;
  .elastic_layer
    display:none;
</style>
