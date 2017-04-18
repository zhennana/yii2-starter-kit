/**
 * Created by Administrator on 2017-04-14.
 */
import axios from '../config/axios'
// import qs from 'qs'

export default {
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
  }
}
