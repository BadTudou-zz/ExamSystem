<!-- 查看题目 -->
<template lang="html">
  <div class="box">
    <div>
      <div v-show="isShowSearchQuestion" class="search-box">
        <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入关键字">
        <!-- <button disabled @click="searchQuestion()" class="button" type="button" name="button">查找题目</button> -->
        <div @click="searchQuestion()" class="search-button"><i class="fas fa-search"></i></div>
      </div>
        <button v-show="isShowCreateQuestion" @click="addQuestion()" class="button add-question-button" type="button" name="button">添加题目</button>
    </div>

    <p v-if="!questionData" class="empty-message-prompt">暂无题目</p>
    <table v-else class="table is-bordered is-striped is-hoverable is-fullwidths">
      <thead>
        <tr>
          <th>序号</th>
          <th>类型</th>
          <th>难度</th>
          <th>题目</th>
          <th>选项</th>
          <th is-show="isShowDeleteQuestion">操作</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in questionData">
          <td>{{ item.id }}</td>
          <td>{{ computedQuestionType(item.question_type) }}</td>
          <td>{{ computedLevelType(item.level_type) }}</td>
          <td><p  :title="item.title" class="limit-words">{{ item.title }}</p></td>
          <td><p  :title="getOptionsString(item.body)" class="question-limit-words">{{ getOptionsString(item.body) }}</p></td>
          <td>
            <div v-show="isShowEditQuestion" @click="editQuestion(index)" class="edit-button"><i class="fas fa-edit"></i></div>
            <button v-show="isShowDeleteQuestion" @click="deleteQuestion(index)" class="delete" type="button" name="button">删除题目</button>
          </td>
        </tr>
      </tbody>
    </table>

    <add-question ref="addQuestion"
                  v-on:getQuestion="getQuestion"
    ></add-question>

    <edit-question ref="editQuestion"
                   v-on:getQuestion="getQuestion"
                   v-bind:edit-data="editData"
    ></edit-question>

    <pagination v-show="searchResult.length === 0"
                v-bind:pagination-data="paginationData"
                v-model="data"
    ></pagination>
  </div>
</template>

<script>
import Pagination from './../Pagination'
import AddQuestion from './AddQuestion'
import EditQuestion from './EditQuestion'
import SingleChoice from './SingleChoice'
import MultipleChoice from './MultipleChoice'

