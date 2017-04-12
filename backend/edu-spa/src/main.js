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

// Vue.directive('permission', {
//   bind (el) {
//     console.log('bind')
//     console.log(el)
//   },
//   insert () {
//     console.log('insert')
//   },
//   update (el, binding) {
//     console.log('update')
//     el.style.display = 'none'
//     console.log(el)
//     console.log(binding)
//   },
//   componentUpdated () {
//     console.log('componentUpdated')
//   },
//   unbind () {
//     console.log('unbind')
//   }
// })
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

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: {App}
})
