<template lang="html">
  <div class="">
    <login v-if="isShowLogin"
           v-on:checkLoginState="checkLoginState"
    ></login>
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
      logOut: null,
    }
  },
  components: {
    Login,
    HomePage,
  },
  methods: {
    checkLoginState: function () {
      const that = this;
      let token = sessionStorage.getItem("token");
      let userPermissions = sessionStorage.getItem('permissions')
      if (token && userPermissions !== null) {
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
    logOut: function (value, oldValue) {
      const that = this;
      if (value === 'logOut') {
        that.isShowLogin = true;
      }
    },
  }
}
</script>

<style lang="css">
nav {
  margin-bottom: 30px;
}
</style>
