/**
 * Created by Administrator on 2017-04-26.
 */
import axios from '../../config/axios'
// import qs from 'qs'
export default {
  getCourseware (params) {
    return axios.get('/campus/api/v1/courseware/index', {
      params: params
    }).then(response => {
      if (response.status !== 200) {
        throw new Error('返回接口失败')
      } else {
        return response.data
      }
    })
  }
}
