<template>
  <div class="clearFix">
    <div class="fl select-top-boss">
      <div class="select-top">省</div>
      <el-select v-model="threeCombinations.province.id" placeholder="省份" v-on:change="obtainCity()">
        <el-option v-for="(val, key, index) in depositProvince" :label="val.province_name" :value="val.province_id" :key="val.province_id"></el-option>
      </el-select>
    </div>
    <div class="fl">
      <div class="select-top">市</div>
      <el-select v-model="threeCombinations.city.id" placeholder="市" v-on:change="obtainCounty()">
        <el-option v-for="(val, key, index) in depositCity" :label="val.city_name" :value="val.city_id" :key="val.city_id"></el-option>
      </el-select>
    </div>
    <div class="fl">
      <div class="select-top">县</div>
      <el-select v-model="threeCombinations.county.id" v-on:change="sendOutCounty" placeholder="县（区）">
        <el-option v-for="(val, key, index) in urbanCounty" :label="val.region_name" :value="val.region_id" :key="val.region_id"></el-option>
      </el-select>
    </div>
    <div>{{ msg }}</div>
  </div>
</template>
<script>
  import Campus from '../../api/campus'
  export default {
    created () {
      this.threeLevelLinkage()
    },
    mounted () {
//      this.initSelect()
    },
    updated () {
      console.log('数据')
      console.log(this.initData)
    },
    data () {
      return {
        // 存放省份的数据
        depositProvince: [],
        // 存放市的数据
        depositCity: [],
        // 存放县的数据
        urbanCounty: [],
        // 省市县三个组合
//        threeCombinations: {
//          // 存放省的数据 用来获取市
//          province: {
//            type_id: '1',
//            id: this.initData.province_id
//          },
//          // 存放市的数据 用来获取县
//          city: {
//            type_id: '2',
//            id: this.initData.city_id
//          },
//          // 存放县的数据
//          county: {
//            type_id: '3',
//            id: this.initData.region_id
//          }
//        },
        arr: []
      }
    },
    computed: {
      threeCombinations () {
        console.log(1111)
        return {
          // 存放省的数据 用来获取市
          province: {
            type_id: '1',
            id: this.initData.province_id
          },
          // 存放市的数据 用来获取县
          city: {
            type_id: '2',
            id: this.initData.city_id
          },
          // 存放县的数据
          county: {
            type_id: '3',
            id: this.initData.region_id
          }
        }
      }
    },
    props: {
      initData: {
        type: Object,
        default () {
          return {
            province_id: '',
            city_id: '',
            region_id: ''
          }
        }
      },
      msg: {
        type: String,
        default () { return 'aaa' }
      }
    },
    methods: {
      initSelect () {
        console.log(this.initData)
        for (let key in this.initData) {
          if (key === 'province_id') {
            this.threeCombinations.province.id = this.initData[key]
          } else if (key === 'city_id') {
            this.threeCombinations.city.id = this.initData[key]
          } else if (key === 'region_id') {
            this.threeCombinations.county.id = this.initData[key]
          }
        }
        this.threeCombinations.province.id = this.initData.province_id
        this.threeCombinations.city.id = this.initData.city_id
        this.threeCombinations.county.id = this.initData.region_id
      },
     // 三级联动   获取省
      threeLevelLinkage () {
        Campus.provinceCity(this.depositProvince).then(response => {
          if (response.errno === '0') {
            this.depositProvince = response.result
            this.$emit('obtainCity', this.threeCombinations)
          }
        }).catch(error => {
          console.log(error)
        })
      },
//    三级联动  获取市
      obtainCity () {
        Campus.provinceCity(this.threeCombinations.province).then(response => {
          if (response.errno === '0') {
            this.threeCombinations.city.id = ''
            this.depositCity = []
            this.depositCity = response.result
            this.$emit('obtainCity', this.threeCombinations)
          }
        }).catch(error => {
          console.log(error)
        })
      },
//   三级联动 获取县
      obtainCounty () {
        Campus.provinceCity(this.threeCombinations.city).then(response => {
          if (response.errno === '0') {
            this.threeCombinations.county.id = ''
            this.urbanCounty = []
            this.urbanCounty = response.result
            this.$emit('obtainCity', this.threeCombinations)
          }
        }).catch(error => {
          console.log(error)
        })
      },
//  给父组件发县的ID
      sendOutCounty () {
        this.$emit('obtainCity', this.threeCombinations)
      }
    }
  }
</script>
<style lang="stylus" type="text/stylus" rel="stylesheet/stylus">
  .fl
    float:fl;
  .clearFix:after
    clear:both;
    display:block;
    content: '';
  .select-top-boss
    text-align: center;
  .clearFix
    zoom:1;
  .select-top
    margin-bottom:10px;
    font-size: 14px;
    color: #48576a;
    vertical-align: middle;
</style>
