<!-- 编辑角色-->
<template lang="html">
  <div class="modal" v-bind:class="{'is-active': isShowModal}">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">编辑组织</p>
      <button @click="switchModal()" class="delete" aria-label="close"></button>
    </header>
    <section class="modal-card-body">
      <div class="box-item">
        <label>角色名称</label>
        <input v-model="currentRoleData.name" class="input" type="text" placeholder="请输入英文角色名">
      </div>

      <div class="box-item">
        <label>显示的角色名称</label>
        <input v-model="currentRoleData.display_name" class="input" type="text" placeholder="请输入中文角色名">
      </div>
      <div class="box-item">
        <label>角色描述</label>
        <input v-model="currentRoleData.description" class="input" type="text">
      </div>
    </section>
    <footer class="modal-card-foot">
      <button @click="editRole()" class="button is-success">确认</button>
      <button @click="switchModal()" class="button">取消</button>
    </footer>
  </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      currentRoleData: {
        id: null,
        name: null,
        description: null,
        max: null,
      },
      isShowModal: false,
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
    clearWords: function () {
      const that = this;
      that.currentRoleData.name = '';
      that.currentRoleData.display_name = '';
      that.currentRoleData.description = '';
    },
    editRole: function () {
      const that = this;
      axios({
        method: 'put',
        url: `${this.GLOBAL.localDomain}/api/v1/roles/${that.currentRoleData.id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          name: that.currentRoleData.name,
          display_name: that.currentRoleData.display_name,
          description: that.currentRoleData.description,
        }
      }).then(res => {
        that.clearWords();
        alert('编辑成功');
        that.$emit('getRole');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
      }).catch(err => {
        alert('编辑失败');
        console.log(err);
      })
    }
  },
  creatad() {

  },
  watch: {
    editData: function (value, oldValue) {
      const that = this;
      that.currentRoleData.id = value.id;
      that.currentRoleData.name = value.name;
      that.currentRoleData.display_name = value.display_name;
      that.currentRoleData.description = value.description;
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
