<template>
  <div>
    <el-select :value="initData.province_id" placeholder="请选择省份" v-on:change="getCities">
      <el-option
        v-for="item in provinces"
        v-on:handle-click="provinceSelected"
        :label="item.province_name"
        :key="item.province_id"
        :value="item.province_id">

      </el-option>
    </el-select>

    <el-select  placeholder="请选择城市" v-bind:value="initData.city_id" v-on:change="getRegions">
      <el-option
        v-for="item in cities"
        :label="item.city_name"
        v-on:handle-click="citySelected"
        :key="item.city_id"
        :value="item.city_id">

      </el-option>
    </el-select>

    <el-select placeholder="请选择县区" v-bind:value="initData.region_id">
      <el-option
        v-for="item in regions"
        :label="item.region_name"
        :key="item.region_id"
        v-on:handle-click="regionSelected"
        :value="item.region_id">

      </el-option>
    </el-select>

  </div>
</template>

<script>
  import Address from '../../api/address'
  import ElOption from './option.vue'
  export default {
    components: {ElOption},
    name: 'address-cascader',
    created () {
      this.getProvince()
      this.getCities(this.initData.province_id)
      this.getRegions(this.initData.city_id)
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
      }
    },
    data () {
      return {
        provinces: [],
        cities: [],
        regions: [],
        options: [
          {
            province_id: '110000',
            province_name: '北京市'
          },
          {
            province_id: '120000',
            province_name: '天津市'
          }
        ]
      }
    },
    methods: {
      getProvince () {
        Address.getProvince().then(response => {
          if (response.errno === '0') {
            this.provinces = response.result
          }
        }).catch(error => {
          console.log(error)
        })
      },
      getCities (provinceId) {
        console.log(111)
        console.log(provinceId)
        Address.getCities(provinceId).then(response => {
          if (response.errno === '0') {
            this.cities = response.result
            this.$emit('city-select', this.cities[0].city_id)
          }
        }).catch(error => {
          console.log(error)
        })
      },
      getRegions (cityId) {
        Address.getRegions(cityId).then(response => {
          if (response.errno === '0') {
            this.regions = response.result
            this.$emit('region-select', this.regions[0].region_id)
          }
        }).catch(error => {
          console.log(error)
        })
      },
      handleRegion (regionId) {
        console.log(regionId)
      },
      provinceSelected (provinceId) {
        console.log(provinceId)
        this.$emit('province-select', provinceId)
        this.$emit('city-select', '')
        this.$emit('region-select', '')
      },
      citySelected (cityId) {
        console.log(cityId)
        this.$emit('city-select', cityId)
        this.$emit('region-select', '')
      },
      regionSelected (regionId) {
        console.log(regionId)
        this.$emit('region-select', regionId)
      }
    },
    computed: {}
  }
</script>

<style>

</style>
