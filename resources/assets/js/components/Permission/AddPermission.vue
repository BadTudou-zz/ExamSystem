<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加权限</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>权限名称</label>
          <input v-model="permissionData.name" class="input" type="text" placeholder="请输入英文权限名">
        </div>

        <div class="box-item">
          <label>显示的权限名称</label>
          <input v-model="permissionData.display_name" class="input" type="text" placeholder="请输入中文权限名">
        </div>

        <div class="box-item">
          <label>描述</label>
          <input v-model="permissionData.description" class="input" type="text">
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="addPermission()" class="button is-success">确认添加</button>
        <button  @click="switchModal()" class="button">取消</button>
      </footer>
    </div>

  </div>
</template>
<script>
export default {
  data() {
    return {
      token: null,
      isShowModal: false,
      permissionData: {
        name: null,
        display_name: null,
        description: null,
      }
    }
  },
  components: {
  },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
      that.clearWords();
    },
    clearWords: function () {
      that.permissionData.name = '';
      that.permissionData.display_name = '';
      that.permissionData.description = '';
    },
    addPermission: function () {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/permissions/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token,
        },
        params: {
          name: that.permissionData.name,
          display_name: that.permissionData.display_name,
          description: that.permissionData.description,
        }
      }).then(res => {
        alert('添加成功');
        that.$emit('getPermission');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
        that.clearWords();
      }).catch(err => {
        // alert('添加失败');
        console.log(err);
        that.clearWords();
      })
    }
  },
  created() {
    this.token = sessionStorage.getItem('token');
  },
  watch: {
  }
}
</script>


<style>
</style>
