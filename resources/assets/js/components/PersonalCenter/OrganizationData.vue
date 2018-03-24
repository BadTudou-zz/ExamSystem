<!-- 查看组织 -->
<template lang="html">
  <div class="box">
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
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in organizationData">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.creator_id }}</td>
          <td>{{ item.description }}</td>
          <td>{{ item.max }}</td>
          <td>{{ item.current }}</td>
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
import Pagination from './../Pagination'

export default {
  data() {
    return {
      token: null,
      organizationData: null,
      isShowModal: false,
      searchKey: null,
      editData: null,  // 当前编辑的组织数据
      paginationData: null,
      data: null,
      currentOrganizationData: null,
      userId: null,
      
    }
  },
  components: {
    Pagination,
  },
  methods: {
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
        that.organizationData = res.data.data;
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
    this.getOrganization();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.organizationData = value.data;
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
