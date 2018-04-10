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
          <li>
            <i class="far fa-user-circle"></i>
            <router-link @click="currentTag = 'uuser'" :class="{'is-active' : currentTag === 'uuser'}" to="/uuser"><span>用户</span></router-link>
          </li>

          <li>
            <i class="fas fa-users"></i>
            <router-link to="/role"><span>角色</span></router-link>
          </li>

          <li>
            <i class="fas fa-key"></i>
            <router-link to="/ppermission"><span>权限</span></router-link>
          </li>

          <li>
            <i class="far fa-comments"></i>
            <router-link to="/mmessage"><span>消息</span></router-link>
          </li>

          <li>
            <i class="far fa-bell"></i>
            <router-link to="/nnotice"><span>通知</span></router-link>
          </li>

          <li>
            <i class="fas fa-braille"></i>
            <router-link to="/organization"><span>组织</span></router-link>
          </li>

          <li>
            <i class="fas fa-book"></i>
            <!-- <router-link to="/course"><span>课程</span></router-link> -->
            <router-link to="/courseAndTeaching"><span>课程</span></router-link>
          </li>

          <li>
            <i class="far fa-file-alt"></i>
            <router-link to="/testAndPaperAndQuesiton"><span>考试</span></router-link>
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
    }
  },
  components: {
  },
  methods: {
    getUserDetail: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/${this.GLOBAL.userId}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': this.GLOBAL.token,
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
        url: `${this.GLOBAL.localDomain}/api/v1/users/${this.GLOBAL.userId}/messages/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': this.GLOBAL.token,
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
        url: `${this.GLOBAL.localDomain}/api/v1/users/${this.GLOBAL.userId}/notifications/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': this.GLOBAL.token,
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
  },
  created() {
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
  war
  display: flex;
  display: -webkit-flex;
}
.left-nav {
  width: 17%;
  min-height: 800px;
  height: auto;
  background-color: #2f4860;
}
.is-active {
  background-color: #1f3244;
  color: #fff;
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
