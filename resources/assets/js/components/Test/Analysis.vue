<!-- 考试结果分析 -->
<template lang="html">
  <div>
    <div class="item-box">f</div>
    <div class="item-box">f</div>
    <div class="item-box">f</div>
    <div class="item-box">f</div>
    <ve-pie :data="chartData" :settings="chartSettings"></ve-pie>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isShowModal: false,
      userData: [],
      scoreData: [],
      chartData: {
        columns: ['日期', '成本', '利润'],
        rows: [
          { '日期': '1月1号', '分数': 123, '人数': 3 },
          { '日期': '1月2号', '分数': 1223, '人数': 6 },
          { '日期': '1月3号', '分数': 2123, '人数': 90 },
          { '日期': '1月4号', '分数': 4123, '人数': 12 },
          { '日期': '1月5号', '分数': 3123, '人数': 15 },
          { '日期': '1月6号', '分数': 7123, '人数': 20 }
        ]
      },
      chartSettings: {
        dimension: '分数',
        metrics: '人数'
      },
      userScoresList: [],
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
    getScores: function () {
      const that = this;
      let examId = that.examData.id;
      let score = '';
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/${examId}/scores`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.scoreData = res.data.data;
        for (let i in that.scoreData) {
          that.userScoresList.push(that.scoreData[i].score);
        }

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
      that.getScores();
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
.modal-card-body {
  background-color: #f9fbfc;
}
.modal-card {
  width: 1000px;
}
.item-box {
  width: 20%;
  height: 100px;
  display: inline-block;
  margin-left: 35px;
  border-radius: 5px;
  box-shadow: 4px 4px 7px #f5f5f5;
  background-color: #fff;
}
</style>
