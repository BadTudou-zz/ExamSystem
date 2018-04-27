<!-- 查看用户 -->
<template lang="html">
  <div>
    <div class="tabs is-centered is-boxed">
      <ul>
        <!-- 1.用户 -->
        <li v-bind:class="{'is-active': currentTag === 'user'}">
          <a>
            <span @click="currentTag = 'user'">用户</span>
          </a>
        </li>
        <!-- 2.角色 -->
        <li v-bind:class="{'is-active': currentTag === 'role'}">
          <a>
            <span @click="currentTag = 'role'">角色</span>
          </a>
        </li>
        <!-- 3.权限 -->
        <li v-bind:class="{'is-active': currentTag === 'permission'}">
          <a>
            <span @click="currentTag = 'permission'">权限</span>
          </a>
        </li>
        <!-- 4.消息 -->
        <li v-bind:class="{'is-active': currentTag === 'message'}">
          <a>
            <span @click="currentTag = 'message'">消息</span>
          </a>
        </li>
        <!-- 5.通知 -->
        <li  v-bind:class="{'is-active': currentTag === 'notice'}">
          <a>
            <span @click="currentTag = 'notice'">通知</span>
          </a>
        </li>
        <!-- 6.组织 -->
        <li v-bind:class="{'is-active': currentTag === 'organization'}">
          <a>
            <span @click="currentTag = 'organization'">组织</span>
          </a>
        </li>
        <!-- 7.课程 -->
        <li v-bind:class="{'is-active': currentTag === 'course'}">
          <a>
            <span @click="currentTag = 'course'">课程</span>
          </a>
        </li>
        <!-- 8.授课 -->
        <li v-bind:class="{'is-active': currentTag === 'teaching'}">
          <a>
            <span @click="currentTag = 'teaching'">授课</span>
          </a>
        </li>
        <!-- 9.考试 -->
        <li v-bind:class="{'is-active': currentTag === 'Test'}">
          <a>
            <span @click="currentTag = 'test'">考试</span>
          </a>
        </li>
        <!-- 10.试卷 -->
        <li v-bind:class="{'is-active': currentTag === 'examinationPaper'}">
          <a>
            <span @click="currentTag = 'examinationPaper'">试卷</span>
          </a>
        </li>
        <!-- 11.题目 -->
        <li v-bind:class="{'is-active': currentTag === 'question'}">
          <a>
            <span @click="currentTag = 'question'">题目</span>
          </a>
        </li>
        <!-- 12.标签 -->
        <li v-bind:class="{'is-active': currentTag === 'label'}">
          <a>
            <span @click="currentTag = 'label'">标签</span>
          </a>
        </li>
        <!-- 13.申请 -->
        <li v-bind:class="{'is-active': currentTag === 'applyFor'}">
          <a>
            <span @click="currentTag = 'applyFor'">申请</span>
          </a>
        </li>

      </ul>
    </div>

  </div>
</template>

<script>

export default {
  data() {
    return {
      currentTag: 'user',
    }
  },
  components: {
  },
  methods: {
  },
  created() {
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
  watch: {
    currentTag: function (value, oldValue) {
      const that = this;
      that.$emit('input', that.currentTag);
    }
  }
}
</script>

<style lang="css">

</style>
