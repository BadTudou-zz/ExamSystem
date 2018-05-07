<!-- 查看讨论 -->
<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-content">
      <div class="box">

        <div class="search-box">
          <div class="field">
            <div class="control">
              <div class="select is-small">
                <select  v-model="searchType" @change="changeSeachType()">
                  <option value="">请选择查找类型</option>
                  <option value="fuzzy-search">模糊查找</option>
                  <option value="user-id-search">根据用户ID查找</option>
                  <option value="lecture-id-search">根据授课ID查找</option>
                </select>
              </div>
            </div>
          </div>

          <input v-model="searchKey" class="input search-input" type="text" placeholder="">
          <div class="search-button"><i class="fas fa-search"></i></div>
        </div>

        <button v-show="roleName !== 'student'" @click="addDiscuss()" class="button add-discuss-button" type="button" name="button">添加讨论</button>

        <p v-if="!discussData" class="empty-message-prompt">暂无讨论</p>
        <table v-else class="table is-bordered is-striped is-hoverable is-fullwidths">
          <thead>
            <tr>
              <th>序号</th>
              <th>标题</th>
              <th>内容</th>
              <th>操作</th>
            </tr>
          </thead>
        <tbody>
            <tr v-for="(item,index) in discussData">
              <td>{{ item.id }}</td>
              <td>{{ item.title }}</td>
              <td>{{ item.content }}</td>
              <td>
                <button  v-show="roleName !== 'student'" disabled @click="publishDiscuss(index)" class="button is-small" type="button" name="button">发布讨论</button>
                <button @click="reply(index)" class="button is-small" type="button" name="button">查看讨论</button>
                <div  v-show="roleName !== 'student'" @click="deleteDiscuss(index)" class="icon-button"><i class="far fa-trash-alt"></i></div>
                <div  v-show="roleName !== 'student'" @click="editDiscuss(index)" class="icon-button"><i class="fas fa-edit"></i></div>
              </td>
            </tr>
          </tbody>
        </table>

      </div>
    </div>
    <button @click="switchModal()" class="modal-close is-large" aria-label="close"></button>


    <add-discuss ref="addDiscuss"
                 v-on:getDiscuss="getDiscuss"
                 v-bind:current-teaching-data="currentTeachingData"></add-discuss>

    <edit-discuss ref="editDiscuss"
                  v-on:getDiscuss="getDiscuss"
                  v-bind:edit-data="editData"
    ></edit-discuss>

    <reply ref="reply"
           v-on:getDiscuss="getDiscuss"
           v-bind:edit-data="editData"
    ></reply>

  </div>

</template>

<script>
import AddDiscuss from './AddDiscuss'
import EditDiscuss from './EditDiscuss'
import Reply from './Reply'

export default {
  data() {
    return {
      isShowModal: false,
      discussData: null,
      searchKey: '',
      // get all discuss
      currentDiscuss: [],
      allDiscuss: [],
      searchResult: [],
      editData: null,
      searchType: '',
      roleName: sessionStorage.getItem('roleName'),
    }
  },
  components: {
    AddDiscuss,
    EditDiscuss,
    Reply,
  },
  props: [
    'currentTeachingData'
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    reply: function (index) {
      const that = this;
      that.editData = that.discussData[index];
      that.$refs.reply.switchModal();
    },
    addDiscuss: function() {
      const that = this;
      that.$refs.addDiscuss.switchModal();
    },
    editDiscuss: function (index) {
      const that = this;
      that.editData = that.discussData[index];
      that.$refs.editDiscuss.switchModal();
    },
    deleteDiscuss: function (index) {
      const that = this;
      let id = that.discussData[index]['id'];
      let prompt = confirm("确认删除该讨论吗？");
      if (prompt) {
        axios({
          method: 'post',
          url: `${this.GLOBAL.localDomain}/api/v1/discuss/deleteDiscuss`,
          headers: {
            'Accept': 'application/json',
            'Authorization': sessionStorage.getItem('token'),
          },
          params: {
            id: id,
          }
        }).then(res => {
          alert('删除成功');
          that.getDiscuss()
        }).catch(err => {
          alert('删除失败')
          console.log(err)
        })
      }
    },
    // 通过授课ID获取讨论信息
    getDiscussForCid: function() {
      const that = this;
      let l_id = that.currentTeachingData.id;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/discuss/selectDiscussForLid`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          'l_id': l_id
        },
      }).then(res => {
        that.discussData = res.data;
      }).catch(err => {
        console.log(err);
      })
    },
    // 通过userID获取讨论信息
    getDiscussForUserId: function() {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/discuss/selectDiscussForUserid`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          userid: sessionStorage.getItem('userId')
        }
      }).then(res => {
        that.discussData = res.data.data;
      }).catch(err => {
        console.log(err);
      })
    },
    getDiscuss: function() {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/discuss/selectDiscussAll`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.discussData = res.data;
      }).catch(err => {
        console.log(err);
      })
    },
    searchDiscuss: function () {
      const that = this;
      // 如果没有搜索值
      if (!that.searchKey) {
        that.getDiscuss();
        that.searchResult = [];
        return;
      }
      // 如果已经获取全部数据
      else if (that.allDiscuss.length > 0) {
        let allData  = that.allDiscuss;
        let len = that.allDiscuss.length;
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
        that.discussData = res;
      }
      // 如果有搜索值并且还未获取全部数据
      else {
        let url = `${this.GLOBAL.localDomain}/api/v1/discusss/`;
        that.getAllDiscuss(url);
      }
    },
    getAllDiscuss: function (url) {
      const that = this;
      let urlPath = url ? url : that.url
      axios({
        method: 'post',
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
            that.currentDiscuss.push(res.data.data[i]);
          }
        }
        else if (that.getJsonLength(res.data.data)) {
          for (let i in res.data.data) {
            that.currentDiscuss.push(res.data.data[i]);
          }
        }

        if (that.url) {
          that.getAllDiscuss(that.url);
        }
        else {
          that.allDiscuss = that.currentDiscuss;
        }
      }).catch(err => {
        console.log(err);
      })
    },
    changeSeachType: function () {
      const that = this;
      let searchType = that.searchType;
      switch (searchType) {
        case '':
          break;
        case 'fuzzy-search':
          that.getDiscuss();
          break;
        case 'user-id-search':
          that.getDiscussForUserId();
          break;
        case 'lecture-id-search':
          that.getDiscussForCid();
          break;
      }
    },
    publishDiscuss: function (index) {
      const that = this;
      let discussId = that.discussData[index]['id']
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/discuss/publish`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          id: discussId,
        }
      }).then(res => {
        that.getDiscuss();
        alert('发布成功');
      }).catch(err => {
        alert('发布失败');
        console.log(err);
      })
    },
    computedPublishStatus: function (value) {
      const that = this;
      let status = '';
      switch (value) {
        case 0:
          status = '未发布';
          break;
        case 1:
          status = '已发布';
          break;
      }
      return status;
    }
  },
  computed: {
  },
  created() {
  },
  watch: {
    isShowModal: function (value, oldValue) {
      const that = this;
      that.getDiscuss();
    },
    // currentTeachingData: function (value, oldValue) {
    //   const that = this;
    //   that.getDiscuss();
    // }
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
  width: 400px;
  padding-right: 20px;
  display: inline-block;
  border-right: 1px solid #dedede;
}
.add-discuss-button {
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
.modal-content {
  width: 1200px;
}
.field {
  display: inline-block;
}
</style>
