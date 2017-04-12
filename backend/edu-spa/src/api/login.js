/**
 * Created by YJZX-LCH on 2017-04-11.
 */
import axios from '../config/axios'
import qs from 'qs'

export default {
  Login (userName, password) {
    return axios.post('users/api/v1/sign-in/login', qs.stringify({
      'LoginForm[identity]': 'changshaoshuai',
      'LoginForm[password]': 'wakoo518'
    })).then((response) => {
      if (response.status !== 200) {
        throw new Error('接口返回失败')
      } else {
        return response.data
      }
    }).catch(error => {
      console.log('-----------------------------')
      console.log(error)
    })
  },

  getList () {
    return axios.post('/api/index.php?m=list&a=list', {
      cat: 12
    }).then((response) => {
      if (response.status !== 200) {
        throw new Error('接口返回失败')
      } else {
        return response.data
      }
    }).catch(error => {
      console.log('-----------------------------')
      console.log(error)
    })
  }
}
