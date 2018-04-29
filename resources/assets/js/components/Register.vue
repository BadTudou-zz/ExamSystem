<template lang="html">
  <div class="">
    <!-- register -->
    <div class="modal" :class="{'is-active' : isShowModal}">
      <div class="modal-background is-actice"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">注册</p>
          <button class="delete" aria-label="close"  @click="switchModal()"></button>
        </header>
        <section class="modal-card-body">
          <div class="item-box">
            <span>用户名</span>
            <input v-model="registerData.name" class="input" type="text">
          </div>
          <div class="item-box">
            <span>邮箱</span>
            <input v-model="registerData.email" class="input" type="text">
          </div>
          <div class="item-box">
            <span>密码</span>
            <input v-model="registerData.password" class="input" type="password">
          </div>
          <div class="item-box">
            <span>确认密码</span>
            <input v-model="registerData.c_password" class="input" type="password">
          </div>
          <div class="item-box">
            <span>验证码</span>
            <input v-model="registerData.captcha" class="input" type="text">
          </div>
          <div class="code-box">
            <img class="verification-code" :src="captchaFigure" alt="">
            <a @click="getVerificationCode()" class="get-verification-code">获取验证码</a>
          </div>
        </section>
        <footer class="modal-card-foot">
          <button @click="register()" class="button is-success">确认注册</button>
          <button class="button" @click="switchModal()">取消</button>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isShowModal: false,
      captchaFigure: null,
      registerData: {
        name: '',
        email: '',
        password: '',
        c_password: '',
        captcha: '',
      }

    };
  },
  components: {
  },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    clearWords: function () {
      const that = this;
      that.registerData.name = '';
      that.registerData.email = '';
      that.registerData.password = '';
      that.registerData.c_password = '';
      that.registerData.captcha = '';
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
          'purpose': 'REGISTER',
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
    register: function (username, password) {
      const that = this;

      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/register`,
        headers: {
          'Content-type': 'application/json;charset=utf8',
        },
        data: {
          name: that.registerData.name,
          email: that.registerData.email,
          password: that.registerData.password,
          c_password: that.registerData.c_password,
          captcha: that.registerData.captcha,
        }
      }).then(res => {
        alert('注册成功，正在登录');
        that.clearWords();

        that.switchModal();
        that.$emit('input', that.registerData)
      }).catch(err => {
        alert('注册失败');
        this.getVerificationCode();
      })
    },
  },
  watch: {

  },
  created() {
    this.getVerificationCode();
  }
}
</script>

<style lang="scss">
.item-box {
  width: 500px;
  margin: 0 auto;
  margin-bottom: 20px;
  input {
    display: inline-block;
    width: 300px;
  }
  span {
    display: inline-block;
    width: 80px;
    margin-right: 20px;
  }
}
.code-box {
  margin: 0 auto;
  width: 300px;
}
</style>
