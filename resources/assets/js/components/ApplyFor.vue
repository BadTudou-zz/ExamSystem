<!-- 查看申请 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input class="input search-input" type="text" placeholder="请输入你要查看的申请">
        <button class="button" type="button" name="button">查找申请</button>
      </div>
        <button @click="showModal()" class="button add-role-button" type="button" name="button">添加申请</button>
    </div>
    <table class="table">
      <thead>
        <tr>
          <!-- <th>ID</th> -->
          <th>申请类型</th>
          <th>申请ID</th>
          <th>申请类型</th>
          <!-- <th>内容</th> -->
          <th>创建时间</th>
          <th>更新时间</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <!-- "id": "53e20281-90ee-4d1e-824e-ac45ac138446",
          "type": "App\\Notifications\\ApplicationNotification",
          "notifiable_id": "1",
          "notifiable_type": "App\\User",
          "data": "{\"notifiable_id\":\"1\",\"action\":\"create\",\"resource_id\":\"1\",\"resource_type\":\"Organization\",\"data\":\"\\u8fd9\\u662f\\u79c1\\u4fe1\"}",
          "read_at": null,
          "created_at": "2018-01-21 14:04:22",
          "updated_at": "2018-01-21 14:04:22" -->
        <tr v-for="item in data">
          <!-- <td>{{ item.id }}</td> -->
          <td>{{ item.type }}</td>
          <td>{{ item.notifiable_id }}</td>
          <td>{{ item.notifiable_type }}</td>
          <!-- <td>{{ item.data }}</td> -->
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
          <td>
            <button @click="deleteRole()" class="button" type="button" name="button">删除申请</button>
            <button  class="button" type="button" name="button">编辑申请</button>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="modal" :class="{'is-active' : isShowModal}">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">添加申请</p>
          <button @click="showModal()" class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
          <div class="box-item">
            <label>申请名称</label>
            <input class="input" type="text" placeholder="请输入申请名">
          </div>

          <div class="box-item">
            <label>申请名称</label>
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
      "data": [
           {
               "id": "53e20281-90ee-4d1e-824e-ac45ac138446",
               "type": "App\\Notifications\\ApplicationNotification",
               "notifiable_id": "1",
               "notifiable_type": "App\\User",
               "data": "{\"notifiable_id\":\"1\",\"action\":\"create\",\"resource_id\":\"1\",\"resource_type\":\"Organization\",\"data\":\"\\u8fd9\\u662f\\u79c1\\u4fe1\"}",
               "read_at": null,
               "created_at": "2018-01-21 14:04:22",
               "updated_at": "2018-01-21 14:04:22"
           }
       ],
      isShowModal: false,
    }
  },
  components: {
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    deleteRole: function () {
      const that = this;
      let prompt = confirm("确认删除改申请吗？");
      if (prompt) {

      }
    }
  },
  created() {
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
