<!-- 查看考试 -->
<template lang="html">
  <div>
    <div  v-show="!isTesting">
      <h3 class="title">考试</h3>
      <table class="table">
        <thead>
          <tr>
            <th>序号</th>
            <th>考试标题</th>
            <th>总分</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item,index) in testData">
            <td>{{ item.id }}</td>
            <td>{{ item.title }}</td>
            <td>{{ item.score }}</td>
            <td>
              <button @click="startTest(index)" class="is-small button" type="button" name="button">开始考试</button>
              <button @click="showScore(index)" class="is-small button" type="button" name="button">查看成绩</button>
            </td>
          </tr>
        </tbody>
      </table>

      <pagination v-bind:pagination-data="paginationData"
                  v-model="data"
      ></pagination>

    </div>

    <!-- <testing ref="testing"
             v-show="isTesting"
             v-on:switchTesting="switchTesting"
             v-bind:paper-id="paperId"
             v-bind:exam-id="examId"
             v-bind:exam-time="examTime"
    ></testing>     -->

    <testing ref="testing"
                 v-show="isTesting"
                 v-on:switchTesting="switchTesting"
                 v-bind:current-test-data="currentTestData"
    ></testing>

    <score ref="score"
           v-bind:selected-test-data="selectedTestData"
    ></score>
  </div>
</template>

<script>
import Testing from './Testing'
import Pagination from './../Pagination.vue'
import Score from './Score'
export default {
  data() {
    return {
      isShowModal: false,
      searchKey: null,
      testData: null,
      editData: null,
      searchKey: null,
      //
      paginationData: null,
      data: null,
      //
      isTesting: false,  // 是否已经开始考试
      // paperId: null,  // 试卷ID
      // examId: null, // 考试ID testID
      examTime: null,
      selectedTestData: null,  // 当前选中的考试
      currentTestData: null,
    }
  },
  components: {
    Pagination,
    Testing,
    Score,
  },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    switchTesting: function () {
      const that = this;
      that.isTesting = !that.isTesting;
    },
    getTest: function () {
      const that = this;

      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/${sessionStorage.getItem('userId')}/exams`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        if (res.data.data.length !== 0) {
          that.testData = res.data.data;
        }
        else {
          that.testData = [];
        }
      }).catch(err => {
        console.log(err)
      })
    },
    showScore: function (index) {
      const that = this;
      that.$refs.score.switchModal();
      that.selectedTestData = that.testData[index];
    },
    startTest: function (index) {
      const that = this;

      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/${that.testData[index].id}/begin`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.currentTestData = that.testData[index];
        that.switchTesting();
        alert('已开考');
      }).catch(err => {
        // that.switchTesting();
        // that.currentTestData = that.testData[index];
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
  },
  computed: {
  },
  created() {
    this.getTest();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.testData = value.data;
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
  label {
    display: inline-block;
    width: 130px;
  }
}
.title {
  color: #363636;
  font-size: 1.5rem;
  font-weight: 600;
  line-height: 1.125;
}
</style>
