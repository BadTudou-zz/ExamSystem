<!-- 查看成员 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input v-model="organizationId" class="input search-input" type="text" placeholder="请输入你要查看的成员">
        <button @click="searchMember()" class="button" type="button" name="button">查找成员</button>
      </div>
        <button @click="addMember()" class="button add-role-button" type="button" name="button">添加成员</button>
        <button @click="synchronizeMember()" class="button add-role-button" type="button" name="button">同步成员</button>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>成员名</th>
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
        <tr v-for="item in MemberData">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.creator_id }}</td>
          <td> {{ item.description }}</td>
          <td>{{ item.max }}</td>
          <td>{{ item.current }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
          <td>
            <button @click="deleteMember(index)" class="button" type="button" name="button">删除成员</button>
            <button @click="synchronizeMember(index)"  class="button" type="button" name="button">编辑成员</button>
            <button  class="button" type="button" name="button">查看成员</button>
          </td>
        </tr>
      </tbody>
    </table>

    <add-member ref="addMember"></add-member>
    <synchronize-member ref="synchronizeMember"  :edit-data="editData"></synchronize-member>
  </div>
</template>

<script>
import AddMember from './AddMember'
import SynchronizeMember from './SynchronizeMember'

export default {
  data() {
    return {
      token: null,
      "MemberData": [
          {
              "id": 1,
              "name": "admin",
              "email": "admin@email.com",
              "number": null,
              "phone": null,
              "qq": null,
              "created_at": "2018-01-13 07:59:11",
              "updated_at": "2018-01-13 07:59:11",
              "pivot": {
                  "user_id": "2",
                  "organization_id": "1"
              }
          }
      ],
      isShowModal: false,
      // MemberData: null,
      organizationId: null,
      editData: null,  // 当前编辑的成员数据
    }
  },
  components: {
    AddMember,
    SynchronizeMember,
  },
  methods: {
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
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/organizations/2/users`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.memberData = res.data.data;
         
      }).catch(err => {
        console.log(err)
      })
    },
    searchMember: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/organizations/${that.organizationId}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.memberData = [];
        that.memberData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    },
    // 删除成员 ??删除需要的参数
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
            'Authorization': that.token
          }
        }).then(res => {
        }).catch(err => {
          console.log(err)
        })
      }
    }
  },
  created() {
    this.token = sessionStorage.getItem('token');
    // this.getMember();
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
