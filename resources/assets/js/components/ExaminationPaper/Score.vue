<!-- 查看分数 -->
<template lang="html">
  <div class="modal" v-bind:class="{'is-active': isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-content score-content">
      <div class="box score-box">
        <table class="table">
          <thead>
            <tr>
              <th>题号</th>
              <th>分值</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item,index) in scoreData">
              <td>{{ index }}</td>
              <td>{{ item }}分</td>
            </tr>
          </tbody>
        </table>

        <!-- <pagination v-bind:pagination-data="paginationData"
                    v-model="data"
        ></pagination> -->

      </div>
    </div>
    <button @click="switchModal()" class="modal-close is-large" aria-label="close"></button>
  </div>
</template>

<script>
// import Pagination from './../Pagination'

export default {
  data() {
    return {
      isShowModal: false,
      scoreData: null,
      paginationData: null,
      data: null,
      examinationPaperId: null,
//       scoreData: {
//         "1": "5",
//         "2": "4"
//       }
    }
  },
  components: {
    // Pagination,
  },
  props: [
    'currentExaminationPaperData',
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    getScore: function () {
      const that = this;
      let paperId = that.examinationPaperId;
      if (!paperId) return;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/papers/${paperId}/scores`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.scoreData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
  },
  created() {
  },
  watch: {
    // data:function (value, oldValue) {
    //   const that = this;
    //   that.examinationPaperData = value.data;
    //   that.paginationData = value.links;
    // },
    currentExaminationPaperData: function (value, oldValue) {
      const that = this;
      that.examinationPaperId = value.id;
      that.getScore();
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
.score-box {
  width: 1300px;
}
.score-content {
  width: 1300px;
}
</style>
