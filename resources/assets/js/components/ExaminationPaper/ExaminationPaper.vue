<!-- 查看试卷 -->
<template lang="html">
  <div class="box">
    <div>
      <div v-show="isShowSearchPaper" class="search-box">
        <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入关键字">
        <!-- <button disabled @click="searchExaminationPaper()" class="button" type="button" name="button">查找试卷</button> -->
        <div @click="searchExaminationPaper()" class="search-button"><i class="fas fa-search"></i></div>
      </div>
        <button v-show="isShowCreatePaper" @click="addExaminationPaper()" class="button add-examinationPaper-button" type="button" name="button">添加试卷</button>
        <button disabled v-show="isShowUpdatePaper" @click="updatePaper()" class="button" type="button" name="button">同步试卷</button>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>序号</th>
          <!-- <th>创建者</th> -->
          <th>试卷标题</th>
          <th>总分数</th>
          <th>时长</th>
          <th>描述</th>
          <!-- <th>章节id</th> -->
          <!-- <th>Tags</th> -->
          <th>创建时间</th>
          <th>更新时间</th>
          <th>试卷操作</th>
          <th>章节操作</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in examinationPaperData">
          <td>{{ item.id }}</td>
          <!-- <td>{{ item.creator_id }}</td> -->
          <td>{{ item.title }}</td>
          <td>{{ item.score }}</td>
          <td>{{ item.min }}</td>
          <td> {{ item.description }}</td>
          <!-- <td>{{ item.sections }}</td> -->
          <!-- <td>{{ item.tags }}</td> -->
          <td>{{ toTime(item.created_at) }}</td>
          <td>{{ toTime(item.updated_at) }}</td>
          <td>
            <button v-show="isShowDeletePaper" @click="deleteExaminationPaper(index)" class="delete" type="button" name="button">删除试卷</button>
            <div @click="editExaminationPaper(index)" class="edit-button"><i class="fas fa-edit"></i></div>
            <button @click="showAllQuestion(index)" class="button is-small" type="button" name="button">全部问题</button>
            <button @click="showAllScore(index)" class="button is-small" type="button" name="button">全部分数</button>
          </td>
          <td>
            <button @click="showChapter(index)" class="button is-small" type="button" name="button">查看章节</button>
          </td>
        </tr>
      </tbody>
    </table>

    <add-examination-paper ref="addExaminationPaper"
                           v-on:getExaminationPaper="getExaminationPaper"
    ></add-examination-paper>

    <edit-examination-paper ref="editExaminationPaper"
                            v-on:getExaminationPaper="getExaminationPaper"
                            v-bind:edit-data="editData"
    ></edit-examination-paper>

    <chapter ref="chapter"
             v-bind:current-examination-paper-data="currentExaminationPaperData"
    ></chapter>

    <question ref="question"
              v-bind:current-examination-paper-data="currentExaminationPaperData"
    ></question>

    <score ref="score"
           v-bind:current-examination-paper-data="currentExaminationPaperData"
    ></score>

    <pagination v-show="searchResult.length === 0"
                v-bind:pagination-data="paginationData"
                v-model="data"
    ></pagination>

  </div>
</template>

<script>
import moment from 'moment'
import Pagination from './../Pagination.vue'
import AddExaminationPaper from './AddExaminationPaper'
import EditExaminationPaper from './EditExaminationPaper'
import Chapter from './../Chapter/Chapter'
import Question from './Question'
import Score from './Score'

