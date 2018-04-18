<!-- 个人中心 -->
<template lang="html">
  <div class="box">

    <personal-center-navigation v-model="navigationTag"></personal-center-navigation>

    <div class="data-box">

      <user-data v-show="navigationTag === 'userData'"></user-data>
      <message-data v-if="navigationTag === 'messageData'"></message-data>
      <notice-data v-if="navigationTag === 'noticeData'"></notice-data>
      <lecture-data v-if="navigationTag === 'lectureData'"></lecture-data>
      <organization-data v-if="navigationTag === 'organizationData'"></organization-data>
      <role-data v-if="navigationTag === 'roleData'"></role-data>
      <permission-data v-if="navigationTag === 'permissionData'"></permission-data>
      <apply-for-data v-if="navigationTag === 'applyForData'"></apply-for-data>
      <test-data v-if="navigationTag === 'testData'"></test-data>
    </div>

  </div>
</template>

<script>
import PersonalCenterNavigation from './PersonalCenterNavigation'
import UserData from './UserData'
import MessageData from './MessageData'
import NoticeData from './NoticeData'
import LectureData from './LectureData'
import OrganizationData from './OrganizationData'
import RoleData from './RoleData'
import PermissionData from './PermissionData'
import ApplyForData from './ApplyForData'
import TestData from './TestData'


export default {
  data() {
    return {
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
    PersonalCenterNavigation,
    UserData,
    MessageData,
    NoticeData,
    LectureData,
    OrganizationData,
    RoleData,
    PermissionData,
    ApplyForData,
    TestData,
  },
  methods: {
    // 全部用户
    getUser: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/${sessionStorage.getItem('userId')}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
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
