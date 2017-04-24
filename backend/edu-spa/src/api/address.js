/**
 * Created by YJZX-LCH on 2017-04-21.
 */
import axios from '../config/axios'

export default {
  getProvince () {
    return axios.get('/campus/api/v1/school/standard-address', {
      params: {
        type_id: 0
      }
    }).then(response => {
      if (response.status === 200) {
        return response.data
      } else {
        throw new Error('接口返回错误')
      }
    })
  },
  getCities (provinceId) {
    return axios.get('/campus/api/v1/school/standard-address', {
      params: {
        type_id: 1,
        id: provinceId
      }
    }).then(response => {
      if (response.status === 200) {
        return response.data
      } else {
        throw new Error('接口返回错误')
      }
    })
  },
  getRegions (cityId) {
    return axios.get('/campus/api/v1/school/standard-address', {
      params: {
        type_id: 2,
        id: cityId
      }
    }).then(response => {
      if (response.status === 200) {
        return response.data
      } else {
        throw new Error('接口返回错误')
      }
    })
  }
}
