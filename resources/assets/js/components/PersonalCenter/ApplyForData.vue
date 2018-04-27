<!-- 查看申请 -->
<template lang="html">
  <div class="box">
    <h3 class="title">申请</h3>

    <p v-if="!applyForData" class="empty-message-prompt">暂无申请</p>
    <table v-else class="table">
      <thead>
        <tr>
          <th>发送者</th>
          <!-- <th>to</th> -->
          <!-- <th>action</th> -->
          <!-- <th>resource_id</th> -->
          <!-- <th>resource_type</th> -->
          <th>data</th>
          <th>创建时间</th>
          <!-- <th>操作</th> -->
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in applyForData">
          <td>{{ item.from }}</td>
          <!-- <td>{{ item.to }}</td> -->
          <!-- <td>{{ item.action }}</td> -->
          <!-- <td>{{ item.resource_id }}</td> -->
          <!-- <td>{{ item.resource_type }}</td> -->
          <td>{{ item.data }}</td>
          <td>{{ GLOBAL.toTime(item.created_at.date) }}</td>
          <!-- <td>
            <button @click="acceptApplyFor(index)" class="button" type="button" name="button">接受</button>
            <button @click="rejectApplyFor(index)" class="button" type="button" name="button">拒绝</button>
          </td> -->
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
      applyForData: null,
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
    getApplyFor: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/${sessionStorage.getItem('userId')}/applications?reveived=true`,
        // url: `${this.GLOBAL.localDomain}/api/v1/applications/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        // that.applyForData = [];
        // that.applyForData.push(res.data.data);

        that.applyForData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
    acceptApplyFor: function (index) {
      const that = this;
      let id = that.applyForData[index].id;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/applications/${id}/accept`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        // that.applyForData = [];
        // that.applyForData.push(res.data.data);
        alert('已接受')
      }).catch(err => {
        alert('接受失败，请稍后再试')
        console.log(err)
      })
    },
    rejectApplyFor: function (index) {
      const that = this;
      let id = that.applyForData[index].id;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/applications/${id}/reject`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        alert('已拒绝')
        // that.applyForData = [];
        // that.applyForData.push(res.data.data);
      }).catch(err => {
        console.log(err)
        alert('拒绝失败，请稍后再试')
      })
    },
  },
  computed: {
  },
  created() {
    this.getApplyFor();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.applyForData = value.data;
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
