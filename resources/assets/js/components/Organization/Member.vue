<!-- 查看成员 -->
<template lang="html">
  <div class="modal" v-bind:class="{'is-active': isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-content member-content">
      <div class="box member-box">
        <div>
          <div class="search-box">
            <input disabled v-model="searchKey" class="input search-input" type="text" placeholder="请输入关键字">
            <button disabled @click="searchMember()" class="button" type="button" name="button">查找成员</button>
          </div>
            <button @click="addMember()" class="button add-role-button" type="button" name="button">添加成员</button>
            <button @click="synchronizeMember()" class="button add-role-button" type="button" name="button">同步成员</button>
            <button @click="deleteMember()" class="button" type="button" name="button">删除成员</button>
        </div>
        <table class="table">
          <thead>
            <tr>
              <th>是否选中</th>
              <th>ID</th>
              <th>成员名</th>
              <th>邮箱</th>
              <th>手机</th>
              <th>QQ</th>
              <th>创建时间</th>
              <th>更新时间</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item,index) in memberData">
              <td><input type="checkbox" v-bind:value="item.id" v-model="selectedMember" class="permission-seleted"></td>
              <td>{{ item.id }}</td>
              <td>{{ item.name }}</td>
              <td>{{ item.email }}</td>
              <td>{{ item.phone }}</td>
              <td>{{ item.qq }}</td>
              <td>{{ GLOBAL.toTime(item.created_at) }}</td>
              <td>{{ GLOBAL.toTime(item.updated_at) }}</td>
            </tr>
          </tbody>
        </table>

        <pagination v-bind:pagination-data="paginationData"
                    v-model="data"
        ></pagination>

        <add-member ref="addMember"
                    v-bind:organization-id="organizationId"
                    v-on:getMember="getMember"
        ></add-member>

        <synchronize-member ref="synchronizeMember"
                            v-bind:organization-id="organizationId"
                            v-on:getMember="getMember"
        ></synchronize-member>
      </div>
    </div>
    <button @click="switchModal()" class="modal-close is-large" aria-label="close"></button>
  </div>
</template>

<script>
import Pagination from './../Pagination'
import SynchronizeMember from './SynchronizeMember'
import AddMember from './AddMember'

export default {
  data() {
    return {
      isShowModal: false,
      memberData: null,
      searchKey: null,
      editData: null,  // 当前编辑的成员数据
      paginationData: null,
      data: null,
      organizationId: null,
      selectedMember: [],
    }
  },
  components: {
    Pagination,
    SynchronizeMember,
    AddMember,
  },
  props: [
    'currentOrganizationData',
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    clearWords: function () {
      const that = this;
      that.memberData.id = '';
      that.memberData.name = '';
      that.memberData.email = '';
      that.memberData.number = '';
      that.memberData.phone = '';
      that.memberData.qq = '';
      that.memberData.created_at = '';
      that.memberData.updated_at = '';
      that.memberData.pivot.user_id = '';
      that.memberData.pivot.organization_id = '';
    },
    addMember: function() {
      const that = this;
      that.$refs.addMember.switchModal();
    },
    synchronizeMember: function () {
      const that = this;
      that.$refs.synchronizeMember.switchModal();
    },
    getMember: function () {
      const that = this;
      let id = that.currentOrganizationData['id'];
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/organizations/${id}/users`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.memberData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
    searchMember: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/organizations/${that.searchKey}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.memberData = [];
        that.memberData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    },
    deleteMember: function () {
      const that = this;
      if (!that.selectedMember) {
        alert('请选择需要删除的成员');
      }
      let id = that.organizationId;
      let params = this.GLOBAL.computedParams(that.selectedMember, 'users');
      let prompt = confirm("确认删除该成员吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/organizations/${id}/users?${params}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': sessionStorage.getItem('token'),
          }
        }).then(res => {
          alert('删除成功！');
          that.getMember();
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
      that.organizationData = value.data;
      that.paginationData = value.links;
    },
    currentOrganizationData: function (value, oldValue) {
      const that = this;
      that.organizationId = value.id;
      this.getMember();
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
.member-box {
  width: 1300px;
}
.member-content {
  width: 1300px;
}
</style>
