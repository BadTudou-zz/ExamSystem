<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加考试用户</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>用户ID：</label>
          <input v-model="users" class="input" type="text">
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="addTestUsers()" class="button is-success">确认</button>
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
      testUserData: {},
      users: '',
    }
  },
  components: {
  },
  props: [
    'examId'
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    clearWords: function () {
      const that = this;
      that.users = '';
    },
    addTestUsers: function () {
      const that = this;
      // let params = this.GLOBAL.computedParams(selectedUsers, 'users');
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/${that.examId}/users`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        // data: {
        //   users: '1'
        // }
      }).then(res => {
        alert('添加成功');
      }).catch(err => {
        alert('添加失败');
        console.log(err)
      })
    }
  },
  created() {
  },
  watch: {
    examId: function (value, oldValue) {
      const that = this;
    }
  }
}
</script>

<style scoped>
</style>
