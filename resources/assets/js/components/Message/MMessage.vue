<!-- 查看消息 -->
<template lang="html">
  <div class="box">
    <div>
      <div v-show="isShowSearchMessage" class="search-box">
        <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入你要查看的消息">
        <button @click="searchMessage()" class="button" type="button" name="button">查找消息</button>
      </div>
        <button v-show="isShowCreateMessage" @click="addMessage()" class="button add-role-button" type="button" name="button">添加消息</button>
    </div>
    <div  v-for="(item,index) in messageData" class="message box">
      <div class="notification">
        <button v-show="isShowDeleteMessage" @click="deleteMessage(index)" class="delete"></button>
        {{ item.data}}
        <p>{{ GLOBAL.toTime(item.created_at) }}</p>
      </div>
    </div>

    <add-message ref="addMessage"
                 v-on:getMessage="getMessage"
    ></add-message>

    <pagination v-bind:pagination-data="paginationData"
                v-model="data"
    ></pagination>

  </div>
</template>

<script>
import AddMessage from './AddMessage'
import Pagination from './../Pagination.vue'

export default {
  data() {
    return {
      messageData: null,
      isShowModal: false,
      paginationData: null,
      data: null,
      searchKey: null,
    }
  },
  components: {
    AddMessage,
    Pagination,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    deleteMessage: function (index) {
      const that = this;
      let id = that.messageData[index]['id'];
      let prompt = confirm("确认删除该消息吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/messages/${id}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': sessionStorage.getItem('token'),
          }
        }).then(res => {
          alert('删除成功');
          that.getMessage();
        }).catch(err => {
          alert('删除失败');
          console.log(err)
        })
      }
    },
    addMessage: function () {
      const that = this;
      that.$refs.addMessage.switchModal();
    },
    getMessage: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/messages/`,
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
    searchMessage: function () {
      const that = this;
      if (!that.searchKey) {
        that.searchKey = '';
        that.getMessage();
        return;
      }
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/messages/${that.searchKey}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.messageData = [];
        that.messageData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    }
  },
  computed: {
    isShowCreateMessage() {
      return sessionStorage.getItem('permissions').includes(14);
    },
    isShowSearchMessage() {
      return sessionStorage.getItem('permissions').includes(15);
    },
    isShowDeleteMessage() {
      return sessionStorage.getItem('permissions').includes(16);
    },
  },
  created() {

    this.getMessage();
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
