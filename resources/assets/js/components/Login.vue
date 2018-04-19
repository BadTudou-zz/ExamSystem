<template lang="html">
  <div id="app" class="login-wrapper">

    <div v-show="isShowLoginBox" class="login-box">

      <input v-model="account" class="input form-control" placeholder="请输入你的账号/邮箱">
      <input v-model="password" type="password" class="input form-control" placeholder="密码">
      <input v-model="captcha" class="input form-control" placeholder="请输入验证码">

      <div class="code-box">
        <img class="verification-code" :src="captchaFigure" alt="">
        <a @click="getVerificationCode()" class="get-verification-code">获取验证码</a>
      </div>

      <button @click="login()" type="button" class="button" name="button">登录</button>
      <div class="operate-box">
        <a>忘记密码</a><a @click="register()">注册</a>
      </div>
    </div>


    <register ref="register"></register>

    <login-loading ref="loginLoading"></login-loading>
  </div>
</template>

<script>
let Base64 = require('js-base64').Base64;
// import Base64 from 'js-base64';
import Register from './Register'
import LoginLoading from './LoginLoading'

export default {
  data() {
    return {
      captchaFigure: null,  // 验证码图片
      account: null,  // 账号
      password: null,  // 密码
      captcha: null,  // 验证码

      permissionIdList: [],
      permissionData: null,
      permissions: [],
      url: '',
      isShowLoginBox: true,
    };
  },
  components: {
    Register,
    LoginLoading,
  },
  methods: {
    register: function() {
      const that = this;
      that.$refs.register.switchModal();
    },
    loadingModal: function () {
      const that = this;
      that.$refs.loginLoading.switchModal();
    },
    login: function (username, password) {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/login`,
        headers: {
          'Content-type': 'application/json;charset=utf8',
        },
        data: {
          'email': that.account,
          'password': that.password,
          'type': 'mobile',
          'captcha': that.captcha,
        }
      }).then(res => {
        let userId = res.data.data.user.id;
        let token = res.data.data.token;
        that.userId = res.data.data.user.id;
        that.token = res.data.data.token;
        that.isShowLoginBox = false;
        that.loadingModal();
        sessionStorage.setItem("token",`Bearer ${token}`);
        sessionStorage.setItem('userId', userId);
        that.$store.commit('setToken', token);

        let url = `${this.GLOBAL.localDomain}/api/v1/users/${that.userId}/permissions/`;
        that.getPermission(url);

      }).catch(err => {
        let errorMsg = err.response.data.message;
        alert(errorMsg);
        that.captcha = '';
        that.getVerificationCode();
      })
    },
    getVerificationCode: function () {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/captchas`,
        responseType: 'arraybuffer',
        headers: {
          'Content-type': 'application/x-www-form-urlencoded',
          'Accept': 'application/json'
        },
        params: {
          'purpose': 'LOGIN',
        }
      }).then(res => {
        that.captchaFigure = 'data:image/png;base64,' + btoa(
          new Uint8Array(res.data)
            .reduce((data, byte) => data + String.fromCharCode(byte), '')
        );
      }).catch(err => {
        console.log(err)
      })
    },
    getJsonLength: function (json) {
      const that = this;
      let jsonLength = 0;
      for (let i in json) {
          jsonLength++;
      }
      return jsonLength;
    },
    getPermission: function (url) {
      const that = this;
      console.log('getPermission')
      let urlPath = url ? url : that.url
      axios({
        method: 'get',
        url: urlPath,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.permissionData = res.data;  // conclude links
        that.url = res.data.links.next;
        console.log(res.data.data.length);

        let len = res.data.data.length ? res.data.data.length : that.getJsonLength(res.data.data);

        // data数据结构不一致 可能是数组/也可能是json
        if (res.data.data.length) {
          for (let i = 0; i < len; i++) {
            that.permissionIdList.push(res.data.data[i].name);
          }
        }
        else if (that.getJsonLength(res.data.data)) {
          for (let i in res.data.data) {
            that.permissionIdList.push(res.data.data[i].name);
          }
        }

        if (that.url) {
          that.getPermission(that.url);
        }
        else {
          sessionStorage.setItem('permissions', that.permissionIdList);
          that.permissions = sessionStorage.getItem('permissions');
        }
      }).catch(err => {
        alert('登录失败，请重新登录');
        that.$refs.loginLoading.switchModal();
        // that.$emit('input', 'loginFailure');
        that.isShowLoginBox = true;
        console.log(err);
      })
    },
  },
  created() {
    this.getVerificationCode();
  },
  watch: {
    permissions: function (value, oldValue) {
      const that = this;
      that.$refs.loginLoading.switchModal();
      that.$emit('checkLoginState');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
    }
  }
}
</script>

<style lang="scss" scoped>
body {
  margin: 0;
}
.login-wrapper {
  // background-color: #334056;
  width: 100%;
  height: 966px;
  background-image:url('../../img/background.jpg');
  background-size:auto 100%;
  background-position:center 0;
  background-repeat:no-repeat;
}
.login-box {
  width: 320px;
  height: 335px;
  position: absolute;
  top: 50%;
  left: 50%;
  margin-top: -105px;
  margin-left: -160px;
  padding: 25px;
  border-radius: 5px;
  text-align: center;
  background-color: #fff;
  background: hsla(0,0%,100%,0.6);
  .select-box {
    // position: relative;
    // left: -27px;
    width: 270px;
    margin-bottom: 20px;
    height: 27px;
    line-height:  27px;
  }
  input {
    margin-bottom: 20px;
  }
  button {
    width: 100%;
    height: 38px;
    font-size: 16px;
    background-color: #2CA2FC;
    color: #fff;
    border: none;
    border-radius: 5px;
  }
  div {
    display: inline-block;
  }
  .operate-box {
    float: right;
    a {
      position: relative;
      right: 10px;
      font-size: 12px;
      display: inline-block;
      margin-left: 20px;
      margin-top: 10px;
    }
  }
  .verification-code {
    width: 130px;
    height: 30px;
    margin: 0 auto;
  }
}
.get-verification-code {
  display: inline-block;
  font-size: 12px;
  // margin-bottom: 10px;
}
.code-box {
  margin-bottom: 15px;
}
</style>
