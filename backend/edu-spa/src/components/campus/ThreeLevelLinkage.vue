<template>

</template>
<script>
  import Campus from '../../api/campus'
  import Vue from 'vue'
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

</style>
