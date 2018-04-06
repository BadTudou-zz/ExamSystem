<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">同步成员</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>users</label>
          <input v-model="memberData.users" class="input" type="number">
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="synchronousMember()" class="button is-success">确认</button>
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
      memberData: {
        users: null,
      },
      permissionId: null,
    }
  },
  props: [
    'organizationId',
  ],
  components: {
  },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    clearWords: function () {
      const that = this;
      that.memberData.users = '';
    },
    synchronousMember: function () {
      const that = this;
      let id = that.organizationId;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/organizations/${id}/users`,
        headers: {
          'Accept': 'application/json',
          'Authorization': this.GLOBAL.token,
        },
        params: {
          users: null,
        }
      }).then(res => {
        alert('同步成功');
        that.$emit('getMember');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
      }).catch(err => {
        alert('同步失败');
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
