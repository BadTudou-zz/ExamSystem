<!-- 查看授课 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入关键字">
        <div @click="searchTeaching()" class="search-button"><i class="fas fa-search"></i></div>
      </div>
    </div>

    <p v-if="!teachingData" class="empty-message-prompt">暂无授课</p>
    <table v-else class="table is-bordered is-striped is-hoverable is-fullwidths">
      <thead>
        <tr>
          <th>授课名</th>
          <th>课程号</th>
          <th>描述</th>
          <th>最大容量</th>
          <th>当前容量</th>
          <th>更多</th>
        </tr>
      </thead>
    <tbody>
        <tr v-for="(item,index) in teachingData">
          <td>{{ item.name }}</td>
          <td><p class="limit-words">{{ item.description }}</p></td>
          <td>{{ item.max }}</td>
          <td>{{ item.current }}</td>
          <td>
            <button @click="showDetail(index)" class="button is-small" type="button" name="button">查看详情</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- <detail ref="detail"
            v-bind:current-teaching-data="currentTeachingData"
    ></detail> -->

    <pagination v-show="searchResult.length === 0"
                v-bind:pagination-data="paginationData"
                v-model="data"
    ></pagination>
  </div>
</template>

<script>
import Pagination from './../Pagination'
// import Detail from './Detail'

export default {
  data() {
    return {
      isShowModal: false,
      teachingData: [],
      searchKey: null,
      editData: null,
      paginationData: null,
      data: null,
      currentTeachingData: null,
      // get all teaching
      currentTeaching: [],
      allTeaching: [],
      searchResult: [],
    }
  },
  components: {
    Pagination,
    // Detail,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    getTeaching: function() {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/lectures`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.teachingData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
    searchTeaching: function () {
      const that = this;
      if (!that.searchKey) {
        that.searchKey = '';
        that.getTeaching();
        return;
      }
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/lectures/${that.searchKey}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.teachingData = [];
        that.teachingData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    },
    searchTeaching: function () {
      const that = this;
      // 如果没有搜索值
      if (!that.searchKey) {
        that.getTeaching();
        that.searchResult = [];
        return;
      }
      // 如果已经获取全部数据
      else if (that.allTeaching.length > 0) {
        let allData  = that.allTeaching;
        let len = that.allTeaching.length;
        let res = [];

        for (let i = 0; i < len; i++) {
          for (let j in allData[i]) {
            if (allData[i][j]) {
              if ((allData[i][j].toString()).indexOf(that.searchKey) !== -1) {
                res.push(allData[i]);
                break;
              }
            }
          }
        }
        that.searchResult = res;
        that.teachingData = res;
      }
      // 如果有搜索值并且还未获取全部数据
      else {
        let url = `${this.GLOBAL.localDomain}/api/v1/lectures/`;
        that.getAllTeaching(url);
      }
    },
    getAllTeaching: function (url) {
      const that = this;
      let urlPath = url ? url : that.url
      axios({
        method: 'get',
        url: urlPath,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.url = res.data.links.next;

        let len = res.data.data.length ? res.data.data.length : that.getJsonLength(res.data.data);

        // data数据结构不一致 可能是数组/也可能是json
        if (res.data.data.length) {
          for (let i = 0; i < len; i++) {
            that.currentTeaching.push(res.data.data[i]);
          }
        }
        else if (that.getJsonLength(res.data.data)) {
          for (let i in res.data.data) {
            that.currentTeaching.push(res.data.data[i]);
          }
        }

        if (that.url) {
          that.getAllTeaching(that.url);
        }
        else {
          that.allTeaching = that.currentTeaching;
        }
      }).catch(err => {
        console.log(err);
      })
    },
    showDetail: function (index) {
      const that = this;
      that.currentTeachingData = that.teachingData[index];
      that.$refs.detail.switchModal();
    }
  },
  computed: {
  },
  created() {
    this.getTeaching();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.teachingData = value.data;
      that.paginationData = value.links;
    },
    allTeaching: function (value, oldValue) {
      const that = this;
      that.searchTeaching(that.searchKey);
    }
  }
}
</script>

<style lang="scss" scoped>
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
.add-teaching-button {
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
</style>
