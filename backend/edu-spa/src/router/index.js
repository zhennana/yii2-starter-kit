import Vue from 'vue'
import Router from 'vue-router'

// ---------------------------学校管理目录下-------------------------

import SchoolManager from '../components/schoolmanager/SchoolManager'
import CourseManager from '../components/coursemanager/CourseManager'
import ClassClassificationManagement from '../components/schoolmanager/ClassClassifcationManagement'
import ClassManagement from '../components/schoolmanager/ClassManagement'
import CollegeManagement from '../components/schoolmanager/CollegeManagement'
import StudentManagement from '../components/schoolmanager/StudentManagement'
import StudentRecordsManagement from '../components/schoolmanager/StudentRecordsManagement'

// ----------------------------课程管理目录下------------------------------------------

import AttendanceManagement from '../components/coursemanager/AttendanceManagement'
import Curriculum from '../components/coursemanager/Curriculum'

// --------------------------------课件管理目录下-----------------------------------------

import CoursewareManagement from '../components/coursewareManagement/CoursewareManagement'
import CoursewareList from '../components/coursewareManagement/CoursewareList'
import CoursewareAccessories from '../components/coursewareManagement/CoursewareAccessories'
import CoursewareClassification from '../components/coursewareManagement/CoursewareClassification'
import CoursewareRelation from '../components/coursewareManagement/CoursewareRelation'
import AttachmentManagement from '../components/coursewareManagement/AttachmentManagement'

// ---------------------------------内容目录下------------------------------------------

import Content from '../components/content/Content'
import StaticPage from '../components/content/StaticPage'
import Article from '../components/content/Article'
import ArticleClassification from '../components/content/ArticleClassification'
import TextComponent from '../components/content/TextComponent'

// ----------------------------未知--------------------------------------

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
          path: '/',
          name: 'CollegeManagement',
          component: CollegeManagement
        },
        {
          path: '/CollegeManagement',
          name: 'CollegeManagement',
          component: CollegeManagement
        },
        {
          path: '/ClassClassificationManagement',
          name: 'ClassClassificationManagement',
          component: ClassClassificationManagement
        },
        {
          path: '/ClassManagement',
          name: 'ClassManagement',
          component: ClassManagement
        },
        {
          path: '/StudentManagement',
          name: 'StudentManagement',
          component: StudentManagement
        },
        {
          path: '/StudentRecordsManagement',
          name: StudentRecordsManagement,
          component: StudentRecordsManagement
        }
      ]
    },
    {
      path: '/CourseManager',
      name: 'course-manager',
      component: CourseManager,
      children: [
        {
          path: '/',
          name: 'Curriculum',
          component: Curriculum
        },
        {
          path: '/Curriculum',
          name: 'Curriculum',
          component: Curriculum
        },
        {
          path: '/AttendanceManagement',
          name: 'AttendanceManagement',
          component: AttendanceManagement
        }
      ]
    },
    {
      path: '/CoursewareManagement',
      name: 'CoursewareManagement',
      component: CoursewareManagement,
      children: [
        {
          path: '/',
          name: 'CoursewareList',
          component: CoursewareList
        },
        {
          path: '/CoursewareList',
          name: 'CoursewareList',
          component: CoursewareList
        },
        {
          path: '/CoursewareAccessories',
          name: 'CoursewareAccessories',
          component: CoursewareAccessories
        },
        {
          path: '/CoursewareClassification',
          name: 'CoursewareClassification',
          component: CoursewareClassification
        },
        {
          path: '/CoursewareRelation',
          name: 'CoursewareRelation',
          component: CoursewareRelation
        },
        {
          path: '/AttachmentManagement',
          name: 'AttachmentManagement',
          component: AttachmentManagement
        }
      ]
    },
    {
      path: '/Content',
      name: 'Content',
      component: Content,
      children: [
        {
          path: '/',
          name: 'StaticPage',
          component: StaticPage
        },
        {
          path: '/StaticPage',
          name: 'StaticPage',
          component: StaticPage
        },
        {
          path: '/Article',
          name: 'Article',
          component: Article
        },
        {
          path: '/ArticleClassification',
          name: 'ArticleClassification',
          component: ArticleClassification
        },
        {
          path: '/TextComponent',
          name: 'TextComponent',
          component: TextComponent
        }
      ]
    },
    {
      path: '/CourseManager'
    }
  ]
})
