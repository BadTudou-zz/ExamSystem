import Home from './components/Home.vue'
import login from './components/Login.vue'
import UUser from './components/User/UUser.vue'
import View from './components/User/View.vue'
import Role from './components/Role/Role.vue'
import Permission from './components/Role/Permission.vue'
import PPermission from './components/Permission/PPermission.vue'
import MMessage from './components/Message/MMessage.vue'
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

const routes = [
  {
    path: '/',
    name: '/',
    // component: Index
    redirect: '/personalData',
  },
  {
    path: '/repository',
    name: 'repository',
    meta: {
      requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
    },
    component: Repository
  },
  {
    path: '/login',
    name: 'login',
    component: Login
  }
];

export default[
  {path: '/', redirect: '/personalData'},
  // 主页
  { path: '/Home', component: require('./components/Home.vue') },
  // 登录
  { path: '/login', component: require('./components/Login.vue') },
  // // 用户
  { path: '/UUser', component: require('./components/User/UUser.vue') },
  { path: '/View', component: require('./components/User/View.vue') },
  // 角色
  { path: '/Role', component: require('./components/Role/Role.vue') },
  // ?? delete
  { path: '/Permission', component: require('./components/Role/Permission.vue') },
  // 权限
  { path: '/PPermission', component: require('./components/Permission/PPermission.vue') },
  // 消息
  { path: '/MMessage', component: require('./components/Message/MMessage.vue') },
  // 通知
  { path: '/NNotice', component: require('./components/Notice/NNotice.vue') },
  // 组织
  { path: '/Organization', component: require('./components/Organization/Organization.vue') },
  // 课程
  { path: '/Course', component: require('./components/Course/Course.vue') },
  // 授课
  { path: '/Teaching', component: require('./components/Teaching/Teaching.vue') },
  // 课程 & 授课 wrapper
  { path: '/CourseAndTeaching', component: require('./components/CourseAndTeaching.vue') },
  // 题目
  { path: '/Question', component: require('./components/Question/Question.vue') },
  // 题目类型
  // { path: '/QuestionType', component: require('./components/QuestionType/QuestionType.vue') },
  // 试卷
  { path: '/ExaminationPaper', component: require('./components/ExaminationPaper/ExaminationPaper.vue') },
  // 章节
  { path: '/Chapter', component: require('./components/Chapter/Chapter.vue') },
  // 题目 & 考 & 试卷 wrapper
  { path: '/TestAndPaperAndQuesiton', component: require('./components/TestAndPaperAndQuesiton.vue') },
  // others wrapper : applyFor & labe
  { path: '/Others', component: require('./components/Others.vue') },
  // 申请
  { path: '/ApplyFor', component: require('./components/ApplyFor/ApplyFor.vue') },
  // 标签
  { path: '/Label', component: require('./components/Label/Label.vue') },
  // 考试
  { path: '/Test', component: require('./components/Test/Test.vue') },
  // 视频
  { path: '/VideoInfo', component: require('./components/VideoInfo/VideoInfo.vue') },

  // { path: '/User', component: require('./components/User.vue') },
  // 个人中心
  // { path: '/PersonalCenter', component: require('./components/PersonalCenter/PersonalCenter.vue') },
  { path: '/PersonalData', component: require('./components/PersonalCenter/PersonalData.vue') },
  // 【个人】 消息
  { path: '/MessageData', component: require('./components/PersonalCenter/MessageData.vue') },
  // 【个人】通知
  { path: '/NoticeData', component: require('./components/PersonalCenter/NoticeData.vue') },
  // 【个人】选课
  { path: '/LectureData', component: require('./components/PersonalCenter/LectureData.vue') },
  // 【个人】组织
  { path: '/OrganizationData', component: require('./components/PersonalCenter/OrganizationData.vue') },
  // 【个人】角色
  { path: '/RoleData', component: require('./components/PersonalCenter/RoleData.vue') },
  // 【个人】权限
  { path: '/PermissionData', component: require('./components/PersonalCenter/PermissionData.vue') },
  // 【个人】申请
  { path: '/ApplyForData', component: require('./components/PersonalCenter/ApplyForData.vue') },
  // 【个人】 考试
  { path: '/TestData', component: require('./components/PersonalCenter/TestData.vue') },
  // 【个人】 课程
  { path: '/CourseData', component: require('./components/PersonalCenter/CourseData.vue') },
  // 【个人】 授课
  { path: '/TeachingData', component: require('./components/PersonalCenter/TeachingData.vue') },
  // 管理中心
  { path: '/Setting', component: require('./components/Setting.vue') },
  // webrtc
  // { path: '/webrtc', component: require('./components/SurveillanceVideo/webrtc.vue') },
  // webrtc
  { path: '/VideoMonitoring', component: require('./components/SurveillanceVideo/VideoMonitoring.vue') },
  // 管理中心
  // { path: '/Setting', component: require('./components/SurveillanceVideo/Setting.vue') },
]
