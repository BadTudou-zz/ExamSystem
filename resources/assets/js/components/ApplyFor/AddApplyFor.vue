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
                  <td><input type="radio" v-bind:value="item.id" v-model="applyForData.to" class="seleted-input"></td>
                  <td>{{ item.id }}</td>
                  <td>{{ item.name }}</td>
                  <td>{{ item.email }}</td>
                </tr>
              </tbody>
            </table>
            <pagination v-bind:pagination-data="paginationData1"
                        v-model="data1"
            ></pagination>
          </div>
        </div>

        <div class="box-item">
          请选择需要申请的资源：
          <div class="select">
            <select v-model="applyForData.resource_type">
              <option value="Organization">组织</option>
              <option value="Lecture">授课</option>
            </select>
          </div>

          <div class="all-user">

            <table v-if="applyForData.resource_type === 'Organization'"  class="table">
              <thead>
                <tr>
                  <th>是否选中</th>
                  <th>序号</th>
                  <th>组织名</th>
                  <th>描述</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item,index) in resourceData">
                  <td><input type="radio" v-bind:value="item.id" v-model="applyForData.resource_id" class="seleted-input"></td>
                  <td>{{ item.id }}</td>
                  <td>{{ item.name }}</td>
                  <td>{{ item.describe }}</td>
                </tr>
              </tbody>
            </table>

            <table  v-if="applyForData.resource_type === 'Lecture'" class="table">
              <thead>
                <tr>
                  <th>是否选中</th>
                  <th>序号</th>
                  <th>课程名</th>
                  <th>描述</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item,index) in resourceData">
                  <td><input type="radio" v-bind:value="item.id" v-model="applyForData.resource_id" class="seleted-input"></td>
                  <td>{{ item.id }}</td>
                  <td>{{ item.name }}</td>
                  <td>{{ item.describe }}</td>
                </tr>
              </tbody>
            </table>
            <pagination v-bind:pagination-data="paginationData2"
                        v-model="data2"
            ></pagination>
          </div>
        </div>

        <div class="box-item">
          <label>内容</label>
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
        to: '',
        action: 'create',
        resource_id: '',
        resource_type: 'Organization',  // 组织、授课
        data: '',
      },
      // 翻页
      paginationData1: null,
      data1: null,
      // 翻页
      paginationData2: null,
      data2: null,
      //
      userData: [],
      resourceData: [],
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
      that.applyForData.action = 'create';
      that.applyForData.resource_id = '';
      that.applyForData.resource_type = '';
      that.applyForData.data = '';
    },
    addApplyFor: function () {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/applications`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          to: that.applyForData.to,
          action: 'create',
          resource_id: that.applyForData.resource_id,
          resource_type: that.applyForData.resource_type,
          data: that.applyForData.data,
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
        that.paginationData1 = res.data.links;
      }).catch(err => {
        console.log(err);
      })
    },
    getOrganization: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/organizations`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.resourceData = res.data.data;
        that.paginationData2 = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
    getLecture: function() {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/lectures`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.resourceData = res.data.data;
        that.paginationData2 = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
  },
  created() {
    // this.clearWords();
    // this.getUser();
  },
  watch: {
    isShowModal: function (value, oldVale) {
      const that = this;
      if (value) {
        this.clearWords();
        this.getUser();
      }
    },
    data1:function (value, oldValue) {
      const that = this;
      that.applyForData = value.data;
      that.paginationData1 = value.links;
    },
    data2:function (value, oldValue) {
      const that = this;
      that.resourceData = value.data;
      that.paginationData2 = value.links;
    },
    'applyForData.resource_type': function (value, oldValue) {
      const that = this;
      if (value === 'Organization') {
        that.getOrganization();
      }
      else if (value === 'Lecture') {
        that.getLecture();
      }
      else {
        return;
      }
    }
  }
}
</script>

<style scoped>
.seleted-input {
  width: 10px;
}
</style>