export default {
  data() {
    return {
       isShowModal: false,
       questionData: null,
       editData: null,
       //
       paginationData: null,
       data: null,
       //
       searchKey: null,
       // get all question
       currentQuestion: [],
       allQuestion: [],
       searchResult: [],

    }
  },
  components: {
    AddQuestion,
    EditQuestion,
    Pagination,
    SingleChoice,
    MultipleChoice,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    deleteQuestion: function (index, questionId) {
      const that = this;
      let id;
      if (questionId) {
        id = questionId;
      }
      else {
        id = that.questionData[index]['id'];
      }
      let prompt = confirm("确认删除该题目吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/questions/${id}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': sessionStorage.getItem('token'),
          }
        }).then(res => {
          alert('删除成功');
          that.getQuestion();
        }).catch(err => {
          alert('删除失败');
          console.log(err)
        })
      }
    },
    getQuestion: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/questions`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.questionData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
    addQuestion: function () {
      const that = this;
      that.$refs.addQuestion.switchModal();
    },
    editQuestion: function (index, editData) {
      const that = this;
      if (editData) {
        that.editData = editData;
      }
      else {
        that.editData = that.questionData[index];
      }
      that.$refs.editQuestion.switchModal();
    },
    searchQuestion: function () {
      const that = this;
      let id = that.searchKey;
      if (!that.searchKey) {
        that.searchKey = '';
        that.getQuestion();
        return;
      }
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/questions/${id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.questionData = [];
        that.questionData.push(res.data.data)
        // that.questionData = res.data.data;
      }).catch(err => {
        alert('查找出错');
        that.getQuestion();
        console.log(err);
      })
    },
    searchQuestion: function () {
      const that = this;
      // 如果没有搜索值
      if (!that.searchKey) {
        that.getQuestion();
        that.searchResult = [];
        return;
      }
      // 如果已经获取全部数据
      else if (that.allQuestion.length > 0) {
        let allData  = that.allQuestion;
        let len = that.allQuestion.length;
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
        that.questionData = res;
      }
      // 如果有搜索值并且还未获取全部数据
      else {
        let url = `${this.GLOBAL.localDomain}/api/v1/questions/`;
        that.getAllQuestion(url);
      }
    },
    getAllQuestion: function (url) {
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
            that.currentQuestion.push(res.data.data[i]);
          }
        }
        else if (that.getJsonLength(res.data.data)) {
          for (let i in res.data.data) {
            that.currentQuestion.push(res.data.data[i]);
          }
        }

        if (that.url) {
          that.getAllQuestion(that.url);
        }
        else {
          that.allQuestion = that.currentQuestion;
        }
      }).catch(err => {
        console.log(err);
      })
    },
    getOptionsString: function (value) {
      const that = this;
      let arr = value.split(' ');
      let alphabet = ['A','B','C','D','E','F','G','H','I'];
      let str = '';
      for (let i = 0; i < arr.length; i++) {
        str += ' ' + alphabet[i] + '.' + arr[i]  + '\n';
        // if (i === 0) {
        //   str += alphabet[i] + '.' + arr[i] + '.';
        // }
        // else {
        //   str += ' ' + alphabet[i] + '.' + arr[i];
        // }
      }
      // let optionArray = str.split('\n');
      // return opstrtionArray;
      return str;
    },
    computedLevelType: function (value) {
      let levelType = '';
      switch (value) {
        case 'EASY':
          levelType = '容易';
          break;
        case 'HARD':
          levelType = '困难';
          break;
      }
      return levelType;
    },
    computedQuestionType: function (value) {
      const that = this;
      let questionType = '';
      switch (value) {
        case 'SINGLE_CHOICE':
          questionType = '单选';
          break;
        case 'MULTIPLE_CHOICE':
          questionType = '多选';
          break;
      }
      return questionType;
    }
  },
  computed: {
    isShowCreateQuestion() {
      // return true;
      return sessionStorage.getItem('permissions').includes('question-store');
    },
    isShowSearchQuestion() {
      // return true;
      return sessionStorage.getItem('permissions').includes('question-show');
    },
    isShowEditQuestion() {
      // return true;
      return sessionStorage.getItem('permissions').includes('question-update');
    },
    isShowDeleteQuestion() {
      // return true;
      return sessionStorage.getItem('permissions').includes('question-destroy');
    },
  },
  created() {
    this.getQuestion();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.questionData = value.data;
      that.paginationData = value.links;
    },
    allQuestion: function (value, oldValue) {
      const that = this;
      that.searchQuestion(that.searchKey);
    }
  }
}
</script>

<style lang="scss" scoped>
.message {
  margin: 35px auto 0 auto;
}
.search-input {
  width: 250px;
  display: inline-block;
  margin-right: 10px;
}
.search-box {
  padding-right: 20px;
  display: inline-block;
  border-right: 1px solid #dedede;
}
.add-question-button {
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
.message {
  .notification {
    margin: 0;
  }
}
.notification .time{
  margin-top: 25px;
  text-align: right;
  padding-bottom: 20px;
  border-bottom: 1px solid #dedede;
}
.question {
  text-align: left;
  margin-bottom: 10px;
}
.edit-question {
  float: right;
}
.operate-box {
  height: 40px;
  line-height: 40px;
}
.delete {
  float: right;
  margin-left: 20px;
}
.answer {
  margin-left: 24px;
}
.multiple-choice {
  width: 200px;
}
.question-limit-words {
  display: inline-block;
  width: 200px;
  overflow: hidden;
  text-overflow:ellipsis;
  white-space: nowrap;
}

</style>
