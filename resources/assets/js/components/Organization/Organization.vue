<!-- 查看组织 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input v-model="organizationId" class="input search-input" type="text" placeholder="请输入你要查看的组织">
        <button @click="searchOrganization()" class="button" type="button" name="button">查找组织</button>
      </div>
        <button @click="addOrganization()" class="button add-role-button" type="button" name="button">添加组织</button>
        <button class="button add-role-button" type="button" name="button">同步组织</button>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>组织名</th>
          <th>创建者ID</th>
          <th>描述</th>
          <th>最大容量</th>
          <th>当前容量</th>
          <th>创建时间</th>
          <th>更新时间</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in OrganizationData">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.creator_id }}</td>
          <td> {{ item.description }}</td>
          <td>{{ item.max }}</td>
          <td>{{ item.current }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
          <td>
            <button @click="deleteOrganization(index)" class="button" type="button" name="button">删除组织</button>
            <button @click="editOrganization(index)"  class="button" type="button" name="button">编辑组织</button>
            <button  class="button" type="button" name="button">查看成员</button>
          </td>
        </tr>
      </tbody>
    </table>

    <add-organization ref="addOrganization"></add-organization>
    <edit-organization ref="editOrganization"  :edit-data="editData"></edit-organization>

  </div>
</template>

<script>
import AddOrganization from './AddOrganization'
import EditOrganization from './EditOrganization'

export default {
  data() {
    return {
      token: null,
      "OrganizationData": [
          {
              "id": 2,
              "name": "1班1111",
              "creator_id": "1",
              "": "职教师资1班",
              "max": "234",
              "current": "1",
              "created_at": "2018-01-13 08:04:13",
              "updated_at": "2018-01-13 08:08:55"
          }
      ],
      isShowModal: false,
      // OrganizationData: null,
      organizationId: null,
      editData: null,  // 当前编辑的组织数据
    }
  },
  components: {
    AddOrganization,
    EditOrganization,
  },
  methods: {
    addOrganization: function() {
      const that = this;
      that.$refs.addOrganization.switchModal();
    },
    editOrganization: function (index) {
      const that = this;
      that.$refs.editOrganization.switchModal();
    },
    getOrganization: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/organizations`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.permissionData = res.data.data;
      }).catch(err => {
        console.log(err)
      })
    },
    searchOrganization: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/organizations/${that.organizationId}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.permissionData = [];
        that.permissionData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    },
    // 删除组织 ??删除需要的参数
    deleteOrganization: function (index) {
      const that = this;
      let id = that.organizationData[index]['id'];
      axios({
        method: 'delete',
        url: `${this.GLOBAL.localDomain}/api/v1/organizations/${id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
      }).catch(err => {
        console.log(err)
      })
    }
  },
  created() {
    this.token = sessionStorage.getItem('token');
    this.getOrganization();
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
