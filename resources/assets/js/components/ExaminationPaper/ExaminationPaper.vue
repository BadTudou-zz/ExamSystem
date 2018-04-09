<!-- 查看试卷 -->
<template lang="html">
  <div class="box">
    <div>
      <div v-show="isShowSearchPaper" class="search-box">
        <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入你要查看的试卷">
        <button @click="searchExaminationPaper()" class="button" type="button" name="button">查找试卷</button>
      </div>
        <button v-show="isShowCreatePaper" @click="addExaminationPaper()" class="button add-role-button" type="button" name="button">添加试卷</button>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>创建者ID</th>
          <th>试卷标题</th>
          <th>总分数</th>
          <th>最小</th>
          <th>描述</th>
          <th>章节id</th>
          <th>Tags</th>
          <th>创建时间</th>
          <th>更新时间</th>
          <th>试卷操作</th>
          <th>章节操作</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in examinationPaperData">
          <td>{{ item.id }}</td>
          <td>{{ item.creator_id }}</td>
          <td>{{ item.title }}</td>
          <td>{{ item.score }}</td>
          <td>{{ item.min }}</td>
          <td> {{ item.description }}</td>
          <td>{{ item.sections }}</td>
          <td>{{ item.tags }}</td>
          <td>{{ toTime(item.created_at) }}</td>
          <td>{{ toTime(item.updated_at) }}</td>
          <td>
            <button v-show="isShowDeletePaper" @click="deleteExaminationPaper(index)" class="button is-small" type="button" name="button">删除试卷</button>
            <button @click="editExaminationPaper(index)" class="button is-small" type="button" name="button">编辑试卷</button>
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

    <pagination v-bind:pagination-data="paginationData"
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
            'Authorization': this.GLOBAL.token,
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
          'Authorization': this.GLOBAL.token,
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
    searchExaminationPaper: function () {
      const that = this;
      let id = that.searchKey;
      if (!id) {
        alert('没有找到相关数据，已为你显示全部数据');
        that.getExaminationPaper();
        return;
      }
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/papers/${id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': this.GLOBAL.token,
        }
      }).then(res => {
        that.examinationPaperData = [];
        that.examinationPaperData.push(res.data.data);
        that.searchKey = '';
      }).catch(err => {
        alert('查找出错，已加载全部数据');
        that.searchKey = '';
        that.getExaminationPaper();
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
      return this.GLOBAL.permissions.includes(39);
    },
    isShowSearchPaper() {
      return this.GLOBAL.permissions.includes(40);
    },
    isShowUpdatePaper() {
      return this.GLOBAL.permissions.includes(41);
    },
    isShowDeletePaper() {
      return this.GLOBAL.permissions.includes(42);
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
</style>
