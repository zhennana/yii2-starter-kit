/**
 * Created by Administrator on 2017-04-25.
 */
import axios from '../../config/axios'
import qs from 'qs'
export default {
  // 查询班级分类
  getClassification (params) {
    return axios.get('/campus/api/v1/grade-category/index', {
      params: params
    }).then(response => {
      if (response.status !== 200) {
        throw new Error('返回接口失败')
      } else {
        return response.data
      }
    })
  },
  getSelect (params) {
    return axios.get('/campus/api/v1/grade-category/form-list', {
      params: params
    }).then(response => {
      if (response.status !== 200) {
        throw new Error('返回接口失败')
      } else {
        return response.data
      }
    })
  },
  modifyClassification (params) {
    return axios.post('/campus/api/v1/grade-category/update', qs.stringify(params)).then(response => {
      if (response.status !== 200) {
        throw new Error('返回接口失败')
      } else {
        return response.data
      }
    })
  },
  createCategories (params) {
    return axios.post('/campus/api/v1/grade-category/create', qs.stringify(params)).then(response => {
      if (response.status !== 201) {
        throw new Error('返回接口失败')
      } else {
        return response.data
      }
    })
  }
}
