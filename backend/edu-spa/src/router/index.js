import Vue from 'vue'
import Router from 'vue-router'

// ---------------------------学校管理目录下-------------------------

import School from '../components/school/School'
import SchoolCollege from '../components/school/SchoolCollege'

// ----------------------------未知--------------------------------------

import Home from '../components/home/Home'
import Login from '../components/login/Login.vue'
import Main from '../components/main/Main.vue'
import store from '../store'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Login',
      component: Login
    },
    {
      path: '/login',
      name: 'Login',
      component: Login,
      beforeEnter: (to, from, next) => {
        // 判断用户信息
        if (store.state.userInfo.user) {
          next({
            path: '/main'
          })
        } else {
          next()
        }
      }
    },
    {
      path: '/main',
      name: 'main',
      component: Main,
      meta: {
        requireAuth: true
      },
      children: [
        {
          path: '',
          name: 'home',
          component: Home,
          meta: {
            requireAuth: true
          }
        },
        {
          path: '/school',
          name: 'school',
          component: School,
          redirect: '/school-college',
          meta: {
            requireAuth: true
          },
          children: [
            {
              path: '/school-college',
              name: 'school-college',
              component: SchoolCollege,
              meta: {
                requireAuth: true
              }
            }
          ]
        }
      ]
    }
  ]
})
