<!-- 查看问题 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input class="input search-input" type="text" placeholder="请输入你要查看的问题">
        <button @click="searchQuestion()" class="button" type="button" name="button">查找问题</button>
      </div>
        <button @click="addQuestion()" class="button add-role-button" type="button" name="button">添加问题</button>
    </div>

    <div  v-for="item in questionData" class="message box">
      <div class="notification">
        <button @click="editQuestion()" class="button edit-question" type="button" name="button">编辑问题</button>
        <button class="delete"></button>
        <p class="question">问题题目：{{ item.title }}
          &nbsp;&nbsp;&nbsp;&nbsp; 问题类型：{{ item.question_type }}
          &nbsp;&nbsp;&nbsp;&nbsp; 难易程度：{{ item.level_type }}
        </p>
        {{ item.body }}
        <p class="time">{{item.created_at}}</p>
      </div>
      <div class="answer">
        <p>回复：{{ item.answer_comment }}</p>
      </div>
    </div>

    <add-question ref="addQuestion"></add-question>
    <edit-question ref="editQuestion" v-bind:edit-data="editData"></edit-question>
  </div>
</template>

<script>
import AddQuestion from './AddQuestion'
import EditQuestion from './EditQuestion'

export default {
  data() {
    return {
      "questionData": [
        {
              "id": 2,
              "question_type": "SINGLE_CHOICE",
              "tag_id": "0",
              "level_type": "EASY",
              "title": "1+1等于多少23234？",
              "body": "1.2 \n2. 3\n3. 4",
              "answer": "1",
              "answer_comment": "没有",
              "created_at": "2018-01-27 04:54:50",
              "updated_at": "2018-01-27 04:59:21"
          },
          {
              "id": 3,
              "question_type": "SINGLE_CHOICE",
              "tag_id": "0",
              "level_type": "EASY",
              "title": "1+1等于多少23234？",
              "body": "1.2 \n2. 3\n3. 4",
              "answer": "1",
              "answer_comment": "没有",
              "created_at": "2018-01-27 04:58:32",
              "updated_at": "2018-01-27 04:58:32"
          },
          {
              "id": 4,
              "question_type": "SINGLE_CHOICE",
              "tag_id": "0",
              "level_type": "EASY",
              "title": "1+1等于多少？",
              "body": "1.2 \n2. 3\n3. 4",
              "answer": "1",
              "answer_comment": "没有",
              "created_at": "2018-01-27 05:06:28",
              "updated_at": "2018-01-27 05:06:28"
          }
       ],

       isShowModal: false,
       // questionData: null,
       token: null,
       editData: null,
    }
  },
  components: {
    AddQuestion,
    EditQuestion,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    deleteQuestion: function (index) {
      const that = this;
      let id = that.questionData[index]['id'];
      let prompt = confirm("确认删除改问题吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/questions/${id}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': that.token
          }
        }).then(res => {
          that.questionData = res.data.data;
        }).catch(err => {
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
          'Authorization': that.token
        }
      }).then(res => {
         
        that.questiondData = [];
        that.questiondData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    },
    addQuestion: function () {
      const that = this;
      that.$refs.addQuestion.switchModal();
    },
    editQuestion: function () {
      const that = this;
      that.$refs.editQuestion.switchModal();
    },
    searchQuestion: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/questions/${that.questionId}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.questionData = [];
        that.questionData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    }
  },
  created() {
    this.token = sessionStorage.getItem('token');
    // this.getQuestion();
  },
  watch: {
  }
}
</script>

<style lang="scss">
.message {
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
.answer {
  margin-left: 50px;
}
.edit-question {
  float: right;
}
</style>
