<template lang="html">
  <div class="wrapper">
    <div class="left-nav">
      <div>
        <div class="head-portrait">
          当前用户：{{userName}}
        </div>
        <ul>
          <el-row class="tac">
            <el-menu
              default-active="2"
              class="el-menu-vertical-demo"
              @open="handleOpen"
              @close="handleClose"
              background-color="#1c3146"
              text-color="#fff"
              active-text-color="#ffd04b">

              <el-submenu index="0">
                <template slot="title">
                  <i class="el-icon-menu"></i>
                  <span>个人中心</span>
                </template>
                <el-menu-item-group>
                  <template slot="title"></template>
                  <el-menu-item index="0-1"><router-link to="/personalData">个人信息</router-link></el-menu-item>
                  <el-menu-item index="0-2"><router-link to="/practiceData">题目练习</router-link></el-menu-item>
                  <el-menu-item index="0-3"><router-link to="/testData">考试测评</router-link></el-menu-item>
                </el-menu-item-group>
              </el-submenu>

              <el-submenu index="7">
                <template slot="title">
                  <i class="el-icon-view"></i>
                  <span>权限</span>
                </template>
                <el-menu-item-group>
                  <template slot="title"></template>
                  <!-- <el-menu-item index="7-1"><router-link to="/roleData">角色</router-link></el-menu-item> -->
                  <el-menu-item index="7-2"><router-link to="/permissionData">权限</router-link></el-menu-item>
                  <el-menu-item index="7-3"><router-link to="/organizationData">组织</router-link></el-menu-item>
                </el-menu-item-group>
              </el-submenu>

              <el-submenu index="8">
                <template slot="title">
                  <i class="el-icon-bell"></i>
                  <span>消息</span>
                </template>
                <el-menu-item-group>
                  <template slot="title"></template>
                  <el-menu-item index="8-1"><router-link to="/messageData">消息</router-link></el-menu-item>
                  <el-menu-item index="8-1"><router-link to="/noticeData">通知</router-link></el-menu-item>
                  <el-menu-item index="8-1"><router-link to="/applyForData">申请</router-link></el-menu-item>
                </el-menu-item-group>
              </el-submenu>

              <el-submenu index="9">
                <template slot="title">
                  <i class="el-icon-menu"></i>
                  <span>课程</span>
                </template>
                <el-menu-item-group>
                  <template slot="title"></template>
                  <el-menu-item index="9-1"><router-link to="/lectureData">选课</router-link></el-menu-item>
                  <el-menu-item index="9-1"><router-link to="/courseData">课程</router-link></el-menu-item>
                  <el-menu-item index="9-1"><router-link to="/teaching">授课</router-link></el-menu-item>
                </el-menu-item-group>
              </el-submenu>

              <el-submenu index="1" v-show="isShowUser || isShowRole || isShowPermission || isShowOrganization">
                <template slot="title">
                  <i class="el-icon-view"></i>
                  <span>权限管理</span>
                </template>
                <el-menu-item-group>
                  <template slot="title"></template>
                  <el-menu-item v-show="isShowUser" index="1-1"><router-link to="/uuser">用户</router-link></el-menu-item>
                  <el-menu-item v-show="isShowRole" index="1-2"><router-link to="/role">角色</router-link></el-menu-item>
                  <el-menu-item v-show="isShowPermission" index="1-3"><router-link to="/ppermission">权限</router-link></el-menu-item>
                  <el-menu-item v-show="isShowOrganization" index="1-4"><router-link to="/organization">组织</router-link></el-menu-item>
                </el-menu-item-group>
              </el-submenu>

              <el-submenu index="2" v-show="isShowMessage || isShowNotification || isShowApplication">
                <template slot="title">
                  <i class="el-icon-bell"></i>
                  <span>消息管理</span>
                </template>
                <el-menu-item-group>
                  <template slot="title"></template>
                  <el-menu-item v-show="isShowMessage" index="2-1"><router-link to="/mmessage">消息</router-link></el-menu-item>
                  <el-menu-item v-show="isShowNotification" index="2-2"><router-link to="/nnotice">通知</router-link></el-menu-item>
                  <el-menu-item v-show="isShowApplication" index="2-3"><router-link to="/applyFor">申请</router-link></el-menu-item>
                </el-menu-item-group>
              </el-submenu>

              <el-submenu index="3" v-show="isShowCourse || isShowLecture">
                <template slot="title">
                  <i class="el-icon-menu"></i>
                  <span>课程管理</span>
                </template>
                <el-menu-item-group>
                  <template slot="title"></template>
                  <el-menu-item v-show="isShowCourse" index="3-1"><router-link to="/course">课程</router-link></el-menu-item>
                  <el-menu-item v-show="isShowLecture" index="3-2"><router-link to="/teaching">授课</router-link></el-menu-item>
                  <!-- <el-menu-item index="3-3"><router-link to="/video">视频</router-link></el-menu-item> -->
                </el-menu-item-group>
              </el-submenu>

              <el-submenu index="4" v-show="isShowQuestion || isShowPaper || isShowExam">
                <template slot="title">
                  <i class="el-icon-edit-outline"></i>
                  <span>测评管理</span>
                </template>
                <el-menu-item-group>
                  <template slot="title"></template>
                  <el-menu-item v-show="isShowQuestion" index="4-1"><router-link to="/question">题目</router-link></el-menu-item>
                  <el-menu-item v-show="isShowPaper" index="4-2"><router-link to="/examinationPaper">试卷</router-link></el-menu-item>
                  <el-menu-item v-show="isShowExam" index="4-3"><router-link to="/test">考试</router-link></el-menu-item>
                  <el-menu-item index="4-4"><router-link to="/practice">练习</router-link></el-menu-item>
                </el-menu-item-group>
              </el-submenu>

              <el-submenu index="5"  v-show="isShowTag">
                <template slot="title">
                  <i class="el-icon-more-outline"></i>
                  <span>其他管理</span>
                </template>
                <el-menu-item-group>
                  <template slot="title"></template>
                  <el-menu-item v-show="isShowTag" index="5-1"><router-link to="/label">标签</router-link></el-menu-item>
                  <!-- <el-menu-item index="5-3"><router-link to="/videoMonitoring">视频监控</router-link></el-menu-item> -->
                  <!-- <el-menu-item index="5-2"><router-link to="/webrtc">webrtc</router-link></el-menu-item>
                  <el-menu-item index="5-3"><router-link to="/webrtcServer">webrtcSever</router-link></el-menu-item> -->
                </el-menu-item-group>
              </el-submenu>
            </el-menu>
        </el-row>
        </ul>
      </div>
    </div>

    <div class="right-nav">
      <div class="operate">
        <div @click="logOut()" class="exit">
          <i class="fas fa-sign-out-alt"></i>
          <span>退出</span>
        </div>
      </div>
      <div class="router-view">
        <router-view></router-view>
      </div>
    </div>
  </div>

  </div>
