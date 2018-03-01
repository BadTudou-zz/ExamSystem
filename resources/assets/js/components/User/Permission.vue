<!-- 查看权限 -->
<template lang="html">
  <div class="box">
    <table class="table">
      <thead>
        <tr>
          <th>项目ID</th>
          <th>权限ID</th>
          <th>权限名</th>
          <th>别名</th>
          <th>描述</th>
          <th>创建时间</th>
          <th>更新时间</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in permissionData">
          <td>{{ item.id }}</td>
          <td>{{ item.pivot.permission_id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.display_name }}</td>
          <td>{{ item.description }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
        </tr>
      </tbody>
    </table>

    <div class="modal" :class="{'is-active' : isShowModal}">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">添加权限</p>
          <button @click="showModal()" class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
          <div class="box-item">
            <label>权限名称</label>
            <input class="input" type="text" placeholder="请输入权限名">
          </div>

          <div class="box-item">
            <label>权限名称</label>
            <input class="input" type="text">
          </div>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-success">确认</button>
          <button  @click="showModal()" class="button">取消</button>
        </footer>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isShowModal: false,
      permissionData: null,
    }
  },
  components: {
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    // 查看权限
    getPermission: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/1/permissions/`,
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
  },
  created() {
    this.token = sessionStorage.getItem('token');
    this.getPermission();
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
