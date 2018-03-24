<!-- 个人中心 -->
<template lang="html">
  <div class="box">

    <navigation></navigation>

    <div class="data-box">
      <user-data></user-data>

    </div>

  </div>
</template>

<script>
import Navigation from './Navigation'
import UserData from './UserData'

export default {
  data() {
    return {
      token: '',
      userId: null,
      userData: null,
      currentUserData: {
        id: '',
        name: '',
        email: '',
        created_at: '',
        updated_at: '',
      },
      isShowEditModal: false,
      editData: null,
    }
  },
  components: {
    ChangePassword,
    Navigation,
    UserData,
  },
  methods: {
    // 全部用户
    getUser: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/${that.userId}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.userData = res.data.data;
        that.currentUserData.id = res.data.data.id;
        that.currentUserData.name = res.data.data.name;
        that.currentUserData.email = res.data.data.email;
        that.currentUserData.created_at = res.data.data.created_at.date;
        that.currentUserData.updated_at = res.data.data.updated_at.date;
      }).catch(err => {
        console.log(err)
      })
    },
    changePassword: function () {
      const that = this;
      that.editData = that.userData;
      that.$refs.changePassword.switchModal();
    },
  },
  computed: {
  },
  created() {
    this.token = sessionStorage.getItem('token');
    this.userId = sessionStorage.getItem('userId');
    this.getUser();
  },
  watch: {
  }
}
</script>

<style lang="css">
.box {
  margin: 30px;
  padding: 20px 50px 30px 50px;
}
.data-box {
  padding-top: 20px;
}
</style>
