<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加讨论</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>

      <section class="modal-card-body">

        <div class="discuss-item-box">
          <label>主题标题</label>
          <input v-model="discussData.title" class="input" type="text">
        </div>

        <div class="discuss-item-box">
          <label>主题内容</label>
          <input v-model="discussData.content" class="input" type="text">
        </div>

      </section>
      <footer class="modal-card-foot">
        <button @click="addDiscuss()" class="button is-success">确认</button>
        <button  @click="switchModal()" class="button">取消</button>
      </footer>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isShowModal: false,
      discussData: {
        title: '',
        content: '',
        l_id: '',
        userid: '',
      },
    }
  },
  components: {
  },
  props: [
    'currentTeachingData'
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    clearWords: function () {
      const that = this;
      that.discussData.title = '';
      that.discussData.content = '';
      that.discussData.userid = '';
      that.discussData.l_id = '';
    },
    addDiscuss: function () {
      const that = this;

      that.userId = sessionStorage.getItem('userId')
      let teachingId = that.currentTeachingData.id;
      that.cid = teachingId;  // 授课ID

      axios({
        method: 'POST',
        url: `${this.GLOBAL.localDomain}/api/v1/discuss/publishDiscuss`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          title: that.discussData.title,
          content: that.discussData.content,
          l_id: this.discussData.l_id,
          userid: that.discussData.userid,
        },
      }).then(res => {
        alert('添加成功');
        that.clearWords();
        that.$emit('getDiscuss');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
      }).catch(err => {
        alert('添加失败');
        return;
        console.log(err);
      })
    },
  },
  created() {
  },
  watch: {
    currentTeachingData: function (value, oldValue) {
      const that = this;
      that.discussData.l_id = value.id;
      that.discussData.userid = sessionStorage.getItem('userId');
    }
  }
}
</script>

<style scoped>
.progress {
  margin: 15px 0 20px 0;
}
.discuss-item-box {
  margin: 25px 0
}
.discuss-item-box input {
  display: inline-block;
  width: 300px;
}
</style>
