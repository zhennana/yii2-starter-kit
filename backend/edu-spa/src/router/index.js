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
import MenuComponent from '../components/content/MenuComponent'
import CarouselWidgets from '../components/content/CarouselWidgets'
import JoinInformation from '../components/content/JoinInformation'
import ContactUs from '../components/content/ContactUs'

// --------------------------------时间轴-------------------------------------

import TimeAxis from '../components/timeAxis/TimeAxis'

// ------------------------------用户管理-------------------------------

import UserManagement from '../components/UserManagement/UserManagement'

// --------------------------------其他---------------------------------------

import Other from '../components/other/Other'
import InternationalSourceInformation from '../components/other/internationalization/InternationalSourceInformation'
import InternationalInformation from '../components/other/internationalization/InternationalInformation'
import jsonStorage from '../components/other/jsonStorage'
import FileStore from '../components/other/FileStore'
import Cache from '../components/other/Cache'
import FileManagement from '../components/other/FileManagement'

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
        // ...
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
          path: '/SchoolManager',
          name: 'school-manager',
          component: SchoolManager,
          redirect: '/CollegeManagement',
          meta: {
            requireAuth: true
          },
          children: [
            {
              path: '/CollegeManagement',
              name: 'CollegeManagement',
              component: CollegeManagement,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/ClassClassificationManagement',
              name: 'ClassClassificationManagement',
              component: ClassClassificationManagement,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/ClassManagement',
              name: 'ClassManagement',
              component: ClassManagement,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/StudentManagement',
              name: 'StudentManagement',
              component: StudentManagement,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/StudentRecordsManagement',
              name: StudentRecordsManagement,
              component: StudentRecordsManagement,
              meta: {
                requireAuth: true
              }
            }
          ]
        },
        {
          path: '/CourseManager',
          name: 'course-manager',
          component: CourseManager,
          redirect: '/Curriculum',
          meta: {
            requireAuth: true
          },
          children: [
            {
              path: '/Curriculum',
              name: 'Curriculum',
              component: Curriculum,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/AttendanceManagement',
              name: 'AttendanceManagement',
              component: AttendanceManagement,
              meta: {
                requireAuth: true
              }
            }
          ]
        },
        {
          path: '/CoursewareManagement',
          name: 'CoursewareManagement',
          component: CoursewareManagement,
          redirect: '/CoursewareList',
          meta: {
            requireAuth: true
          },
          children: [
            {
              path: '/CoursewareList',
              name: 'CoursewareList',
              component: CoursewareList,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/CoursewareAccessories',
              name: 'CoursewareAccessories',
              component: CoursewareAccessories,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/CoursewareClassification',
              name: 'CoursewareClassification',
              component: CoursewareClassification,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/CoursewareRelation',
              name: 'CoursewareRelation',
              component: CoursewareRelation,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/AttachmentManagement',
              name: 'AttachmentManagement',
              component: AttachmentManagement,
              meta: {
                requireAuth: true
              }
            }
          ]
        },
        {
          path: '/Content',
          name: 'Content',
          component: Content,
          redirect: '/StaticPage',
          meta: {
            requireAuth: true
          },
          children: [
            {
              path: '/StaticPage',
              name: 'StaticPage',
              component: StaticPage,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/Article',
              name: 'Article',
              component: Article,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/ArticleClassification',
              name: 'ArticleClassification',
              component: ArticleClassification,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/TextComponent',
              name: 'TextComponent',
              component: TextComponent,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/MenuComponent',
              name: 'MenuComponent',
              component: MenuComponent,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/CarouselWidgets',
              name: 'CarouselWidgets',
              component: CarouselWidgets,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/JoinInformation',
              name: 'JoinInformation',
              component: JoinInformation,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/ContactUs',
              name: 'ContactUs',
              component: ContactUs,
              meta: {
                requireAuth: true
              }
            }
          ]
        },
        {
          path: '/TimeAxis',
          name: 'TimeAxis',
          component: TimeAxis,
          meta: {
            requireAuth: true
          }
        },
        {
          path: '/UserManagement',
          name: 'UserManagement',
          component: UserManagement,
          meta: {
            requireAuth: true
          }
        },
        {
          path: '/Other',
          name: 'Other',
          component: Other,
          meta: {
            requireAuth: true
          },
          children: [
            {
              path: '/InternationalSourceInformation',
              name: 'InternationalSourceInformation',
              component: InternationalSourceInformation,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/InternationalInformation',
              name: 'InternationalInformation',
              component: InternationalInformation,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/jsonStorage',
              name: 'jsonStorage',
              component: jsonStorage,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/FileStore',
              name: 'FileStore',
              component: FileStore,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/Cache',
              name: 'Cache',
              component: Cache,
              meta: {
                requireAuth: true
              }
            },
            {
              path: '/FileManagement',
              name: '/FileManagement',
              component: FileManagement,
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
