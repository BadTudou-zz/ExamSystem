<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">编辑标签</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>标签标题</label>
          <input class="input" type="text" >
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="editLabel()" class="button is-success">确认</button>
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
      labelData: null,
    }
  },
  components: {
  },
  props: [
    'editData',
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    clearWords: function () {
      const that = this;
      that.labelData.title = '';
    },
    editLabel: function (index) {
      const that = this;
      let id = that.editData[id];
      axios({
        method: 'put',
        url: `${this.GLOBAL.localDomain}/api/v1/labels${id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': this.GLOBAL.token,
        },
        params: {
          'title': that.labelData.title,
        }
      }).then(res => {
        alert('编辑成功');
        that.$emit('getLabel');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.clearWords();
        that.switchModal();
      }).catch(err => {
        alert('编辑失败');
        console.log(err);
        that.clearWords();
      })
    }
  },
  created() {

  },
  watch: {
    editData: function (value, oldValue) {
      const that = this;
      that.labelData.title = value.title;
    }
  }
}
</script>

<style>
</style>
