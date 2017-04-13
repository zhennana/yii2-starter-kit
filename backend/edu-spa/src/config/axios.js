/**
 * Created by YJZX-LCH on 2017-04-11.
 */
import axios from 'axios'

const instance = axios.create({
  baseURL: 'http://localhost:8080/',
  timeout: 30000,
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded',
    'Accept': 'application/json'
  },
  // 自带Cookie 信息验证
  withCredentials: true,
  validateStatus: function (status) {
    return status === 200
  }
})

export default instance
