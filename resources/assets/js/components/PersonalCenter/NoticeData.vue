<!-- 查看通知 -->
<template lang="html">
  <div class="box">
    <h3 class="title">通知</h3>

    <p v-if="!noticeData" class="empty-message-prompt">暂无通知</p>
    <div v-else  v-for="(item,index) in noticeData" class="notice box">
      <div class="notification">
        {{ item.data}}
        <p>{{ GLOBAL.toTime(item.created_at.date) }}</p>
      </div>
    </div>

    <pagination v-bind:pagination-data="paginationData"
                v-model="data"
    ></pagination>

  </div>


</template>

<script>
import Pagination from './../Pagination.vue'
export default {
  data() {
    return {
      noticeData: [],
      isShowModal: false,
      paginationData: null,
      data: null,
    }
  },
  components: {
    // AddNotice,
    Pagination,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    getNotice: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/${sessionStorage.getItem('userId')}/notifications/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.noticeData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
  },
  computed: {
  },
  created() {
    this.getNotice();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.noticeData = value.data;
      that.paginationData = value.links;
    }
  }
}
</script>

<style lang="scss">
.notice {
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
.notification p{
  margin-top: 25px;
  text-align: right;
}
.title {
  color: #363636;
  font-size: 1.5rem;
  font-weight: 600;
  line-height: 1.125;
}
</style>
