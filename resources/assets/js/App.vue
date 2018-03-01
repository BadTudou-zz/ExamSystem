<template lang="html">
  <div class="">
    <!-- <a @click="setToken()" class="button">session token</a> -->
    <login v-if="isShowLogin" v-model="loginStatus"></login>
    <home-page v-else></home-page>
  </div>
</template>

<script>
import Login from './components/Login.vue'
import HomePage from './components/HomePage.vue'
export default {
  data() {
    return {
      isShowLogin: false,
      loginStatus: null,
    };
  },
  components: {
    Login,
    HomePage,
  },
  methods: {
    setToken: function () {
      const that = this;
      // sessionStorage.setItem('token', that.token);
      // sessionStorage.getItem('token');
    },
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
    //  
  },
  watch: {
    'isShowLogin': function (value, oldValue) {
      const that = this;
    },
    loginStatus: function (value, oldValue) {
      const that = this;
      that.isShowLogin = value;
    }
  }
}
</script>

<style lang="css">
nav {
  margin-bottom: 30px;
}
</style>
