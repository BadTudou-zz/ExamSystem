<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加成员</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <!-- // ?? 添加成员参数 -->
          <label>users</label>
          <input v-model="memberData.name" class="input" type="text" placeholder="请输入成员名">
        </div>

        <div class="box-item">
          <label>users</label>
          <input v-model="memberData.max" class="input" type="number">
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="addMember()" class="button is-success">确认</button>
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
        users: null,
      },
      token: null,
      permissionId: null,
    }
  },
  components: {
  },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    // 添加成员
    addMember: function () {
      const that = this;
      that.memberData.max = Number(that.memberData.max);
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/organizations`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        },
        body: {
        //   users: that.memberData.
        //   users: that.memberData.
        }
      }).then(res => {
         
      }).catch(err => {
        console.log(err)
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
