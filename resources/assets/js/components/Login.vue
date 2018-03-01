<template lang="html">
  <div id="app" class="login-wrapper">
    <!-- login -->
    <p class="title">用户登录</p>
    <div class="login-box">

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
  </div>
</template>

<script>
let Base64 = require('js-base64').Base64;
// import Base64 from 'js-base64';
import Register from './Register'
export default {
  data() {
    return {
      currentRole: '',
      // placeholderData: '请输入你的账号/邮箱',
      captchaFigure: null,  // 验证码图片
      account: null,  // 账号
      password: null,  // 密码
      captcha: null,  // 验证码
      isShowLogin: false,  // 是否显示登录组件
    };
  },
  components: {
    Register,
  },
  methods: {
    changeRole: function (element) {
      const that = this;
      let value = element.target.value;
      switch (value) {
        case 'student':
          that.placeholderData = '请输入你的学号';
          break;
        case 'teacher':
          that.placeholderData = '请输入你的教师工号';
          break;
        case 'administrator':
          that.placeholderData = '请输入你的管理员账号';
          break;
      }
    },
    register: function() {
      console.log('注册')
      const that = this;
      that.$refs.register.switchModal();
    },
    login: function (username, password) {
      const that = this;
      console.log('登录')
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
        let token = res.data.data.token;
        sessionStorage.setItem("token",`Bearer ${token}`);
        that.$emit('input', false);
      }).catch(err => {
        let errorMsg = err.response.data.error;
        if (errorMsg === 'Unauthorised') {
          that.password = '';
          alert('密码错误，请重新输入');
        }
        if (errorMsg === 'Bad captcha！') {
          that.captcha = '';
          alert('验证码错误，请重新输入');
        }
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
    }
  },
  created() {
    // this.login();
    this.getVerificationCode();
  },
  watch: {
  }
}
</script>

<style lang="scss" scoped>
body {
  margin: 0;
}
.login-wrapper {
  background-color: #334056;
  width: 100%;
  height: 1000px;
  .title {
    text-align: center;
    font-size: 34px;
    color: #fff;
  }
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
