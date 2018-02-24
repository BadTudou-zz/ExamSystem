<!-- 查看考试 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input class="input search-input" type="text" placeholder="请输入你要查看的考试">
        <button class="button" type="button" name="button">查找考试</button>
      </div>
        <button @click="showModal()" class="button add-role-button" type="button" name="button">添加考试</button>
    </div>
    <table class="table">
      <thead>
        <tr>
          <!-- "id": 1,
          "creator_id": 1,
          "title": "期末考试啊",
          "paper_id": 1,
          "exam_type": "OPEN",
          "score": 100,
          "min": 1,
          "describe": "单选",
          "allowable_lecture_ids": "0",
          "allowable_orgaization_ids": "0",
          "allowable_user_ids": "0",
          "begin_at": "2018-12-12 10:10:12",
          "start_at": null,
          "finish_at": null,
          "created_at": "2018-02-05 03:50:07",
          "updated_at": "2018-02-05 03:51:10" -->
          <th>ID</th>
          <th>创建者ID</th>
          <th>考试标题</th>
          <th>试卷ID</th>
          <th>考试类型</th>
          <th>成绩总值</th>
          <th>最小</th>
          <th>描述</th>
          <th>创建时间</th>
          <th>更新时间</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in data">
          <td>{{ item.id }}</td>
          <td>{{ item.creator_id }}</td>
          <td>{{ item.title }}</td>
          <td>{{ item.paper_id }}</td>
          <td>{{ item.exam_type }}</td>
          <td>{{ item.score }}</td>
          <td>{{ item.min }}</td>
          <td>{{ item.describe }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
          <td>
            <button @click="deleteRole()" class="button" type="button" name="button">删除考试</button>
            <button  class="button" type="button" name="button">编辑考试</button>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="modal" :class="{'is-active' : isShowModal}">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">添加考试</p>
          <button @click="showModal()" class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
          <div class="box-item">
            <label>考试名称</label>
            <input class="input" type="text" placeholder="请输入考试名">
          </div>

          <div class="box-item">
            <label>考试名称</label>
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
              "id": 1,
              "creator_id": 1,
              "title": "期末考试啊",
              "paper_id": 1,
              "exam_type": "OPEN",
              "score": 100,
              "min": 1,
              "describe": "单选",
              "allowable_lecture_ids": "0",
              "allowable_orgaization_ids": "0",
              "allowable_user_ids": "0",
              "begin_at": "2018-12-12 10:10:12",
              "start_at": null,
              "finish_at": null,
              "created_at": "2018-02-05 03:50:07",
              "updated_at": "2018-02-05 03:51:10"
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
      let prompt = confirm("确认删除改考试吗？");
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
