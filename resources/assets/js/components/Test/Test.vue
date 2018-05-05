<!-- 查看考试 -->
<template lang="html">
  <div class="box">

    <!-- <analysis v-show="isShowAnalysis"
              v-bind:exam-data="examData"
    ></analysis> -->
    <div>
      <div>
        <div v-show="isShowSearchTest" class="search-box">
          <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入关键字">
          <!-- <button disabled @click="searchTest()" class="button" type="button" name="button">查找考试</button> -->
          <div @click="searchTest()" class="search-button"><i class="fas fa-search"></i></div>
        </div>
        <button v-show="isShowCreateTest" @click="addTest()" class="button add-test-button" type="button" name="button">添加考试</button>
      </div>

      <p v-if="!testData" class="empty-message-prompt">暂无考试</p>
      <table v-else class="table is-bordered is-striped is-hoverable is-fullwidths">
        <thead>
          <tr>
            <th>序号</th>
            <!-- <th>创建者ID</th> -->
            <th>标题</th>
            <!-- <th>试卷ID</th> -->
            <th>类型</th>
            <th>分值</th>
            <th>时长(分钟)</th>
            <!-- <th><p class="test-limit-words">描述</p></th> -->
            <!-- <th>创建时间</th> -->
            <!-- <th>更新时间</th> -->
            <th>操作</th>
            <th>用户</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item,index) in testData">
            <td>{{ item.id }}</td>
            <!-- <td>{{ item.creator_id }}</td> -->
            <td>{{ item.title }}</td>
            <!-- <td>{{ item.paper_id }}</td> -->
            <td>{{ item.exam_type }}</td>
            <td>{{ item.score }}</td>
            <td>{{ item.min }}</td>
            <!-- <td> {{ item.description }}</td> -->
            <!-- <td>{{ GLOBAL.toTime(item.created_at) }}</td> -->
            <!-- <td>{{ GLOBAL.toTime(item.updated_at) }}</td> -->
            <td>
              <!-- <button v-show="isShowDeleteTest" @click="deleteTest(index)" class="delete" type="button" name="button">删除</button> -->
              <div v-show="isShowDeleteTest" @click="deleteTest(index)" class="icon-button"><i class="far fa-trash-alt"></i></div>
              <div v-show="isShowEditTest" @click="editTest(index)" class="icon-button"><i class="fas fa-edit"></i></div>
              <button @click="startTest(index)" class="is-small button" type="button" name="button">开始考试</button>
              <button @click="stopTest(index)" class="is-small button" type="button" name="button">结束考试</button>
              <button @click="gradingPapers(index)" class="is-small button" type="button" name="button">批改</button>
              <!-- <button @click="analysis(index)" class="is-small button" type="button" name="button">分析</button> -->
            </td>
            <td>
              <button @click="participateUser(index)" class="is-small button" type="button" name="button">查看考试用户</button>
              <button @click="showMonitor(index)" class="is-small button" type="button" name="button">查看监控</button>
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

      <pagination v-show="searchResult.length === 0"
                  v-bind:pagination-data="paginationData"
                  v-model="data"
      ></pagination>
    </div>

    <participate-user ref="participateUser"
                      v-bind:exam-id="examId"
    ></participate-user>

    <monitor-video ref="monitorVideo"
                   v-bind:edit-data="editData"
    ></monitor-video>
  </div>
</template>

<script>
import Pagination from './../Pagination.vue'
import AddTest from './AddTest'
import EditTest from './EditTest'
import ParticipateUser from './ParticipateUser'
import MonitorVideo from '../SurveillanceVideo/MonitorVideo'

