<!-- 查看消息 -->
<template lang="html">
  <div class="box">
    <div>
      <div v-show="isShowSearchMessage" class="search-box">
        <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入关键字">
        <!-- <button disabled @click="searchMessage()" class="button" type="button" name="button">查找消息</button> -->
        <div @click="searchMessage()" class="search-button"><i class="fas fa-search"></i></div>
      </div>
        <button v-show="isShowCreateMessage" @click="addMessage()" class="button add-role-button" type="button" name="button">添加消息</button>
    </div>

    <p v-if="!messageData" class="empty-message-prompt">暂无消息</p>
    <table v-else class="table is-bordered is-striped is-hoverable is-fullwidths">
      <thead>
        <tr>
          <!-- <th>序号</th> -->
          <th>发送者</th>
          <th>接受者</th>
          <th>内容</th>
          <th>创建时间</th>
          <!-- <th>更新时间</th> -->
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in messageData">
          <!-- <td>{{ item.id }}</td> -->
          <td>{{ item.from_name }}</td>
          <td>{{ item.to_name }}</td>
          <td><p class="limit-words">{{ item.data }}</p></td>
          <td>{{ GLOBAL.toTime(item.created_at.date) }}</td>
          <!-- <td>{{ GLOBAL.toTime(item.updated_at.date) }}</td> -->
          <td>
            <div v-show="isShowDeleteMessage" @click="deleteMessage(index)" class="icon-button"><i class="far fa-trash-alt"></i></div>
            <!-- <button v-show="isShowDeleteMessage" @click="deleteMessage(index)" class="delete" type="button">删除消息</button> -->
          </td>
        </tr>
      </tbody>
    </table>


    <add-message ref="addMessage"
                 v-on:getMessage="getMessage"
    ></add-message>

    <pagination v-show="searchResult.length === 0"
                v-bind:pagination-data="paginationData"
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
      messageData: [],
      isShowModal: false,
      paginationData: null,
      data: null,
      searchKey: null,
      // get all message
      currentMessage: [],
      allMessage: [],
      searchResult: [],

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
    // searchMessage: function () {
    //   const that = this;
    //   that.messageData = [];
    //
    //   if (!that.searchKey) {
    //     that.searchKey = '';
    //     that.getMessage();
    //     return;
    //   }
    //   axios({
    //     method: 'get',
    //     url: `${this.GLOBAL.localDomain}/api/v1/messages/${that.searchKey}`,
    //     headers: {
    //       'Accept': 'application/json',
    //       'Authorization': sessionStorage.getItem('token'),
    //     }
    //   }).then(res => {
    //     that.messageData.push(res.data.data);
    //   }).catch(err => {
    //     console.log(err)
    //   })
    // },
    searchMessage: function () {
      const that = this;
      // 如果没有搜索值
      if (!that.searchKey) {
        that.getMessage();
        that.searchResult = [];
        return;
      }
      // 如果已经获取全部数据
      else if (that.allMessage.length > 0) {
        let allData  = that.allMessage;
        let len = that.allMessage.length;
        let res = [];

        for (let i = 0; i < len; i++) {
          for (let j in allData[i]) {
            if (allData[i][j]) {
              if ((allData[i][j].toString()).indexOf(that.searchKey) !== -1) {
                res.push(allData[i]);
                break;
              }
            }
          }
        }
        that.searchResult = res;
        that.messageData = res;
      }
      // 如果有搜索值并且还未获取全部数据
      else {
        let url = `${this.GLOBAL.localDomain}/api/v1/messages/`;
        that.getAllMessage(url);
      }
    },
    getAllMessage: function (url) {
      const that = this;
      let urlPath = url ? url : that.url
      axios({
        method: 'get',
        url: urlPath,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.url = res.data.links.next;

        let len = res.data.data.length ? res.data.data.length : that.getJsonLength(res.data.data);

        // data数据结构不一致 可能是数组/也可能是json
        if (res.data.data.length) {
          for (let i = 0; i < len; i++) {
            that.currentMessage.push(res.data.data[i]);
          }
        }
        else if (that.getJsonLength(res.data.data)) {
          for (let i in res.data.data) {
            that.currentMessage.push(res.data.data[i]);
          }
        }

        if (that.url) {
          that.getAllMessage(that.url);
        }
        else {
          that.allMessage = that.currentMessage;
        }
      }).catch(err => {
        console.log(err);
      })
    },
  },
  computed: {
    isShowCreateMessage() {
      // return true;
      return sessionStorage.getItem('permissions').includes('message-store');
    },
    isShowSearchMessage() {
      // return true;
      return sessionStorage.getItem('permissions').includes('message-show');
    },
    isShowDeleteMessage() {
      // return true;
      return sessionStorage.getItem('permissions').includes('message-destroy');
    },
  },
  created() {
    this.getMessage();
  },
  watch: {
    allMessage: function (value, oldValue) {
      const that = this;
      that.searchMessage(that.searchKey);
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
.notification p{
  margin-top: 25px;
  text-align: right;
}
</style>
