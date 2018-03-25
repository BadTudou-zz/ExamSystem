<!-- 编辑用户 -->
<!-- ??有哪些数据允许编辑 -->
<template lang="html">
  <div class="modal" v-bind:class="{'is-active': isShowModal}"
                     >
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">修改密码</p>
      <button @click="switchModal()" class="delete" aria-label="close"></button>
    </header>
    <section class="modal-card-body">
      <div class="label-box">
        <label class="label">旧密码：</label>
        <input class="input" type="password" v-model="password">
      </div>
      <div class="label-box">
        <label class="label">新密码：</label>
        <input class="input" type="password" v-model="new_password">
      </div>
    </section>
    <footer class="modal-card-foot">
      <button @click="changePassword()" class="button is-success">确认</button>
      <button @click="switchModal()" class="button">取消</button>
    </footer>
  </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      isShowModal: null,
      token: '',
      password: null,
      new_password: null,
    }
  },
  props: [
    'editData',
  ],
  components: {

  },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    clearWords:function () {
      const that = this;
      that.password = '';
      that.oldPassword = '';
    },
    changePassword: function () {
      const that = this;
      let id = that.editData.id;
      axios({
        method: 'patch',
        url: `${this.GLOBAL.localDomain}/api/v1/users/${id}/password/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token,
        },
        data: {
          password: that.password,
          new_password: that.new_password,
        }
      }).then(res => {
        alert('修改成功！')
        that.$emit('getUser');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
        that.clearWords();
      }).catch(err => {
      alert('修改失败，请稍后再试');
        that.clearWords();
      })
    }
  },
  created() {
    this.token = sessionStorage.getItem('token');
  },
  watch: {
    isShowEditModal: function (value, oldValue) {
      const that = this;
      that.isShowModal = value;
    },
    editData: function (value, oldValue) {
      console.log(value)
    }
  }
}
</script>

<style lang="css">
label {
  display: inline-block;
  width: 100px;
}
.label {
  display: inline-block;
}
.label-box {
  margin-bottom: 10px;
}
.label-box input {
  width: 300px;
  display: inline-block;
}
</style>
