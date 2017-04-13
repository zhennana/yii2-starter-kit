/**
 * Created by YJZX-LCH on 2017-04-11.
 */
import axios from '../config/axios'
import qs from 'qs'

export default {
  login (userName, password) {
    return axios.post('users/api/v1/sign-in/login', qs.stringify({
      'LoginForm[identity]': userName,
      'LoginForm[password]': password
    })).then((response) => {
      if (response.status !== 200) {
        throw new Error('接口返回失败')
      } else {
        return response.data
      }
    })
  }
}
