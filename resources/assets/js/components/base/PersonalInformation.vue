<!--
 个人信息组件
【用户】
涉及API：
-->
<template lang="html">
  <div class="box info-box">
    <div class="field">
      <label class="label">姓名：</label>
      <span>admin</span>
      <a @click="changePassword()" class="button is-small change-password">更改密码</a>
      <div  v-show="isShowInput" class="change">
        <input class="input is-small change-password-input" type="text" placeholder="请输入新密码">
        <a @click="confirmChanges()" class="button is-small is-info change-password">确认更改</a>
      </div>
    </div>
    <div class="field">
      <label class="label">邮箱：</label>
      <span>admin@email.com</span>
    </div>
    <div class="field">
      <label class="label">注册时间：</label>
      <span>2018-01-01</span>
    </div>
    <div class="field">
      <label class="label">更新时间：</label>
      <span>2018-01-01</span>
    </div>
  </div>
</template>


<script>
import Moment from 'moment';

export default {
  data() {
    return {
      messageList: '',
      isShowInput: false
    }
  },
  props: [],
  methods: {
    getMessage: function () {
      const that = this;
      console.log('登录')
      axios({
        method: 'post',
        url: 'http://localhost:8000/api/v1/users/1/messages/',
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
    changePassword: function () {
      const that = this;
      that.isShowInput = true;
    },
    confirmChanges: function () {

    }
  },
  created() {
  },
  watch: {

  }
}
</script>

<style lang="css">
.info-box {
  width: 50%;
  margin: 0 auto;
}
.label {
  width: 100px;
  display: inline-block;
}
.change {
  display: inline-block;
}
.change-password {
  margin-left: 15px;
}
.change-password-input {
  display: inline-block;
  width: 200px;
}
</style>
