<!-- 查看通知 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input class="input search-input" type="text" placeholder="请输入你要查看的通知">
        <button class="button" type="button" name="button">查找通知</button>
      </div>
        <button @click="addNotice()" class="button add-role-button" type="button" name="button">添加通知</button>
    </div>
    <div  v-for="item in noticeData" class="notice box">
      <div class="notification">
        <button class="delete"></button>
        {{ item.data}}
        <p>{{item.created_at}}</p>
      </div>
    </div>

    <add-notice ref="addNotice"></add-notice>
    <pagination v-bind:pagination-data="paginationData"
            v-model="data"
    ></pagination>
  </div>
</template>

<script>
import AddNotice from './AddNotice'
import Pagination from './../Pagination.vue'
export default {
  data() {
    return {
      token: null,
      // noticeData: null,
      isShowModal: false,
      noticeData: [
        {
            "id": "bd35eef4-a1a9-4594-8a26-ff3225162006",
            "type": "App\\Notifications\\SystemNotification",
            "notifiable_id": "1",
            "notifiable_type": "App\\User",
            "data": "{\"data\":\"\\u8fd9\\u662f\\u901a\\u77e5\"}",
            "read_at": null,
            "created_at": "2018-01-21 12:34:56",
            "updated_at": "2018-01-21 12:34:56"
        }
      ],
      paginationData: null,
      data: null,
    }
  },
  components: {
    AddNotice,
    Pagination,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    addNotice: function () {
      const that = this;
      that.$refs.addNotice.switchModal();
    },
    getNotice: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/notifications/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.noticeData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    }
  },
  computed: {
    isShowCreateNotification() {
      return this.$store.state.permissionIdList.includes(18)
    },
    isShowSearchNotification() {
      return this.$store.state.permissionIdList.includes(19)
    },
    isShowUpdateNotification() {
      return this.$store.state.permissionIdList.includes(20)
    },
    isShowDeleteNotification() {
      return this.$store.state.permissionIdList.includes(21)
    },
  },
  created() {
    this.token = sessionStorage.getItem('token');
    // this.getNotice();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.permissionData = value.data;
      that.paginationData = value.links;
    }
  }
}
</script>

<style lang="scss">
.notice {
  margin: 35px auto 0 auto;
}
.search-input {
  width: 200px;
  display: inline-block;
  margin-right: 10px;
}
.search-box {
  padding-right: 20px;
  display: inline-block;
  border-right: 1px solid #dedede;
}
.add-role-button {
  margin-left: 20px;
}
.box-item {
  margin-bottom: 20px;
  input  {
    display: inline-block;
    width: 300px;
  }
  label {
    display: inline-block;
    width: 130px;
  }
}
.notification p{
  margin-top: 25px;
  text-align: right;
}
</style>
