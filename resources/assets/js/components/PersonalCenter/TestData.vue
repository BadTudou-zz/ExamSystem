<!-- 查看考试 -->
<template lang="html">
  <div class="box">
    <h3 class="title">考试</h3>
    <table class="table">
      <thead>
        <tr>
          <th>from</th>
          <th>to</th>
          <th>action</th>
          <th>resource_id</th>
          <th>resource_type</th>
          <th>data</th>
          <th>更新时间</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in testData">
          <td>{{ item.from }}</td>
          <td>{{ item.to }}</td>
          <td>{{ item.action }}</td>
          <td>{{ item.resource_id }}</td>
          <td>{{ item.resource_type }}</td>
          <td>{{ item.data }}</td>
          <td>{{ item.updated_at.date }}</td>
        </tr>
      </tbody>
    </table>

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
      isShowModal: false,
      searchKey: null,
      testData: null,
      editData: null,
      searchKey: null,
      paginationData: null,
      data: null,
    }
  },
  components: {
    Pagination,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    getTest: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/applications/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        // that.testData = [];
        // that.testData.push(res.data.data);

        that.testData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
  },
  computed: {
  },
  created() {
    this.getTest();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.testData = value.data;
      that.paginationData = value.links;
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
.title {
  color: #363636;
  font-size: 1.5rem;
  font-weight: 600;
  line-height: 1.125;
}
</style>
