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
        <tr v-for="item in testData">
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
            <button @click="deleteTest()" class="button" type="button" name="button">删除</button>
            <button @click="editTest()" class="button" type="button" name="button">编辑</button>
            <button @click="startTest()" class="button" type="button" name="button">开始</button>
            <button @click="stopTest()" class="button" type="button" name="button">结束</button>
          </td>
        </tr>
      </tbody>
    </table>

    <add-test ref="addTest"></add-test>
    <edit-test ref="editTest" v-bind:edit-data="editData"></edit-test>
  </div>
</template>

<script>
import AddTest from './AddTest'
import EditTest from './EditTest'

export default {
  data() {
    return {
      testData: [
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
      token: null,
      searchKey: null,
      // testData: null,
      editData: null,
      searchKey: null,
    }
  },
  components: {
    AddTest,
    EditTest,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    deleteTest: function (index) {
      const that = this;
      // let id = that.testData[index].id;
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
          that.testData = res.data.data;
        }).catch(err => {
          console.log(err)
        })
      }
    },
    searchTest: function () {
      const that = this;
      let id = that.searchKey;
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
      // that.$refs.addTest.switchModal();
      that.$refs.editTest.switchModal();
    },
    startTest: function (index) {
      const that = this;
      let id = that.testData[index].id;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/${id}/start`,
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
    stopTest: function (index) {
      const that = this;
      let id = that.testData[index].id;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/${id}/stop`,
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
    }
  },
  created() {
    this.token = sessionStorage.getItem('token');
    this.getTest();
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
  test {
    display: inline-block;
    width: 130px;
  }
}
</style>
