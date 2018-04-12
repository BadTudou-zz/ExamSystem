<template lang="html">
  <div class="">
    <login v-if="isShowLogin" v-model="loginStatus"></login>
    <home-page v-else v-model="logOut"></home-page>
  </div>
</template>

<script>
import Login from './Login'
import HomePage from './HomePage'

export default {
  data() {
    return {
      isShowLogin: true,
      loginStatus: null,
      logOut: null,
    };
  },
  components: {
    Login,
    HomePage,
  },
  methods: {
    checkLoginState: function () {
      const that = this;
      let token = sessionStorage.getItem("token");
      if (token) {
        that.isShowLogin = false;
      }
      else {
        that.isShowLogin = true;
      }
    }
  },
  created() {
    this.checkLoginState();
  },
  watch: {
    'isShowLogin': function (value, oldValue) {
      const that = this;
    },
    'loginStatus': function (value, oldValue) {
      const that = this;
      that.isShowLogin = value;
      // if (value === false) {
      //   location.reload();
      //   console.log('已刷新')
      // }
    },
    logOut: function (value, oldValue) {
      const that = this;
      if (value === 'logOut') {
        that.isShowLogin = true;
      }
    }
  }
}
</script>

<style lang="css">
nav {
  margin-bottom: 30px;
}
</style>
