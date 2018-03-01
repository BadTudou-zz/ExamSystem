<!-- 查看申请 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入你要查看的申请">
        <button @click="searchApplyFor()" class="button" type="button" name="button">查找申请</button>
      </div>
        <button @click="addApplyFor()" class="button add-role-button" type="button" name="button">添加申请</button>
    </div>
    <table class="table">
      <thead>
        <tr>
          <!-- <th>ID</th> -->
          <th>申请类型</th>
          <th>申请ID</th>
          <th>申请类型</th>
          <!-- <th>内容</th> -->
          <th>创建时间</th>
          <th>更新时间</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in applyForData">
          <td>{{ item.type }}</td>
          <td>{{ item.notifiable_id }}</td>
          <td>{{ item.notifiable_type }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
          <td>
            <button @click="deleteApplyFor()" class="button" type="button" name="button">删除</button>
            <button @click="editApplyFor()" class="button" type="button" name="button">编辑</button>
            <button @click="acceptApplyFor()" class="button" type="button" name="button">接受</button>
            <button @click="rejectApplyFor()" class="button" type="button" name="button">拒绝</button>
          </td>
        </tr>
      </tbody>
    </table>
    <add-apply-for ref="addApplyFor"></add-apply-for>
    <edit-apply-for ref="editApplyFor" v-bind:edit-data="editData"></edit-apply-for>
  </div>
</template>

<script>
import AddApplyFor from './AddApplyFor'
import EditApplyFor from './EditApplyFor'
export default {
  data() {
    return {
      applyForData: [
        {
            "id": "53e20281-90ee-4d1e-824e-ac45ac138446",
            "type": "App\\Notifications\\ApplicationNotification",
            "notifiable_id": "1",
            "notifiable_type": "App\\User",
            "data": "{\"notifiable_id\":\"1\",\"action\":\"create\",\"resource_id\":\"1\",\"resource_type\":\"Organization\",\"data\":\"\\u8fd9\\u662f\\u79c1\\u4fe1\"}",
            "read_at": null,
            "created_at": "2018-01-21 14:04:22",
            "updated_at": "2018-01-21 14:04:22"
        }
    ],
      isShowModal: false,
      token: null,
      searchKey: null,
      // applyForData: null,
      editData: null,
      searchKey: null,
    }
  },
  components: {
    AddApplyFor,
    EditApplyFor,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    deleteApplyFor: function (index) {
      const that = this;
      let id = that.applyForData[index].id;
      let prompt = confirm("确认删除该申请吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/applications/${id}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': that.token
          }
        }).then(res => {
          that.applyForData = res.data.data;
        }).catch(err => {
          console.log(err)
        })
      }
    },
    searchApplyFor: function () {
      const that = this;
      let id = that.searchKey;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/applications/${id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.applyForData = [];
        that.applyForData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    },
    getApplyFor: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/applications/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
         
        that.applyForData = [];
        that.applyForData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    },
    addApplyFor: function () {
      const that = this;
      that.$refs.addApplyFor.switchModal();
    },
    editApplyFor: function (index) {
      const that = this;
      that.editData = that.applyForData[index];
      // that.$refs.addApplyFor.switchModal();
      that.$refs.editApplyFor.switchModal();
    },
    acceptApplyFor: function (index) {
      const that = this;
      let id = that.applyForData[index].id;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/applications/${id}/accept`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
         
        that.applyForData = [];
        that.applyForData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    },
    rejectApplyFor: function (index) {
      const that = this;
      let id = that.applyForData[index].id;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/applications/${id}/reject`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
         
        that.applyForData = [];
        that.applyForData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    }
  },
  created() {
    this.token = sessionStorage.getItem('token');
    this.getApplyFor();
  },
  watch: {
  }
}
</script>

<style lang="scss">
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
</style>
