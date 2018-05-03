<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">编辑讨论</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>

      <section class="modal-card-body">

        <div class="discuss-item-box">
          <label>讨论标题</label>
          <input v-model="discussData.title" class="input" type="text">
        </div>

        <div class="discuss-item-box">
          <label>内容</label>
          <textarea v-model="discussData.content" class="textarea" name="name" rows="8" cols="80"></textarea>
        </div>

        <!-- <div class="discuss-item-box">
          <label>修改是否发布</label>

          <div class="control">
            <label class="radio">
              <input v-model="discussData.isPublish" value=1 type="radio" name="answer">是
            </label>
            <label class="radio">
              <input v-model="discussData.isPublish" value=0 type="radio" name="answer">否
            </label>
          </div>
        </div> -->
      </section>

      <footer class="modal-card-foot">
        <button @click="editDiscuss()" class="button is-success">确认</button>
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
        id: '',  // 要更新的讨论主题id
        title: '',  // 主题标题
        content: '',  // 主题内容
        l_id: '',  // 授课id
        userid: '',  // 用户id
      },
      cid: null,
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
    clearWords: function () {
      const that = this;
      that.discussData.id = '';
      that.discussData.title = '';
      that.discussData.content = '';
      that.discussData.l_id = '';
      that.discussData.userid = '';
    },
    editDiscuss: function () {
      const that = this;

      axios({
        method: 'POST',
        url: `${this.GLOBAL.localDomain}/api/v1/discuss/updateDiscuss`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          id: that.discussData.id,
          title: that.discussData.title,
          content: that.discussData.content,
          l_id: that.discussData.l_id,
          userid: that.discussData.userid,
        },
      }).then(res => {
        alert('编辑成功');
        that.$emit('getDiscuss');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
        that.clearWords();
      }).catch(err => {
        alert('编辑失败');
        console.log(err);
      })
    },
  },
  created() {
  },
  watch: {
    editData: function (value, oldValue) {
      const that = this;
      that.discussData.id = value.id;
      that.discussData.title = value.title;
      that.discussData.content = value.content;
      that.discussData.l_id = value.l_id;
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
