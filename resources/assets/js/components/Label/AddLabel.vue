<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加标签</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>标签题目</label>
          <input v-model="labelData.title" class="input" type="text">
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="addLabel()" class="button is-success">确认</button>
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
      labelData: {
        title: '',
      },
      token: null,
    }
  },
  components: {
  },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    clearWords: function () {
      const that = this;
      that.labelData.title = '';
    },
    addLabel: function () {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/applications/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        },
        body: {
          title: that.labelData.title,
        }
      }).then(res => {
        alert('添加成功');
        that.$emit('getLabel');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
      }).catch(err => {
        alert('添加失败');
        console.log(err);
        that.clearWords();
      })
    },
  },
  created() {
    this.token = sessionStorage.getItem('token');
  }
}
</script>

<style>
</style>
