<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">发送消息</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          请选择需要发送的用户：

          <div class="all-user">
            <table class="table">
              <thead>
                <tr>
                  <th>是否选中</th>
                  <th>序号</th>
                  <th>用户名</th>
                  <th>邮箱</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item,index) in userData">
                  <td><input type="radio" v-bind:value="item.id" v-model="selectedUser" class="user-seleted"></td>
                  <td>{{ item.id }}</td>
                  <td>{{ item.name }}</td>
                  <td>{{ item.email }}</td>
                </tr>
              </tbody>
            </table>
            <pagination v-bind:pagination-data="paginationData"
                        v-model="data"
            ></pagination>
          </div>

        </div>

        <div class="box-item">
          <label>消息内容</label>
          <textarea v-model="messageData.data" class="textarea" type="text"></textarea>
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="addMessage()" class="button is-success">确认发送</button>
        <button  @click="switchModal()" class="button">取消</button>
      </footer>
    </div>

  </div>
</template>
<script>
import Pagination from './../Pagination.vue'

export default {
  data() {
    return {
      isShowModal: false,
      messageData: {
        to: null,
        data: null,
      },
      selectedUser: '', // 单选
      userData: null,
      // 翻页
      paginationData: null,
      data: null,
      //
    }
  },
  components: {
    Pagination,
  },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
      that.clearWords();
    },
    clearWords: function () {
      const that = this;
      // that.messageData.to = '';
      that.selectedUser = '',
      that.messageData.data = '';
    },
    addMessage: function () {
      const that = this;
      if (!that.selectedUser || !that.messageData.data) {
        alert('请检查发送的信息是否完整！');
        return;
      }
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/messages/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          to: that.selectedUser,
          data: that.messageData.data
        }
      }).then(res => {
        alert('发送成功');
        that.$emit('getMessage');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
        that.clearWords();
      }).catch(err => {
        alert('发送失败');
        console.log(err);
        that.clearWords();
      })
    },
    // 全部用户
    getUser: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.userData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err);
      })
    },
  },
  created() {
    this.clearWords();
    this.getUser();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.messageData = value.data;
      that.paginationData = value.links;
    },
    isShowModal: function (value, oldVale) {
      const that = this;
      if (value) {
        this.clearWords();
        this.getUser();
      }
    },
  }
}
</script>

<style scoped>
.box-item input {
  width: 20px;
}
</style>
