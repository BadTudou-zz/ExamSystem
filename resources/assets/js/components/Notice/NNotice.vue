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
  </div>
</template>

<script>
import AddNotice from './AddNotice'
export default {
  data() {
    return {
      token: null,
      noticeData: null,
      isShowModal: false,
    }
  },
  components: {
    AddNotice,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    deleteRole: function () {
      const that = this;
      let prompt = confirm("确认删除改通知吗？");
      if (prompt) {

      }
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
      }).catch(err => {
        console.log(err)
      })
    }
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
