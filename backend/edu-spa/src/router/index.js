import Vue from 'vue'
import Router from 'vue-router'
import SchoolManager from '../components/schoolmanager/SchoolManager'
import CourseManager from '../components/coursemanager/CourseManager'
import Hello from '../components/Hello'
import Home from '../components/home/Home'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/SchoolManager',
      name: 'school-manager',
      component: SchoolManager,
      children: [
        {
          path: '/Hello',
          name: 'hello',
          component: Hello
        }
      ]
    },
    {
      path: '/CourseManager',
      name: 'course-manager',
      component: CourseManager
    },
    {
      path: '/CourseManager'
    }
  ]
})
