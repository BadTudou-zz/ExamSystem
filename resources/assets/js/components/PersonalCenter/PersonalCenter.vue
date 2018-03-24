<!-- 个人中心 -->
<template lang="html">
  <div class="box">

    <navigation v-model="navigationTag"></navigation>

    <div class="data-box">

      <user-data v-show="navigationTag === 'userData'"></user-data>
      <message-data v-show="navigationTag === 'messageData'"></message-data>
      <notice-data v-show="navigationTag === 'noticeData'"></notice-data>
      <lecture-data v-show="navigationTag === 'lectureData'"></lecture-data>
      <organization-data v-show="navigationTag === 'organizationData'"></organization-data>
      <role-data v-show="navigationTag === 'roleData'"></role-data>
      <permission-data v-show="navigationTag === 'permissionData'"></permission-data>
      <apply-for-data v-show="navigationTag === 'applyForData'"></apply-for-data>

    </div>

  </div>
</template>

<script>
import Navigation from './Navigation'
import UserData from './UserData'

import MessageData from './MessageData'
import NoticeData from './NoticeData'
import LectureData from './LectureData'
import OrganizationData from './OrganizationData'
import RoleData from './RoleData'
import PermissionData from './PermissionData'
import ApplyForData from './ApplyForData'


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
      navigationTag: 'userData',
    }
  },
  components: {
    Navigation,
    UserData,
    MessageData,
    NoticeData,
    LectureData,
    OrganizationData,
    RoleData,
    PermissionData,
    ApplyForData,
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