export default {
  data() {
    return {
      isShowModal: false,
      searchKey: null,
      testData: null,
      editData: null,
      searchKey: null,
      paginationData: null,
      data: null,
      paperId: null,
      examId: null,
      isShowAnalysis: false,
      // get all test
      currentTest: [],
      allTest: [],
      searchResult: [],
      examData: null,
    }
  },
  components: {
    AddTest,
    EditTest,
    Pagination,
    ParticipateUser,
    MonitorVideo,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    deleteTest: function (index) {
      const that = this;
      let id = that.testData[index].id;
      let prompt = confirm("确认删除该考试吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/exams/${id}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': sessionStorage.getItem('token'),
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
    // searchTest: function () {
    //   const that = this;
    //   let id = that.searchKey;
    //   if (!id) {
    //     that.searchKey = '';
    //     that.getTest();
    //     return;
    //   }
    //   axios({
    //     method: 'get',
    //     url: `${this.GLOBAL.localDomain}/api/v1/exams/${id}`,
    //     headers: {
    //       'Accept': 'application/json',
    //       'Authorization': sessionStorage.getItem('token'),
    //     }
    //   }).then(res => {
    //     // that.testData = res.data.data
    //     that.testData = [];
    //     that.testData.push(res.data.data);
    //   }).catch(err => {
    //     alert('查找失败，已加载全部数据')
    //     console.log(err)
    //   })
    // },
    searchTest: function () {
      const that = this;
      // 如果没有搜索值
      if (!that.searchKey) {
        that.getTest();
        that.searchResult = [];
        return;
      }
      // 如果已经获取全部数据
      else if (that.allTest.length > 0) {
        let allData  = that.allTest;
        let len = that.allTest.length;
        let res = [];

        for (let i = 0; i < len; i++) {
          for (let j in allData[i]) {
            if (allData[i][j]) {
              if ((allData[i][j].toString()).indexOf(that.searchKey) !== -1) {
                res.push(allData[i]);
                break;
              }
            }
          }
        }
        that.searchResult = res;
        that.testData = res;
      }
      // 如果有搜索值并且还未获取全部数据
      else {
        let url = `${this.GLOBAL.localDomain}/api/v1/exams`;
        that.getAllTest(url);
      }
    },
    getAllTest: function (url) {
      const that = this;
      let urlPath = url ? url : that.url
      axios({
        method: 'get',
        url: urlPath,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          type: 'PRACTICE'
        }
      }).then(res => {
        that.url = res.data.links.next;

        let len = res.data.data.length ? res.data.data.length : that.getJsonLength(res.data.data);

        // data数据结构不一致 可能是数组/也可能是json
        if (res.data.data.length) {
          for (let i = 0; i < len; i++) {
            that.currentTest.push(res.data.data[i]);
          }
        }
        else if (that.getJsonLength(res.data.data)) {
          for (let i in res.data.data) {
            that.currentTest.push(res.data.data[i]);
          }
        }

        if (that.url) {
          that.getAllTest(that.url);
        }
        else {
          that.allTest = that.currentTest;
        }
      }).catch(err => {
        console.log(err);
      })
    },
    getTest: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/exams`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          type: 'EXAM'
        }
      }).then(res => {
        if (res.data.data.length !== 0) {
          that.testData = res.data.data;
        }
        else {
          that.testData = [];
        }
        // that.testData = [];
        // that.testData.push(res.data.data);
      }).catch(err => {
        console.log(err);
        if (err.response.status === 401) {
          // alert('登录超时');
          // location.reload();
        }
      })
    },
    showMonitor: function (index) {
      const that = this;
      that.editData = that.testData[index];
      that.$refs.monitorVideo.switchModal();
    },
    addTest: function () {
      const that = this;
      that.$refs.addTest.switchModal();
    },
    analysis: function (index) {
      const that = this;
      that.isShowAnalysis = true;
      that.examData = that.testData[index];
    },
    participateUser: function (index) {
      const that = this;
      let id = that.testData[index].id;
      that.examId = id;
      that.$refs.participateUser.switchModal();
    },
    editTest: function (index) {
      const that = this;
      that.editData = that.testData[index];
      that.$refs.editTest.switchModal();
    },
    startTest: function (index) {
      const that = this;
      // that.$refs.testing.clearQuestionIds();
      let id = that.testData[index].id;
      that.paperId = that.testData[index].paper_id;
      that.examId = id;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/${id}/start`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        alert('已开考');
      }).catch(err => {
        let errMsg = err.response.data.error;
        if (errMsg) {
          alert(errMsg);
        }
        else {
          alert('开始失败，请稍后再试');
        }
        console.log(err)
      })
    },
    // 结束考试
    stopTest: function (index) {
      const that = this;
      let id = that.testData[index].id;
      that.examId = id;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/${id}/stop`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        alert('已结束');
      }).catch(err => {
        let errMsg = err.response.data.error;
        if (errMsg) {
          alert(errMsg);
        }
        else {
          alert('结束失败，请稍后再试');
        }
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
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        alert('批改完成');
      }).catch(err => {
        alert('操作失败，请稍后再试');
        console.log(err)
      })
    },
  },
  created() {

    this.getTest();
  },
  computed: {
    // 【考试】
    isShowSearchTest() {
      // return true;
      return sessionStorage.getItem('permissions').includes('exam-show');
    },
    isShowCreateTest() {
      // return true;
      return sessionStorage.getItem('permissions').includes('exam-store');
    },
    isShowEditTest() {
      // return true;
      return sessionStorage.getItem('permissions').includes('exam-update');
    },
    isShowDeleteTest() {
      // return true;
      return sessionStorage.getItem('permissions').includes('exam-destroy');
    },
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.testData = value.data;
      that.paginationData = value.links;
    },
    allTest: function (value, oldValue) {
      const that = this;
      that.searchTest(that.searchKey);
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
.add-test-button {
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
.test-limit-words {
  display: inline-block;
  width: 200px;
  overflow: hidden;
  text-overflow:ellipsis;
  white-space: nowrap;
}

</style>
