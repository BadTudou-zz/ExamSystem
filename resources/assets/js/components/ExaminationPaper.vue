<!-- 查看试卷 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input class="input search-input" type="text" placeholder="请输入你要查看的试卷">
        <button class="button" type="button" name="button">查找试卷</button>
      </div>
        <button @click="showModal()" class="button add-role-button" type="button" name="button">添加试卷</button>
        <button class="button add-role-button" type="button" name="button">同步试卷</button>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>创建者ID</th>
          <th>试卷标题</th>
          <th>总分数</th>
          <th>最小</th>
          <th>描述</th>
          <th>章节</th>
          <th>Tags</th>
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
          <td>{{ item.score }}</td>
          <td>{{ item.min }}</td>
          <td>{{ item.describe }}</td>
          <td>{{ item.sections }}</td>
          <td>{{ item.tags }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
          <td>
            <button @click="deleteRole()" class="button" type="button" name="button">删除试卷</button>
            <button  class="button" type="button" name="button">编辑试卷</button>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="modal" :class="{'is-active' : isShowModal}">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">添加试卷</p>
          <button @click="showModal()" class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
          <div class="box-item">
            <label>试卷名称</label>
            <input class="input" type="text" placeholder="请输入试卷名">
          </div>

          <div class="box-item">
            <label>试卷名称</label>
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
            "creator_id": "1",
            "title": "英语等级考试1",
            "score": "100",
            "min": "120",
            "describe": "英语考试",
            "sections": null,
            "tags": null,
            "created_at": "2018-01-27 14:22:19",
            "updated_at": "2018-01-27 14:23:17"
        },
        {
            "id": 2,
            "creator_id": "1",
            "title": "英语等级考试",
            "score": "100",
            "min": "120",
            "describe": "英语考试",
            "sections": null,
            "tags": null,
            "created_at": "2018-01-27 14:39:14",
            "updated_at": "2018-01-27 14:39:14"
        },
        {
            "id": 3,
            "creator_id": "1",
            "title": "英语等级考试",
            "score": "100",
            "min": "120",
            "describe": "英语考试",
            "sections": null,
            "tags": null,
            "created_at": "2018-01-27 14:40:12",
            "updated_at": "2018-01-27 14:40:12"
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
      let prompt = confirm("确认删除改试卷吗？");
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
