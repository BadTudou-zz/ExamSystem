<!-- 查看讨论 -->
<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-content">
      <div class="box">
        <article class="media">
          <figure class="media-left">
            <!-- <p class="image is-64x64">
              <img src="https://bulma.io/images/placeholders/128x128.png">
            </p> -->
          </figure>
          <div class="media-content">
            <div class="content">
              <p>
                <strong>{{ discussData.user_name }}</strong>
                <br>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis porta eros lacus, nec ultricies elit blandit non. Suspendisse pellentesque mauris sit amet dolor blandit rutrum. Nunc in tempus turpis.
                {{ discussData.body }}
                <br>
                <small><a @click="deleteReply()">Delete</a> · <a>Reply</a> · {{ discussData.created_at }}</small>
              </p>
            </div>

            <article class="media">
              <figure class="media-left">
                <!-- <p class="image is-48x48">
                  <img src="https://bulma.io/images/placeholders/96x96.png">
                </p> -->
              </figure>
              <div class="media-content">
                <div v-for="(item, index) in replyData" class="content">
                  <p>
                    <strong>{{ item.user_name }} </strong>
                    <br>
                    Sed convallis scelerisque mauris, non pulvinar nunc mattis vel. Maecenas varius felis sit amet magna vestibulum euismod malesuada cursus libero. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus lacinia non nisl id feugiat.
                    {{ item.body }}
                    <br>
                    <small><a @click="deleteReply(index)">Delete</a> · <a>Reply</a> · {{ item.created_at }}</small>
                  </p>
                </div>
              </div>
            </article>
          </div>
        </article>
        <article class="media">
          <figure class="media-left">
            <!-- <p class="image is-64x64">
              <img src="https://bulma.io/images/placeholders/128x128.png">
            </p> -->
          </figure>
          <div class="media-content">
            <div class="field">
              <p class="control">
                <textarea class="textarea" placeholder="Add a comment..."></textarea>
              </p>
            </div>
            <div class="field">
              <p class="control">
                <button @click="postComment" class="button">发布评论</button>
              </p>
            </div>
          </div>
        </article>
      </div>
    </div>
    <button @click="switchModal()" class="modal-close is-large" aria-label="close"></button>

  </div>

</template>

<script>

export default {
  data() {
    return {
      isShowModal: false,
      replyData: null,
      discussData: null,
      searchKey: '',
      // get all reply
      currentReply: [],
      allReply: [],
      searchResult: [],
      searchType: '',
    }
  },
  components: {
  },
  props: [
    'editData'
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    postComment: function (index) {
      const that = this;

      let discuss_id = that.editData['id'];
      let userid = sessionStorage.getItem('userid');


      let prompt = confirm("确认删除该讨论吗？");
      // if (prompt) {
      //   axios({
      //     method: 'post',
      //     url: `${this.GLOBAL.localDomain}/api/v1/discuss/replyDiscuss`,
      //     headers: {
      //       'Accept': 'application/json',
      //       'Authorization': sessionStorage.getItem('token'),
      //     },
      //     params: {
      //       userid:  // 回复的用户
      //       discuss_id :  // 回复的主题id
      //       body: // 回复的具体内容(这里用富文本)
      //     }
      //   }).then(res => {
      //     alert('删除成功');
      //     that.getReply()
      //   }).catch(err => {
      //     alert('删除失败')
      //     console.log(err)
      //   })
      // }
    },
    deleteReply: function (index) {
      const that = this;
      console.log('删除')
      // let id = that.replyData[index]['id'];
      // let prompt = confirm("确认删除该讨论吗？");
      // if (prompt) {
      //   axios({
      //     method: 'post',
      //     url: `${this.GLOBAL.localDomain}/api/v1/discuss/deleteReply`,
      //     headers: {
      //       'Accept': 'application/json',
      //       'Authorization': sessionStorage.getItem('token'),
      //     },
      //     params: {
      //       id: id,
      //     }
      //   }).then(res => {
      //     alert('删除成功');
      //     that.getReply()
      //   }).catch(err => {
      //     alert('删除失败')
      //     console.log(err)
      //   })
      // }
    },
    // 通过discuss_id获取讨论信息
    getReplyForCid: function() {
      const that = this;
      let discuss_id = that.editData.id;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/discuss/selectReplyForDid`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          'discuss_id': discuss_id
        },
      }).then(res => {
        that.replyData = res.data;
        debugger
      }).catch(err => {
        console.log(err);
      })
    },
    // 通过userID获取讨论信息
    getReplyForUserId: function() {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/discuss/selectReplyForUserid`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          userid: sessionStorage.getItem('userId')
        }
      }).then(res => {
        that.replyData = res.data.data;
      }).catch(err => {
        console.log(err);
      })
    },
    getReply: function() {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/discuss/selectReplyAll`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.replyData = res.data;
      }).catch(err => {
        console.log(err);
      })
    },
    searchReply: function () {
      const that = this;
      // 如果没有搜索值
      if (!that.searchKey) {
        that.getReply();
        that.searchResult = [];
        return;
      }
      // 如果已经获取全部数据
      else if (that.allReply.length > 0) {
        let allData  = that.allReply;
        let len = that.allReply.length;
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
        that.replyData = res;
      }
      // 如果有搜索值并且还未获取全部数据
      else {
        let url = `${this.GLOBAL.localDomain}/api/v1/replys/`;
        that.getAllReply(url);
      }
    },
    getAllReply: function (url) {
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
            that.currentReply.push(res.data.data[i]);
          }
        }
        else if (that.getJsonLength(res.data.data)) {
          for (let i in res.data.data) {
            that.currentReply.push(res.data.data[i]);
          }
        }

        if (that.url) {
          that.getAllReply(that.url);
        }
        else {
          that.allReply = that.currentReply;
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
          that.getReply();
          break;
        case 'user-id-search':
          that.getReplyForUserId();
          break;
        case 'lecture-id-search':
          that.getReplyForCid();
          break;
      }
    },
    publishReply: function (index) {
      const that = this;
      let replyId = that.replyData[index]['id']
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/reply/publish`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          id: replyId,
        }
      }).then(res => {
        that.getReply();
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
      that.getReplyForCid();
    },
    editData: function (value, oldValue) {
      const that = this;
      that.discussData = value;
    }
  }
}
</script>

<style lang="scss" scoped>
.modal-content {
  width: 1200px;
}
</style>
