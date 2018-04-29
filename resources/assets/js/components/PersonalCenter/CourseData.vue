<!-- 查看课程 -->
<template lang="html">
  <div class="box">
    <div>
        <div class="search-box">
          <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入课程">
          <!-- <button class="button" type="button" name="button">查找课程</button> -->
          <div @click="searchCourse()" class="search-button"><i class="fas fa-search"></i></div>
        </div>
    </div>
    <p v-if="!courseData" class="empty-message-prompt">暂无课程</p>
    <table v-else class="table is-bordered is-striped is-hoverable is-fullwidths">
      <thead>
        <tr>
          <th>ID</th>
          <th>课程名</th>
          <th>课程别名</th>
          <th>课程数</th>
          <th>课程描述</th>
          <th>创建时间</th>
          <!-- <th>更新时间</th> -->
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in courseData">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.display_name }}</td>
          <td>{{ item.number }}</td>
          <td><p class="limit-words">{{ item.descripe }}</p></td>
          <td>{{ GLOBAL.toTime(item.created_at) }}</td>
          <!-- <td>{{ GLOBAL.toTime(item.updated_at) }}</td> -->
        </tr>
      </tbody>
    </table>


    <pagination v-show="searchResult.length === 0"
                v-bind:pagination-data="paginationData"
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
      courseData: null,
      editData: null,
      paginationData: null,
      data: null,
      searchKey: '',
      // get all course
      currentCourse: [],
      allCourse: [],
      searchResult: [],

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
    getCourse: function() {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/courses`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.courseData = res.data.data;
        that.paginationData = res.data.links;
        //
      }).catch(err => {
        console.log(err)
      })
    },
    searchCourse: function () {
      const that = this;
      // 如果没有搜索值
      if (!that.searchKey) {
        that.getCourse();
        that.searchResult = [];
        return;
      }
      // 如果已经获取全部数据
      else if (that.allCourse.length > 0) {
        let allData  = that.allCourse;
        let len = that.allCourse.length;
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
        that.courseData = res;
      }
      // 如果有搜索值并且还未获取全部数据
      else {
        let url = `${this.GLOBAL.localDomain}/api/v1/courses/`;
        that.getAllCourse(url);
      }
    },
    getAllCourse: function (url) {
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
            that.currentCourse.push(res.data.data[i]);
          }
        }
        else if (that.getJsonLength(res.data.data)) {
          for (let i in res.data.data) {
            that.currentCourse.push(res.data.data[i]);
          }
        }

        if (that.url) {
          that.getAllCourse(that.url);
        }
        else {
          that.allCourse = that.currentCourse;
        }
      }).catch(err => {
        console.log(err);
      })
    },

  },
  computed: {
  },
  created() {
    this.getCourse();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.courseData = value.data;
      that.paginationData = value.links;
    },
    allCourse: function (value, oldValue) {
      const that = this;
      that.searchCourse(that.searchKey);
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
.add-course-button {
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
