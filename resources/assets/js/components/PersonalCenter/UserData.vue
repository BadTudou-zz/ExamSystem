<!-- 查看用户 -->
<template lang="html">
  <div>
    <div>
      <h3 class="title">个人信息</h3>
      <div class="label-box">
        <label class="label">用户ID：</label>
        <span>{{ currentUserData.id }}</span>
        <a @click="changePassword()" class="button is-link is-outlined change-password is-small">更改密码</a>
        <a @click="changeUserName()" class="button is-link is-outlined change-password is-small">更改用户名</a>
      </div>
      <div class="label-box">
        <label class="label">用户名：</label>
        <span>{{ currentUserData.name }}</span>
      </div>
      <div class="label-box">
        <label class="label">邮箱：</label>
        <span>{{ currentUserData.email }}</span>
      </div>
      <div class="label-box">
        <label class="label">创建时间：</label>
        <span>{{ toTime(currentUserData.created_at) }}</span>
      </div>
      <!-- <div class="label-box">
        <label class="label">更新时间：</label>
        <span>{{ toTime(currentUserData.updated_at) }}</span>
      </div> -->

      <ve-pie :data="chartData" :settings="chartSettings"></ve-pie>


    </div>

    <change-password ref="changePassword"
                     v-bind:edit-data="editData"
                     v-on:getUser="getUser"
    ></change-password>


    <change-user-name ref="changeUserName"
                      v-bind:edit-data="editData"
                      v-on:getUser="getUser"
    ></change-user-name>

  </div>
</template>

<script>
import ChangePassword from '../User/ChangePassword'
import ChangeUserName from './ChangeUserName'
import moment from 'moment'

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
      // chartData: {
      //   columns: ['日期', '成本', '利润'],
      //   rows: [
      //     { '日期': '1月1号', '成本': 123, '利润': 3 },
      //     { '日期': '1月2号', '成本': 1223, '利润': 6 },
      //     { '日期': '1月3号', '成本': 2123, '利润': 90 },
      //     { '日期': '1月4号', '成本': 4123, '利润': 12 },
      //     { '日期': '1月5号', '成本': 3123, '利润': 15 },
      //     { '日期': '1月6号', '成本': 7123, '利润': 20 }
      //   ]
      // },
      // chartSettings: {
      //   dimension: '成本',
      //   metrics: '利润'
      // }
    }
  },
  components: {
    ChangePassword,
    ChangeUserName,
  },
  methods: {
    toTime: function (time) {
      return moment(time).format('YYYY-MM-DD');
    },
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
    changeUserName: function () {
      const that = this;
      that.editData = that.userData;
      that.$refs.changeUserName.switchModal();
    },
  },
  computed: {
  },
  created() {
    this.getUser();
    // this.chartData = {
    //   columns: ['日期', '成本', '利润'],
    //   rows: [
    //     { '日期': '1月1号', '成本': 123, '利润': 3 },
    //     { '日期': '1月2号', '成本': 1223, '利润': 6 },
    //     { '日期': '1月3号', '成本': 2123, '利润': 90 },
    //     { '日期': '1月4号', '成本': 4123, '利润': 12 },
    //     { '日期': '1月5号', '成本': 3123, '利润': 15 },
    //     { '日期': '1月6号', '成本': 7123, '利润': 20 }
    //   ]
    // }
    // this.chartSettings = {
    //   dimension: '成本',
    //   metrics: '利润'
    // }
  },
  created: function () {
  },
  watch: {
  }
}
</script>

<style lang="css">
label {
  display: inline-block;
  width: 100px;
}
.label {
  display: inline-block;
}
.label-box {
  margin-bottom: 10px;
  height: 36px;
  line-height: 36px;
}
.title {
  color: #363636;
  font-size: 1.5rem;
  font-weight: 600;
  line-height: 1.125;
}
.change-password {
  display: inline-block;
  margin-top: 7px;
  margin-left: 10px;
}
</style>
