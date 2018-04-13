export default[
    {path: '/', redirect: '/personalCenter'},
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
    // 问题
    { path: '/Question', component: require('./components/Question/Question.vue') },
    // 试卷
    { path: '/ExaminationPaper', component: require('./components/ExaminationPaper/ExaminationPaper.vue') },
    // 章节
    { path: '/Chapter', component: require('./components/Chapter/Chapter.vue') },
    // 问题 & 考 & 试卷 wrapper
    { path: '/TestAndPaperAndQuesiton', component: require('./components/TestAndPaperAndQuesiton.vue') },
    // others wrapper : applyFor & labe
    { path: '/Others', component: require('./components/Others.vue') },
    // 申请
    { path: '/ApplyFor', component: require('./components/ApplyFor/ApplyFor.vue') },
    // 标签
    { path: '/Label', component: require('./components/Label/Label.vue') },
    // 考试
    { path: '/Test', component: require('./components/Test/Test.vue') },

    { path: '/User', component: require('./components/User.vue') },
    // 个人中心
    { path: '/PersonalCenter', component: require('./components/PersonalCenter/PersonalCenter.vue') },
    // 主页
    { path: '/Home', component: require('./components/Home.vue') },

];
