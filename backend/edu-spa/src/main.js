// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import router from './router'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css'
import './assets/stylus/common/_common.styl'
import store from './store'

import App from './App'

Vue.config.productionTip = false
Vue.use(ElementUI)
// -----------------------   自定义指令   ------------------------
Vue.directive('permission',
  function (el, binding) {
    console.log('update')
    if (store.state.userInfo.prems) {
      el.style.display = binding.value.display
    } else {
      el.style.display = 'none'
    }
    console.log(el)
    console.log(binding)
  })

// ----------------------- router 钩子函数  ------------------------
router.beforeEach((to, from, next) => {
  if (to.meta.requireAuth) {
    if (store.state.userInfo.user) {
      next()
    } else {
      next({
        path: '/login',
        query: {
          redirect: to.fullPath
        }
      })
    }
  } else {
    next()
  }
})

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: {App}
})
