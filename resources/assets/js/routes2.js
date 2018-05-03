import Home from './components/Home.vue'
import login from './components/Login.vue'
import UUser from './components/User/UUser.vue'
import View from './components/User/View.vue'
import Role from './components/Role/Role.vue'
import Permission from './components/Role/Permission.vue'
import PPermission from './components/Permission/PPermission.vue'
import MMessage from './components/Message/MMessage.vue'
import NNotice from './components/Notice/NNotice.vue'
import Organization from './components/Organization/Organization.vue'
import Course from './components/Course/Course.vue'
import Teaching from './components/Teaching/Teaching.vue'
import CourseAndTeaching from './components/CourseAndTeaching.vue'
import Question from './components/Question/Question.vue'
import ExaminationPaper from './components/ExaminationPaper/ExaminationPaper.vue'
import Chapter from './components/Chapter/Chapter.vue'
import TestAndPaperAndQuesiton from './components/TestAndPaperAndQuesiton.vue'
import Others from './components/Others.vue'
import ApplyFor from './components/ApplyFor/ApplyFor.vue'
import Label from './components/Label/Label.vue'
import Test from './components/Test/Test.vue'
import VideoInfo from './components/VideoInfo/VideoInfo.vue'
import PersonalData from './components/PersonalCenter/PersonalData.vue'
import MessageData from './components/PersonalCenter/MessageData.vue'
import NoticeData from './components/PersonalCenter/NoticeData.vue'
import LectureData from './components/PersonalCenter/LectureData.vue'
import OrganizationData from './components/PersonalCenter/OrganizationData.vue'
import RoleData from './components/PersonalCenter/RoleData.vue'
import PermissionData from './components/PersonalCenter/PermissionData.vue'
import ApplyForData from './components/PersonalCenter/ApplyForData.vue'
import TestData from './components/PersonalCenter/TestData.vue'
import CourseData from './components/PersonalCenter/CourseData.vue'
import TeachingData from './components/PersonalCenter/TeachingData.vue'
import Setting from './components/Setting.vue'
import VideoMonitoring from './components/SurveillanceVideo/VideoMonitoring.vue'
import Practice from './components/Practice/Practice.vue'
import Upload from './components/Upload/Upload.vue'

export default [
  {
    path: '/',
    name: '/',
    // component: Index
    redirect: '/personalData'
  },
  {
    path: '/Home',
    name: '主页',
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    },
    component: Home
  },
  {
    path: '/login',
    component: login,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/UUser',
    component: UUser,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/View',
    component: View,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/Role',
    component: Role,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/Permission',
    component: Permission,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/PPermission',
    component: PPermission,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/MMessage',
    component: MMessage,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/NNotice',
    component: NNotice,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/Organization',
    component: Organization,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/Course',
    component: Course,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/Teaching',
    component: Teaching,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/CourseAndTeaching',
    component: CourseAndTeaching,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/Question',
    component: Question,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/ExaminationPaper',
    component: ExaminationPaper,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/Chapter',
    component: Chapter,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/TestAndPaperAndQuesiton',
    component: TestAndPaperAndQuesiton,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/Others',
    component: Others,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/ApplyFor',
    component: ApplyFor,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/Label',
    component: Label,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/Test',
    component: Test,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/VideoInfo',
    component: VideoInfo,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/PersonalData',
    component: PersonalData,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/MessageData',
    component: MessageData,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/NoticeData',
    component: NoticeData,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/LectureData',
    component: LectureData,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/OrganizationData',
    component: OrganizationData,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/RoleData',
    component: RoleData,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/PermissionData',
    component: PermissionData,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/ApplyForData',
    component: ApplyForData,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/TestData',
    component: TestData,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/CourseData',
    component: CourseData,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/TeachingData',
    component: TeachingData,
    meta: {
      requireAuth: true // 添加该字段，表示进入这个路由是需要登录的
    }
  },
  {
    path: '/Setting',
    component: Setting,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/VideoMonitoring',
    component: VideoMonitoring,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/Practice',
    name: '练习',
    component: Practice,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/Upload',
    name: '上传',
    component: Upload,
    meta: {
      requireAuth: true
    }
  }
]
