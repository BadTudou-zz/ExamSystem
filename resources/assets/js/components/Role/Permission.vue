<!-- 查看权限 -->
<template lang="html">
  <div class="modal" v-bind:class="{'is-active': isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-content permission-content">
      <div class="box permission-box">
        <div>
            <button @click="addPermission()" class="button add-permission-button" type="button" name="button">添加权限</button>
            <button @click="synchronizePermission()" class="button add-permission-button" type="button" name="button">同步权限</button>
            <!-- <button @click="deletePermission()" class="button" type="button" name="button">删除权限</button> -->
            <div @click="deletePermission()" class="icon-button"><i class="far fa-trash-alt"></i></div>
        </div>
        <table class="table">
          <thead>
            <tr>
              <th>是否选中</th>
              <th>序号</th>
              <th>名称</th>
              <th>描述</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item,index) in permissionData">
              <td><input type="checkbox" v-bind:value="item.id" v-model="selectedPermission" class="permission-seleted"></td>
              <td>{{ item.id }}</td>
              <td>{{ item.name }}</td>
              <td><p class="limit-words">{{ item.description }}</p></td>
            </tr>
          </tbody>
        </table>

        <pagination v-bind:pagination-data="paginationData"
                    v-model="data"
        ></pagination>

      </div>
    </div>
    <button @click="switchModal()" class="modal-close is-large" aria-label="close"></button>


    <add-permission ref="addPermission"
                    v-bind:role-id="roleId"
                    v-on:getPermission="getPermission"
    ></add-permission>

    <synchronize-permission ref="synchronizePermission"
                            v-bind:role-id="roleId"
                            v-on:getPermission="getPermission"
    ></synchronize-permission>

  </div>
</template>

<script>
import Pagination from './../Pagination'
import AddPermission from './AddPermission'
import SynchronizePermission from './SynchronizePermission'

export default {
  data() {
    return {
      isShowModal: false,
      permissionData: [],
      paginationData: null,
      data: null,
      roleId: null,
      selectedPermission: [],

      // url: '',
      // currentPermission: [],
      // allPermission: [],
      // isLoading: true,
    }
  },
  components: {
    Pagination,
    AddPermission,
    SynchronizePermission,
  },
  props: [
    'currentRoleData',
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    getJsonLength: function (json) {
      const that = this;
      let jsonLength = 0;
      for (let i in json) {
          jsonLength++;
      }
      return jsonLength;
    },
    getPermission: function () {
      const that = this;
      let id = that.roleId;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/roles/${id}/permissions`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.permissionData = res.data.data;

        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
    deletePermission: function (index) {
      const that = this;
      let id = that.roleId;
      let params = this.GLOBAL.computedParams(that.selectedPermission, 'permissions');
      let prompt = confirm("确认删除该权限吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/roles/${id}/permissions?${params}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': sessionStorage.getItem('token'),
          }
        }).then(res => {
          alert('删除成功！');
          that.getPermission();
        }).catch(err => {
          alert('删除失败，请稍后再试')
          console.log(err)
        })
      }
    },
    addPermission: function () {
      const that = this;
      that.$refs.addPermission.switchModal();
    },
    synchronizePermission: function () {
      const that = this;
      that.$refs.synchronizePermission.switchModal();
    },
  },
  created() {
    this.permissionData = [];
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.permissionData = value.data;
      that.paginationData = value.links;
    },
    currentRoleData: function (value, oldValue) {
      const that = this;
      that.roleId = value.id;
      that.getPermission();
    },
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
.permission-content {
  width: 1300px;
}

</style>
