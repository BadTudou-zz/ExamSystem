<!-- 查看课程 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input class="input search-input" type="text" placeholder="请输入你要查看的课程">
        <button class="button" type="button" name="button">查找课程</button>
      </div>
        <button @click="showModal()" class="button add-role-button" type="button" name="button">添加课程</button>
        <button class="button add-role-button" type="button" name="button">同步课程</button>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>课程名</th>
          <th>课程别名</th>
          <th>课程数</th>
          <th>课程描述</th>
          <th>创建时间</th>
          <th>更新时间</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in data">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.display_name }}</td>
          <td>{{ item.number }}</td>
          <td>{{ item.describe }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
          <td>
            <button @click="deleteRole()" class="button" type="button" name="button">删除课程</button>
            <button  class="button" type="button" name="button">编辑课程</button>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="modal" :class="{'is-active' : isShowModal}">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">添加课程</p>
          <button @click="showModal()" class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
          <div class="box-item">
            <label>课程名称</label>
            <input class="input" type="text" placeholder="请输入课程名">
          </div>

          <div class="box-item">
            <label>课程名称</label>
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
            "name": "english",
            "number": "123",
            "display_name": "英语",
            "descripe": "这是英语课程",
            "created_at": "2018-01-19 15:01:45",
            "updated_at": "2018-01-19 15:01:45"
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
      let prompt = confirm("确认删除改课程吗？");
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
