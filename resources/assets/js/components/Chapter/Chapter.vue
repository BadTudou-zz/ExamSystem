<!-- 查看章节 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入你要查看的章节">
        <button @click="searchChapter()" class="button" type="button" name="button">查找章节</button>
      </div>
        <button @click="addChapter()" class="button add-role-button" type="button" name="button">添加章节</button>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>章节名称</th>
          <th>描述</th>
          <th>问题类型</th>
          <th>成绩总值</th>
          <th>数量</th>
          <th>问题</th>
          <th>创建时间</th>
          <th>更新时间</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in chapterData">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.description }}</td>
          <td>{{ item.question_type }}</td>
          <td>{{ item.score }}</td>
          <td>{{ item.number }}</td>
          <td>{{ item.questions }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
          <td>
            <button @click="deleteChapter(index)" class="button" type="button" name="button">删除章节</button>
            <button @click="editChapter(index)" class="button" type="button" name="button">编辑章节</button>
          </td>
        </tr>
      </tbody>
    </table>

    <add-chapter ref="addChapter"></add-chapter>
    <edit-chapter ref="editChapter"></edit-chapter>

  </div>
</template>

<script>
import AddChapter from './AddChapter'
import EditChapter from './EditChapter'
export default {
  data() {
    return {
      chapterData: [
        {
          "id": 8,
          "name": "选择题12312",
          "describe": "单选",
          "question_type": "SINGLE_CHOICE",
          "score": 100,
          "number": 100,
          "questions": null,
          "created_at": "2018-02-04 07:31:25",
          "updated_at": "2018-02-04 07:52:05"
        }
      ],
      isShowModal: false,
      token: null,
      // chapterData: null
      searchKey: null,
    }
  },
  components: {
    AddChapter,
    EditChapter,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    deleteChapter: function (index) {
      const that = this;
      let id = that.chapterData[index].id;
      let prompt = confirm("确认删除该章节吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/papers/1/sections/${id}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': that.token
          }
        }).then(res => {
          that.chapterData = res.data.data;
        }).catch(err => {
          console.log(err)
        })
      }
    },
    searchChapter: function () {
      const that = this;
      let id = that.searchKey;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/papers/1/sections/${id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.chapterData = [];
        that.chapterData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    },
    getChapter: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/papers/1/sections/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
         
        that.chapterData = [];
        that.chapterData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    },
    addChapter: function () {
      const that = this;
      that.$refs.addChapter.switchModal();
    },
    editChapter: function (index) {
      const that = this;
      that.editData = that.chapterData[index];
      // that.$refs.addChapter.switchModal();
      that.$refs.editChapter.switchModal();
    },
  },
  created() {
    this.token = sessionStorage.getItem('token');
    // this.getChapter();
  },
  watch: {
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
