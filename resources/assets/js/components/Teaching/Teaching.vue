<!-- 查看授课 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入你要查看的授课">
        <button @click="searchTeaching()" class="button" type="button" name="button">查找授课</button>
      </div>
        <button @click="addTeaching()" class="button add-role-button" type="button" name="button">添加授课</button>
        <button class="button add-role-button" type="button" name="button">同步授课</button>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>授课名</th>
          <th>用户ID</th>
          <th>课程ID</th>
          <th>允许组织的ID</th>
          <th>允许用户的ID</th>
          <th>描述</th>
          <th>最大容量</th>
          <th>当前容量</th>
          <th>创建时间</th>
          <th>更新时间</th>
          <th>操作</th>
        </tr>
      </thead>
    <tbody>
        <tr v-for="(item,index) in teachingData">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.user_id }}</td>
          <td>{{ item.course_id }}</td>
          <td>{{ item.allowable_organization_ids }}</td>
          <td>{{ item.allowable_user_ids }}</td>
          <td> {{ item.description }}</td>
          <td>{{ item.max }}</td>
          <td>{{ item.current }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
          <td>
            <button @click="deleteTeaching(index)" class="button is-small" type="button" name="button">删除授课</button>
            <button @click="editTeaching(index)" class="button is-small" type="button" name="button">编辑授课</button>
          </td>
        </tr>
      </tbody>
    </table>

    <add-teaching ref="addTeaching"></add-teaching>
    <edit-teaching ref='editTeaching'></edit-teaching>
  </div>
</template>

<script>
import AddTeaching from './AddTeaching'
import EditTeaching from './EditTeaching'
export default {
  data() {
    return {
      teachingData: [
        {
            "id": 2,
            "name": "1班的英语",
            "user_id": "1",
            "course_id": "3",
            "allowable_organization_ids": "1",
            "allowable_user_ids": "",
            "": "这是描述",
            "max": "20",
            "current": "1",
            "created_at": "2018-01-19 16:14:27",
            "updated_at": "2018-01-19 16:14:27"
        }
      ],
      isShowModal: false,
      // teachingData: null,
      searchKey: null,
      editData: null,
    }
  },
  components: {
    AddTeaching,
    EditTeaching,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    getTeaching: function() {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/lectures`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.teachingData = res.data.data;
         
      }).catch(err => {
        console.log(err)
      })
    },
    searchTeaching: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/lectures/${that.searchKey}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.roleData = [];
        that.roleData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    },
    deleteTeaching: function (index) {
      const that = this;
      let id = that.teachingData[index]['id'];
      let prompt = confirm("确认删除该授课？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/lectures/${id}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': that.token
          }
        }).then(res => {
          that.teachingData = res.data.data;
        }).catch(err => {
          console.log(err)
        })
      }
    },
    editTeaching: function (index) {
      const that = this;
      that.editData = that.teachingData[index];
      that.$refs.editTeaching.switchModal();
    },
    addTeaching: function () {
      const that = this;
      that.$refs.addTeaching.switchModal();
    }
  },
  created() {
    this.token = sessionStorage.getItem('token');
    // this.getTeaching();
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
