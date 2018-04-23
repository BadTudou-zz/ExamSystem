<!-- 查看权限 -->
<template lang="html">
  <div class="box">
    <h3 class="title">权限</h3>

    <p v-if="!permissionData" class="empty-message-prompt">暂无权限</p>

    <table v-else class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>权限名</th>
          <th>别名</th>
          <th>描述</th>
          <th>创建时间</th>
          <th>更新时间</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in permissionData">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.display_name }}</td>
          <td><p class="limit-words">{{ item.description }}</p></td>
          <td>{{ GLOBAL.toTime(item.created_at) }}</td>
          <td>{{ GLOBAL.toTime(item.updated_at) }}</td>
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
      permissionData: null,
      isShowModal: false,
      permissionId: null,
      paginationData: null,
      data: null,  // from Pagination.vue
    }
  },
  components: {
    Pagination,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    getPermission: function (page = 1) {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/${sessionStorage.getItem('userId')}/permissions/`,
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
  },
  computed: {
  },
  created() {
    this.getPermission();
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
.add-permission-button {
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
