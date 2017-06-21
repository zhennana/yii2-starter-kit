import Vue from 'vue'
import Router from 'vue-router'

// ---------------------------学校管理目录下-------------------------

import Campus from '../components/campus/Campus'
import campusCollege from '../components/campus/campusCollege'
import Class from '../components/campus/Class.vue'
import Classification from '../components/campus/Classification'
import Student from '../components/campus/Student'

// -----------------------------课件管理目录下--------------------------

import Courseware from '../components/courseware/Courseware'
import CoursewareList from '../components/courseware/CoursewareList'

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
          redirect: '/campus',
          meta: {
            requireAuth: true
          }
        },
        {
          path: '/campus',
          name: 'campus',
          component: Campus,
          redirect: '/campus-college',
          meta: {
            requireAuth: true
          },
          children: [
            {
              path: '/campus-college',
              name: 'campus-college',
              component: campusCollege,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/class',
              name: 'class',
              component: Class,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/classification',
              name: 'classification',
              component: Classification,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/student',
              name: 'student',
              component: Student,
              meta: {
                requireAuth: true
              }
            }
          ]
        },
        {
          path: '/courseware',
          name: 'Courseware',
          component: Courseware,
          redirect: '/courseware-list',
          meta: {
            requireAuth: true
          },
          children: [
            {
              path: '/courseware-list',
              name: 'courseware-list',
              component: CoursewareList,
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