export default {
  data() {
    return {
      searchKey: null,
      examinationPaperData: null,
      isShowModal: false,
      editData: null,
      paginationData: null,
      data: null,
      editData: null,
      currentExaminationPaperData: null,
      // get all examinationPaper
      currentExaminationPaper: [],
      allExaminationPaper: [],
      searchResult: [],
    }
  },
  components: {
    Pagination,
    AddExaminationPaper,
    EditExaminationPaper,
    Chapter,
    Question,
    Score,
  },
  methods: {
    toTime: function (time) {
      return moment(time).format('YYYY-MM-DD');
    },
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    deleteExaminationPaper: function (index) {
      const that = this;
      let id = that.examinationPaperData[index]['id'];
      let prompt = confirm("确认删除该试卷吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/papers/${id}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': sessionStorage.getItem('token'),
          }
        }).then(res => {
          alert('删除成功');
          that.getExaminationPaper();
        }).catch(err => {
          alert('删除失败');
          console.log(err);
        })
      }
    },
    getExaminationPaper: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/papers`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.examinationPaperData = res.data.data;
        // that.examinationPaperData = [];
        // that.examinationPaperData.push(res.data.data);
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
    // searchExaminationPaper: function () {
    //   const that = this;
    //   let id = that.searchKey;
    //   if (!id) {
    //     that.searchKey = '';
    //     that.getExaminationPaper();
    //     return;
    //   }
    //   axios({
    //     method: 'get',
    //     url: `${this.GLOBAL.localDomain}/api/v1/papers/${id}`,
    //     headers: {
    //       'Accept': 'application/json',
    //       'Authorization': sessionStorage.getItem('token'),
    //     }
    //   }).then(res => {
    //     that.examinationPaperData = [];
    //     that.examinationPaperData.push(res.data.data);
    //     that.searchKey = '';
    //   }).catch(err => {
    //     alert('没有查找到相关数据，已加载全部数据');
    //     that.searchKey = '';
    //     that.getExaminationPaper();
    //     console.log(err);
    //   })
    // },
    searchExaminationPaper: function () {
      const that = this;
      // 如果没有搜索值
      if (!that.searchKey) {
        that.getExaminationPaper();
        that.searchResult = [];
        return;
      }
      // 如果已经获取全部数据
      else if (that.allExaminationPaper.length > 0) {
        let allData  = that.allExaminationPaper;
        let len = that.allExaminationPaper.length;
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
        that.examinationPaperData = res;
      }
      // 如果有搜索值并且还未获取全部数据
      else {
        let url = `${this.GLOBAL.localDomain}/api/v1/papers/`;
        that.getAllExaminationPaper(url);
      }
    },
    getAllExaminationPaper: function (url) {
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
            that.currentExaminationPaper.push(res.data.data[i]);
          }
        }
        else if (that.getJsonLength(res.data.data)) {
          for (let i in res.data.data) {
            that.currentExaminationPaper.push(res.data.data[i]);
          }
        }

        if (that.url) {
          that.getAllExaminationPaper(that.url);
        }
        else {
          that.allExaminationPaper = that.currentExaminationPaper;
        }
      }).catch(err => {
        console.log(err);
      })
    },
    addExaminationPaper: function () {
      const that = this;
      that.$refs.addExaminationPaper.switchModal();
    },
    editExaminationPaper: function (index) {
      const that = this;
      that.editData = that.examinationPaperData[index];
      that.$refs.editExaminationPaper.switchModal();
    },
    showChapter: function (index) {
      const that = this;
      that.currentExaminationPaperData = that.examinationPaperData[index];
      that.$refs.chapter.switchModal();
    },
    showAllQuestion: function (index) {
      const that = this;
      that.currentExaminationPaperData = that.examinationPaperData[index];
      that.$refs.question.switchModal();
    },
    showAllScore: function (index) {
      const that = this;
      that.currentExaminationPaperData = that.examinationPaperData[index];
      that.$refs.score.switchModal();
    }
  },
  computed: {
    isShowCreatePaper() {
      return sessionStorage.getItem('permissions').includes('paper-store');
      // return true;
    },
    isShowSearchPaper() {
      return sessionStorage.getItem('permissions').includes('paper-show');
      // return true;
    },
    isShowUpdatePaper() {
      return sessionStorage.getItem('permissions').includes('paper-update');
      // return true;
    },
    isShowDeletePaper() {
      // return true;
      return sessionStorage.getItem('permissions').includes('paper-destroy');
    },
  },
  created() {

    this.getExaminationPaper();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.examinationPaperData = value.data;
      that.paginationData = value.links;
    },
    allExaminationPaper: function (value, oldValue) {
      const that = this;
      that.searchExaminationPaper(that.searchKey);
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
.add-examinationPaper-button {
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
