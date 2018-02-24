<!-- 查看问题 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input class="input search-input" type="text" placeholder="请输入你要查看的问题">
        <button class="button" type="button" name="button">查找问题</button>
      </div>
        <button @click="showModal()" class="button add-role-button" type="button" name="button">添加问题</button>
    </div>

    <div  v-for="item in data" class="message box">
      <div class="notification">
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

    <div class="modal" :class="{'is-active' : isShowModal}">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">添加问题</p>
          <button @click="showModal()" class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
          <div class="box-item">
            <label>发送到</label>
            <input class="input" type="text" placeholder="需要发送的用户名">
          </div>

          <div class="box-item">
            <label>问题内容</label>
            <textarea class="textarea" type="text"></textarea>
          </div>
        </section>
       <footer class="modal-card-foot">
          <button class="button is-success">确认</button>
          <button @click="showModal()" class="button">取消</button>
        </footer>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      "data": [
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
      let prompt = confirm("确认删除改问题吗？");
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
</style>
