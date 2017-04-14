/**
 * Created by YJZX-LCH on 2017-04-11.
 */
import axios from 'axios'
import config from '../../config'
//  配置 baseUrl
const baseUrl = process.env.NODE_ENV === 'production' ? config.build.baseUrl : (config.dev.baseUrl + ':' + config.dev.port) + '/'

const instance = axios.create({
  baseURL: baseUrl,
  timeout: 30000,
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded',
    'Accept': 'application/json'
  },
  withCredentials: false,
  validateStatus: function (status) {
    return status === 200
  }
})

export default instance
