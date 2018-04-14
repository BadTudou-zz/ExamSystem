<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加申请</p>
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
                  <td><input type="radio" v-bind:value="item.id" v-model="applyForData.to" class="user-seleted"></td>
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
          <label>资源ID</label>
          <input v-model="applyForData.resource_id" class="input" type="text">
        </div>
        <div class="box-item">
          <label>资源类型</label>
          <input v-model="applyForData.resource_type" class="input" type="text">
        </div>
        <div class="box-item">
          <label>数据</label>
          <input v-model="applyForData.data" class="input" type="text">
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="addApplyFor()" class="button is-success">确认</button>
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
      applyForData: {
        to: '',  // 发送到的用户
        action: '',  // ??
        resource_id: '',  // ??
        resource_type: '',  // ??
        data: '',  // ??SSS
      },
      // 翻页
      paginationData: null,
      data: null,
      //
      userData: [],
    }
  },
  components: {
    Pagination,
  },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    clearWords: function () {
      const that = this;
      that.applyForData.to = '';
      that.applyForData.action = '';
      that.applyForData.resource_id = '';
      that.applyForData.resource_type = '';
      that.applyForData.data = '';
    },
    addApplyFor: function () {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/applications/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        body: {
          to: that.applyForData.to,
          action: 'create',  // ?? 枚举值
          // resource_id: that.applyForData.resource_id,
          resource_id: 1,
          // resource_type: that.applyForData.type,
          resource_type: 'Organization',
          data: that.applyForData.data
        }
      }).then(res => {
        alert('添加成功');
        that.$emit('getApplyFor');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
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
    }
  },
  created() {
    this.clearWords();
    this.getUser();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.applyForData = value.data;
      that.paginationData = value.links;
    }
  }
}
</script>

<style scoped>
</style>
