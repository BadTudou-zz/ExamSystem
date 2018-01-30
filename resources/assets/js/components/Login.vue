<template lang="html">
  <div id="app" class="login-wrapper">
    <!-- login -->
    <p class="title">用户登录</p>
    <div class="login-box">
      <div class="select-box">
        <span>用户类型&nbsp;&nbsp;</span>
        <div>
          <div class="select is-small">
            <select v-on:change="changeRole($event)">
              <option value="student">学生</option>
              <option value="teacher">老师</option>
              <option value="administrator">管理员</option>
            </select>
          </div>
        </div>
      </div>
      <input type="" class="form-control" :placeholder="placeholderData">
      <input type="password" class="form-control" placeholder="密码">
            <img class="verification-code" src="https://fp.yangcong345.com/o_1c48qhluh1qf0r6v1ip765c1s799.png" alt="">
      <button @click="login()" type="button" class="button" name="button">登录</button>
      <div class="operate-box">
        <a>忘记密码</a><a @click="register()">注册</a>
      </div>
    </div>

    <register ref="register"></register>
  </div>
</template>

<script>
import Register from './Register'
export default {
  data() {
    return {
      currentRole: '',
      placeholderData: '请输入你的学号',
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
        url: 'http://localhost:8000/api/login',
        data: {
          'email': 'admin@email.com',
          'password': 'admin',
          'type': 'mobile',
          'captcha': 'ilhup',
        }
      }).then(res => {
        console.log(res)
      }).catch(err => {
        console.log(err)
      })
    },
    getVerificationCode: function () {
      const that = this;
      axios({
        method: 'post',
        url: 'http://localhost:8000/api/captchas',
        data: {
          'purpose': 'LOGIN'
        }
      }).then(res => {
        console.log(res)
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
  height: 300px;
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
    margin: 0 auto;
  }
}
</style>
