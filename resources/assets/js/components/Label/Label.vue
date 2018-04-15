<!-- 查看标签 -->
<template lang="html">
  <div class="box">
    <div>
      <div v-show="isShowSearchLabel" class="search-box">
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
        <tr v-for="(item,index) in labelData">
          <td>{{ item.id }}</td>
          <td>{{ item.title }}</td>
          <td>{{ item.commentabl_type }}</td>
          <td>{{ item.creator_id }}</td>
          <td>{{ GLOBAL.toTime(item.created_at) }}</td>
          <td>{{ GLOBAL.toTime(item.updated_at) }}</td>
          <td>
            <button v-show="isShowDeleteLabel" @click="deleteLabel(index)" class="button" type="button" name="button">删除标签</button>
            <button @click="editLabel(index)" class="button" type="button" name="button">编辑标签</button>
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

    <add-label ref="addLabel"
                   v-on:getLabel="getLabel"></add-label>

    <edit-label ref="editLabel"
                v-on:getLabel="getLabel"
                v-bind:edit-data="editData"
    ></edit-label>


    <pagination v-bind:pagination-data="paginationData"
            v-model="data"
    ></pagination>
  </div>
</template>

<script>
import AddLabel from './AddLabel'
import EditLabel from './EditLabel'
import Pagination from './../Pagination.vue'

export default {
  data() {
    return {
      isShowModal: false,
      searchKey: null,
      labelData: [],
      editData: null,
      searchKey: null,
      paginationData: null,
      data: null,
    }
  },
  components: {
    AddLabel,
    EditLabel,
    Pagination,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    deleteLabel: function (index) {
      const that = this;
      let id = that.labelData[index].id;
      let prompt = confirm("确认删除该标签吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/tags/${id}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': sessionStorage.getItem('token'),
          }
        }).then(res => {
          alert('删除成功');
          that.getLabel();
        }).catch(err => {
          alert('删除失败');
          console.log(err);
        })
      }
    },
    searchLabel: function () {
      const that = this;
      that.labelData = [];
      let id = that.searchKey;
      if (!that.searchKey) {
        that.searchKey = '';
        that.getLabel();
        return;
      }
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/tags/${id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.labelData.push(res.data.data);
      }).catch(err => {
        alert('暂无相关数据，已加载全部数据');
        that.getLabel();
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
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.labelData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
    addLabel: function () {
      const that = this;
      // Multiple addition invalid  ??
      that.$refs.addLabel.switchModal();
    },
    editLabel: function (index) {
      const that = this;
      that.editData = that.labelData[index];
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
          'Authorization': sessionStorage.getItem('token'),
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
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {

        that.labelData = [];
        that.labelData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    }
  },
  computed: {
    isShowSearchLabel() {
      // return true;
      return sessionStorage.getItem('permissions').includes('tag-show');
    },
    isShowUpdateLabel() {
      // return true;
      return sessionStorage.getItem('permissions').includes('tag-update');
    },
    isShowDeleteLabel() {
      // return true;
      return sessionStorage.getItem('permissions').includes('tag-destroy');
    },
  },
  created() {

    this.getLabel();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.permissionData = value.data;
      that.paginationData = value.links;
    }
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
