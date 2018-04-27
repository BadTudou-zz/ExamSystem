<!-- 查看消息 -->
<template lang="html">
  <div class="box">
    <h3 class="title">消息</h3>

    <div>
      <p v-if="!messageData" class="empty-message-prompt">暂无消息</p>
      <div v-else v-for="(item,index) in messageData" class="message box">
        <div class="message">
          <p class="message-data">{{ item.data }}</p>

          <div class="message-detail">
            <p>来自：{{ item.from_name }}</p>
            <p>收到时间：{{ GLOBAL.toTime(item.created_at.date) }}</p>
          </div>
        </div>
      </div>
      <pagination v-bind:pagination-data="paginationData"
                  v-model="data"
      ></pagination>
    </div>

  </div>
</template>

<script>
import Pagination from './../Pagination.vue'

export default {
  data() {
    return {
      messageData: [],
      isShowModal: false,
      paginationData: null,
      data: null,
      searchKey: null,
    }
  },
  components: {
    Pagination,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    getMessage: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/${sessionStorage.getItem('userId')}/messages/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.messageData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
  },
  computed: {
  },
  created() {
    this.getMessage();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.messageData = value.data;
      that.paginationData = value.links;
    }
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
.message-detail {
  margin: 0px;
  text-align: right;
  color: #acb9b8;
}
.title {
  color: #363636;
  font-size: 1.5rem;
  font-weight: 600;
  line-height: 1.125;
}
.message-data {
  margin-bottom: 20px;
}
</style>
