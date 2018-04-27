<!-- 个人中心 -->
<template lang="html">
  <div class="box">

    <personal-center-navigation v-model="navigationTag"></personal-center-navigation>

    <div class="data-box">
      <!-- 1.用户 -->
      <user v-show="navigationTag === 'user'"></user>
      <!-- 2.角色 -->
      <role v-if="navigationTag === 'role'"></role>
      <!-- 3.权限 -->
      <permission v-if="navigationTag === 'permission'"></permission>
      <!-- 4.消息 -->
      <message v-if="navigationTag === 'message'"></message>
      <!-- 5.通知 -->
      <notice v-if="navigationTag === 'notice'"></notice>
      <!-- 6.组织 -->
      <organization v-if="navigationTag === 'organization'"></organization>
      <!-- 7.课程 -->
      <course v-if="navigationTag === 'course'"></course>
      <!-- 8.授课 -->
      <teaching v-if="navigationTag === 'teaching'"></teaching>
      <!-- 9.考试 -->
      <test v-if="navigationTag === 'test'"></test>
      <!-- 10.试卷 -->
      <examination-paper v-if="navigationTag === 'examinationPaper'"></examination-paper>
      <!-- 11.题目 -->
      <question v-if="navigationTag === 'question'"></question>
      <!-- 12.标签 -->
      <labels v-if="navigationTag === 'label'"></labels>
      <!-- 13.申请 -->
      <apply-for v-if="navigationTag === 'applyFor'"></apply-for>
    </div>
  </div>
</template>

<script>
import User from './User/UUser'
import Role from './Role/Role.vue'
import Permission from './Permission/PPermission.vue'
import Message from './Message/MMessage.vue'
import Notice from './Notice/NNotice.vue'
import Organization from './Organization/Organization.vue'
import Course from './Course/Course.vue'
import Teaching from './Teaching/Teaching.vue'
import Test from './Test/Test.vue'
import ExaminationPaper from './ExaminationPaper/ExaminationPaper.vue'
import Question from './Question/Question.vue'
import Labels from './Label/Label.vue'
import ApplyFor from './ApplyFor/ApplyFor.vue'
import PersonalCenterNavigation from './PersonalCenter/PersonalCenterNavigation'

export default {
  data() {
    return {
      userData: null,
      currentUserData: {
        id: '',
        name: '',
        email: '',
        created_at: '',
        updated_at: '',
      },
      isShowEditModal: false,
      editData: null,
      navigationTag: 'user',
    }
  },
  components: {
    User,
    Role,
    Permission,
    Message,
    Notice,
    Organization,
    Course,
    Teaching,
    Test,
    ExaminationPaper,
    Question,
    Labels,
    ApplyFor,
    PersonalCenterNavigation,
  },
  methods: {

  },
  computed: {
    // 1.【权限】
    isShowPermission() {
      // return true;
      return sessionStorage.getItem('permissions').includes('permission-index');
    },
    // 2.【角色】
    isShowRole() {
      // return true;
      return sessionStorage.getItem('permissions').includes('role-index');
    },
    // 3.【用户】
    isShowUser() {
      // return false;
      return sessionStorage.getItem('permissions').includes('user-index');
    },
    // 4.【消息】
    isShowMessage() {
      // return true;
      return sessionStorage.getItem('permissions').includes('message-index');
    },
    // 5.【通知】
    isShowNotification() {
      // return true;
      return sessionStorage.getItem('permissions').includes('notification-index');
    },
    // 6.【课程】
    isShowCourse() {
      // return true;
      return sessionStorage.getItem('permissions').includes('course-index');
    },
    // 7.【组织】
    isShowOrganization() {
      // return true;
      return sessionStorage.getItem('permissions').includes('organization-index');
    },
    // 8.【授课】
    isShowLecture() {
      // return true;
      return sessionStorage.getItem('permissions').includes('lecture-index');
    },
    // 9.【题目】
    isShowQuestion() {
      // return true;
      return sessionStorage.getItem('permissions').includes('question-index');
    },
    // 10.【试卷】
    isShowPaper() {
      // return true;
      return sessionStorage.getItem('permissions').includes('paper-index');
    },
    // 11.【申请】
    isShowApplication() {
      // return true;
      return sessionStorage.getItem('permissions').includes('application-index');
    },
    // 12.【标签】
    isShowTag() {
      // return true;
      return sessionStorage.getItem('permissions').includes('tag-index');
    },
    // 13.【考试】
    isShowExam() {
      // return true;
      return sessionStorage.getItem('permissions').includes('exam-index');
    }
  },
  created() {
  },
  watch: {

  }
}
</script>

<style lang="css">
.box {
  margin: 30px;
  padding: 20px 50px 30px 50px;
}
.data-box {
  padding-top: 20px;
}
</style>
