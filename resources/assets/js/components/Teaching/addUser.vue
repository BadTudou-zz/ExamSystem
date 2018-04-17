<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加用户</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          请选择用户：
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
                  <td><input type="checkbox" v-bind:value="item.id" v-model="users" class="user-seleted"></td>
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
      </section>
      <footer class="modal-card-foot">
        <button @click="addUser" class="button is-success">确认</button>
        <button @click="switchModal()" class="button">取消</button>
      </footer>
    </div>
  </div>
</template>

<script>
import Pagination from './../Pagination'

export default {
  data() {
    return {
      isShowModal: false,
      userData: [],
      users: [],
      // 翻页
      paginationData: null,
      data: null,
      //
    }
  },
  components: {
    Pagination,
  },
  props: [
    'teachingId'
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    clearWords: function () {
      const that = this;
      that.users =  [];
    },
    addUser: function () {
      const that = this;
      let id = that.teachingId;
      let params = this.GLOBAL.computedParams(that.users, 'users')
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/lectures/${id}/users?${params}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
      }).then(res => {
        alert('添加成功');
        that.$emit('getUser');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
      }).catch(err => {
        alert('添加失败');
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

  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.userData = value.data;
      that.paginationData = value.links;
    },
    teachingId: function (value, oldValue) {
      const that = this;
      that.getUser();
    }
  }
}
</script>

<style scoped>
.user-seleted {
  width: 30px;
}
</style>
