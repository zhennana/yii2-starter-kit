/**
 * Created by YJZX-LCH on 2017-04-14.
 */
import axios from '../config/axios'
import qs from 'qs'

export default {
  getClassData (params) {
    return axios.get('/campus/api/v1/grade/index', {
      params: params
    }).then(response => {
      if (response.status === 200) {
        return response.data
      } else {
        throw new Error('接口返回失败')
      }
    })
  },
  getClassFormInfo () {
    return axios.get('/campus/api/v1/grade/form-list').then(response => {
      if (response.status === 200) {
        return response.data
      } else {
        throw new Error('接口返回失败')
      }
    })
  },
  /**
   * 创建班级
   * @param info
   * @returns {Promise.<T>}
   */
  createClass (info) {
    return axios.post('/campus/api/v1/grade/create', qs.stringify(info))
      .then(response => {
        if (response.status === 201) {
          return response.data
        } else {
          throw new Error('接口返回失败')
        }
      })
  },
  /**
   * 修改班级信息
   * @param info
   */
  updateClass (info) {
    return axios.post('/campus/api/v1/grade/update?id=' + info.grade_id, qs.stringify(info))
      .then(response => {
        if (response.status === 200) {
          return response.data
        } else {
          throw new Error('接口返回失败')
        }
      })
  },
  /**
   * 删除 班级
   * @param info
   */
  deleteClass (info) {
    info.status = 0
    return axios.post('/campus/api/v1/grade/update?id=' + info.grade_id, qs.stringify(info))
      .then(response => {
        if (response.status === 200) {
          return response.data
        } else {
          throw new Error('接口返回失败')
        }
      })
  }
}
