<!-- 查看课程 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input class="input search-input" type="text" placeholder="请输入你要查看的课程">
        <button class="button" type="button" name="button">查找课程</button>
      </div>
        <button @click="addCourse()" class="button add-role-button" type="button" name="button">添加课程</button>
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
        <tr v-for="item in courseData">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.display_name }}</td>
          <td>{{ item.number }}</td>
          <td> {{ item.description }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
          <td>
            <button @click="deleteCourse(index)" class="button" type="button" name="button">删除课程</button>
            <button @click="editCourse()" class="button" type="button" name="button">编辑课程</button>
          </td>
        </tr>
      </tbody>
    </table>

    <add-course ref="addCourse"></add-course>
    <edit-course ref="editCourse" v-bind:edit-data="editData"></edit-course>
    </div>
  </div>
</template>

<script>
import AddCourse from './AddCourse'
import EditCourse from './EditCourse'

export default {
  data() {
    return {
      courseData: [
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
      token: null,
      // courseData: null,
      editData: null,
    }
  },
  components: {
    AddCourse,
    EditCourse,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    addCourse: function() {
      const that = this;
      that.$refs.addCourse.switchModal();
    },
    editCourse: function () {
      const that = this;
      that.$refs.addCourse.switchModal();
    },
    deleteCourse: function (index) {
      const that = this;
      let id = that.courseData[index]['id'];
      let prompt = confirm("确认删除该课程吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/courses/${id}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': that.token
          }
        }).then(res => {
        }).catch(err => {
          console.log(err)
        })
      }
    },
    getCourse: function() {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/courses`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.courseData = res.data.data;
        //  
      }).catch(err => {
        console.log(err)
      })
    }
  },
  created() {
    this.token = sessionStorage.getItem('token');
    // this.getCourse();
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
