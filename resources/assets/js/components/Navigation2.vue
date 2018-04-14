<template lang="html">
  <div class="wrapper">
    <div class="left-nav">
      <div>
        <div class="head-portrait">
          <!-- <i class="far fa-heart"></i> -->
          当前用户：{{userName}}
        </div>
        <ul>
          <!-- <li><i class="fas fa-home"></i><span>主页</span></li> -->
          <li :class="{'is-active' : currentTag === 'uuser'}" v-show="isShowUser" @click="currentTag = 'uuser'">
            <router-link @click="currentTag = 'uuser'" to="/uuser"><i class="far fa-user-circle"></i><span>用户</span></router-link>
          </li>

          <li v-show="isShowRole" :class="{'is-active' : currentTag === 'role'}" @click="currentTag = 'role'">
            <router-link to="/role"><i class="fas fa-users"></i><span>角色</span></router-link>
          </li>

          <li v-show="isShowPermission" :class="{'is-active' : currentTag === 'permission'}" @click="currentTag = 'permission'">
            <router-link to="/ppermission"><i class="fas fa-key"></i><span>权限</span></router-link>
          </li>

          <li v-show="isShowMessage" :class="{'is-active' : currentTag === 'mmessage'}"  @click="currentTag = 'mmessage'">
            <router-link to="/mmessage"><i class="far fa-comments"></i><span>消息</span></router-link>
          </li>

          <li v-show="isShowNotification" :class="{'is-active' : currentTag === 'nnotice'}"  @click="currentTag = 'nnotice'">
            <router-link to="/nnotice"><i class="far fa-bell"></i><span>通知</span></router-link>
          </li>

          <li v-show="isShowOrganization" :class="{'is-active' : currentTag === 'organization'}" @click="currentTag = 'organization'">
            <router-link to="/organization"><i class="fas fa-braille"></i><span>组织</span></router-link>
          </li>

          <li :class="{'is-active' : currentTag === 'course'}" @click="currentTag = 'course'">
            <router-link to="/course"><i class="fas fa-book"></i><span>课程</span></router-link>
          </li>


          <li v-show="isShowUser" :class="{'is-active' : currentTag === 'teaching'}" @click="currentTag = 'teaching'">
            <router-link to="/teaching"><i class="fas fa-book"></i><span>授课</span></router-link>
          </li>

          <li v-show="isShowExam" :class="{'is-active' : currentTag === 'test'}" @click="currentTag = 'test'">
            <router-link to="/test"><i class="far fa-file-alt"></i><span>考试</span></router-link>
          </li>

          <li v-show="isShowPaper" :class="{'is-active' : currentTag === 'examinationPaper'}" @click="currentTag = 'examinationPaper'">
            <router-link to="/examinationPaper"><i class="far fa-file-alt"></i><span>试卷</span></router-link>
          </li>

          <li v-show="isShowQuestion" :class="{'is-active' : currentTag === 'question'}" @click="currentTag = 'question'">
            <router-link to="/question"><i class="far fa-file-alt"></i><span>问题</span></router-link>
          </li>

          <li is-show="isShowLabel" :class="{'is-active' : currentTag === 'label'}" @click="currentTag = 'label'">
            <router-link to="/label"><i class="fas fa-tags"></i><span>标签</span></router-link>
          </li>

          <li v-show="isShowApplication" :class="{'is-active' : currentTag === 'applyFor'}" @click="currentTag = 'applyFor'">
            <router-link to="/applyFor"><i class="fab fa-adn"></i><span>申请</span></router-link>
          </li>

          <!-- <li>
            <i class="fas fa-align-left"></i>
            <router-link to="/others"><span>其他</span></router-link>
          </li> -->

        </ul>
      </div>
    </div>

    <div class="right-nav">
      <div class="operate">
        <div class="notice">
          <router-link title="个人中心" to="/personalCenter"><i class="far fa-user"></i></router-link>
          <router-link title="个人消息" to="/mmessage"><i class="far fa-comment-alt"></i></router-link><span v-show="messageLength > 0" class="prompt">{{ messageLength }}</span>
          <router-link title="个人通知" to="/nnotice"><i class="fas fa-bullhorn"></i></router-link><span v-show="noticeLength > 0"class="prompt">{{ noticeLength }}</span>
        </div>
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
      return sessionStorage.getItem('permissions').includes(4);
    },
    // 2.【角色】
    isShowRole() {
      // return true;
      return sessionStorage.getItem('permissions').includes(7);
    },
    // 3.【用户】
    isShowUser() {
      // return true;
      return sessionStorage.getItem('permissions').includes(10);
    },
    // 4.【消息】
    isShowMessage() {
      // return true;
      return sessionStorage.getItem('permissions').includes(13);
    },
    // 5.【通知】
    isShowNotification() {
      // return true;
      return sessionStorage.getItem('permissions').includes(17);
    },
    // 6.【组织】
    isShowOrganization() {
      // return true;
      return sessionStorage.getItem('permissions').includes(26);
    },
    // 7.【问题】
    isShowQuestion() {
      // return true;
      return sessionStorage.getItem('permissions').includes(33);
    },
    // 8.【试卷】
    isShowPaper() {
      // return true;
      return sessionStorage.getItem('permissions').includes(38);
    },
    // 9.【申请】
    isShowApplication() {
      // return true;
      return sessionStorage.getItem('permissions').includes(43);
    },
    // 10.【标签】
    isShowLabel() {
      // return true;
      return sessionStorage.getItem('permissions').includes(49);
    },
    // 11.【考试】
    isShowExam() {
      // return true;
      return sessionStorage.getItem('permissions').includes(53);
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
  background-color: #2f4860;
}
ul {
  padding-top: 30px;
}
ul li {
  list-style: none;
  text-align: center;
  color: #76929d;
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
  color: #76929d;
}
a:hover {
  color: #fff;
}
ul li {
  list-style: none;
  text-align: center;
  color: #76929d;
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
  margin-left: 20px;
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
.notice {
  font-size: 17px;
  height: 76px;
  line-height: 76px;
  float: left;
  margin: 0;
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
.fa-user,
.fa-comment-alt,
.fa-bullhorn {
  display: inline-block;
  margin: 0 15px;
  cursor: pointer;
  color: #aeb8b8;
}
.fa-sign-out-alt {
  font-size: 17px;
  cursor: pointer;
  color: #aeb8b8;
}
.prompt {
  font-size: 12px;
  width: 50px;
  height: 50px;
  border-radius: 100%;
  color: #fff;
  font-weight: bold;
  background-color: red;
  position: relative;
  left: -20px;
  top: -13px;
}
</style>
