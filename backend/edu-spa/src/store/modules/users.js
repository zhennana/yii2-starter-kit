/**
 * Created by YJZX-LCH on 2017-04-12.
 */

import localStorage from '../../localstorage/localStorage'

const state = {
  user: JSON.parse(localStorage.getData('user')),
  prems: true
}

const getters = {
  getUserInfo (state) {
    return state.user
  }
}

const mutations = {
  clearUserInfo (state) {
    state.user = false
    localStorage.removeData('user')
  },
  receivedUserInfoFromRemote (state, user) {
    state.user = user
    localStorage.addData('user', user)
  },
  receivedUserInfoFromLocal (state, user) {
    state.user = user
  }
}

export default {
  state,
  getters,
  mutations
}
