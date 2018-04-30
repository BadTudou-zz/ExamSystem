<!-- 查看题目类型 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入关键字">
        <div @click="searchQuestionType()" class="search-button"><i class="fas fa-search"></i></div>
      </div>
      <button @click="addQuestionType()" class="button add-questionType-button" type="button" name="button">添加题目类型</button>

      <button @click="getQuestionType()" class="button add-questionType-button" type="button" name="button">全部题目类型</button>
      <button @click="addQuestionType2()" class="button add-questionType-button" type="button" name="button">查看题目类型的全部题目</button>
    </div>

    <p v-if="!questionTypeData" class="empty-message-prompt">暂无题目类型</p>
    <table v-else class="table is-bordered is-striped is-hoverable is-fullwidths">
      <thead>
        <tr>
          <!-- created_at:"2018-04-29 19:24:25" -->
          <!-- delimiter:"!" -->
          <!-- id:1 -->
          <!-- is_multiple_choice:true -->
          <!-- name:"SINGLE_CHOICE"title:"单选题" -->
          <!-- updated_at:"2018-04-29 19:33:03" -->
          <th>序号</th>
          <th>类型名</th>
          <th>分隔符</th>
          <th>是否允许多选</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in questionTypeData">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.delimiter }}</td>
          <td>{{ computedIsAllowMultiple(item.is_multiple_choice) }}</td>
          <td>
            <div @click="editQuestionType(index)" class="icon-button"><i class="fas fa-edit"></i></div>
            <div @click="deleteQuestionType(index)" class="icon-button"><i class="far fa-trash-alt"></i></div>
          </td>
        </tr>
      </tbody>
    </table>

    <add-question-type ref="addQuestionType"
                  v-on:getQuestionType="getQuestionType"
    ></add-question-type>

    <edit-question-type ref="editQuestionType"
                   v-on:getQuestionType="getQuestionType"
                   v-bind:edit-data="editData"
    ></edit-question-type>

    <pagination v-show="searchResult.length === 0"
                v-bind:pagination-data="paginationData"
                v-model="data"
    ></pagination>
  </div>
</template>

<script>
import Pagination from './../Pagination'
import AddQuestionType from './AddQuestionType'
import EditQuestionType from './EditQuestionType'


export default {
  data() {
    return {
       isShowModal: false,
       questionTypeData: null,
       editData: null,
       //
       paginationData: null,
       data: null,
       //
       searchKey: null,
       // get all questionType
       currentQuestionType: [],
       allQuestionType: [],
       searchResult: [],

    }
  },
  components: {
    AddQuestionType,
    EditQuestionType,
    Pagination,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    // 全部题目类型
    getQuestionType: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/questionTypes`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.questionTypeData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err);
        if (err.response.status === 401) {
          // alert('登录超时');
          // location.reload();
        }
      })
    },
    // 查看题目类型的全部题目
    addQuestionType2: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/questionTypes/2/questions/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.questionTypeData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err);
        if (err.response.status === 401) {
          // alert('登录超时');
          // location.reload();
        }
      })
    },
    deleteQuestionType: function (index) {
      const that = this;
      let id = that.questionTypeData[index]['id'];
      let prompt = confirm("确认删除该类型吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/questionTypes/${id}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': sessionStorage.getItem('token'),
          }
        }).then(res => {
          alert('删除成功');
          that.getQuestionType();
        }).catch(err => {
          alert('删除失败');
          console.log(err)
        })
      }
    },
    getQuestionType: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/questionTypes`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.questionTypeData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err);
        if (err.response.status === 401) {
          // alert('登录超时');
          // location.reload();
        }
      })
    },
    addQuestionType: function () {
      const that = this;
      that.$refs.addQuestionType.switchModal();
    },
    editQuestionType: function (index, editData) {
      const that = this;
      if (editData) {
        that.editData = editData;
      }
      else {
        that.editData = that.questionTypeData[index];
      }
      that.$refs.editQuestionType.switchModal();
    },
    searchQuestionType: function () {
      const that = this;
      // 如果没有搜索值
      if (!that.searchKey) {
        that.getQuestionType();
        that.searchResult = [];
        return;
      }
      // 如果已经获取全部数据
      else if (that.allQuestionType.length > 0) {
        let allData  = that.allQuestionType;
        let len = that.allQuestionType.length;
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
        that.questionTypeData = res;
      }
      // 如果有搜索值并且还未获取全部数据
      else {
        let url = `${this.GLOBAL.localDomain}/api/v1/questionTypes/`;
        that.getAllQuestionType(url);
      }
    },
    getAllQuestionType: function (url) {
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
            that.currentQuestionType.push(res.data.data[i]);
          }
        }
        else if (that.getJsonLength(res.data.data)) {
          for (let i in res.data.data) {
            that.currentQuestionType.push(res.data.data[i]);
          }
        }

        if (that.url) {
          that.getAllQuestionType(that.url);
        }
        else {
          that.allQuestionType = that.currentQuestionType;
        }
      }).catch(err => {
        console.log(err);
      })
    },
    computedIsAllowMultiple: function(value) {
      const that = this;
      let string = '';
      switch (value) {
        case false:
          string = '禁止';
          break;
        case true:
          string = '允许';
          break;
      }
      return string;
    }
  },
  computed: {
  },
  created() {
    this.getQuestionType();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.questionTypeData = value.data;
      that.paginationData = value.links;
    },
    allQuestionType: function (value, oldValue) {
      const that = this;
      that.searchQuestionType(that.searchKey);
    }
  }
}
</script>

<style lang="scss" scoped>
.message {
  margin: 35px auto 0 auto;
}
.search-input {
  width: 250px;
  display: inline-block;
  margin-right: 10px;
}
.search-box {
  padding-right: 20px;
  display: inline-block;
  border-right: 1px solid #dedede;
}
.add-questionType-button {
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
.message {
  .notification {
    margin: 0;
  }
}
.notification .time{
  margin-top: 25px;
  text-align: right;
  padding-bottom: 20px;
  border-bottom: 1px solid #dedede;
}
.questionType {
  text-align: left;
  margin-bottom: 10px;
}
.edit-questionType {
  float: right;
}
.operate-box {
  height: 40px;
  line-height: 40px;
}
.delete {
  float: right;
  margin-left: 20px;
}
.answer {
  margin-left: 24px;
}
.multiple-choice {
  width: 200px;
}
.questionType-limit-words {
  display: inline-block;
  width: 200px;
  overflow: hidden;
  text-overflow:ellipsis;
  white-space: nowrap;
}

</style>
