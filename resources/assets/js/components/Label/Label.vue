<!-- 查看标签 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入你要查看的标签">
        <button @click="searchLabel()" class="button" type="button" name="button">查找标签</button>
      </div>
        <button @click="addLabel()" class="button add-role-button" type="button" name="button">添加标签</button>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>标签标题</th>
          <th>commentabl_type</th>
          <th>创建者ID</th>
          <th>创建时间</th>
          <th>更新时间</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in labelData">
          <td>{{ item.id }}</td>
          <td>{{ item.title }}</td>
          <td>{{ item.commentabl_type }}</td>
          <td>{{ item.creator_id }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
          <td>
            <button @click="deleteLabel()" class="button" type="button" name="button">删除标签</button>
            <button @click="editLabel()" class="button" type="button" name="button">编辑标签</button>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="modal" :class="{'is-active' : isShowModal}">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">添加标签</p>
          <button @click="showModal()" class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
          <div class="box-item">
            <label>标签名称</label>
            <input class="input" type="text" placeholder="请输入标签名">
          </div>

          <div class="box-item">
            <label>标签名称</label>
            <input class="input" type="text">
          </div>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-success">确认</button>
          <button  @click="showModal()" class="button">取消</button>
        </footer>
      </div>
    </div>

    <add-label ref="addLabel"></add-label>
    <edit-label ref="editLabel" v-bind:edit-data="editData"></edit-label>
  </div>
</template>

<script>
import AddLabel from './AddLabel'
import EditLabel from './EditLabel'
export default {
  data() {
    return {
      labelData: [
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
      // labelData: null,
      editData: null,
      searchKey: null,
    }
  },
  components: {
    AddLabel,
    EditLabel,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    deleteLabel: function (index) {
      const that = this;
      // let id = that.labelData[index].id;
      let prompt = confirm("确认删除该标签吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/tags/${id}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': that.token
          }
        }).then(res => {
          that.labelData = res.data.data;
        }).catch(err => {
          console.log(err)
        })
      }
    },
    searchLabel: function () {
      const that = this;
      let id = that.searchKey;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/tags/${id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.labelData = [];
        that.labelData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    },
    getLabel: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/tags`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
         
        that.labelData = [];
        that.labelData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    },
    addLabel: function () {
      const that = this;
      that.$refs.addLabel.switchModal();
    },
    editLabel: function (index) {
      const that = this;
      that.editData = that.labelData[index];
      // that.$refs.addLabel.switchModal();
      that.$refs.editLabel.switchModal();
    },
    acceptLabel: function (index) {
      const that = this;
      let id = that.labelData[index].id;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/applications/${id}/accept`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
         
        that.labelData = [];
        that.labelData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    },
    rejectLabel: function (index) {
      const that = this;
      let id = that.labelData[index].id;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/applications/${id}/reject`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
         
        that.labelData = [];
        that.labelData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    }
  },
  created() {
    this.token = sessionStorage.getItem('token');
    // this.getLabel();
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
