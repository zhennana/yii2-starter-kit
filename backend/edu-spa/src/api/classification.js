/**
 * Created by Administrator on 2017-04-25.
 */
import axios from '../config/axios'
// import qs from 'qs'
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
  }
}
