<!-- 查看考试 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入你要查看的考试">
        <button @click="searchTest()" class="button" type="button" name="button">查找考试</button>
      </div>
        <button @click="addTest()" class="button add-role-button" type="button" name="button">添加考试</button>
    </div>
    <table class="table">
      <thead>
        <tr>
          <!-- <th>ID</th> -->
          <!-- <th>创建者ID</th> -->
          <th>考试标题</th>
          <!-- <th>试卷ID</th> -->
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
        <tr v-for="(item,index) in testData">
          <!-- <td>{{ item.id }}</td> -->
          <!-- <td>{{ item.creator_id }}</td> -->
          <td>{{ item.title }}</td>
          <!-- <td>{{ item.paper_id }}</td> -->
          <td>{{ item.exam_type }}</td>
          <td>{{ item.score }}</td>
          <td>{{ item.min }}</td>
          <td> {{ item.description }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
          <td>
            <button @click="deleteTest(index)" class="button" type="button" name="button">删除</button>
            <button @click="editTest(index)" class="button" type="button" name="button">编辑</button>
            <button @click="startTest(index)" class="button" type="button" name="button">开始</button>
            <button @click="stopTest(index)" class="button" type="button" name="button">结束</button>
            <button @click="gradingPapers(index)" class="button" type="button" name="button">批改</button>
          </td>
        </tr>
      </tbody>
    </table>

    <add-test ref="addTest"
              v-on:getTest="getTest"
    ></add-test>

    <edit-test ref="editTest"
               v-on:getTest="getTest"
               v-bind:edit-data="editData"
    ></edit-test>

    <pagination v-bind:pagination-data="paginationData"
            v-model="data"
    ></pagination>

  </div>
</template>

<script>
import AddTest from './AddTest'
import EditTest from './EditTest'
import Pagination from './../Pagination.vue'

export default {
  data() {
    return {
      isShowModal: false,
      token: null,
      searchKey: null,
      testData: null,
      editData: null,
      searchKey: null,
      paginationData: null,
      data: null,
    }
  },
  components: {
    AddTest,
    EditTest,
    Pagination,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    deleteTest: function (index) {
      const that = this;
      let id = that.testData[index].id;
      let prompt = confirm("确认删除该标签吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/exams/${id}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': that.token
          }
        }).then(res => {
          alert('删除成功');
          that.getTest();
        }).catch(err => {
          alert('删除失败');
          console.log(err)
        })
      }
    },
    searchTest: function () {
      const that = this;
      let id = that.searchKey;
      if (!id) {
        that.getTest();
        return;
      }
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/${id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.testData = [];
        that.testData.push(res.data.data);
      }).catch(err => {
        alert('查找失败，已加载全部数据')
        console.log(err)
      })
    },
    getTest: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.testData = [];
        that.testData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    },
    addTest: function () {
      const that = this;
      that.$refs.addTest.switchModal();
    },
    editTest: function (index) {
      const that = this;
      that.editData = that.testData[index];
      that.$refs.editTest.switchModal();
    },
    startTest: function (index) {
      const that = this;
      let id = that.testData[index].id;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/${id}/start`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        alert('已开始');
      }).catch(err => {
        alert('开始失败，请稍后再试')
        console.log(err)
      })
    },
    stopTest: function (index) {
      const that = this;
      let id = that.testData[index].id;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/${id}/stop`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        alert('已结束');
      }).catch(err => {
        alert('结束失败，请稍后再试');
        console.log(err)
      })
    },
    gradingPapers: function (index) {
      const that = this;
      let id = that.testData[index].id;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/${id}/correct`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        alert('可以开始批改');
      }).catch(err => {
        alert('操作失败，请稍后再试');
        console.log(err)
      })
    }
  },
  created() {
    this.token = sessionStorage.getItem('token');
    this.getTest();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.permissionData = value.data;
      that.paginationData = value.links;
    }
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
  test {
    display: inline-block;
    width: 130px;
  }
}
</style>
