<!-- 查看用户 -->
<template lang="html">
  <div class="modal" v-bind:class="{'is-active': isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-content user-content">
      <div class="box user-box">
        <div>
            <button @click="addPracticeUser()" class="button add-role-button" type="button" name="button">添加用户</button>
            <button @click="deleteUser()" class="button" type="button" name="button">删除用户</button>
        </div>
        <table class="table">
          <thead>
            <tr>
              <th>是否选中</th>
              <th>用户名</th>
              <th>邮箱</th>
              <th>电话</th>
              <th>QQ</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item,index) in userData">
              <td><input type="checkbox" v-bind:value="item.id" v-model="users" class="user-seleted"></td>
              <td>{{ item.name }}</td>
              <td>{{ item.email }}</td>
              <td>{{ item.phone }}</td>
              <td>{{ item.qq }}</td>
            </tr>
          </tbody>
        </table>

        <pagination v-bind:pagination-data="paginationData"
                    v-model="data"
        ></pagination>

        <add-practice-user ref="addPracticeUser"
                       v-on:getUser="getUser"
                       v-bind:exam-id="examId"
        ></add-practice-user>

      </div>
    </div>
    <button @click="switchModal()" class="modal-close is-large" aria-label="close"></button>
  </div>
</template>

<script>
import Pagination from './../Pagination'
import AddPracticeUser from './AddPracticeUser'

export default {
  data() {
    return {
      isShowModal: false,
      userData: null,
      searchKey: null,
      editData: null,  // 当前编辑的用户数据
      // 翻页
      paginationData: null,
      data: null,
      //
      teachingId: null,
      users: [],
    }
  },
  components: {
    Pagination,
    AddPracticeUser,
  },
  props: [
    'examId'
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    addPracticeUser: function() {
      const that = this;
      that.$refs.addPracticeUser.switchModal();
    },
    getUser: function () {
      const that = this;
      let id = that.examId;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/${id}/users`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.userData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
    deleteUser: function () {
      const that = this;
      if (!that.users) {
        alert('请勾选需要删除的用户');
        return;
      }
      let id = that.examId;
      let params = this.GLOBAL.computedParams(that.users, 'users')
      let prompt = confirm("确认删除选中的用户吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/exams/${id}/users?${params}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': sessionStorage.getItem('token'),
          }
        }).then(res => {
          that.getUser();
          alert('删除成功！')
        }).catch(err => {
          alert('删除失败')
          console.log(err)
        })
      }
    }
  },
  created() {
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.teachingData = value.data;
      that.paginationData = value.links;
    },
    examId: function (value, oldValue) {
      this.getUser();
    }
  }
}
</script>

<style lang="scss" scoped>
table {
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
.user-box {
  width: 1300px;
}
.user-content {
  width: 1300px;
}
</style>
