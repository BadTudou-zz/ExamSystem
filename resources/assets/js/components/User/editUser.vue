<!-- 编辑用户 -->
<template lang="html">
  <div class="modal" v-bind:class="{'is-active': isShowModal}">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">编辑用户</p>
      <button @click="switchModal()" class="delete" aria-label="close"></button>
    </header>
    <section class="modal-card-body">
      <!-- <div class="label-box">
        <label class="label">邮箱：</label>
        <input class="input" v-model:email="userData.email" disabled>
      </div> -->
      <div class="label-box">
        <label class="label">用户名：</label>
        <input class="input" v-model:name="userData.name">
      </div>
      <div class="label-box">
        <label class="label">固话</label>
        <input class="input" v-model:number="userData.number">
      </div>
      <div class="label-box">
        <label class="label">手机</label>
        <input class="input" v-model:phone="userData.phone">
      </div>
      <div class="label-box">
        <label class="label">QQ：</label>
        <input class="input" v-model:qq="userData.qq">
      </div>
    </section>
    <footer class="modal-card-foot">
      <button @click="editUser()" class="button is-success">确认</button>
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
      userData: {
        name: '',
        email: '',
        number: '',
        phone: '',
        qq: '',
      },
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
    // 编辑
    editUser: function () {
      const that = this;
      let id = that.editData.id;
      axios({
        method: 'put',
        url: `${this.GLOBAL.localDomain}/api/v1/users/${id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        data: {
          name: that.userData.name,
          // email: that.userData.email,
          number: that.userData.number,
          phone: that.userData.phone,
          qq: that.userData.qq,
        }
      }).then(res => {
        alert('修改成功！')
        that.$emit('getUser');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
        that.userData.name = '';
      }).catch(err => {
        let errMsg = err.response.data.message;
        alert(errMsg);
        console.log(err)
      })
    },
  },
  created() {
  },
  watch: {
    isShowEditModal: function (value, oldValue) {
      const that = this;
      that.isShowModal = value;
    },
    editData: function (value, oldValue) {
      const that = this;
      that.userData.name = value.name ? value.name : '';
      that.userData.email = value.email ? value.email : '';
      that.userData.number = value.number ? value.number : '';
      that.userData.phone = value.phone ? value.phone : '';
      that.userData.qq = value.qq ? value.qq : '';
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
