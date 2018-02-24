<!-- 查看组织 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input class="input search-input" type="text" placeholder="请输入你要查看的组织">
        <button class="button" type="button" name="button">查找组织</button>
      </div>
        <button @click="showModal()" class="button add-role-button" type="button" name="button">添加组织</button>
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
        <tr v-for="item in data">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.creator_id }}</td>
          <td>{{ item.describe}}</td>
          <td>{{ item.max }}</td>
          <td>{{ item.current }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
          <td>
            <button @click="deleteRole()" class="button" type="button" name="button">删除组织</button>
            <button  class="button" type="button" name="button">编辑组织</button>
            <button  class="button" type="button" name="button">查看成员</button>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="modal" :class="{'is-active' : isShowModal}">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">添加组织</p>
          <button @click="showModal()" class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
          <div class="box-item">
            <label>组织名称</label>
            <input class="input" type="text" placeholder="请输入组织名">
          </div>

          <div class="box-item">
            <label>组织名称</label>
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
              "id": 2,
              "name": "1班1111",
              "creator_id": "1",
              "describe": "职教师资1班",
              "max": "234",
              "current": "1",
              "created_at": "2018-01-13 08:04:13",
              "updated_at": "2018-01-13 08:08:55"
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
      let prompt = confirm("确认删除改组织吗？");
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
