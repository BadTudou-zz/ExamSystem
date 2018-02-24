<!-- 查看标签 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input class="input search-input" type="text" placeholder="请输入你要查看的标签">
        <button class="button" type="button" name="button">查找标签</button>
      </div>
        <button @click="showModal()" class="button add-role-button" type="button" name="button">添加标签</button>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>标签标题</th>
          <th>commentabl_type</th>
          <th>创建者ID</th>
          <th>创建时间</th>
          <th>更新时间</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <!-- "id": 1,
        "title": "英语等级考试1",
        "commentabl_type": null,
        "creator_id": "1",
        "created_at": "2018-02-01 01:55:06",
        "updated_at": "2018-02-01 02:02:14" -->
        <tr v-for="item in data">
          <td>{{ item.id }}</td>
          <td>{{ item.title }}</td>
          <td>{{ item.commentabl_type }}</td>
          <td>{{ item.creator_id }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
          <td>
            <button @click="deleteRole()" class="button" type="button" name="button">删除标签</button>
            <button  class="button" type="button" name="button">编辑标签</button>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="modal" :class="{'is-active' : isShowModal}">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">添加标签</p>
          <button @click="showModal()" class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
          <div class="box-item">
            <label>标签名称</label>
            <input class="input" type="text" placeholder="请输入标签名">
          </div>

          <div class="box-item">
            <label>标签名称</label>
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
              "title": "英语等级考试1",
              "commentabl_type": null,
              "creator_id": "1",
              "created_at": "2018-02-01 01:55:06",
              "updated_at": "2018-02-01 02:02:14"
          },
          {
              "id": 2,
              "title": "英语等级考试",
              "commentabl_type": null,
              "creator_id": "1",
              "created_at": "2018-02-01 02:03:36",
              "updated_at": "2018-02-01 02:03:36"
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
      let prompt = confirm("确认删除改标签吗？");
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
