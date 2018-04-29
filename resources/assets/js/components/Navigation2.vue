<template lang="html">
  <div class="wrapper">
    <div class="left-nav">
      <div>
        <div class="head-portrait">
          当前用户：{{userName}}
        </div>
        <ul>
          <!-- <el-row class="tac">
            <el-menu
              default-active="2"
              class="el-menu-vertical-demo"
              @open="handleOpen"
              @close="handleClose"
              background-color="#1c3146"
              text-color="#fff"
              active-text-color="#ffd04b">

              <el-menu-item index="6">
                <i class="el-icon-menu"></i>
                <router-link slot="title" to="/personalData">个人</router-link>
              </el-menu-item>

              <el-submenu index="7">
                <template slot="title">
                  <i class="el-icon-view"></i>
                  <span>权限</span>
                </template>
                <el-menu-item-group>
                  <template slot="title"></template>
                  <el-menu-item index="7-1">角色</el-menu-item>
                  <el-menu-item index="7-2">权限</el-menu-item>
                  <el-menu-item index="7-3">组织</el-menu-item>
                </el-menu-item-group>
              </el-submenu>

              <el-submenu index="8">
                <template slot="title">
                  <i class="el-icon-bell"></i>
                  <span>消息</span>
                </template>
                <el-menu-item-group>
                  <template slot="title"></template>
                  <el-menu-item index="8-1">消息</el-menu-item>
                  <el-menu-item index="8-2">通知</el-menu-item>
                  <el-menu-item index="8-3">申请</el-menu-item>
                </el-menu-item-group>
              </el-submenu>

              <el-submenu index="9">
                <template slot="title">
                  <i class="el-icon-menu"></i>
                  <span>课程</span>
                </template>
                <el-menu-item-group>
                  <template slot="title"></template>
                  <el-menu-item index="9-1">选课</el-menu-item>
                  <el-menu-item index="9-2">课程</el-menu-item>
                  <el-menu-item index="9-3">授课</el-menu-item>
                </el-menu-item-group>
              </el-submenu>

              <el-menu-item index="10">
                <i class="el-icon-menu"></i>
                <span slot="title">考试</span>
              </el-menu-item>

              <el-submenu index="1">
                <template slot="title">
                  <i class="el-icon-view"></i>
                  <span>权限管理</span>
                </template>
                <el-menu-item-group>
                  <template slot="title"></template>
                  <el-menu-item index="1-1">用户</el-menu-item>
                  <el-menu-item index="1-2">角色</el-menu-item>
                  <el-menu-item index="1-3">权限</el-menu-item>
                  <el-menu-item index="1-4">组织</el-menu-item>
                </el-menu-item-group>
              </el-submenu>

              <el-submenu index="2">
                <template slot="title">
                  <i class="el-icon-bell"></i>
                  <span>消息管理</span>
                </template>
                <el-menu-item-group>
                  <template slot="title"></template>
                  <el-menu-item index="2-1">消息</el-menu-item>
                  <el-menu-item index="2-2">通知</el-menu-item>
                  <el-menu-item index="2-3">申请</el-menu-item>
                </el-menu-item-group>
              </el-submenu>

              <el-submenu index="3">
                <template slot="title">
                  <i class="el-icon-menu"></i>
                  <span>课程管理</span>
                </template>
                <el-menu-item-group>
                  <template slot="title"></template>
                  <el-menu-item index="3-1">课程</el-menu-item>
                  <el-menu-item index="3-2">授课</el-menu-item>
                </el-menu-item-group>
              </el-submenu>

              <el-submenu index="4">
                <template slot="title">
                  <i class="el-icon-edit-outline"></i>
                  <span>考试管理</span>
                </template>
                <el-menu-item-group>
                  <template slot="title"></template>
                  <el-menu-item index="4-1">题目</el-menu-item>
                  <el-menu-item index="4-2">试卷</el-menu-item>
                  <el-menu-item index="4-2">考试</el-menu-item>
                </el-menu-item-group>
              </el-submenu>

              <el-submenu index="5">
                <template slot="title">
                  <i class="el-icon-more-outline"></i>
                  <span>其他管理</span>
                </template>
                <el-menu-item-group>
                  <template slot="title"></template>
                  <el-menu-item index="5-1">标签</el-menu-item>
                </el-menu-item-group>
              </el-submenu>
            </el-menu>
        </el-row> -->

          <li v-show="isShowManagement" :class="{'is-active' : currentTag === 'setting'}" @click="currentTag = 'setting'">
            <router-link to="/setting"><i class="fas fa-sliders-h"></i><span>管理</span></router-link>
          </li>

          <li :class="{'is-active' : currentTag === 'personalData'}" @click="currentTag = 'personalData'">
            <router-link to="/personalData"><i class="far fa-user-circle"></i><span>个人</span></router-link>
          </li>

          <li :class="{'is-active' : currentTag === 'messageData'}" @click="currentTag = 'messageData'">
            <router-link to="/messageData"><i class="far fa-comments"></i><span>消息</span></router-link>
          </li>

          <li :class="{'is-active' : currentTag === 'noticeData'}" @click="currentTag = 'noticeData'">
            <router-link to="/noticeData"><i class="far fa-bell"></i><span>通知</span></router-link>
          </li>

          <li :class="{'is-active' : currentTag === 'lectureData'}" @click="currentTag = 'lectureData'">
            <router-link to="/lectureData"><i class="fas fa-align-left"></i><span>选课</span></router-link>
          </li>

          <li :class="{'is-active' : currentTag === 'organizationData'}" @click="currentTag = 'organizationData'">
            <router-link to="/organizationData"><i class="fas fa-braille"></i><span>组织</span></router-link>
          </li>

          <li :class="{'is-active' : currentTag === 'roleData'}" @click="currentTag = 'roleData'">
            <router-link to="/roleData"><i class="fas fa-users"></i><span>角色</span></router-link>
          </li>

          <li :class="{'is-active' : currentTag === 'permissionData'}" @click="currentTag = 'permissionData'">
            <router-link to="/permissionData"><i class="fas fa-key"></i><span>权限</span></router-link>
          </li>

          <li :class="{'is-active' : currentTag === 'applyForData'}" @click="currentTag = 'applyForData'">
            <router-link to="/applyForData"><i class="fab fa-adn"></i><span>申请</span></router-link>
          </li>

          <li :class="{'is-active' : currentTag === 'testData'}" @click="currentTag = 'testData'">
            <router-link to="/testData"><i class="far fa-file-alt"></i><span>考试</span></router-link>
          </li>
          <li :class="{'is-active' : currentTag === 'courseData'}" @click="currentTag = 'courseData'">
            <router-link to="/courseData"><i class="fas fa-book"></i><span>课程</span></router-link>
          </li>
          <li :class="{'is-active' : currentTag === 'teachingData'}" @click="currentTag = 'teachingData'">
            <router-link to="/teachingData"><i class="fas fa-graduation-cap"></i><span>授课</span></router-link>
          </li>
          <li :class="{'is-active' : currentTag === 'video'}" @click="currentTag = 'video'">
            <router-link to="/video"><i class="fas fa-graduation-cap"></i><span>视屏</span></router-link>
          </li>
        </ul>
      </div>
    </div>

    <div class="right-nav">
      <div class="operate">
        <!-- <div class="top-nav-box">
          <router-link v-show="isShowUser" to="/uuser"><span>用户</span></router-link>

          <router-link v-show="isShowRole" to="/role"><span>角色</span></router-link>

          <router-link v-show="isShowPermission" to="/ppermission"><span>权限</span></router-link>

          <router-link v-show="isShowMessage" to="/mmessage"><span>消息</span></router-link>

          <router-link v-show="isShowNotification" to="/nnotice"><span>通知</span></router-link>

          <router-link v-show="isShowOrganization" to="/organization"><span>组织</span></router-link>

          <router-link to="/course"><span>课程</span></router-link>

          <router-link to="/teaching"><span>授课</span></router-link>

          <router-link v-show="isShowExam"  to="/test"><span>考试</span></router-link>

          <router-link v-show="isShowPaper" to="/examinationPaper"><span>试卷</span></router-link>

          <router-link v-show="isShowQuestion" to="/question"><span>题目</span></router-link>

          <router-link is-show="isShowTag" to="/label"><span>标签</span></router-link>

          <router-link v-show="isShowApplication" to="/applyFor"><span>申请</span></router-link>

        </div> -->
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
      console.log(key, keyPath);
    },
    handleClose(key, keyPath) {
      console.log(key, keyPath);
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
  padding: 0px;
}

</style>
