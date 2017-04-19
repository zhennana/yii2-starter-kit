/**
 * Created by Administrator on 2017-04-14.
 */
import axios from '../config/axios'
// import qs from 'qs'

export default {
  // 展示学校
  getSchool (params) {
    return axios.get('/campus/api/v1/school/index', {
      params: params
    }).then(response => {
      if (response.status !== 200) {
        throw new Error('接口返回失败')
      } else {
        return response.data
      }
    })
  },
  // 创建学校
  appendSchool (params) {
    return axios.post('/campus/api/v1/school/create', {
      params: params
    }).then(response => {
      if (response.status !== 200) {
        throw new Error('接口返回失败')
      } else {
        return response.data
      }
    })
  },
  // 三级联动
  provinceCity (params) {
    return axios.get('/campus/api/v1/school/standard-address', {
      params: params
    }).then(response => {
      if (response.status !== 200) {
        throw new Error('接口返回失败')
      } else {
        return response.data
      }
    })
  }
}
