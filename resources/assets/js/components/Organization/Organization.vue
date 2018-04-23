<!-- 查看组织 -->
<template lang="html">
  <div class="box">
    <div>
      <div v-show="isShowSearchOrganization" class="search-box">
        <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入关键字">
        <!-- <button disabled @click="searchOrganization()" class="button" type="button" name="button">查找组织</button> -->
        <div @click="searchOrganization()" class="search-button"><i class="fas fa-search"></i></div>
      </div>
      <button v-show="isShowCreateOrganization" @click="addOrganization()" class="button add-role-button" type="button" name="button">添加组织</button>
      <button class="button add-role-button" type="button" name="button">同步组织</button>
    </div>

    <p v-if="!organizationData" class="empty-message-prompt">暂无组织</p>
    <table v-else class="table is-bordered is-striped is-hoverable is-fullwidths">
      <thead>
        <tr>
          <th>ID</th>
          <th>组织名</th>
          <th>创建者ID</th>
          <th>描述</th>
          <th>最大容纳人数</th>
          <th>当前人数</th>
          <th>创建时间</th>
          <th>更新时间</th>
          <th>组织操作</th>
          <th>成员操作</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in organizationData">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.creator_id }}</td>
          <td><p class="limit-words">{{ item.describe }}</p></td>
          <td>{{ item.max }}</td>
          <td>{{ item.current }}</td>
          <td>{{ GLOBAL.toTime(item.created_at) }}</td>
          <td>{{ GLOBAL.toTime(item.updated_at) }}</td>
          <td>
            <button  v-show="isShowDeleteOrganization" @click="deleteOrganization(index)" class="delete" type="button" name="button">删除组织</button>
            <div @click="editOrganization(index)" class="icon-button"><i class="fas fa-edit"></i></div>
          </td>
          <td>
            <button @click="showMember(index)"  class="is-small button" type="button" name="button">查看成员</button>
          </td>
        </tr>
      </tbody>
    </table>

    <add-organization ref="addOrganization"
                      v-on:getOrganization="getOrganization"
    ></add-organization>

    <edit-organization ref="editOrganization"
                       v-on:getOrganization="getOrganization"
                       v-bind:edit-data="editData"
    ></edit-organization>

    <member ref="member"
            v-bind:current-organization-data="currentOrganizationData"
    ></member>

    <pagination v-show="searchResult.length === 0"
                v-bind:pagination-data="paginationData"
                v-model="data"
    ></pagination>

  </div>
</template>

<script>
import AddOrganization from './AddOrganization'
import EditOrganization from './EditOrganization'
import Pagination from './../Pagination'
import Member from './Member'

export default {
  data() {
    return {
      organizationData: [],
      isShowModal: false,
      searchKey: null,
      editData: null,  // 当前编辑的组织数据
      paginationData: null,
      data: null,
      currentOrganizationData: null,
      // get all organization
      currentOrganization: [],
      allOrganization: [],
      searchResult: [],
    }
  },
  components: {
    AddOrganization,
    EditOrganization,
    Pagination,
    Member,
  },
  methods: {
    addOrganization: function() {
      const that = this;
      that.$refs.addOrganization.switchModal();
    },
    editOrganization: function (index) {
      const that = this;
      that.editData = that.organizationData[index];
      that.$refs.editOrganization.switchModal();
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
        that.organizationData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
    // searchOrganization: function () {
    //   const that = this;
    //   that.organizationData = [];
    //   if (!that.searchKey) {
    //     that.searchKey = '';
    //     that.getOrganization();
    //     return;
    //   }
    //   axios({
    //     method: 'get',
    //     url: `${this.GLOBAL.localDomain}/api/v1/organizations/${that.searchKey}`,
    //     headers: {
    //       'Accept': 'application/json',
    //       'Authorization': sessionStorage.getItem('token'),
    //     }
    //   }).then(res => {
    //     that.organizationData.push(res.data.data);
    //   }).catch(err => {
    //     console.log(err)
    //   })
    // },

    searchOrganization: function () {
      const that = this;
      // 如果没有搜索值
      if (!that.searchKey) {
        that.getOrganization();
        that.searchResult = [];
        return;
      }
      // 如果已经获取全部数据
      else if (that.allOrganization.length > 0) {
        let allData  = that.allOrganization;
        let len = that.allOrganization.length;
        let res = [];

        for (let i = 0; i < len; i++) {
          for (let j in allData[i]) {
            if (allData[i][j]) {
              if ((allData[i][j].toString()).indexOf(that.searchKey) !== -1) {
                res.push(allData[i]);
                break;
              }
            }
          }
        }
        that.searchResult = res;
        that.organizationData = res;
      }
      // 如果有搜索值并且还未获取全部数据
      else {
        let url = `${this.GLOBAL.localDomain}/api/v1/organizations/`;
        that.getAllOrganization(url);
      }
    },
    getAllOrganization: function (url) {
      const that = this;
      let urlPath = url ? url : that.url
      axios({
        method: 'get',
        url: urlPath,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.url = res.data.links.next;

        let len = res.data.data.length ? res.data.data.length : that.getJsonLength(res.data.data);

        // data数据结构不一致 可能是数组/也可能是json
        if (res.data.data.length) {
          for (let i = 0; i < len; i++) {
            that.currentOrganization.push(res.data.data[i]);
          }
        }
        else if (that.getJsonLength(res.data.data)) {
          for (let i in res.data.data) {
            that.currentOrganization.push(res.data.data[i]);
          }
        }

        if (that.url) {
          that.getAllOrganization(that.url);
        }
        else {
          that.allOrganization = that.currentOrganization;
        }
      }).catch(err => {
        console.log(err);
      })
    },
    deleteOrganization: function (index) {
      const that = this;
      let id = that.organizationData[index]['id'];
      let prompt = confirm("确认删除该组织吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/organizations/${id}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': sessionStorage.getItem('token'),
          }
        }).then(res => {
          alert('删除成功');
          that.getOrganization();
        }).catch(err => {
          alert('删除失败');
          console.log(err)
        })
      }
    },
    showMember: function (index) {
      const that = this;
      that.currentOrganizationData = that.organizationData[index];
      that.$refs.member.switchModal();
    },
    addMember: function (index) {
      const that = this;
      that.currentOrganizationData = that.organizationData[index];
      that.$refs.addMember.switchModal();
    },
  },
  computed: {
    isShowCreateOrganization() {
      // return true;
      return sessionStorage.getItem('permissions').includes('organization-store')
    },
    isShowSearchOrganization() {
      // return true;
      return sessionStorage.getItem('permissions').includes('organization-show')
    },
    isShowDeleteOrganization() {
      // return true;
      return sessionStorage.getItem('permissions').includes('organization-destroy')
    },
  },
  created() {
    this.getOrganization();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.organizationData = value.data;
      that.paginationData = value.links;
    },
    allOrganization: function (value, oldValue) {
      const that = this;
      that.searchOrganization(that.searchKey);
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
