<!-- 查看练习 -->
<template lang="html">
  <div class="box">

    <!-- <analysis v-show="isShowAnalysis"
              v-bind:exam-data="examData"
    ></analysis> -->
    <div>
      <div>
        <div v-show="isShowSearchPractice" class="search-box">
          <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入关键字">
          <!-- <button disabled @click="searchPractice()" class="button" type="button" name="button">查找练习</button> -->
          <div @click="searchPractice()" class="search-button"><i class="fas fa-search"></i></div>
        </div>
        <button v-show="isShowCreatePractice" @click="addPractice()" class="button add-practice-button" type="button" name="button">添加练习</button>
      </div>

      <p v-if="!practiceData" class="empty-message-prompt">暂无练习</p>
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
            <th><p class="practice-limit-words">描述</p></th>
            <!-- <th>创建时间</th> -->
            <!-- <th>更新时间</th> -->
            <th>操作</th>
            <th>用户</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item,index) in practiceData">
            <td>{{ item.id }}</td>
            <!-- <td>{{ item.creator_id }}</td> -->
            <td>{{ item.title }}</td>
            <!-- <td>{{ item.paper_id }}</td> -->
            <td>{{ item.exam_type }}</td>
            <td>{{ item.score }}</td>
            <td>{{ item.min }}</td>
            <td> {{ item.description }}</td>
            <!-- <td>{{ GLOBAL.toTime(item.created_at) }}</td> -->
            <!-- <td>{{ GLOBAL.toTime(item.updated_at) }}</td> -->
            <td>
              <!-- <button v-show="isShowDeletePractice" @click="deletePractice(index)" class="delete" type="button" name="button">删除</button> -->
              <div v-show="isShowDeletePractice" @click="deletePractice(index)" class="icon-button"><i class="far fa-trash-alt"></i></div>
              <div v-show="isShowEditPractice" @click="editPractice(index)" class="icon-button"><i class="fas fa-edit"></i></div>
              <button @click="startPractice(index)" class="is-small button" type="button" name="button">开始练习</button>
              <button @click="stopPractice(index)" class="is-small button" type="button" name="button">结束练习</button>
              <button @click="gradingPapers(index)" class="is-small button" type="button" name="button">批改</button>
              <!-- <button @click="analysis(index)" class="is-small button" type="button" name="button">分析</button> -->
            </td>
            <td>
              <button @click="participateUser(index)" class="is-small button" type="button" name="button">查看练习用户</button>
            </td>
          </tr>
        </tbody>
      </table>

      <add-practice ref="addPractice"
                v-on:getPractice="getPractice"
      ></add-practice>

      <edit-practice ref="editPractice"
                 v-on:getPractice="getPractice"
                 v-bind:edit-data="editData"
      ></edit-practice>

      <pagination v-show="searchResult.length === 0"
                  v-bind:pagination-data="paginationData"
                  v-model="data"
      ></pagination>
    </div>

    <participate-user ref="participateUser"
                      v-bind:exam-id="examId"
    ></participate-user>

  </div>
</template>

<script>
import Pagination from './../Pagination.vue'
import AddPractice from './AddPractice'
import EditPractice from './EditPractice'
import ParticipateUser from './ParticipateUser'

