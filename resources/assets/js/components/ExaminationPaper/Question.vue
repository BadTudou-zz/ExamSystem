<!-- 查看题目 -->
<template lang="html">
  <div class="modal" v-bind:class="{'is-active': isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-content question-content">
      <div class="box question-box">
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>题目类型</th>
              <th>标签</th>
              <th>等级类型</th>
              <th>题目</th>
              <th>body</th>
              <th>答案</th>
              <th>答案评论</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item,index) in questionData">
              <td>{{ item.id }}</td>
              <td>{{ item.type_id }}</td>
              <td>{{ item.tags }}</td>
              <td>{{ item.level_type }}</td>
              <td>{{ item.title }}</td>
              <td>{{ item.body }}</td>
              <td>{{ item.answer }}</td>
              <td>{{ item.answer_comment }}</td>
            </tr>
          </tbody>
        </table>

        <pagination v-bind:pagination-data="paginationData"
                    v-model="data"
        ></pagination>

      </div>
    </div>
    <button @click="switchModal()" class="modal-close is-large" aria-label="close"></button>
  </div>
</template>

<script>
import Pagination from './../Pagination'

export default {
  data() {
    return {
      isShowModal: false,
      questionData: null,
      paginationData: null,
      data: null,
      examinationPaperId: null,
    }
  },
  components: {
    Pagination,
  },
  props: [
    'currentExaminationPaperData',
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    getQuestion: function () {
      const that = this;
      let id = that.examinationPaperId;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/papers/${id}/questions`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        if (res.data.data.length !== 0) {
          that.questionData  = res.data.data;
        }
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
  },
  created() {

  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.examinationPaperData = value.data;
      that.paginationData = value.links;
    },
    currentExaminationPaperData: function (value, oldValue) {
      const that = this;
      that.examinationPaperId = value.id;
      that.getQuestion();
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
.question-box {
  width: 1300px;
}
.question-content {
  width: 1300px;
}
</style>
