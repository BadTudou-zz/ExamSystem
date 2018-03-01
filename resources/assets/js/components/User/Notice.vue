<!-- 查看通知 -->
<template lang="html">
  <div class="box">
    <div  v-for="item in data" class="message box">
      <div class="notification">
        <button class="delete"></button>
        {{ item.data.data}}
        <p>{{item.created_at}}</p>
      </div>
    </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      "data": [
        {
            "id": "20d91d78-0075-4e6e-b7db-ec8fabe1e130",
            "type": "App\\Notifications\\SystemNotification",
            "notifiable_id": "1",
            "notifiable_type": "App\\User",
            "data": {
                "data": "SystemNotification"
            },
            "read_at": null,
            "created_at": "2018-01-05 17:53:30",
            "updated_at": "2018-01-05 17:53:30"
        },
        {
            "id": "e58f93d1-1c44-4271-8381-0f927b7bdda4",
            "type": "App\\Notifications\\SystemNotification",
            "notifiable_id": "1",
            "notifiable_type": "App\\User",
            "data": {
                "data": "test"
            },
            "read_at": null,
            "created_at": "2018-01-05 17:52:52",
            "updated_at": "2018-01-05 17:52:52"
        }
    ],
      isShowModal: false,
      noticeData: null,
    }
  },
  components: {
  },
  methods: {
    // 全部通知
    getNotice: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/1/notifications/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.noticeData = res.data.data;
      }).catch(err => {
        console.log(err)
      })
    },
  },
  created() {
    this.token = sessionStorage.getItem('token');
    this.getNotice();
  },
  watch: {
  }
}
</script>

<style lang="scss">
.message {
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
