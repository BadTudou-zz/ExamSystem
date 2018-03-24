<!-- 查看角色 -->
<template lang="html">
  <div class="box">
    <h3 class="title">角色</h3>

    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>用户名</th>
          <th>别名</th>
          <th>创建时间</th>
          <th>更新时间</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in roleData">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.display_name }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
        </tr>
      </tbody>
    </table>

    <pagination v-bind:pagination-data="paginationData"
                v-model="data"
    ></pagination>

  </div>
</template>

<script>
import Pagination from './../Pagination.vue'

export default {
  data() {
    return {
      token: '',
      roleData: null,
      isShowModal: false,
      searchKey: null,
      paginationData: null,
      data: null,
      currentRoleData: null,
      userId: null,

    }
  },
  components: {
    Pagination,
  },
  methods: {
    switchModal: function () {
      const that = this;
      that.$refs.addRole.switchModal();
    },
    getRole: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/${that.userId}/roles/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.roleData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
  },
  computed: {
  },
  created() {
    this.userId = sessionStorage.getItem('userId');
    this.token = sessionStorage.getItem('token');
    this.getRole();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.roleData = value.data;
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
.title {
  color: #363636;
  font-size: 1.5rem;
  font-weight: 600;
  line-height: 1.125;
}
</style>