export default {
  data() {
    return {
      isShowModal: false,
      searchKey: null,
      practiceData: null,
      editData: null,
      searchKey: null,
      paginationData: null,
      data: null,
      paperId: null,
      examId: null,
      isShowAnalysis: false,
      // get all practice
      currentPractice: [],
      allPractice: [],
      searchResult: [],
      examData: null,
    }
  },
  components: {
    AddPractice,
    EditPractice,
    Pagination,
    ParticipateUser,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    deletePractice: function (index) {
      const that = this;
      let id = that.practiceData[index].id;
      let prompt = confirm("确认删除该练习吗？");
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
          that.getPractice();
        }).catch(err => {
          alert('删除失败');
          console.log(err)
        })
      }
    },
    searchPractice: function () {
      const that = this;
      let id = that.searchKey;
      if (!id) {
        that.searchKey = '';
        that.getPractice();
        return;
      }
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/${id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        // that.practiceData = res.data.data
        that.practiceData = [];
        that.practiceData.push(res.data.data);
      }).catch(err => {
        alert('查找失败，已加载全部数据')
        console.log(err)
      })
    },
    searchPractice: function () {
      const that = this;
      // 如果没有搜索值
      if (!that.searchKey) {
        that.getPractice();
        that.searchResult = [];
        return;
      }
      // 如果已经获取全部数据
      else if (that.allPractice.length > 0) {
        let allData  = that.allPractice;
        let len = that.allPractice.length;
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
        that.practiceData = res;
      }
      // 如果有搜索值并且还未获取全部数据
      else {
        let url = `${this.GLOBAL.localDomain}/api/v1/exams/`;
        that.getAllPractice(url);
      }
    },
    getAllPractice: function (url) {
      const that = this;
      let urlPath = url ? url : that.url
      axios({
        method: 'get',
        url: urlPath,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.url = res.data.links.next;

        let len = res.data.data.length ? res.data.data.length : that.getJsonLength(res.data.data);

        // data数据结构不一致 可能是数组/也可能是json
        if (res.data.data.length) {
          for (let i = 0; i < len; i++) {
            that.currentPractice.push(res.data.data[i]);
          }
        }
        else if (that.getJsonLength(res.data.data)) {
          for (let i in res.data.data) {
            that.currentPractice.push(res.data.data[i]);
          }
        }

        if (that.url) {
          that.getAllPractice(that.url);
        }
        else {
          that.allPractice = that.currentPractice;
        }
      }).catch(err => {
        console.log(err);
      })
    },
    getPractice: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        if (res.data.data.length !== 0) {
          that.practiceData = res.data.data;
        }
        else {
          that.practiceData = [];
        }
        // that.practiceData = [];
        // that.practiceData.push(res.data.data);
      }).catch(err => {
        console.log(err);
        if (err.response.status === 401) {
          // alert('登录超时');
          // location.reload();
        }
      })
    },
    addPractice: function () {
      const that = this;
      that.$refs.addPractice.switchModal();
    },
    analysis: function (index) {
      const that = this;
      that.isShowAnalysis = true;
      that.examData = that.practiceData[index];
    },
    participateUser: function (index) {
      const that = this;
      let id = that.practiceData[index].id;
      that.examId = id;
      that.$refs.participateUser.switchModal();
    },
    editPractice: function (index) {
      const that = this;
      that.editData = that.practiceData[index];
      that.$refs.editPractice.switchModal();
    },
    startPractice: function (index) {
      const that = this;
      // that.$refs.practiceing.clearQuestionIds();
      let id = that.practiceData[index].id;
      that.paperId = that.practiceData[index].paper_id;
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
    // 结束练习
    stopPractice: function (index) {
      const that = this;
      let id = that.practiceData[index].id;
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
      let id = that.practiceData[index].id;
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

    this.getPractice();
  },
  computed: {
    // 【练习】
    isShowSearchPractice() {
      // return true;
      return sessionStorage.getItem('permissions').includes('exam-show');
    },
    isShowCreatePractice() {
      // return true;
      return sessionStorage.getItem('permissions').includes('exam-store');
    },
    isShowEditPractice() {
      // return true;
      return sessionStorage.getItem('permissions').includes('exam-update');
    },
    isShowDeletePractice() {
      // return true;
      return sessionStorage.getItem('permissions').includes('exam-destroy');
    },
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.practiceData = value.data;
      that.paginationData = value.links;
    },
    allPractice: function (value, oldValue) {
      const that = this;
      that.searchPractice(that.searchKey);
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
.add-practice-button {
  margin-left: 20px;
}
.box-item {
  margin-bottom: 20px;
  input  {
    display: inline-block;
    width: 300px;
  }
  practice {
    display: inline-block;
    width: 130px;
  }
}
.practice-limit-words {
  display: inline-block;
  width: 200px;
  overflow: hidden;
  text-overflow:ellipsis;
  white-space: nowrap;
}

</style>
