<!-- 查看授课 -->
<template lang="html">
  <div class="box">
    <div>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>授课名</th>
          <th>用户ID</th>
          <th>课程ID</th>
          <th>允许组织的ID</th>
          <th>允许用户的ID</th>
          <th>描述</th>
          <th>最大容量</th>
          <th>当前容量</th>
          <th>创建时间</th>
          <th>更新时间</th>
        </tr>
      </thead>
    <tbody>
        <tr v-for="item in data">
          <td>{{ item.name }}</td>
          <td>{{ item.user_id }}</td>
          <td>{{ item.course_id }}</td>
          <td>{{ item.allowable_organization_ids }}</td>
          <td>{{ item.allowable_user_ids }}</td>
          <td> {{ item.description }}</td>
          <td>{{ item.max }}</td>
          <td>{{ item.current }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>

        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      "data": [
        {
            "id": 1,
            "name": "1班的英语",
            "user_id": "1",
            "course_id": "1",
            "allowable_organization_ids": "",
            "allowable_user_ids": "",
            "": "这是描述",
            "max": "20",
            "current": "1",
            "created_at": "2018-01-19 18:44:54",
            "updated_at": "2018-01-19 18:44:54",
            "pivot": {
                "user_id": "1",
                "lecture_id": "1"
            }
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
      let prompt = confirm("确认删除改授课吗？");
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