</template>

<script>
export default {
  data() {
    return {
      userName: '',
      messageData: null,
      messageLength: null,
      noticeData: null,
      noticeLength: null,
      currentTag: '',
      token: null,
      userId: null,
    }
  },
  components: {
  },
  methods: {
    handleOpen(key, keyPath) {
      // console.log(key, keyPath);
    },
    handleClose(key, keyPath) {
      // console.log(key, keyPath);
    },
    getUserDetail: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/${this.userId}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': this.token
        }
      }).then(res => {
        that.userName = res.data.data.name;
      }).catch(err => {
        console.log(err)
      })
    },
    logOut: function () {
      const that = this;
      console.log('退出登录');
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/logout`,
        headers: {
          'Accept': 'application/json',
          'Authorization': this.token,
        }
      }).then(res => {
      }).catch(err => {
        console.log(err)
      })
      that.$emit('input', 'logOut');
      sessionStorage.removeItem("token");
      sessionStorage.removeItem("permissions");
    },
    getMessage: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/${this.userId}/messages/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': this.token,
        }
      }).then(res => {
        that.messageData = res.data.data;
        if (that.messageData) {
          that.messageLength = res.data.data.length;
        }
        else {
          that.messageLength = null;
        }
      }).catch(err => {
        console.log(err)
      })
    },
    getNotice: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/${this.userId}/notifications/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': this.token,
        }
      }).then(res => {
        that.noticeData = res.data.data;
        if (that.noticeData) {
          that.noticeLength = res.data.data.length;
        }
        else {
          that.noticeLength = null;
        }
      }).catch(err => {
        console.log(err)
      })
    },
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
    },
    isShowManagement: function () {
      let res = this.isShowExam    || this.isShowTag          || this.isShowApplication || this.isShowPaper        || this.isShowQuestion ||
                this.isShowLecture || this.isShowOrganization || this.isShowCourse      || this.isShowNotification || this.isShowMessage ||
                this.isShowUser    || this.isShowRole         || this.isShowPermission
      return res;
    }
  },
  created() {
    this.token = sessionStorage.getItem('token');
    this.userId = sessionStorage.getItem('userId');

    this.getUserDetail();
    this.getMessage();
    this.getNotice();

  },
  watch: {
  }
}
</script>

<style scoped>
.wrapper {
  display: flex;
  display: -webkit-flex;
}
.left-nav {
  width: 17%;
  min-height: 800px;
  height: auto;
  /* background-color: #2f4860; */
  background-color: #1c3146;
}
ul {
  padding-top: 30px;
}
ul li {
  list-style: none;
  text-align: center;
  /* color: #76929d; */
  color: #fff;
  padding: 13px 0;
  cursor: pointer;
}
ul li:hover {
  background-color: #1f3244;
  color: #fff;
}
.is-active {
  background-color: #1f3244;
  color: #fff;
}
a {
  color: #fff;
  width: 100%;
  height: 100%;
  display: inline-block;
}
ul li {
  list-style: none;
  text-align: center;
  /* color: #76929d; */
  color: #fff;
  padding: 13px 0;
  cursor: pointer;
}
ul li:hover {
  background-color: #1f3244;
  color: #fff;
}

.fa-home,
.fa-user-circle,
.fa-users,
.fa-comments,
.fa-bell,
.fa-key,
.fa-braille,
.fa-book,
.fa-file-alt,
.fa-align-left {
  /* color: #ffc500; */
  font-size: 20px;
}
ul li span {
  display: inline-block;
  /* margin-left: 20px; */
  width: 56px;
}
.head-portrait {
  height: 75px;
  line-height: 75px;
  text-align: center;
  /* padding-top: 15px; */
  margin: 0 auto;
  background-color: #5d93d2;
  color: #fff;
  font-weight: bold;
}
.fa-heart {
  font-size: 45px;
}
/* right */
.right-nav {
  flex: 1;
  background-color: #eaf1f1;
}

.operate {
  height: 76px;
  padding: 0 20px;
  border-bottom: 1px solid #dedede;
  background-color: #fff;
}
.top-nav-box {
  font-size: 16px;
  height: 76px;
  line-height: 76px;
  float: left;
  margin: 0;
  color: #acb9b8;
}
.top-nav-box span {
  color: #acb9b8;
  font-size: 15px;
  margin: 0 15px 0 17px;
}
.exit {
  float: right;
  height: 76px;
  line-height: 76px;
  cursor: pointer;
}
.exit span {
  font-size: 14px;
  height: 76px;
  line-height: 76px;
}
.top-nav {
  display: inline-block;
  margin: 0 5px;
  cursor: pointer;
  color: #acb9b8;
}
.top-nav span {
  color: #acb9b8;
}
.fa-sign-out-alt {
  font-size: 16px;
  cursor: pointer;
  color: #aeb8b8;
}
.prompt {
  font-size: 12px;
  width: 15px;
  height: 15px;
  border-radius: 100%;
  color: #fff;
  font-weight: bold;
  background-color: red;
  position: relative;
  left: -20px;
  top: 15px;
  display: inline-block;
}
.data-length {
  position: relative;
  top: -30px;
}
.el-submenu {
  padding: 2px;
}

</style>
