<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">成绩详情</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
          <thead>
            <tr>
              <th></th>
              <th>详情</th>
            </tr>
          </thead>
        <tbody>
            <tr>
              <td>成绩</td>
              <td>{{ score }}</td>
            </tr>
            <!-- <tr>
              <td></td>
              <td>{{ currentTeachingData.name }}</td>
            </tr> -->

          </tbody>
        </table>
      </section>
    </div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      isShowModal: false,
      score: '暂无考试成绩',
    }
  },
  components: {
  },
  props: [
    'examId'
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    getScore: function () {
      const that = this;
      let examId = that.examId;
      let score = '';
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/${examId}/score`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        this.score = res.data.data.score;
      }).catch(err => {
        console.log(err);
      })
    },

  },
  computed: {
  },
  created() {
  },
  watch: {
    isShowModal: function (value,oldValue) {
      const that = this;
      if (value) {
        this.getScore();
      }
    },
    examId: function () {
      const that = this;
      
    }
  }
}
</script>

<style scoped>

</style>
