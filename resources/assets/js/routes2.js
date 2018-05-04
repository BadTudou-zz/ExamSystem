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
import PracticeData from './components/PersonalCenter/PracticeData.vue'
// import RoleData from './components/PersonalCenter/RoleData.vue'
import PermissionData from './components/PersonalCenter/PermissionData.vue'
import ApplyForData from './components/PersonalCenter/ApplyForData.vue'
import TestData from './components/PersonalCenter/TestData.vue'
import CourseData from './components/PersonalCenter/CourseData.vue'
import TeachingData from './components/PersonalCenter/TeachingData.vue'
import TestingTest from './components/PersonalCenter/TestingTest.vue'

import Setting from './components/Setting.vue'
import VideoMonitoring from './components/SurveillanceVideo/VideoMonitoring.vue'
// import webrtc from './components/SurveillanceVideo/webrtc.vue'
// import webrtcServer from './components/SurveillanceVideo/webrtcServer.vue'
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
      requireAuth: true
    }
  },
  {
    path: '/UUser',
    component: UUser,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/View',
    component: View,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/Role',
    component: Role,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/Permission',
    component: Permission,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/PPermission',
    component: PPermission,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/MMessage',
    component: MMessage,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/NNotice',
    component: NNotice,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/Organization',
    component: Organization,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/Course',
    component: Course,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/Teaching',
    component: Teaching,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/CourseAndTeaching',
    component: CourseAndTeaching,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/Question',
    component: Question,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/ExaminationPaper',
    component: ExaminationPaper,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/Chapter',
    component: Chapter,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/TestAndPaperAndQuesiton',
    component: TestAndPaperAndQuesiton,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/Others',
    component: Others,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/ApplyFor',
    component: ApplyFor,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/Label',
    component: Label,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/Test',
    component: Test,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/VideoInfo',
    component: VideoInfo,
    meta: {
      requireAuth: true
    }
  },
  // {
  //   path: '/webrtc',
  //   component: webrtc,
  //   meta: {
  //     requireAuth: true
  //   }
  // },
  // {
  //   path: '/webrtcServer',
  //   component: webrtcServer,
  //   meta: {
  //     requireAuth: true
  //   }
  // },
  {
    path: '/PersonalData',
    component: PersonalData,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/MessageData',
    component: MessageData,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/NoticeData',
    component: NoticeData,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/LectureData',
    component: LectureData,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/OrganizationData',
    component: OrganizationData,
    meta: {
      requireAuth: true
    }
  },
  // {
  //   path: '/RoleData',
  //   component: RoleData,
  //   meta: {
  //     requireAuth: true
  //   }
  // },
  {
    path: '/PermissionData',
    component: PermissionData,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/ApplyForData',
    component: ApplyForData,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/TestData',
    component: TestData,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/PracticeData',
    component: PracticeData,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/CourseData',
    component: CourseData,
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/TeachingData',
    component: TeachingData,
    meta: {
      requireAuth: true
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
    path: '/TestingTest',
    name: '测试考试',
    component: TestingTest,
    meta: {
      requireAuth: true
    }
  }
]
