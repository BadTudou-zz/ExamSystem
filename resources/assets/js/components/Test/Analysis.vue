<!-- 考试结果分析 -->
<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">结果分析</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">

      </section>
      <footer class="modal-card-foot">
        <button @click="addTest()" class="button is-success">确认</button>
        <button  @click="switchModal()" class="button">取消</button>
      </footer>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isShowModal: false,
      userData: [],
      scoreData: null,
    }
  },
  components: {
  },
  props: [
    'examData'
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    // 获取参加该考试的所有用户
    getUser: function () {
      const that = this;
      let id = that.examData.id;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/${id}/users`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.userData = res.data.data;
        // that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
    getScore: function () {
      const that = this;
      let examId = that.examData.id;
      let score = '';
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/${examId}/score`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.scoreData = res.data.score;
      }).catch(err => {
        console.log(err);
      })
    }
  },
  created() {
  },
  watch: {
    examData: function (value, oldValue) {
      const that = this;
      that.getUser();
    },
    userData: function (value, oldValue) {
      const that = this;
      for (let i in value) {
        let itemId = value[i]['id'];
        that.getScore();
      }
    }
  }
}
</script>

<style scoped>
.modal-card {
  width: 1000px;
}
</style>
