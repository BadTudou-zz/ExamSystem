<!-- 查看消息 -->
<template lang="html">
  <div class="box">
    <h3 class="title">消息</h3>

    <div>
      <div class="tabs is-centered is-boxed">
        <ul>

          <li v-bind:class="{'is-active': currentTag === 'reveived1'}">
            <a>
              <span @click="currentTag = 'reveived1'">收到的消息</span>
            </a>
          </li>

          <li v-bind:class="{'is-active': currentTag === 'reveived0'}">
            <a>
              <span @click="currentTag = 'reveived0'">发送的消息</span>
            </a>
          </li>

        </ul>
      </div>

    </div>
    <div v-show="currentTag === 'reveived1'">
      <p v-if="!reveivedMessageData || reveivedMessageData.length === 0" class="empty-message-prompt">暂未收到消息</p>
      <div v-else v-for="(item,index) in reveivedMessageData" class="message box">
        <div class="message">
          <p class="message-data">{{ item.data }}</p>

          <div class="message-detail">
            <p>来自：{{ item.from_name }}</p>
            <p>收到时间：{{ GLOBAL.toTime(item.created_at.date) }}</p>
          </div>
        </div>
      </div>
      <pagination v-bind:pagination-data="paginationData1"
                  v-model="data1"
      ></pagination>
    </div>

    <div v-show="currentTag === 'reveived0'">
      <p v-if="!sendMessageData || sendMessageData.length === 0" class="empty-message-prompt">暂未发送消息</p>
      <div v-else v-for="(item,index) in sendMessageData" class="message box">
        <div class="message">
          <p class="message-data">{{ item.data }}</p>

          <div class="message-detail">
            <p>来自：{{ item.from_name }}</p>
            <p>发送时间：{{ GLOBAL.toTime(item.created_at.date) }}</p>
          </div>
        </div>
      </div>
      <pagination v-bind:pagination-data="paginationData2"
                  v-model="data2"
      ></pagination>
    </div>

  </div>
</template>

<script>
import Pagination from './../Pagination.vue'

export default {
  data() {
    return {
      reveivedMessageData: [],
      sendMessageData: [],
      isShowModal: false,
      paginationData1: null,
      data1: null,
      paginationData2: null,
      data2: null,
      searchKey: null,
      currentTag: 'reveived0',
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
    // 收到的消息
    getReveivedMessage: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/${sessionStorage.getItem('userId')}/messages`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          reveived: 1,
        }
      }).then(res => {
        that.reveivedMessageData = res.data.data;
        that.paginationData1 = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
    // 发送的消息
    getSendMessage: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/${sessionStorage.getItem('userId')}/messages`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          reveived: 0,
        }
      }).then(res => {
        that.sendMessageData = res.data.data;
        that.paginationData2 = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
  },
  computed: {
  },
  created() {
    this.getReveivedMessage();
  },
  watch: {
    data1:function (value, oldValue) {
      const that = this;
      that.reveivedMessageData = value.data;
      that.paginationData1 = value.links;
    },
    data2:function (value, oldValue) {
      const that = this;
      that.sendMessageData = value.data;
      that.paginationData2 = value.links;
    },
    currentTag: function (value, oldValue) {
      const that = this;
      if (value === 'reveived0') {
        that.getSendMessage();
      }
      else {
        that.getReveivedMessage();
      }
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
