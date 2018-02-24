<!-- 查看章节 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input class="input search-input" type="text" placeholder="请输入你要查看的章节">
        <button class="button" type="button" name="button">查找章节</button>
      </div>
        <button @click="showModal()" class="button add-role-button" type="button" name="button">添加章节</button>
        <button class="button add-role-button" type="button" name="button">同步章节</button>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>章节名称</th>
          <th>描述</th>
          <th>问题类型</th>
          <th>成绩总值</th>
          <th>数量</th>
          <th>问题</th>
          <th>创建时间</th>
          <th>更新时间</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in data">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.describe }}</td>
          <td>{{ item.question_type }}</td>
          <td>{{ item.score }}</td>
          <td>{{ item.number }}</td>
          <td>{{ item.questions }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
          <td>
            <button @click="deleteRole()" class="button" type="button" name="button">删除章节</button>
            <button  class="button" type="button" name="button">编辑章节</button>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="modal" :class="{'is-active' : isShowModal}">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">添加章节</p>
          <button @click="showModal()" class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
          <div class="box-item">
            <label>章节名称</label>
            <input class="input" type="text" placeholder="请输入章节名">
          </div>

          <div class="box-item">
            <label>章节名称</label>
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
              "id": 8,
              "name": "选择题12312",
              "describe": "单选",
              "question_type": "SINGLE_CHOICE",
              "score": 100,
              "number": 100,
              "questions": null,
              "created_at": "2018-02-04 07:31:25",
              "updated_at": "2018-02-04 07:52:05"
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
      let prompt = confirm("确认删除改章节吗？");
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
