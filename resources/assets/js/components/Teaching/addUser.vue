<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加用户</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <!-- ?? users的语义 -->
          <label>users</label>
          <input v-model="userData.name" class="input" type="text">
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="addUser" class="button is-success">确认</button>
        <button @click="switchModal()" class="button">取消</button>
      </footer>
    </div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      isShowModal: false,
      userData: {
        users: null
      },
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
      that.users =  '';
    },
    addUser: function () {
      const that = this;
      let ids = [];
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/lectures`,
        headers: {
          'Accept': 'application/json',
          'Authorization': this.GLOBAL.token,
        },
        params: {
          users: that.userData.users
        }
      }).then(res => {
        alert('添加成功');
        that.$emit('getUser');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
      }).catch(err => {
        alert('添加失败');
        console.log(err);
        that.clearWords();
      })
    }
  },
  created() {

  }
}
</script>

<style>
</style>
