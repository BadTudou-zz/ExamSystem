<!-- 查看问题 -->
<template lang="html">
  <div class="box">
    <div>
      <div v-show="isShowSearchQuestion" class="search-box">
        <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入问题">
        <button @click="searchQuestion()" class="button" type="button" name="button">查找问题</button>
      </div>
        <button v-show="isShowCreateQuestion" @click="addQuestion()" class="button add-role-button" type="button" name="button">添加问题</button>
    </div>

    <div v-for="(item,index) in questionData">
      <!-- 单选 -->
      <div class="message">
        <div v-show="item.question_type === 'SINGLE_CHOICE'" class="message box">
          <div class="notification">
            <div class="operate-box">
              <button v-show="isShowDeleteQuestion" @click="deleteQuestion(index)" class="delete"></button>
              <button @click="editQuestion(index)" class="button edit-question is-small" type="button" name="button">编辑问题</button>
            </div>
            <p class="detail">        id：{{ item.id }}
              &nbsp;&nbsp;&nbsp;&nbsp; 类型： 单选
              &nbsp;&nbsp;&nbsp;&nbsp; 难度：{{ item.level_type }}
            </p>
            <div class="question">题目：{{ item.title }}</div>
            <div class="question">选项：{{ getOptionsString(item.body) }}</div>
          </div>
        </div>

        <!-- 多选 -->
        <div v-show="item.question_type === 'MULTIPLE_CHOICE'" class="message box">
          <div class="notification">
            <div class="operate-box">
              <button v-show="isShowDeleteQuestion" @click="deleteQuestion(index)" class="delete"></button>
              <button @click="editQuestion(index)" class="button edit-question is-small" type="button" name="button">编辑问题</button>
            </div>
            <p class="detail">        id：{{ item.id }}
              &nbsp;&nbsp;&nbsp;&nbsp; 类型： 多选
              &nbsp;&nbsp;&nbsp;&nbsp; 难度：{{ item.level_type }}
            </p>
            <div class="question">题目：{{ item.title }}</div>
            <div class="question">选项：{{ getOptionsString(item.body) }}</div>
          </div>
        </div>
      </div>
    </div>

    <add-question ref="addQuestion"
                  v-on:getQuestion="getQuestion"
    ></add-question>

    <edit-question ref="editQuestion"
                   v-on:getQuestion="getQuestion"
                   v-bind:edit-data="editData"
    ></edit-question>

    <pagination v-bind:pagination-data="paginationData"
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
       paginationData: null,
       data: null,
       searchKey: null,
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
      let prompt = confirm("确认删除该问题吗？");
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
      // that.$refs.editQuestion.switchModal();
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
    getOptionsString: function (value) {
      const that = this;
      let arr = value.split(' ');
      let alphabet = ['A','B','C','D','E','F','G','H','I'];
      let str = '';
      for (let i = 0; i < arr.length; i++) {
        str += alphabet[i] + '.' + arr[i] + '   ';
      }
      return str;
    },
  },
  computed: {
    isShowCreateQuestion() {
      return sessionStorage.getItem('permissions').includes(34);
    },
    isShowSearchQuestion() {
      return sessionStorage.getItem('permissions').includes(35);
    },
    isShowUpdateQuestion() {
      return sessionStorage.getItem('permissions').includes(36);
    },
    isShowDeleteQuestion() {
      return sessionStorage.getItem('permissions').includes(37);
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
</style>
