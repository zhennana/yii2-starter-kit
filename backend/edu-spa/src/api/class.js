/**
 * Created by YJZX-LCH on 2017-04-14.
 */
import axios from '../config/axios'
// import qs from 'qs'

export default {
  getClassData (params) {
    return axios.get('/campus/api/v1/grade/index', {
      params: params
    }).then(response => {
      return response.data
    }).catch(error => {
      console.log(error)
    })
  }
}
