<!-- 查看成员 -->
<template lang="html">
  <div class="modal" v-bind:class="{'is-active': isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-content member-content">
      <div class="box member-box">
        <div>
          <div class="search-box">
            <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入你要查看的成员">
            <button @click="searchMember()" class="button" type="button" name="button">查找成员</button>
          </div>
            <button @click="addMember()" class="button add-role-button" type="button" name="button">添加成员</button>
            <button @click="synchronizeMember()" class="button add-role-button" type="button" name="button">同步成员</button>
        </div>
        <table class="table">
          <thead>
            <tr>
              <!-- <th>ID</th> -->
              <th>成员名</th>
              <!-- <th>创建者ID</th> -->
              <th>描述</th>
              <th>最大容量</th>
              <th>当前容量</th>
              <th>创建时间</th>
              <th>更新时间</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item,index) in memberData">
              <!-- <td>{{ item.id }}</td> -->
              <td>{{ item.name }}</td>
              <!-- <td>{{ item.creator_id }}</td> -->
              <td>{{ item.description }}</td>
              <td>{{ item.max }}</td>
              <td>{{ item.current }}</td>
              <td>{{ item.created_at }}</td>
              <td>{{ item.updated_at }}</td>
              <td>
                <button @click="deleteMember(index)" class="button" type="button" name="button">删除成员</button>
                <!-- <button @click="synchronizeMember(index)"  class="button" type="button" name="button">编辑成员</button> -->
                <!-- <button  class="button" type="button" name="button">查看成员</button> -->
              </td>
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
    synchronizeMember: function (index) {
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
    deleteMember: function (index) {
      const that = this;
      let id = that.memberData[index]['id'];
      let prompt = confirm("确认删除该成员吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/organizations/${id}/users`,
          headers: {
            'Accept': 'application/json',
            'Authorization': sessionStorage.getItem('token'),
          }
        }).then(res => {
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
