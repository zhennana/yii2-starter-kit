/**
 * Created by YJZX-LCH on 2017-04-12.
 */
import Vue from 'vue'
import Vuex from 'vuex'
import userInfo from './modules/users'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    userInfo
  }
})
